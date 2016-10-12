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

    public function getBalanceByNiveles()
    {
        # code...

        $data = \Input::all();

        $res = $this->contabilidadRep->getBalanceByNiveles($data);


        return \Response::json($res);

    }

    
    
}
