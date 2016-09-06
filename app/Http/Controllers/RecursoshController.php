<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use sirag\Repositories\PersonalRep;

class RecursoshController extends Controller
{

    protected $personalRep;

    public function __construct(PersonalRep $personalRep)
    {
        $this->personalRep = $personalRep;
    }

    public function viewPersonal()
    {
        return view('rh/viewPersonal');
    }
    public function viewHistoryContract($ficha)
    {

        //echo $ficha;
        return view('rh/viewHistoryContract',compact('ficha'));
    }

    //API para traer a los trbajadores

    public function getAllTrabajadoresByParameter()
    {
        $data = \Input::all();

        $res = $this->personalRep->getAllTrabajadoresByParameter($data);

        return \Response::Json($res);

    }

    public function getTrabajadoresByParamOutDates(){

        $data = \Input::all();

        $res = $this->personalRep->getTrabajadoresByParamOutDates($data);

        return \Response::Json($res);

    }


    public function getTrabajadorByFicha($ficha)
    {
        $res = $this->personalRep->getTrabajadorByFicha($ficha);

        return \Response::Json($res);
    }

    public function getContratos($ficha){

        $res = $this->personalRep->getContratos($ficha);

        return \Response::Json($res);

    }

    public function getRenovacionesByFicha($ficha){

        $res = $this->personalRep->getRenovaionesByFicha($ficha);

        return \Response::Json($res);
    }


    public function addNewRenovacion(){

        $data = \Input::all();

        $res = $this->personalRep->addNewRenovacion($data);

        return \Response::Json($res);


    }



}
