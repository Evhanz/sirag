<?php
/**
 * Created by PhpStorm.
 * User: ehernandez
 * Date: 10/08/2016
 * Time: 02:16 PM
 */

namespace sirag\Repositories;
use sirag\DTO\DocumentoDTO;
use sirag\DTO\DetalleDocDTO;

class DocumentoRep
{

    /*funcion para sacar los reportes de los documentos*/
    public function getDocumentoByParameters($data)
    {
        $docDTO = new DocumentoDTO();

        $f_inicio = $data['f_inicio'];
        $f_fin = $data['f_fin'];
        $tipo_doct =$data['tipoDoct'];


        //echo("EXECUTE ps_getVAllDocsByParameters @f_inicio= '$f_inicio', @f_fin= '$f_fin', @t_comprobante= '$tipo_doct' ");

        //primero traemos a todos los documentos
        $docDTO = \DB::select("EXECUTE ps_getVAllDocsByParameters @f_inicio= '$f_inicio', @f_fin= '$f_fin', @t_comprobante= '$tipo_doct' ");



        return $docDTO;


    }


    /*funciones ghelpers que pueden ser usadas si son requeidas*/

    //--funcion para traer detalle del documento con el producto asigndo a este producto
    public function getDetalleDocByID($id)
    {
        $dtalleDocDTO = new DetalleDocDTO();

        $dtalleDocDTO = \DB::select("exec ps_getVAllDetailsByIdDoc @Id = $id;");

        return $dtalleDocDTO;

    }


    /*Para traer las ordenes de compra */

