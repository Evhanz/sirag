<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;

class AdministracionUserController extends Controller
{
    protected  $user ;

    public function __construct(User $user)
    {
        $this->user = $user;

    }

    public function index(){

        $usuarios = User::all();

        return view('usuarios',compact('usuarios'));

    }


    public  function inicio(){

        return view('login');

    }



}
