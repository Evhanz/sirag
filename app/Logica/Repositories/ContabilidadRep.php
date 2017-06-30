<?php
/**
 * Created by PhpStorm.
 * User: ehernandez
 * Date: 14/09/2016
 * Time: 05:08 PM
 */

namespace sirag\Repositories;

use sirag\DTO\DocumentoDTO;
use sirag\Entities\Obj;
use sirag\Helpers\HelpFunct;


class ContabilidadRep
{


    public function getCciByCodigo($codigo)
    {

        $query = "SELECT CODIGO,DESCRIPCION,TEXTO1 FROM flexline.GEN_TABCOD
            WHERE EMPRESA = 'E01'
            AND TIPO = 'CON_CCOSTO_INTERNO'
            AND CODIGO = '$codigo'";

        $res = \DB::select($query);

        if (count($res) > 0) {
            return $res[0];
        } else {
            return 0;
        }
    }


    public function getBalanceByNiveles($data)
    {

        //el formato de las fechas es de
        //paara pasar se verifico con mes dia año
        $fi = $data['f_i'];
        $ff = $data['f_f'];
        $nivel = $data['nivel'];

        //$sql = "EXEC sp_getBalanceByNiveles @fi = '$fi', @ff = '$ff',	@nivel = 1";

        $res_query = \DB::statement("EXEC sp_getBalanceByNiveles @fi = '$fi', @ff = '$ff',	@nivel = $nivel");

        $res_query = \DB::select("select * from temp_balance_general");

        $data = new DocumentoDTO();


        $res = collect($res_query);
        $data->total_SI_DEUDOR = number_format($res->sum('SI_DEUDOR'), 2, '.', ',');
        $data->total_SI_ACREEDOR = number_format($res->sum('SI_ACREEDOR'), 2, '.', ',');
        $data->total_MOV_DEBE = number_format($res->sum('MOV_DEBE'), 2, '.', ',');
        $data->total_MOV_HABER = number_format($res->sum('MOV_HABER'), 2, '.', ',');
        $data->total_SF_DEUDOR = number_format($res->sum('SF_D'), 2, '.', ',');
        $data->total_SF_ACREEDOR = number_format($res->sum('SF_H'), 2, '.', ',');

        foreach ($res_query as $item) {
            $item->DESCRIPCION = utf8_encode($item->DESCRIPCION);
            $item->SI_DEUDOR = number_format($item->SI_DEUDOR, 2, '.', ',');
            $item->SI_ACREEDOR = number_format($item->SI_ACREEDOR, 2, '.', ',');
            $item->MOV_DEBE = number_format($item->MOV_DEBE, 2, '.', ',');
            $item->MOV_HABER = number_format($item->MOV_HABER, 2, '.', ',');
            $item->SF_D = number_format($item->SF_D, 2, '.', ',');
            $item->SF_H = number_format($item->SF_H, 2, '.', ',');
        }


        $data->items = $res;

        return $data;
    }


    /*esta funcion trae todas las ordenes de compra que estan vigentes
    o no , de acuerdo a los filtros que sean necesarios, 
    teniendo en consideracion que se a agregado las columnas
    de cantidad atendida que se obtiene  de las guias atendidas
    por cada item de la orden de compra
    */
    public function getOrdenCompraForControl($data)
    {

        $proveedor = $data['proveedor'];
        $f_inicio = $data['f_inicio'];
        $f_fin = $data['f_fin'];
        $numero = $data['numero'];
        $vigencia = $data['vigencia'];

        $q = "SELECT v.Numero,convert(DATE,v.Fecha)AS FECHA,v.RazonSocial, v.UnidadIngreso,v.cod_producto, v.GLOSA,CONVERT(decimal(9,2),v.Cantidad) AS Cantidad
                          ,Coalesce( (select CONVERT(decimal(9,2),sum(dd.Cantidad))
                          from
                          flexline.DocumentoD dd inner join flexline.Documento d
                          on dd.idDocto = d.idDocto
                          where d.TipoDocto like '%N/I ALMACEN (A)%' 
                          and dd.TipoDoctoOrigen = 'ORDEN DE COMPRA (A)'
                          and dd.CorrelativoOrigen = v.Correlativo
                          and dd.SecuenciaOrigen = v.Secuencia),0) AS ATENDIDO
                          ,v.Correlativo
                          ,v.Secuencia
                          ,v.PrecioIngreso
                          ,convert(DATE,v.FechaEntrega)AS FECHA_ENTREGA

                          FROM v_ordenCompra_details as v
                          where Fecha BETWEEN '$f_inicio' AND '$f_fin'
                          AND RazonSocial like '%$proveedor%'
                          AND Numero like '%$numero%'
                          AND Vigencia like '%$vigencia%'
                          ORDER BY Fecha DESC ";



        $doc = \DB::select($q);

        foreach ($doc as $item) {

            if ($item->Cantidad > $item->ATENDIDO && $item->ATENDIDO > 0) {
                $item->estado = 'PENDIENTE';
            }

            if ($item->Cantidad == $item->ATENDIDO) {
                $item->estado = 'COMPLETADO';
            }
            if ($item->ATENDIDO == 0) {
                $item->estado = 'NO ATENDIDO';
            }

            //------- esto es para traer a las guias que fueron atendidas a la orden de compra


            //---


            $item->Cantidad = number_format($item->Cantidad, 2, '.', ',');
            $item->ATENDIDO = number_format($item->ATENDIDO, 2, '.', ',');
            $item->FECHA = $this->h_chageFormatDate($item->FECHA);
            $item->PrecioIngreso = number_format($item->PrecioIngreso, 3, '.', ',');
            $item->FECHA_ENTREGA = $this->h_chageFormatDate($item->FECHA_ENTREGA);

        }


       // HelpFunct::writeQuery($q);

        return $doc;
    }


