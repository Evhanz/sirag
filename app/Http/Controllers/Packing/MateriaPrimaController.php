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
use sirag\Repositories\packing\MateriaPrimaRep;
use sirag\Repositories\PersonalRep;

class MateriaPrimaController extends Controller
{

    protected  $personalRep;
    protected  $materiaPrimaRep;

    public function __construct(PersonalRep $personalRep,MateriaPrimaRep $materiaPrimaRep)
    {
        $this->personalRep = $personalRep;
        $this->materiaPrimaRep = $materiaPrimaRep;

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


    public function materiaPrimaStoreNew()
    {
        $data = \Input::all();

        $fecha = $data['cabecera']['fecha'];
        $cabecera = \DB::select("SELECT * FROM sirag.ingreso_MP  where fecha = '$fecha'");

        if(count($cabecera)>=1){
            $data = ['respuesta'=>'ya existe un valor con la misma fecha'];
        }else{
            $this->materiaPrimaRep->store($data);
        }


        return \Response::json($data);

    }







    //apis

    public function getTrabajadores(){

        $res = $this->personalRep->getAllTrabajadores();

        return \Response::json($res);

    }





    //helpers

}