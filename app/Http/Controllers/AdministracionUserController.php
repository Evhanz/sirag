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


    public function getAllUsersAndRoles()
    {
        # code...
        $res = $this->usuarioRep->getAllUsersAndRoles();

        return \Response::json($res);

    }


    public function getViewAdminUsuarios()
    {
        return view('usuarios/viewAdminUser');
    }

    public function updateRolesUsuarios()
    {
        $data = \Input::all();

        $res  = $this->usuarioRep->updateRoles($data['user']); 

        return \Response::json($res);
    }



}
