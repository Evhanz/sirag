<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use sirag\Repositories\ContabilidadRep;

class ContabilidadController extends Controller
{

    protected $contabilidadRep;


    function __construct(ContabilidadRep $contabilidadRep)
    {
        $this->contabilidadRep = $contabilidadRep;
    }


    public function viewBalanceGeneral(){

        return view('cc/viewBalanceGeneral');

    }


    public function viewControlOrdenCompra()
    {
        return view('cc/viewControlOrdenCompra');
    }


    
    //APIS

    public function getBalanceByNiveles()
    {
        # code...

        $data = \Input::all();

        $res = $this->contabilidadRep->getBalanceByNiveles($data);


        return \Response::json($res);

    }
    //funcion para el control de las ordenes de compras 
    public function getOrdenCompraForControl()
    {
        # code...

        $data = \Input::all();

        $res = $this->contabilidadRep->getOrdenCompraForControl($data);


        return \Response::json($res);

    }

    public function getGuiasAtendidasOfOC()
    {
        $data = \Input::all();

        $res = $this->contabilidadRep->getGuiasAtendidasOfOC($data);


        return \Response::json($res);


    }

    
    
}
