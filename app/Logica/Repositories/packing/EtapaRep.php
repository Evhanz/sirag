<?php
/**
 * Created by PhpStorm.
 * User: ehernandez
 * Date: 19/04/2017
 * Time: 11:49 AM
 */

namespace sirag\Repositories\packing;


use sirag\Helpers\HelpFunct;

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
        $codigo = $data['codigo'];
        if(isset($data['peso_fijo']))$peso_fijo = $data['peso_fijo'];
        else $peso_fijo='';


       /* $query = "INSERT INTO sirag.etapa(t_caja,uva,calibre,peso,embalaje,fecha,hora,usuario,estado,u_seleccion,u_pesaje,u_embalaje)
                  VALUES
                  ('seleccion','$uva','$calibre')";*/


        // $res = \DB::insert($query);

        $res = \DB::table('sirag.etapa')->insertGetId(
            ['t_caja' => $t_caja, 'uva' => $uva,'calibre' => $calibre,'peso' => $peso,
                 'fecha' => $fecha,'hora' => '00:00', 'usuario' => 'EHERNANDEZ',
                'estado' => 0,'u_seleccion'=>$seleccion,'u_pesaje'=>$pesaje, 'u_embalaje' => $embalaje
                ,'codigo'=>$codigo,'u_peso_fijo'=>$peso_fijo]
        );

        return $res;
    }

    public function getAllEtapa(){
        $res = \DB::table('sirag.etapa')->get();
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

    public function getCalibresUva(){

        $query = "SELECT CODIGO FROM flexline.GEN_TABCOD
                    WHERE EMPRESA='E01'
                    AND TIPO='PRODUCTO.CALIBRE' -- CALIBRE
                    AND VIGENCIA<>'N'";

        $res = \DB::select($query);

        return $res;


    }

    public function getTiposCaja(){

        $query = "SELECT CODIGO,DESCRIPCION FROM flexline.GEN_TABCOD
                WHERE EMPRESA='E01'
                AND TIPO='PRODUCTO.TIPO_CAJA' -- EMBALAJE
                AND VIGENCIA<>'N'";

        $res = \DB::select($query);

        return $res;
    }

    public function getEtapaByCodigo($codigo,$opcion){

        $q1= '';

        if($opcion == 'pallet'){
            $q1= "and cod_pallet IS NULL";
        }

        $query = "SELECT *
                    FROM sirag.etapa
                    where codigo = '$codigo' $q1";
        $res = \DB::select($query);


        return $res;

    }

    public function getEmpleadoByFichaTipo($ficha,$tipo){

        $query = "SELECT * 
                from flexline.PER_TRABAJADOR
                where CARGO = '$tipo' and FICHA = $ficha and VIGENCIA = 'ACTIVO'";

        $res = \DB::select($query);

        return $res;
    }

    public function getEtapaByCodigoPallet($codigo){

        $query = "SELECT 
        e.id,e.t_caja,e.calibre,e.fecha,e.codigo,
        (SELECT (APELLIDO_PATERNO+' '+APELLIDO_MATERNO+' '+NOMBRE) nombre
        from flexline.PER_TRABAJADOR
        where FICHA = e.u_seleccion) seleccion,
        (SELECT (APELLIDO_PATERNO+' '+APELLIDO_MATERNO+' '+NOMBRE) nombre
        from flexline.PER_TRABAJADOR
        where FICHA = e.u_pesaje) pesaje,
        (SELECT (APELLIDO_PATERNO+' '+APELLIDO_MATERNO+' '+NOMBRE) nombre
        from flexline.PER_TRABAJADOR
        where FICHA = e.u_embalaje) embalaje,
        (SELECT (APELLIDO_PATERNO+' '+APELLIDO_MATERNO+' '+NOMBRE) nombre
        from flexline.PER_TRABAJADOR
        where FICHA = e.u_peso_fijo) peso_fijo
        from sirag.etapa as e
        where cod_pallet = $codigo";

        $res = \DB::select($query);


        return $res;

    }


    public function getEtapaByTipoCaja($f_inicio,$f_fin,$codigo){

        $query = "SELECT * 
        FROM sirag.etapa
        where CONVERT(date,fecha,103) >= '$f_inicio'
        and CONVERT(date,fecha,103) <= '$f_fin'
        AND t_caja = '$codigo'";


        $res = \DB::select($query);

        return $res ;

    }

    public function getEtapaByCalibreCaja($f_inicio,$f_fin,$codigo){

        $query = "SELECT * 
        FROM sirag.etapa
        where CONVERT(date,fecha,103) >= '$f_inicio'
        and CONVERT(date,fecha,103) <= '$f_fin'
        AND calibre = '$codigo'";


        $res = \DB::select($query);

        return $res ;

    }



}