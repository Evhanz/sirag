<?php
/**
 * Created by PhpStorm.
 * User: ehernandez
 * Date: 10/05/2017
 * Time: 03:45 PM
 */

namespace sirag\Repositories\packing;


use sirag\Entities\Obj;
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

    /*Esto es para insertar los detalles*/

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

        return $res;
    }

    public function deleteDetailPallet($codigo){

        /*solo actuliza las cajas y blanquea sus estados */

        $query = "UPDATE sirag.etapa
                  SET cod_pallet=NULL ,estado = 0
                  WHERE 
                  cod_pallet = $codigo";

        $res = \DB::update($query);

        HelpFunct::writeQuery($query);

        return $res;



    }

    public function insetDetailPallet($id){

    }

    public function getDetailsPallet($codigo,$limit=null){

        $q1 = '';

        if($limit != null){
            $q1 = "top $limit ";
        }

        $query = "SELECT $q1 e.codigo,e.uva,
        e.t_caja,
        e.calibre,
        p.id, 
        p.fecha_registro,
        p.fecha_vencimiento,
        p.estado,
        e.id cod_caja,
        (select NOMBRE+' '+APELLIDO_PATERNO+' '+APELLIDO_MATERNO 
        from flexline.PER_TRABAJADOR
        where EMPRESA = 'e01'
        and FICHA = e.u_seleccion
        )seleccion,
        (select NOMBRE+' '+APELLIDO_PATERNO+' '+APELLIDO_MATERNO 
        from flexline.PER_TRABAJADOR
        where EMPRESA = 'e01'
        and FICHA = e.u_pesaje
        ) pesaje ,
        (select NOMBRE+' '+APELLIDO_PATERNO+' '+APELLIDO_MATERNO 
        from flexline.PER_TRABAJADOR
        where EMPRESA = 'e01'
        and FICHA = e.u_embalaje
        )embalaje
        FROM sirag.etapa e 
        INNER join sirag.pallet p on e.cod_pallet=p.codigo
        where p.codigo = $codigo";


        $res = \DB::select($query);

        return $res;


    }

    public function getAllPalletPaginate($fecha=null){

        if($fecha==null){
            $res = \DB::table('sirag.pallet')->paginate(3);
        }else{

            $res = \DB::table('sirag.pallet')->
            whereRaw("CONVERT(DATE,fecha_registro,103) ='".$fecha."'")->
            paginate(3);
        }


        return $res;

    }

    public function getAllPalletPaginateFechas($f_i,$f_f){

        $res = \DB::table('sirag.pallet')->
            where('fecha_registro','>=',$f_i)->where('fecha_registro','<=',$f_f)->paginate(3);
        return $res;

    }

    public function getCountNowPallet($fecha){
        $res = \DB::table('sirag.pallet')->whereRaw("CONVERT(DATE,fecha_registro,103) ='".$fecha."'")->get();
        return $res;

    }


    public function getPalletByCodigoWithDetails($codigo){

        $res = \DB::table('sirag.pallet')->where('codigo',$codigo)->get();

        if(isset($res[0])){
            $res = $res[0];
            $res->detalles = $this->getDetailsPallet($codigo);
            $res->t_caja = $res->detalles[0]->t_caja;
            $res->calibre = $res->detalles[0]->calibre;
            $res->cant_cajas = count($res->detalles);
            $res->detail_show = false;
        }

        return $res;
    }

    public function getPalletByFechas($f_inicio,$f_fin){

        $query = "select
                p.codigo codigo,
                e.t_caja,
                e.calibre,
                p.id, 
                p.fecha_registro,
                p.fecha_vencimiento,
                p.estado,
                e.id cod_caja,
                (select NOMBRE+' '+APELLIDO_PATERNO+' '+APELLIDO_MATERNO 
                from flexline.PER_TRABAJADOR
                        where EMPRESA = 'e01'
                        and FICHA = e.u_seleccion
                        )seleccion,
                        (select NOMBRE+' '+APELLIDO_PATERNO+' '+APELLIDO_MATERNO 
                        from flexline.PER_TRABAJADOR
                        where EMPRESA = 'e01'
                        and FICHA = e.u_pesaje
                        ) pesaje ,
                        (select NOMBRE+' '+APELLIDO_PATERNO+' '+APELLIDO_MATERNO 
                        from flexline.PER_TRABAJADOR
                        where EMPRESA = 'e01'
                        and FICHA = e.u_embalaje
                        )embalaje
                FROM sirag.etapa e 
                INNER join sirag.pallet p on e.cod_pallet=p.codigo
                where CONVERT(date,p.fecha_registro,103) >='$f_inicio' AND  CONVERT(date,p.fecha_registro,103) <= '$f_fin'
                order by p.codigo";


        $res = \DB::select($query);

        return $res;
    }


}