<?php
/**
 * Created by PhpStorm.
 * User: ehernandez
 * Date: 14/09/2016
 * Time: 05:08 PM
 */

namespace sirag\Repositories;

use sirag\DTO\DocumentoDTO;


class ContabilidadRep
{

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

      }

       return $doc;

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











}