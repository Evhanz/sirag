<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 28/11/16
 * Time: 04:31 PM
 */

namespace App\Http\Controllers\Packing;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use sirag\Repositories\PersonalRep;

class MateriaPrimaController extends Controller
{

    protected  $personalRep;

    public function __construct(PersonalRep $personalRep)
    {
        $this->personalRep = $personalRep;

    }


    //views

    public function index(){
        return view('packing/materia_prima/viewIndex');
    }


    public function viewStorePMateriaPrima(){

        $data  = \Input::all();



        return view('packing/materia_prima/viewNew');

    }

    public function edit(){

    }







    //apis

    public function getTrabajadores(){


        $res = $this->personalRep->getAllTrabajadores();

        return \Response::json($res);


    }


    //helpers

}