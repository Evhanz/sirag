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








}