    public function pdbCompras($periodo)
    {

        //primero traemos a la data y luego las separamos por '|'

        $query = "EXECUTE dbo.sp_getPDBCompras @periodo='$periodo'";
        $res = \DB::select($query);

        return $res;

    }

    public function pdbVentas($periodo)
    {

        //primero traemos a la data y luego las separamos por '|'

        $query = "EXECUTE dbo.sp_getPDBVentas @periodo='$periodo'";
        $res = \DB::select($query);

        return $res;

    }

    public function getTipoCambio($data)
    {
        $f_i = $data['f_i'];
        $f_f = $data['f_f'];

        $query = "select convert(date,FECHA) as c1,convert(decimal(3,2),VALOR) as c2 from 
                flexline.GEN_TASCAM
                where EMPRESA = 'e01'
                and convert(date,FECHA) between '$f_i' and '$f_f'
                order by FECHA ASC ";

        $res = \DB::select($query);


        return $res;

    }

    public function getFundos()
    {
        $query = "SELECT CODIGO FROM flexline.GEN_TABCOD
              WHERE EMPRESA='E01'
              AND TIPO='GEN_FUNDO'
              AND VIGENCIA NOT IN('N','S') ";

        $res = \DB::select($query);

        return $res;

    }

    public function getParronByFundo($fundo)
    {

        $query = "SELECT CODIGO,VALOR1 ,VALOR2  FROM flexline.GEN_TABCOD
                WHERE EMPRESA='E01'
                AND TIPO='GEN_PARRON'
                AND VIGENCIA <> 'N'
                AND CODIGO LIKE '%$fundo'";
        $res = \DB::select($query);

        return $res;

    }


    public function sendDataForExcelConsumo($data)
    {


        //primero traemos a todos los productos de materia prima

        if ($data['cc'] == 'materiaPrima') {

            $query = "SELECT PRODUCTO,GLOSA,SUBFAMILIA from flexline.PRODUCTO
                where FAMILIA = 'MATERIA PRIMA' 
                and EMPRESA = 'e01'
                ORDER by SUBFAMILIA";
        } else {

            $query = "SELECT PRODUCTO,DESCRIPCION AS GLOSA,SUBFAMILIA from dbo.v_getConsumoGif
                    GROUP BY PRODUCTO,DESCRIPCION,SUBFAMILIA 
                    ORDER by SUBFAMILIA,DESCRIPCION";
        }

        $productos = \DB::select($query);


        //traemos a los consumos de cada producto  de acuerdo a su parron por cada fecha

        foreach ($productos as $item) {

            $item->GLOSA = utf8_encode($item->GLOSA);


            $p = [];


            foreach ($data['parrones'] as $parron) {


                $dto = new DocumentoDTO();
                $consumo = $this->getConsumoByFechasAndProducto($parron['startDate'], $parron['endDate'], $item->PRODUCTO, $parron['CODIGO'], $data['cc']);

                $dto->name_parron = $parron['CODIGO'];
                $dto->area = $parron['VALOR1'];
                $dto->total_cantidad_consumo = $consumo->cantidad;
                $dto->total_precio_consumo = $consumo->total;
                $dto->precio_ha = number_format($consumo->total / $parron['VALOR1'], 2, '.', '');

                /*
                $dto->costo = $consumo->costo;
                $dto->cantidad = $consumo->cantidad;
                */

                array_push($p, $dto);
            }

            $item->analisis_parron = $p;

        }

        //se trae la data de los parrones que no an sido asignados
        $fundo = $data['fundo'];
        $otros = $data['otros'];
        $otros_f_i = $otros['startDate'];
        $otros_f_f = $otros['endDate'];

        //se valida si el centro de costo para manejar la consulta
        if ($data['cc'] == 'materiaPrima') {
            $query = "SELECT PRODUCTO,DESCRIPCION,SUM(CANTIDAD) cantidad ,SUM(TOTAL) total
                from dbo.v_getConsumoMateriaPrima
                WHERE FUNDO = '$fundo'
                and FECHA BETWEEN '$otros_f_i' and '$otros_f_f'  
                AND PARRON NOT LIKE '%PARRON%' 
                GROUP BY PRODUCTO,DESCRIPCION ";
        } else {
            $query = "SELECT PRODUCTO,DESCRIPCION,SUM(CANTIDAD) cantidad ,SUM(TOTAL) total
                from dbo.v_getConsumoGif
                WHERE FUNDO = '$fundo'
                and FECHA BETWEEN '$otros_f_i' and '$otros_f_f'  
                AND PARRON NOT LIKE '%PARRON%' 
                GROUP BY PRODUCTO,DESCRIPCION ";
        }
        $res_otros = \DB::select($query);

        //

        $res = [];

        $res['parrones'] = $data['parrones'];
        $res['productos'] = $productos;
        $res['otros'] = collect($res_otros);
        $res['f_otros_i'] = $otros_f_i;//fecha de los productos que no registran parron
        $res['f_otros_f'] = $otros_f_f;


        return $res;
    }


