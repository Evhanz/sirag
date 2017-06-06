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

        $pallets = $this->palletRep->getAllPallet();

        return view('packing/pallet/viewAllPallet',compact('pallets'));


    }

    public function regPallet(){

        $data = \Input::all();
        $carbon = new \Carbon\Carbon();
        $date = $carbon->now();
        $date = $date->format('Y-M-d H:i:s');

        $pallet = [];
        $pallet['codigo'] = $data['pallet'];
        $pallet['registrador'] = 'EHERNANDEZ';
        $pallet['fecha_registro'] = $date;
        $pallet['estado'] = 1;


        $id_pallet  = $this->palletRep->regPallet($pallet);

        if($id_pallet >0 ){


            $this->palletRep->editPallet($data['detalles'],$pallet['codigo'],1);
            $res = ['code'=>200,'codigo'=>$pallet['codigo']];

        }else{

            $res = ['code'=>500];
        }


        return \Response::json($res);
    }

    public function getDetailsPallet($id){

        $res = $this->palletRep->getDetailsPallet($id);

        return \Response::json($res);
    }

    public function getPalletByCodigo($codigo){

        $res = $this->palletRep->getPalletByCodigo($codigo);

        return \Response::json(count($res));
    }



}