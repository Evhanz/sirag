<?php
/**
 * Created by PhpStorm.
 * User: ehernandez
 * Date: 10/05/2017
 * Time: 03:45 PM
 */

namespace sirag\Repositories\packing;


use sirag\Helpers\HelpFunct;

class PalletRep
{

    public function getAllPallet(){

        $res = \DB::table('sirag.pallet')->get();

        return $res;

    }


    public function getPalletByCodigo($codigo){

        $res = \DB::table('sirag.pallet')->where('codigo',$codigo)->get();

        return $res;
    }

    public function regPallet($data){

        $res = \DB::table('sirag.pallet')->insertGetId($data);

        return $res;

    }

    public function editPallet($detalles,$codPallet,$estado){

        $codigos_etapas = '';


        foreach ($detalles as $item){
            $codigos_etapas = $codigos_etapas.$item['id_caja'].',';
        }

        $codigos_etapas=trim($codigos_etapas, ',');

        $query = "UPDATE sirag.etapa
                        SET cod_pallet=$codPallet,estado = $estado
                        WHERE 
                       codigo in ($codigos_etapas)";

        $res = \DB::update($query);

        HelpFunct::writeQuery($query);

        return $res;

    }

    public function deleteDetailPallet($id){

    }

    public function insetDetailPallet($id){

    }

    public function getDetailsPallet($id){


        $res = \DB::select("select p.id, 
        p.fecha_registro,
        p.fecha_vencimiento,
        p.estado,
        e.id cod_caja,
        (select NOMBRE+' '+APELLIDO_PATERNO+' '+APELLIDO_MATERNO 
        from flexline.PER_TRABAJADOR
        where EMPRESA = 'e01'
        and EMPLEADO = e.u_seleccion
        )seleccion,
        (select NOMBRE+' '+APELLIDO_PATERNO+' '+APELLIDO_MATERNO 
        from flexline.PER_TRABAJADOR
        where EMPRESA = 'e01'
        and EMPLEADO = e.u_seleccion
        ) pesaje ,
        (select NOMBRE+' '+APELLIDO_PATERNO+' '+APELLIDO_MATERNO 
        from flexline.PER_TRABAJADOR
        where EMPRESA = 'e01'
        and EMPLEADO = e.u_seleccion
        )embalaje
        from 
        sirag.pallet p inner join sirag.etapa e on p.id = e.cod_pallet
        where p.id = $id");

        return $res;


    }

}