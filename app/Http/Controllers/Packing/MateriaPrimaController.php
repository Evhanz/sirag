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


    public function viewAllMP()
    {
        $res = $this->materiaPrimaRep->getMateriaPrima();
        return view('packing/materia_prima/viewAllMP',compact('res'));
    }

    public function viewEditIMP($id){
        return view('packing/materia_prima/viewEdit',compact('id'));
    }

    public function viewAllMPPrameters(){

        $data = \Input::all();

        $fechas = explode('-',$data['daterange']) ;
        $fecha_i = explode('/',trim($fechas[0]));
        $fecha_i = $fecha_i[2].'-'.$fecha_i[1].'-'.$fecha_i[0];
        $fecha_f = explode('/',trim($fechas[1]));
        $fecha_f = $fecha_f[2].'-'.$fecha_f[1].'-'.$fecha_f[0];

        $res = $this->materiaPrimaRep->getMateriaPrima($fecha_i,$fecha_f);


        return view('packing/materia_prima/viewAllMP',compact('res'));


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