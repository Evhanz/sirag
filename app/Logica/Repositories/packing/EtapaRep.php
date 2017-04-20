<?php
/**
 * Created by PhpStorm.
 * User: ehernandez
 * Date: 19/04/2017
 * Time: 11:49 AM
 */

namespace sirag\Repositories\packing;


class EtapaRep
{

    public function regSeleccion($data){

        $uva = $data['uva'];
        $calibre = $data['calibre'];

        $query = "INSERT INTO sirag.etapa(tipo,uva,calibre,fecha,hora,usuario,estado,codigo)
                  VALUES
                  ('seleccion','$uva','$calibre')";

        $res = \DB::insert($query);

        return $res;
    }

}