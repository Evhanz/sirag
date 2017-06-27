<?php
/**
 * Created by PhpStorm.
 * User: ehernandez
 * Date: 20/06/2017
 * Time: 05:57 PM
 */

namespace sirag\Repositories\packing;


use sirag\Helpers\HelpFunct;

class MovimientoRep
{

    public function insert($data){
        $res = \DB::table('sirag.movimiento')->insertGetId($data);

        return $res;

    }

    public function insertDetails($data){
        $res = \DB::table('sirag.detalle_movimiento')->insertGetId($data);

        return $res;
    }

    public function getMovimientosByParams($f_i,$f_f,$tipo){
        $query = "select *,(SELECT COUNT (*) FROM 
                    sirag.detalle_movimiento
                    where id_movimiento = m.id) cant_pallet
                    FROM sirag.movimiento m
                    where CONVERT(date,fecha,103) >= '$f_i' AND
                    CONVERT(date,fecha,103) <= '$f_f'
                    and tipo = '$tipo'";
        
        $res = \DB::select($query);

        return $res;
    }

    public function delete(){

    }

    public function update($tipo){

    }

    public function getMovimiento($tipo){

    }

    public function deleteDetailsMovimiento($id){

    }

    public function getCheckDetalleMovimiento($codigo_pallet,$origen,$destino,$tipo){

        $query  = "SELECT *
        FROM sirag.detalle_movimiento
        where id_entidad = $codigo_pallet
        AND origen = '$origen'
        and destino = '$destino'
        AND tipo = '$tipo'";

        $res = \DB::select($query);
        HelpFunct::writeQuery($query);
        return $res;
    }


}