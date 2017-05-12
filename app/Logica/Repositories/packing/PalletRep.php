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

        $res = \DB::table('sirag.pallet')->insertGetId($data);

        return $res;

    }

    public function editPallet($detalles,$codPallet,$estado){

        $codigos_etapas = '( ';

        foreach ($detalles as $item){
            $codigos_etapas = $codigos_etapas.$item['id_caja'].',';
        }

        $codigos_etapas = $codigos_etapas.')';

        $res = \DB::update("UPDATE sirag.pallet
                        SET cod_pallet=$codPallet,estado = $estado
                        WHERE 
                       id in ($codigos_etapas)");

        return $res;

    }

    public function deleteDetailPallet($id){

    }

    public function insetDetailPallet($id){

    }

    public function getDetailsPallet($id){

    }

}