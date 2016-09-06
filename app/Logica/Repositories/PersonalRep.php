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


        $tipo = 'renovacion';
        $fecha_inicio = $data['f_i'];
        $fecha_fin = $data['f_f'];
        $f_fin_cambiada = $data['f_fin_cambiada'];
        $observacion = $data['observacion'];
        $ficha = $data['ficha'];
        $res ='ok';
        //primero insertamos los valores y luego actualizaremos los valores de las tablas
        //PER_TRABJADOR & PER_REM_HIS

        \DB::transaction(function () use ($tipo,$fecha_inicio,$fecha_fin,$f_fin_cambiada,$observacion,$ficha) {
            \DB::insert("INSERT INTO renov_contract (tipo,fecha_inicio,fecha_fin,observacion,f_fin_cambiada,FICHA,estado)
                              values ('$tipo','$fecha_inicio','$fecha_fin','$observacion','$f_fin_cambiada','$ficha',1)");
            //luego cambiamos el formato en la funcion

            $f_f = $this->changeFormat($fecha_fin);

            \DB::update("UPDATE flexline.PER_TRABAJADOR
                        SET FECHA_TERMINO='$f_f'
                        WHERE FICHA='$ficha';");

            \DB::update("UPDATE flexline.PER_REM_HIS
                        SET FECHA_TERMINO='$f_f'
                        WHERE FICHA='$ficha';");

        });

        return $res;

    }


    public function deleteRenovacion($id,$ficha,$fecha_fin){

        //$fecha_fin : es la fecha que fue almacenada en la renovacion de contrato para poder
        // resguardar de que fecha se
        //modifico


        \DB::transaction(function () use ($id,$ficha,$fecha_fin) {

            $f_f = $this->changeFormat($fecha_fin);

            \DB::delete("DELETE FROM renov_contract
                        WHERE id=$id;");

            \DB::update("UPDATE flexline.PER_TRABAJADOR
                        SET FECHA_TERMINO='$f_f'
                        WHERE FICHA='$ficha';");

            \DB::update("UPDATE flexline.PER_REM_HIS
                        SET FECHA_TERMINO='$f_f'
                        WHERE FICHA='$ficha';");

        });

        
    }



    public function changeFormat ($fecha){

        $fecha = explode("-", $fecha);

        $fecha = $fecha[2].$fecha[1].$fecha[0];
        return $fecha;
    }



}