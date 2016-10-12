<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use sirag\Repositories\CentroCostoRep;

class CentroCostoController extends Controller
{
    protected $centroCostoRep;

    public function __construct(CentroCostoRep $centroCostoRep)
    {
        $this->centroCostoRep = $centroCostoRep;
    }

    public function viewSaldoCCByCuentaAndPeriodo(){

        return view('cc/viewSaldoCC');

    }

    public function getSaldoCCByCuentaAndPeriodo(){

        $data = \Input::all();

        $res = $this->centroCostoRep->getSaldoCCByCuentaAndPeriodo($data);

        return  \Response::Json($res);

    }





}
