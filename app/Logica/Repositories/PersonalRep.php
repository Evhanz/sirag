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

        return $res;

    }


    public function getTrabajadorByFicha($ficha)
    {
        $res = \DB::select("select * from v_allTrabajadores where FICHA = '$ficha'");
        return $res[0];
    }

    public function getContratos($ficha){
        $res = \DB::select("SELECT FICHA,CONVERT(decimal(9,2),REMUNERACION) as remuneracion
                            , CONVERT(date, CAST(FECHA_INICIO AS CHAR(8)), 112) as fecha_inicio
                            , CONVERT(date, CAST(FECHA_TERMINO AS CHAR(8)), 112) as fecha_fin
                            FROM flexline.PER_REM_HIS where FICHA = '$ficha' order by fecha_inicio desc");

        return $res;
    }

    public function getRenovaionesByFicha($ficha){

        $res = \DB::select(" select * from
                              renov_contract 
                              where FICHA = '$ficha'");

        return $res;

    }


    public function addNewRenovacion($data){

        /*
         *
         * insert into renov_contract (tipo,fecha_inicio,fecha_fin,observacion,f_fin_cambiada,FICHA)
  values ('','','','','','')
         *
         */

        $tipo = 'renovacion';
        $fecha_inicio = $data['f_i'];
        $fecha_fin = $data['f_f'];
        $f_fin_cambiada = $data['f_fin_cambiada'];
        $observacion = $data['observacion'];
        $ficha = $data['ficha'];

        $res = \DB::insert("insert into renov_contract (tipo,fecha_inicio,fecha_fin,observacion,f_fin_cambiada,FICHA,estado)
                              values ('$tipo','$fecha_inicio','$fecha_fin','$observacion','$f_fin_cambiada','$ficha',1)");

        return $res;

    }



}