    public function getConsumoByFechasAndProducto($fecha_i, $fecha_f, $producto, $parron, $cc)
    {

        if ($cc == 'materiaPrima') {
            $query = " SELECT CONVERT(DECIMAL(12,2),SUM(CANTIDAD)) cantidad, CONVERT(DECIMAL(12,2),SUM(TOTAL)) total 
          FROM dbo.v_getConsumoMateriaPrima  
          where PRODUCTO = '$producto' 
          and FECHA BETWEEN '$fecha_i' and '$fecha_f'  
          and PARRON = '$parron'  ";

        } else {
            $query = "SELECT CONVERT(DECIMAL(12,2),SUM(CANTIDAD)) cantidad, CONVERT(DECIMAL(12,2),SUM(TOTAL)) total 
          FROM dbo.v_getConsumoGif  
          where PRODUCTO = '$producto' 
          and FECHA BETWEEN '$fecha_i' and '$fecha_f'  
          and PARRON = '$parron'  ";

        }


        $res = \DB::select($query);

        return $res[0];

    }


    /*
     * esta funcion reemplaza a la funcion anterior por cmbios
     * en el proceso del ERP ESTO ES POR CCI
     */

    public function getDataForExcelConsumo2($data)
    {
        $codigos = [];
        $cci = [];
        $parrones = $data['parrones'];
        $fundo = $data['fundo'];

        //--

       // HelpFunct::writeQuery(var_dump($data));

        //--


        // $codigos = $codigos->;
        $a_fechas_ini = [];
        $a_fechas_fin = [];

        //primero obtenemos a las fechas de los parrones
        foreach ($parrones as $i) {

            if (!in_array($i['startDate'], $a_fechas_ini)) {
                array_push($a_fechas_ini, $i['startDate']);
            }
            if (!in_array($i['endDate'], $a_fechas_fin)) {
                array_push($a_fechas_fin, $i['endDate']);
            }

        }

        $menor_fecha_ini = date_format($this->getDatePositionByArray($a_fechas_ini, 'date', 'menor'), 'Y-m-d');
        $mayor_fecha_fin = date_format($this->getDatePositionByArray($a_fechas_fin, 'date', 'mayor'), 'Y-m-d');

        //obtenemos los cci que intervienen aqui

        $query = "SELECT Analisis15 cci
                    FROM flexline.DocumentoD 
                    where CONVERT(date,Fecha) BETWEEN '$menor_fecha_ini' AND '$mayor_fecha_fin'
                    AND TipoDocto in ('SALIDA ALMACEN','TRANSF P/ PRODUCTO')
                    AND LEN(Analisis15) = 6
                    and SUBSTRING ( Analisis15 ,3 , 1 )  = $fundo
                    group by  Analisis15
                    ORDER BY cci";

        $res_codigos = \DB::select($query);


        //obtenemos solo los codigos

        foreach ($res_codigos as $item) {
            array_push($codigos, $item->cci);
        }

        //luego sacamos a los producos

        $q_productos = "SELECT p.GLOSA,P.PRODUCTO,P.TIPO
                        FROM flexline.DocumentoD D inner join flexline.PRODUCTO P
                        on D.Producto = P.PRODUCTO 
                        AND  D.Empresa = P.Empresa
                        where CONVERT(date,D.Fecha) BETWEEN '$menor_fecha_ini' AND '$mayor_fecha_fin'
                        AND D.TipoDocto in ('SALIDA ALMACEN','TRANSF P/ PRODUCTO')
                        AND LEN(coalesce( D.AUX_VALOR19,D.Analisis15)) > 0
                        and SUBSTRING ( D.Analisis15 ,3 , 1 )  = $fundo
                        group by p.GLOSA,P.PRODUCTO,P.TIPO
                        ORDER BY P.TIPO,p.GLOSA";

        $productos = \DB::select($q_productos);

        //formateamos los cci

        foreach ($res_codigos as $c) {

            $o = new Obj();

            try{
            $fundo_detalle_fechas = $this->getObjectsFundos($parrones, $c);
            $o->cci = $c->cci;
            $o->f_ini = $fundo_detalle_fechas['startDate'];
            $o->f_fin = $fundo_detalle_fechas['endDate'];
            $o->VALOR1 = $fundo_detalle_fechas['VALOR1'];

            array_push($cci, $o);
            }
            catch (\Exception $e){
                return $res_codigos;
            }
        }

        //recorremos cada producto para obetener la matriz

        foreach ($productos as $p) {
            $detalles = [];

            foreach ($cci as $codigo) {

                $det = $this->getConsumoByParronAnCCI($codigo->f_ini, $codigo->f_fin, $codigo->cci, $p->PRODUCTO);

                $obj_det = new Obj();
                $obj_det->total_cantidad_consumo =  $det->cantidad ;
                $obj_det->total_precio_consumo = $det->total;
                $obj_det->precio_ha = number_format($det->total /  $codigo->VALOR1, 2, '.', '') ;

                array_push($detalles,$obj_det);
            }

            $p->analisis_parron = $detalles;
        }



        //3.- aca es parascar a los otros

        $otros = $data['otros'];
        $startDate = $otros['startDate'];
        $endDate = $otros['endDate'];


        $query = "SELECT Analisis15 cci
                    FROM flexline.DocumentoD 
                    where CONVERT(date,Fecha) BETWEEN '$startDate' AND '$endDate'
                    AND TipoDocto in ('SALIDA ALMACEN','TRANSF P/ PRODUCTO')
                    AND LEN(Analisis15) = 5
                    and SUBSTRING ( Analisis15 ,3 , 1 )  = $fundo
                    group by  Analisis15
                    ORDER BY cci";

        $res_cci_otros = \DB::select($query);


        $q_productos = "SELECT p.GLOSA,P.PRODUCTO,P.TIPO
        FROM flexline.DocumentoD D inner join flexline.PRODUCTO P
        on D.Producto = P.PRODUCTO 
        AND  D.Empresa = P.Empresa
        where CONVERT(date,D.Fecha)  BETWEEN '$startDate' AND '$endDate'
        AND D.TipoDocto  in ('SALIDA ALMACEN','TRANSF P/ PRODUCTO')
        AND LEN(coalesce( D.AUX_VALOR19,D.Analisis15)) = 5
        and SUBSTRING ( D.Analisis15 ,3 , 1 )  = $fundo
        group by p.GLOSA,P.PRODUCTO,P.TIPO
        ORDER BY P.TIPO,p.GLOSA";

        $productos_otros = \DB::select($q_productos);

        $otros = [];

        foreach ($productos_otros as $p){

            foreach ($res_cci_otros as $c){


                $det = $this->getConsumoByParronAnCCI($startDate, $endDate, $c->cci, $p->PRODUCTO);

                $obj_det = new Obj();
                $obj_det->PRODUCTO =  $p->PRODUCTO ;
                $obj_det->DESCRIPCION = $p->GLOSA;
                $obj_det->cantidad = $det->cantidad;
                $obj_det->total = $det->total;

                array_push($otros,$obj_det);

            }

        }



        $response_all = [];
        $response_all['productos'] = $productos;
        $response_all['parrones'] = $parrones;
        $response_all['cci']    = $cci;
        $response_all['otros']    = $otros;
        $response_all['f_otros_i']    = $startDate;
        $response_all['f_otros_f']    = $endDate;

        return $response_all;

    }



