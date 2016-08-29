<?php
/**
 * Created by PhpStorm.
 * User: ehernandez
 * Date: 26/08/2016
 * Time: 05:40 PM
 */

namespace sirag\Repositories;


class PersonalRep
{

    public function getAllTrabajadoresByParameter($data)
    {

        $categoria = $data['categoria'];
        $vigencia = $data['vigencia'];
        $f_i = $data['f_i'];
        $f_f = $data['f_f'];

        $res = \DB::select("EXEC sp_getTrabajadoresByParametes @categoria = '%$categoria%' , @vigencia = '$vigencia' , @f_i = '$f_i', @f_f = '$f_f'");

        return $res;
    }

    public function getTrabajadoresByParamOutDates ($data)
    {
        $categoria = $data['categoria'];
        $vigencia = $data['vigencia'];

        $res = \DB::select("EXEC sp_getTrabajadoresByParamOutDates @categoria = '%$categoria%' , @vigencia = '$vigencia' ;");

       // $res = "EXEC sp_getTrabajadoresByParamOutDates @nombre = '%$nombre%' , @dni = '%$dni%' ;";

        return $res;

    }

}