<?php
/**
 * Created by PhpStorm.
 * User: ehernandez
 * Date: 10/05/2017
 * Time: 03:45 PM
 */

namespace sirag\Repositories\packing;


class PalletRep
{

    public function regPallet($data){

        $uva = $data['uva'];
        $calibre = $data['calibre'];
        $t_caja = $data['t_caja'];
        $peso = $data['peso'];
        $embalaje = $data['embalaje'];
        $fecha = $data['fecha'];
        $seleccion = $data['seleccion'];
        $pesaje = $data['pesaje'];



        $res = \DB::table('sirag.pallet')->insertGetId(
            ['t_caja' => $t_caja, 'uva' => $uva,'calibre' => $calibre,'peso' => $peso,
                'e_embalaje'=>'', 'fecha' => $fecha,'hora' => '00:00', 'usuario' => 'EHERNANDEZ',
                'estado' => 1,'u_seleccion'=>$seleccion,'u_pesaje'=>$pesaje, 'u_embalaje' => $embalaje]
        );

        return $res;

    }

    public function editPallet(){

    }

    public function deleteDetailPallet($id){

    }

    public function insetDetailPallet($id){

    }

    public function getDetailsPallet($id){

    }

}