    public function getDataForExcelConsumoAll($data){

        //3.- aca es parascar a los otros

        $otros = $data['otros'];
        $startDate = $otros['startDate'];
        $endDate = $otros['endDate'];


        $q_productos = "SELECT p.GLOSA,P.PRODUCTO,P.TIPO
        FROM flexline.DocumentoD D inner join flexline.PRODUCTO P
        on D.Producto = P.PRODUCTO 
        AND  D.Empresa = P.Empresa
        where CONVERT(date,D.Fecha)  BETWEEN '$startDate' AND '$endDate'
        AND D.TipoDocto in ('SALIDA ALMACEN','TRANSF P/ PRODUCTO')
        AND LEN(coalesce( D.AUX_VALOR19,D.Analisis15)) = 5
        and  D.Analisis15 =  17000
        group by p.GLOSA,P.PRODUCTO,P.TIPO
        ORDER BY P.TIPO,p.GLOSA";

        //HelpFunct::writeQuery($q_productos);

        $productos_otros = \DB::select($q_productos);


        $otros = [];


        foreach ($productos_otros as $p){

                $det = $this->getConsumoByParronAnCCI($startDate, $endDate, '17000', $p->PRODUCTO);

                $obj_det = new Obj();
                $obj_det->PRODUCTO =  $p->PRODUCTO ;
                $obj_det->DESCRIPCION = $p->GLOSA;
                $obj_det->cantidad = $det->cantidad;
                $obj_det->total = $det->total;

                array_push($otros,$obj_det);
        }


        $response['otros'] = $otros;
        $response['f_otros_i']    = $startDate;
        $response['f_otros_f']    = $endDate;

        return $response;



    }


