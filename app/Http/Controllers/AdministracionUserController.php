<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use sirag\Repositories\UsuarioRep;

class AdministracionUserController extends Controller
{
    protected   $user ;
    protected   $usuarioRep;

    public function __construct(User $user,UsuarioRep $usuarioRep)
    {
        $this->user = $user;
        $this->usuarioRep  = $usuarioRep;

    }

    public function index(){

        $usuarios = User::all();

        return view('usuarios',compact('usuarios'));

    }


    public  function inicio(){
        return view('login');
    }

    public function getViewAdminUsuarios()
    {
        return view('usuarios/viewAdminUser');
    }


    public function getAllUsersAndRoles()
    {
        # code...
        $res = $this->usuarioRep->getAllUsersAndRoles();

        return \Response::json($res);

    }

    public function getOpciones()
    {
        # code...
        $res = $this->usuarioRep->getOpciones();

        return \Response::json($res);

    }


    public function updateRolesUsuarios()
    {
        $data = \Input::all();

        $res  = $this->usuarioRep->updateRoles($data['user']); 

        return \Response::json($res);
    }

    //trae los accesos del usuario
    public function getAllAccesos($usr){

        $query_mod = "SELECT a.id id, m.alias alias,m.icono,a.id_modulo id_modulo  FROM sirag.accesos a inner join sirag.modulos m 
                    on a.id_modulo = m.id
                    where a.usuario = '$usr'
                    AND tipo = 'modulo'";

        $modulos = \DB::select($query_mod);

        $query = "SELECT a.id id_acceso,m.id id_modulo, a.descripcion descripcion, s.id id_submodulo , s.alias alias
                    FROM sirag.accesos a INNER JOIN sirag.sub_modulos s 
                    on a.id_modulo = s.id INNER join sirag.modulos m on s.id_modulo = m.id
                    where a.usuario = '$usr' AND tipo = 'sub_modulo'";

        $submodulos =  \DB::select($query);
        $submodulos =  collect($submodulos);

        $a_sub_modulos = [];
        foreach ($modulos as $modulo ){

            $a_sub_modulos = $submodulos->where('id_modulo',$modulo->id_modulo);
            $modulo->sub_modulo = $a_sub_modulos;
        }

        return $modulos;

    }

    //traelos módulos y los submódulos
    public function getModulosAndSubModulos(){

        $query = "SELECT * FROM sirag.modulos";
        $modulos = \DB::select($query);

        $query = "SELECT * FROM sirag.sub_modulos";
        $submodulos = \DB::select($query);

        $submodulos =  collect($submodulos);


        foreach ($modulos as $modulo ){

            $a_sub_modulos = $submodulos->where('id_modulo',$modulo->id);
            $modulo->sub_modulo = $a_sub_modulos;
        }

        return \Response::Json($modulos);

    }

    public function apiChangeModulo($idModulo,$usr,$tipo){

        if($tipo == 'modulo'){
            $query_mod = "SELECT a.id id, m.alias alias,m.icono,a.id_modulo id_modulo  
                    FROM sirag.accesos a inner join sirag.modulos m 
                    on a.id_modulo = m.id
                    where a.usuario = '$usr'
                    AND tipo = '$tipo' 
                    AND m.id = $idModulo";

        }else{
            $query_mod = "SELECT a.id id, m.alias alias,a.id_modulo id_modulo  
                    FROM sirag.accesos a inner join sirag.sub_modulos m 
                    on a.id_modulo = m.id
                    where a.usuario = '$usr'
                    AND tipo = '$tipo' 
                    AND m.id = $idModulo";
        }



        $modulos = \DB::select($query_mod);


        if(count($modulos)>0){
            //delete
            $this->usuarioRep->DeleteAccesModulo($modulos[0]->id);
        }else{
            //insert
            $this->usuarioRep->insertAccesModulo($idModulo,$usr,$tipo);
        }

        return 'ok';

    }
    //save
    public function apiSaveOpcionModulo(){

        $data= \Input::all();

        $res = '';

        $tipo = $data['tipo'];

        switch ($tipo){
            case 'modulo':
                #llama a modulo
                $res = $this->usuarioRep->addOrEditModule($data['modulo']);
            break;
            case 'sub_modulo':
                #llama a submodulo
                $res = $this->usuarioRep->addOrEditSubModule($data['modulo']);
            break;
        }


        return $res;

    }




}
