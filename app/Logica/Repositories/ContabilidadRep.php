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


        $query = "exec dbo.sp_getBalanceByNiveles @fi=?,@ff=?,@nivel=?";
       
        $res_query = \DB::select($query,array($fi,$ff,$nivel));
         /*
        foreach ($res_query as $item) {
            $item->DESCRIPCION = utf8_decode($item->DESCRIPCION);
        }

        $data = new DocumentoDTO();

        $res = collect($res_query);
        $data->total_SI_DEUDOR = $res->sum('SI_DEUDOR');
        $data->total_SI_ACREEDOR = $res->sum('SI_ACREEDOR');
        $data->total_MOV_DEBE = $res->sum('MOV_DEBE');
        $data->total_MOV_HABER = $res->sum('MOV_HABER');
        $data->total_SF_DEUDOR = $res->sum('SF_D');
        $data->total_SF_ACREEDOR = $res->sum('SF_H');
        $data->items = $res;
        */
        return $res_query;
    }








}