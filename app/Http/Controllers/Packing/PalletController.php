<?php
/**
 * Created by PhpStorm.
 * User: ehernandez
 * Date: 10/05/2017
 * Time: 11:26 AM
 */

namespace App\Http\Controllers\Packing;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use sirag\Repositories\packing\PalletRep;


class PalletController extends Controller
{

    protected $palletRep ;

    public function __construct(PalletRep $palletRep)
    {
        $this->palletRep = $palletRep;
    }


    public function viewNewPallet(){

        return view('packing/pallet/viewNewPallet');

    }

    public function viewEdit(){

    }

    public function viewAll(){

    }

    public function regPallet(){

        $data = \Input::all();

        $res  = $this->palletRep->regPallet($data);

        return \Response::json($res);


    }



}