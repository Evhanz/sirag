<?php
/**
 * Created by PhpStorm.
 * User: ehernandez
 * Date: 16/05/2017
 * Time: 05:36 PM
 */

namespace sirag\Repositories;


use sirag\Helpers\HelpFunct;

class CostoRep
{
    public function getDistribucion($correlativo){

    }

    public function insertCabeceraDistribucion($data){


        $keys= array_keys($data);
        $key  = implode(',',$keys);
        //$values = implode("','",$data);
        $values = '';
        foreach ($data as $val){

            if($val == null || $val == ''){
                $values .="null,";

            }else{
                $values .= "'$val',";
            }

        }
        $values = trim($values,',');


       // \DB::insert('insert into ');
        $table = '##TablaTemporal';
        $bandera = $this->processTemporalTable($keys,'##TablaTemporal');

        $query = "insert into $table values($values)";

        $res = \DB::insert($query);

        return $res;

    }

    public function insertDetallesDistribucion($correlativo,$fecha){


    }

    public function getCabeceraDistribucion($correlativo){

    }

    public function getDetallesDistribucion($correlativo){

    }

    //pasar a una clase helper

    /**
     * @param $keys= es e array de keys que se van a crear la tabla
     * @param $tabla = nombre de la tabla a crear
     * @return int = bandea que vali
     */

    public function processTemporalTable($keys,$tabla){



        $keys  = implode(' varchar(200),',$keys);
        $keys .= ' varchar(200)';

        $bandera = 0;

        $query = "if object_id('tempdb..$tabla') > 0 
            begin
                drop  table $tabla
            end
        else
        CREATE TABLE $tabla ($keys)
                    ";

        \DB::statement($query);

        HelpFunct::writeQuery($query);


        return $bandera;

    }

}