    public function getOrdenesCompras($data)
    {
        $doc = new DocumentoDTO();


        $proveedor = $data['proveedor'];
        $f_inicio = $data['f_inicio'];
        $f_fin = $data['f_fin'];
        $numero = $data['numero'];
        $vigencia = $data['vigencia'];

        $doc = \DB::select("SELECT RazonSocial as EMPRESA,CONVERT(VARCHAR(19),Fecha,103) FechaF,Fecha,idDocto,TipoDocto,Correlativo,Numero,
                            COUNT(Producto) as Productos
                            FROM v_ordenCompra_details
                            where Fecha BETWEEN '$f_inicio' AND '$f_fin'
                            AND RazonSocial like '%$proveedor%'
                            AND Numero like '%$numero%'
                            AND Vigencia like '%$vigencia%'
                            group by RazonSocial,Fecha,idDocto,TipoDocto,Correlativo,Numero
                            ORDER BY Fecha DESC ");



       return $doc;


    }

    public function getDetailOrden($id)
    {

        $d = new DetalleDocDTO();

        $d = \DB::select("SELECT Correlativo,TipoDocto,idDoctoDet,Secuencia,GLOSA,UnidadIngreso,
                            convert(float, Cantidad)as Cantidad
                            FROM v_ordenCompra_details
                            where idDocto = $id");

        foreach($d as $i){

            $data['corelativo'] = $i->Correlativo;
            $data['secuencia'] = $i->Secuencia;

            $i->guia = $this->getGuiaPorDetailAtended($data);

            $i->nGuia = count($i->guia);

            if($i->nGuia >0)
            {
                $i->cant_atendida = $this->addTotalOfGuia($i->guia);
            }else
                $i->cant_atendida = 0;


            $i->estado = $this->estadoOrden($i->Cantidad,$i->cant_atendida,$i->nGuia);

        }

        return $d;
    }

    public function getGuiaPorDetailAtended($data)
    {

        $correlaivo = $data['corelativo']; //esto es para el corelativo de origen

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

    public function addTotalOfGuia($data)
    {

        $suma = 0;

        foreach($data as $i)
        {
            $suma += $i->Cantidad;
        }

        return $suma;
    }

    public function estadoOrden($cantidad,$cant_atendida,$n_guia)
    {
        $res = "";
        if($cantidad == $cant_atendida){
            $res = 'atendido';
        }else if($cantidad > $cant_atendida && $n_guia >0){
            $res = 'falta';
        }elseif($n_guia == 0){
            $res = 'natendido';
        }

        return $res;

    }

    /**
     * Esta funcion trae sa guias que le faltan las factura
     */
    public function getGuiaFaltaFactura($f){

        //$f = '2017-01';

        $query = "SELECT CONVERT(DATE,FECHA_GUIA) FECHA,GUIA,RAZON_SOCIAL
FROM (
SELECT 
B.Fecha AS FECHA_GUIA,
A.NUMERO AS GUIA,
C.RazonSocial AS RAZON_SOCIAL,
(SELECT Y.Numero
FROM 
flexline.DocumentoD X,
FLEXLINE.DOCUMENTO Y
WHERE 
X.idDocto=Y.idDocto
AND X.Empresa=B.Empresa
AND X.CorrelativoOrigen=B.Correlativo
AND X.TipoDoctoOrigen=B.TipoDocto
AND X.SecuenciaOrigen=B.Secuencia
AND X.TipoDocto in ('01 F/C ALMACEN (A)','01 F/C ALMACEN ELEC','12 TICKETS O CINTA (A)')
GROUP BY Y.NUMERO) AS FACTURA
FROM 
flexline.Documento A,
flexline.DocumentoD B,
flexline.CtaCte C
WHERE
A.idDocto=B.idDocto
AND A.Empresa=C.Empresa
AND A.TipoCtaCte=C.TipoCtaCte
AND A.IdCtaCte=C.CtaCte 
AND B.Empresa='E01'
AND B.TipoDocto='N/I ALMACEN (A)'
AND CONVERT(date,b.fecha,113) like '$f-%'---- DEBE FILTRAR POR PERIODO
) AS GUIAS
WHERE FACTURA IS NULL
GROUP BY FECHA_GUIA , GUIA,RAZON_SOCIAL
order by FECHA_GUIA";

        $res = \DB::select($query);


        foreach ($res as $item){
            $fecha = $item->FECHA ;
            $fecha = explode('-',$fecha);
            $item->FECHA = $fecha[2].'-'.$fecha[1].'-'.$fecha[0] ;
        }


        return $res;


    }

    public function getRequerimiento($data){

        if($data['tipo']=='ambos'){

            $q_tipo= " AND D.TipoDocto IN ('R/COMPRA (A)','R/C SERVICIO') " ;

        }else{
            $tipo = $data['tipo'];
            $q_tipo= " AND D.TipoDocto = '$tipo' " ;
        }

        $f_inicio = $data['f_inicio'];
        $f_fin = $data['f_fin'];
        $vigencia = $data['vigencia'];
        $aprobacion = $data['aprobacion'];


        $query = "SELECT D.COMPRADOR,D.NUMERO,CONVERT(DATE,D.Fecha,113) AS FECHA, DD.Producto,P.UNIDAD,P.GLOSA,DD.Cantidad,
                D.Vigencia,D.Aprobacion,D.UsuarioAprueba, CONVERT(DATE,D.FechaAprueba,113) AS FECHA_APRUEBA
                FROM 
                flexline.Documento D,
                FLEXLINE.DocumentoD DD,
                flexline.PRODUCTO P
                WHERE 
                D.idDocto=DD.idDocto
                AND DD.Empresa=P.EMPRESA
                AND DD.Producto=P.PRODUCTO
                AND D.Empresa='E01'
                $q_tipo -- DEBE FILTRAR POR 3 OPCIONES QUE SON 'R/C SERVICIO' , 'R/COMPRA (A)' Y LOS 2 A LA VEZ
                AND D.Vigencia like '%$vigencia%'--- DEBE FILTRAR POR 3 OPCIONES QUE SON 'S'=SIGUE VIGENTE , 'N'= NO ESTA VIGENTE Y LOS 2 A LA VEZ
                AND D.Aprobacion like '%$aprobacion%'--- DEBE FILTRAR POR 3 OPCIONES QUE SON 'S'=APROBADO , 'N'= NO APROBADO , 'P'=PENDIENTE APROBAR Y LOS 3 A LA VEZ
                AND D.Fecha BETWEEN '$f_inicio' AND '$f_fin' -- FILTRAR POR RANGO DE FECHAS
                ORDER BY D.Fecha , D.Numero
                ";

        $res = \DB::select($query);

        $res = collect($res);

        $res = $res->groupBy('NUMERO');

        return $res->toArray();

    }

    public function getAFP(){

        $query = "select * from flexline.gen_tabcod where EMPRESA='e01'  and TIPO='PER_AFP' ";

        $res = \DB::select($query);

        return $res;


    }
    public function getComision(){
        $query = "select * from flexline.gen_tabcod where EMPRESA='e01' and TIPO='PER_TIPO.COMISION'";

        $res = \DB::select($query);

        return $res;
    }

    /*esto edita la GEN_TABLA*/

    public function editPorcentajeAFP($columna,$value,$periodo,$descripcion){

        $res = \DB::table("DBO.GEN_TABLA")
            ->where('empresa','E01')
            ->where('cod_tabla','TABLAAFP')
            ->where('codigo1',$periodo)
            ->where('descripcion',$descripcion)
            ->update([$columna=>$value]);

        return $res;
    }


    /*esto edita la flexline.PER_TRAMOS*/

    public function editPorcentajeAFPEmpleados($columna,$value,$descripcion,$codigo){

        $res = \DB::table("flexline.PER_TRAMOS")
            ->where('empresa','E01')
            ->where('CODIGO',$codigo)
            ->where('FECHA_INICIO','20120901')
            ->where('DESDE',$descripcion)
            ->update([$columna=>$value]);

        return $res;
    }



}