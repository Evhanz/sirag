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

    public function regEtapa($data){

        $uva = $data['uva'];
        $calibre = $data['calibre'];
        $t_caja = $data['t_caja'];
        $peso = $data['peso'];
        $embalaje = $data['embalaje'];
        $fecha = $data['fecha'];
        $seleccion = $data['seleccion'];
        $pesaje = $data['pesaje'];

       /* $query = "INSERT INTO sirag.etapa(t_caja,uva,calibre,peso,embalaje,fecha,hora,usuario,estado,u_seleccion,u_pesaje,u_embalaje)
                  VALUES
                  ('seleccion','$uva','$calibre')";*/


        // $res = \DB::insert($query);

        $res = \DB::table('sirag.etapa')->insertGetId(
            ['t_caja' => $t_caja, 'uva' => $uva,'calibre' => $calibre,'peso' => $peso,
                'e_embalaje'=>'', 'fecha' => $fecha,'hora' => '00:00', 'usuario' => 'EHERNANDEZ',
                'estado' => 0,'u_seleccion'=>$seleccion,'u_pesaje'=>$pesaje, 'u_embalaje' => $embalaje]
        );

        return $res;
    }

    public function getAllEtapa(){
        $res = \DB::table('sirag.etapa')->paginate(15);
        return $res;
    }

    public function getEtapaByParameter($f_inicio,$fecha_fin){

        $res = \DB::table('sirag.etapa')->where('fecha','>=',"$f_inicio")
            ->where('fecha','<=',"$fecha_fin")->get();
        return $res;

    }


    public function getEtapaById($id){
        $query = "SELECT * FROM sirag.etapa WHERE id = $id";

        $res = \DB::select($query);

        return $res[0];
    }


    public function updateEtapa($data){

        $uva = $data['uva'];
        $calibre = $data['calibre'];
        $t_caja = $data['t_caja'];
        $peso = $data['peso'];
        $embalaje = $data['embalaje'];
        $fecha = $data['fecha'];
        $seleccion = $data['seleccion'];
        $pesaje = $data['pesaje'];
        $id  = $data['id'];

        $res =\DB::table('sirag.etapa')
            ->where('id', $id)
            ->update(
                ['t_caja' => $t_caja, 'uva' => $uva,'calibre' => $calibre,'peso' => $peso,
                    'e_embalaje'=>'', 'fecha' => $fecha,'hora' => '00:00', 'usuario' => 'EHERNANDEZ',
                    'estado' => 1,'u_seleccion'=>$seleccion,'u_pesaje'=>$pesaje, 'u_embalaje' => $embalaje]);

        return $res;
    }

}