    public function getRetenciones($data){

        $anio = $data['anio'];
        $mes = $data['mes'];


        $query = "SELECT 
        A.CORRELATIVO,
        A.AUX_VALOR2,
        A.TIPO_DOCUMENTO, 
        A.REFERENCIA,
        A.HABER_INGRESO,
        A.HABER_ORIGEN,
        A.FECHA,
        A.VALOR4,
        B.RazonSocial
        FROM 
        flexline.CON_MOVCOM A,
        flexline.CtaCte B
        WHERE
        A.EMPRESA=B.Empresa
        AND A.AUX_VALOR2=B.CtaCte
        AND A.EMPRESA='E01'
        AND A.CUENTA='040110104001'
        AND A.ESTADO='A'
        AND YEAR(A.FECHA)=$anio
        AND MONTH(A.FECHA)=$mes
        AND A.HABER_INGRESO<>0
        and A.TIPO_COMPROBANTE='EGRESO'
        GROUP BY A.HABER_ORIGEN,A.CORRELATIVO, A.TIPO_DOCUMENTO, A.REFERENCIA,A.HABER_INGRESO,A.FECHA,A.AUX_VALOR2,
        A.VALOR4,B.RazonSocial
        ORDER BY A.FECHA,A.VALOR4";

        $res = \DB::select($query);

        return $res;


    }


    public function updateRetencion($data){

        $nComprobante = $data[ 'tempNDocumento'];
        $fecha = $data[ 'FECHA'];
        $tipo_documento = $data[ 'TIPO_DOCUMENTO'];
        $correlativo = $data['CORRELATIVO'];

        $query = "update 
                flexline.CON_MOVCOM
                set VALOR4 ='$nComprobante'
                where CORRELATIVO = '$correlativo'
                AND CONVERT(DATE,FECHA,113) = '$fecha'
                --AND TIPO_DOCUMENTO LIKE '%$tipo_documento%'
                AND CUENTA='040110104001'
                AND HABER_INGRESO<>0
                AND ESTADO='A'
                AND EMPRESA='E01'";

        $res = \DB::update($query);

        return $res;

    }

