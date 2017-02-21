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


class ContabilidadRep
{


    public function getCciByCodigo($codigo)
    {

        $query = "SELECT CODIGO,DESCRIPCION,TEXTO1 FROM flexline.GEN_TABCOD
            WHERE EMPRESA = 'E01'
            AND TIPO = 'CON_CCOSTO_INTERNO'
            AND CODIGO = '$codigo'";

        $res = \DB::select($query);

        if(count($res)>0){
            return $res[0];
        }else{
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
        $data->total_SI_DEUDOR = number_format($res->sum('SI_DEUDOR'),2,'.',',');
        $data->total_SI_ACREEDOR = number_format($res->sum('SI_ACREEDOR'),2,'.',',');
        $data->total_MOV_DEBE = number_format($res->sum('MOV_DEBE'),2,'.',',');
        $data->total_MOV_HABER = number_format($res->sum('MOV_HABER'),2,'.',',');
        $data->total_SF_DEUDOR = number_format($res->sum('SF_D'),2,'.',',');
        $data->total_SF_ACREEDOR = number_format($res->sum('SF_H'),2,'.',',');

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
    public function getOrdenCompraForControl($data){

      $proveedor = $data['proveedor'];
      $f_inicio = $data['f_inicio'];
      $f_fin = $data['f_fin'];
      $numero = $data['numero'];
      $vigencia = $data['vigencia'];
      $doc = \DB::select("SELECT v.Numero,convert(DATE,v.Fecha)AS FECHA,v.RazonSocial, v.UnidadIngreso,v.cod_producto, v.GLOSA,CONVERT(decimal(9,2),v.Cantidad) AS Cantidad
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
                          ORDER BY Fecha DESC ");

      foreach ($doc as $item) {
        
        if ($item->Cantidad > $item->ATENDIDO && $item->ATENDIDO> 0) {
          $item->estado = 'PENDIENTE';
        } 
        
        if ($item->Cantidad == $item->ATENDIDO ) {
          $item->estado = 'COMPLETADO';
        }
        if ($item->ATENDIDO == 0) {
          $item->estado = 'NO ATENDIDO';
        }
        
        //------- esto es para traer a las guias que fueron atendidas a la orden de compra
       

       //---
             

        $item->Cantidad      = number_format($item->Cantidad,2,'.',',');
        $item->ATENDIDO      = number_format($item->ATENDIDO,2,'.',',');
        $item->FECHA         = $this->h_chageFormatDate($item->FECHA);
        $item->PrecioIngreso = number_format($item->PrecioIngreso,3,'.',',');
        $item->FECHA_ENTREGA = $this->h_chageFormatDate($item->FECHA_ENTREGA);

      }

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

      

      return $res ;

    }

    public function getFundos()
    {
      $query ="SELECT CODIGO FROM flexline.GEN_TABCOD
              WHERE EMPRESA='E01'
              AND TIPO='GEN_FUNDO'
              AND VIGENCIA NOT IN('N','S') ";

      $res = \DB::select($query);

      return $res;

    }

    public function getParronByFundo($fundo)
    {
      
      $query = "SELECT CODIGO,VALOR1 FROM flexline.GEN_TABCOD
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

      if ($data['cc']=='materiaPrima'){

          $query = "SELECT PRODUCTO,GLOSA,SUBFAMILIA from flexline.PRODUCTO
                where FAMILIA = 'MATERIA PRIMA' 
                and EMPRESA = 'e01'
                ORDER by SUBFAMILIA";
      }else{

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
          $consumo = $this->getConsumoByFechasAndProducto($parron['startDate'],$parron['endDate'],$item->PRODUCTO,$parron['CODIGO'],$data['cc']);

          $dto->name_parron = $parron['CODIGO'];
          $dto->area = $parron['VALOR1'];
          $dto->total_cantidad_consumo = $consumo->cantidad;
          $dto->total_precio_consumo = $consumo->total;
          $dto->precio_ha = number_format($consumo->total/$parron['VALOR1'],2,'.','');

          /*
          $dto->costo = $consumo->costo;
          $dto->cantidad = $consumo->cantidad;
          */

          array_push($p, $dto);
        }

        $item->analisis_parron = $p;

      }

      //se trae la data de los parrones que no an sido asignados 
      $fundo      = $data['fundo'];
      $otros      = $data['otros'];
      $otros_f_i  = $otros['startDate'];
      $otros_f_f  = $otros['endDate'];

      //se valida si el centro de costo para manejar la consulta
      if ($data['cc']=='materiaPrima'){
        $query = "SELECT PRODUCTO,DESCRIPCION,SUM(CANTIDAD) cantidad ,SUM(TOTAL) total
                from dbo.v_getConsumoMateriaPrima
                WHERE FUNDO = '$fundo'
                and FECHA BETWEEN '$otros_f_i' and '$otros_f_f'  
                AND PARRON NOT LIKE '%PARRON%' 
                GROUP BY PRODUCTO,DESCRIPCION ";
      }else{
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

      $res['parrones']  = $data['parrones'] ;
      $res['productos'] = $productos;
      $res['otros']     = collect($res_otros);
      $res['f_otros_i'] = $otros_f_i;//fecha de los productos que no registran parron
      $res['f_otros_f'] = $otros_f_f;


      return $res;
    }


    public function getConsumoByFechasAndProducto($fecha_i,$fecha_f,$producto,$parron,$cc)
    {

      if ($cc =='materiaPrima'){
          $query = " SELECT CONVERT(DECIMAL(12,2),SUM(CANTIDAD)) cantidad, CONVERT(DECIMAL(12,2),SUM(TOTAL)) total 
          FROM dbo.v_getConsumoMateriaPrima  
          where PRODUCTO = '$producto' 
          and FECHA BETWEEN '$fecha_i' and '$fecha_f'  
          and PARRON = '$parron'  ";

      }else{
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
     * en el proceso del ERP
     */

    public function getDataForExcelConsumo2($data){



        $codigos = [];


        foreach($data['parron'] as $p){

        }




    }



    //FUNCION HELPER DE CAMBIO DE FECHA DE YY-MM-DD A DD-MM-YY

    public function h_chageFormatDate($fecha)
    {

      $fecha = explode("-", $fecha);

      $fecha = $fecha[2]."-".$fecha[1]."-".$fecha[0];

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

        $totales->t_haber_s =0;
        $totales->t_debe_s =0;

        foreach ($res as $item){

            $item->FECHA = explode('-',$item->FECHA);

            $item->FECHA = $item->FECHA[2].'/'.$item->FECHA[1].'/'.$item->FECHA[0];

            $totales->t_haber_s +=  $item->HABER_S;
            $totales->t_debe_s +=  $item->DEBE_S;

            $item->DEBE_DOLAR = number_format($item->DEBE_DOLAR ,2,'.',',');
            $item->HABER_DOLAR = number_format($item->HABER_DOLAR ,2,'.',',');
            $item->DEBE_S = number_format($item->DEBE_S ,2,'.',',');
            $item->HABER_S = number_format($item->HABER_S ,2,'.',',');

        }

        $response = new Obj();

        $response->data = $res;
        $response->totales = $totales;


        return $response;

    }













}