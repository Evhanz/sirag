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

class EtapaController extends Controller
{

    public function index(){

    }

    public function viewSeleccionReg(){

        return view('packing/etapa/viewSeleccion');

    }


    public function apiSeleccionReg(){
        $data  = \Input::all();

        $carbon = new \Carbon\Carbon();
        $date = $carbon->now();
        $date = $date->toDateTimeString();
        $data['fecha'] = $date;
        dd($data);


    }


}