    public function getFormatOfRetencion($fecha,$correlativo=null){

        $s_query = '';

        if($correlativo != null){
            $s_query = "AND (CASE WHEN A.VALOR4 LIKE 'E%' THEN RIGHT (A.VALOR4,1) ELSE RIGHT (A.VALOR4,4) END like '%$correlativo%' ) ";

        }

        $query = "SELECT 
'6' AS 'c1',
CASE WHEN A.VALOR4 LIKE 'E%' THEN SUBSTRING (A.VALOR4,1,4) ELSE '0001' END AS 'c2',
--CASE WHEN A.VALOR4 LIKE 'E%' THEN RIGHT (A.VALOR4,1) ELSE RIGHT (A.VALOR4,4) END AS 'c3',
RIGHT (A.VALOR4,4) AS 'c3',
CONVERT(DATE,A.FECHA,113) AS 'c4',
A.AUX_VALOR2 AS 'c5',
'6' AS 'c6',
B.RazonSocial AS 'c7',
'01' AS 'c8',
'3.00' AS 'c9',
(select SUM(HABER_ORIGEN) from flexline.CON_MOVCOM
where Empresa=A.EMPRESA
AND CORRELATIVO=A.CORRELATIVO
AND PERIODO=A.PERIODO
AND TIPO_COMPROBANTE='EGRESO'
AND CUENTA='040110104001')AS 'c10',
--(SELECT SUM(ITP) FROM
--(select (ROUND((HABER_ORIGEN/0.03),2) - HABER_ORIGEN) AS 'ITP' from flexline.CON_MOVCOM
--where Empresa=A.EMPRESA
--AND CORRELATIVO=A.CORRELATIVO
--AND PERIODO=A.PERIODO
--AND TIPO_COMPROBANTE='EGRESO'
--AND CUENTA='040110104001') ITP )
ROUND((A.HABER_ORIGEN/0.03),2) AS 'c11',
COALESCE(ROUND((select CASE WHEN MONEDA='S/.' THEN TOTALINGRESO 
ELSE
(A.HABER_CUOTA/0.03) * COALESCE((select valor from 
flexline.GEN_TASCAM
where EMPRESA = A.EMPRESA
AND MONEDA=C.MONEDA
AND FECHA=A.FECHA
),1) 
END 
from flexline.Documento
where Empresa=a.EMPRESA
and TipoDocto=A.TIPO_DOCUMENTO
and Numero=A.REFERENCIA
AND CTACTE=A.AUX_VALOR2),2),ROUND((A.HABER_ORIGEN/0.03),2)) AS 'c11_1',
SUBSTRING (A.TIPO_DOCUMENTO,1,2) as 'c12',
'0'+SUBSTRING (A.REFERENCIA,1,3) as 'c13',
SUBSTRING (A.REFERENCIA,6,20) as 'c14',
convert(date,
COALESCE((select FECHA  from flexline.Documento
where Empresa=a.EMPRESA
and TipoDocto=A.TIPO_DOCUMENTO
and Numero=A.REFERENCIA
AND CTACTE=A.AUX_VALOR2
),A.FECHA),113 ) AS 'c15',
(SELECT SUM(IT) FROM
(select ROUND((HABER_INGRESO/0.03),2) AS 'IT' from flexline.CON_MOVCOM
where Empresa=A.EMPRESA
AND CORRELATIVO=A.CORRELATIVO
AND PERIODO=A.PERIODO
AND TIPO_COMPROBANTE='EGRESO'
AND CUENTA='040110104001') IT )AS 'c16',
COALESCE((select CASE WHEN MONEDA='S/.' THEN 'PEN' ELSE 'USD' END from flexline.Documento
where Empresa=a.EMPRESA
and TipoDocto=A.TIPO_DOCUMENTO
and Numero=A.REFERENCIA
AND CTACTE=A.AUX_VALOR2
),(select TOP 1 CASE WHEN CUENTA='042010101001' THEN 'PEN' ELSE 'USD' END from flexline.CON_MOVCOM
where Empresa=A.EMPRESA
AND CORRELATIVO=A.CORRELATIVO
AND PERIODO=A.PERIODO
AND TIPO_COMPROBANTE=A.TIPO_COMPROBANTE
AND CUENTA IN ('042010101001','042010101002')))AS 'c17',
CONVERT(DATE,A.FECHA,113) AS 'c18',
'1' AS 'c19',
COALESCE((select TOTALINGRESO  from flexline.Documento
where Empresa=a.EMPRESA
and TipoDocto=A.TIPO_DOCUMENTO
and Numero=A.REFERENCIA
AND CTACTE=A.AUX_VALOR2),ROUND((A.HABER_INGRESO/0.03),2)) AS 'c20',
(COALESCE(ROUND((select CASE WHEN MONEDA='S/.' THEN TOTALINGRESO 
ELSE
(A.HABER_CUOTA/0.03) * COALESCE((select valor from 
flexline.GEN_TASCAM
where EMPRESA = A.EMPRESA
AND MONEDA=C.MONEDA
AND FECHA=A.FECHA
),1) 
END 
from flexline.Documento
where Empresa=a.EMPRESA
and TipoDocto=A.TIPO_DOCUMENTO
and Numero=A.REFERENCIA
AND CTACTE=A.AUX_VALOR2),2),ROUND((A.HABER_ORIGEN/0.03),2))) - A.HABER_ORIGEN AS 'c20_1',
COALESCE((select CASE WHEN MONEDA='S/.' THEN 'PEN' ELSE 'USD' END from flexline.Documento
where Empresa=a.EMPRESA
and TipoDocto=A.TIPO_DOCUMENTO
and Numero=A.REFERENCIA
AND CTACTE=A.AUX_VALOR2
),(select TOP 1 CASE WHEN CUENTA='042010101001' THEN 'PEN' ELSE 'USD' END from flexline.CON_MOVCOM
where Empresa=A.EMPRESA
AND CORRELATIVO=A.CORRELATIVO
AND PERIODO=A.PERIODO
AND TIPO_COMPROBANTE=A.TIPO_COMPROBANTE
AND CUENTA IN ('042010101001','042010101002')))AS 'c21',
A.HABER_ORIGEN AS 'c22',
CONVERT(DATE,A.FECHA,113) AS 'c23',
(COALESCE((select TOTALINGRESO  from flexline.Documento
where Empresa=a.EMPRESA
and TipoDocto=A.TIPO_DOCUMENTO
and Numero=A.REFERENCIA
AND CTACTE=A.AUX_VALOR2),ROUND((A.HABER_INGRESO/0.03),2))) - A.HABER_ORIGEN AS 'c24',
COALESCE((select CASE WHEN MONEDA='S/.' THEN 'PEN' ELSE 'USD' END from flexline.Documento
where Empresa=a.EMPRESA
and TipoDocto=A.TIPO_DOCUMENTO
and Numero=A.REFERENCIA
AND CTACTE=A.AUX_VALOR2
),(select TOP 1 CASE WHEN CUENTA='042010101001' THEN 'PEN' ELSE 'USD' END from flexline.CON_MOVCOM
where Empresa=A.EMPRESA
AND CORRELATIVO=A.CORRELATIVO
AND PERIODO=A.PERIODO
AND TIPO_COMPROBANTE=A.TIPO_COMPROBANTE
AND CUENTA IN ('042010101001','042010101002')))AS 'c25',
COALESCE((select valor from 
flexline.GEN_TASCAM
where EMPRESA = A.EMPRESA
AND MONEDA=C.MONEDA
AND FECHA=A.FECHA
),1)AS 'c26',
CONVERT(DATE,A.FECHA,113) AS 'c27',
A.CORRELATIVO
FROM 
flexline.CON_MOVCOM A,
flexline.CtaCte B,
flexline.CON_ENCCOM C
WHERE
A.EMPRESA=B.Empresa
AND A.AUX_VALOR2=B.CtaCte
AND A.EMPRESA=C.EMPRESA
AND A.TIPO_COMPROBANTE=C.TIPO_COMPROBANTE
AND A.CORRELATIVO=C.CORRELATIVO
AND A.FECHA=C.FECHA
AND A.EMPRESA='E01'
AND A.CUENTA='040110104001'
AND A.ESTADO='A'
AND convert(date,A.FECHA,113) like '$fecha'
and A.TIPO_COMPROBANTE='EGRESO'
AND A.HABER_INGRESO<>0
$s_query
GROUP BY a.HABER_CUOTA,A.TIPO_COMPROBANTE,A.PERIODO,C.MONEDA,A.EMPRESA,A.CORRELATIVO,A.HABER_ORIGEN, A.TIPO_DOCUMENTO, A.REFERENCIA,A.HABER_INGRESO,A.FECHA,A.AUX_VALOR2,
A.VALOR4,B.RazonSocial
ORDER BY A.FECHA,A.VALOR4
";

//HelpFunct::writeQuery($query);


        $res = \DB::select($query);

        return $res;



    }




    //FUNCION HELPER DE CAMBIO DE FECHA DE YY-MM-DD A DD-MM-YY

    public function h_chageFormatDate($fecha)
    {

        $fecha = explode("-", $fecha);

        $fecha = $fecha[2] . "-" . $fecha[1] . "-" . $fecha[0];

        return $fecha;

    }


    //Obtener las guias atendidas de las ordenes de compras que se envian 
    public function getGuiasAtendidasOfOC($data)
    {

        $correlaivo = $data['correlativo']; //esto es para el corelativo de origen

        $secuencia = $data['secuencia']; // esto es para la secuencia de origen


        $r = \DB::select("select CONVERT(VARCHAR(19),d.Fecha,103) Fecha,
                          CONVERT(decimal(9,2),dd.Cantidad) Cantidad ,d.Numero, dd.Correlativo,dd.SecuenciaOrigen,
                          dd.CorrelativoOrigen
                          from
                          flexline.DocumentoD dd inner join flexline.Documento d
                          on dd.idDocto = d.idDocto
                          where d.TipoDocto like '%N/I ALMACEN (A)%'
                          and dd.TipoDoctoOrigen = 'ORDEN DE COMPRA (A)'
                          and dd.CorrelativoOrigen = $correlaivo
                          and dd.SecuenciaOrigen = $secuencia");

        return $r;

    }


    public function getComprobanteEgreso($data)
    {

        $correlativo = $data['correlativo'];
        $periodo = $data['periodo'];

        $query = "SELECT
A.CORRELATIVO,
CONVERT(DATE,A.FECHA,113) AS FECHA,
A.GLOSA AS PROVEEDOR,
'' AS DNI,
(SELECT TOP 1 GLOSA
FROM 
flexline.CON_MOVCOM 
WHERE 
EMPRESA=A.EMPRESA
AND TIPO_COMPROBANTE=A.TIPO_COMPROBANTE
AND CORRELATIVO=A.CORRELATIVO
AND PERIODO=A.PERIODO
AND CUENTA LIKE '010%') AS GIRADO_A,
A.DEBE_CUOTA AS DEBE_DOLAR,
A.HABER_CUOTA AS HABER_DOLAR,
A.DEBE_INGRESO AS DEBE_S,
A.HABER_INGRESO AS HABER_S,
(SELECT GLOSA
FROM 
flexline.CON_ENCCOM
WHERE 
EMPRESA=A.EMPRESA
AND TIPO_COMPROBANTE=A.TIPO_COMPROBANTE
AND CORRELATIVO=A.CORRELATIVO
AND PERIODO=A.PERIODO
) AS CONCEPTO,
(SELECT TOP 1 REFERENCIA
FROM 
flexline.CON_MOVCOM 
WHERE 
EMPRESA=A.EMPRESA
AND TIPO_COMPROBANTE=A.TIPO_COMPROBANTE
AND CORRELATIVO=A.CORRELATIVO
AND PERIODO=A.PERIODO
AND CUENTA LIKE '010%') AS N_CHEQUE,
(
SELECT TOP 1 DESCRIPCION
FROM 
flexline.CON_CTACON
WHERE 
EMPRESA=A.EMPRESA
AND CUENTA=A.CUENTA
and CUENTA LIKE '010%') AS BANCO,
(
SELECT ALIAS_CUENTA
FROM 
flexline.CON_CTACON
WHERE 
EMPRESA=A.EMPRESA
AND CUENTA=A.CUENTA) AS CUENTA,
(SELECT USUARIO
FROM 
flexline.CON_ENCCOM
WHERE 
EMPRESA=A.EMPRESA
AND TIPO_COMPROBANTE=A.TIPO_COMPROBANTE
AND CORRELATIVO=A.CORRELATIVO
AND PERIODO=A.PERIODO
) AS usuario

FROM 
flexline.CON_MOVCOM A
WHERE 
A.EMPRESA='E01'
AND A.TIPO_COMPROBANTE='EGRESO' --- DEBE COLOCAR USUARIO
AND A.CORRELATIVO='$correlativo' --- DEBE COLOCAR USUARIO
AND A.PERIODO='$periodo' -- DEBE COLOCAR USUARIO
";

        $res = \DB::select($query);

        $totales = new Obj();

        $totales->t_haber_s = 0;
        $totales->t_debe_s = 0;

        foreach ($res as $item) {

            $item->FECHA = explode('-', $item->FECHA);

            $item->FECHA = $item->FECHA[2] . '/' . $item->FECHA[1] . '/' . $item->FECHA[0];

            $totales->t_haber_s += $item->HABER_S;
            $totales->t_debe_s += $item->DEBE_S;

            $item->DEBE_DOLAR = number_format($item->DEBE_DOLAR, 2, '.', ',');
            $item->HABER_DOLAR = number_format($item->HABER_DOLAR, 2, '.', ',');
            $item->DEBE_S = number_format($item->DEBE_S, 2, '.', ',');
            $item->HABER_S = number_format($item->HABER_S, 2, '.', ',');

        }

        $response = new Obj();

        $response->data = $res;
        $response->totales = $totales;


        return $response;
    }


    public function getDatePositionByArray($array, $tipo, $orden)
    {

        $res = '';

        if ($orden == 'mayor') {

            $mayor = '';

            switch ($tipo) {

                case 'date':

                    $mayor = date_create_from_format('Y-m-d', $array[0]);

                    foreach ($array as $i) {

                        $val = date_create_from_format('Y-m-d', $i);

                        if ($val > $mayor) {
                            $mayor = $val;
                        }
                    }

                    break;
            }

            $res = $mayor;

        } else {

            $menor = '';


            switch ($tipo) {

                case 'date':

                    $menor = date_create_from_format('Y-m-d', $array[0]);

                    foreach ($array as $i) {

                        $val = date_create_from_format('Y-m-d', $i);

                        if ($val < $menor) {
                            $menor = $val;
                        }
                    }

                    break;
            }

            $res = $menor;

        }


        return $res;

    }


    /**
     * la funcion manda al el item que tien el coidgo que se necesita
     * @param $array
     * @param $codigo
     *
     */
    public function getObjectsFundos($array, $codigo)
    {

        $res = '';
        foreach ($array as $item) {
            $temp = substr($codigo->cci, 3, 2);
            $code = substr($item['CODIGO'], 7, 3);

            if ($temp == $code) {
                $res = $item;
                break;
            }
        }

        return $res;
    }


    public function getConsumoByParronAnCCI($f_ini, $f_fin, $cci, $producto)
    {

        $query = "SELECT SUM( Cantidad) cantidad,SUM(costo*Cantidad) total, '$cci' cci
                    FROM flexline.DocumentoD 
                    where CONVERT(date,Fecha) BETWEEN '$f_ini' AND '$f_fin'
                    AND TipoDocto in ('SALIDA ALMACEN','TRANSF P/ PRODUCTO')
                    AND Analisis15 = '$cci'
                    AND Producto = '$producto'";


        //HelpFunct::writeQuery($query);

        $res = \DB::select($query);




        return $res[0];
    }








}