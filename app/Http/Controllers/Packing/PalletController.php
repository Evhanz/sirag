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
use sirag\Entities\Obj;
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

    public function viewPalletRep(){
        return view('packing/pallet/viewPalletReport');
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

    public function getAllPalletPaginate(){

        $hoy = getdate();

        if($hoy['mon']<10)$hoy['mon'] = '0'.$hoy['mon'];
        if($hoy['mday']<10)$hoy['mday'] = '0'.$hoy['mday'];

        $fecha = $hoy['year'].'-'.$hoy['mon'].'-'.$hoy['mday'];

        $res = $this->palletRep->getAllPalletPaginate($fecha);
        return \Response::json($res);
    }

    public function getAllPalletPaginateFechas($f_i,$f_f){
        $res = $this->palletRep->getAllPalletPaginateFechas($f_i,$f_f);
        return \Response::json($res);
    }

    public function getCountNowPallet(){

        $hoy = getdate();

        if($hoy['mon']<10)$hoy['mon'] = '0'.$hoy['mon'];
        if($hoy['mday']<10)$hoy['mday'] = '0'.$hoy['mday'];

        $fecha = $hoy['year'].'-'.$hoy['mon'].'-'.$hoy['mday'];

        $res = $this->palletRep->getCountNowPallet($fecha);
        return \Response::json(count($res));

    }

    public function getPalletByCodigoWithDetails(){

        $data = \Input::all();

        $res = $this->palletRep->getPalletByCodigoWithDetails($data['codigo']);

        return \Response::json($res);

    }


    public function getPalletByFechas(){

        $data= \Input::all();
        $res = $this->palletRep->getPalletByFechas($data['f_inicio'],$data['f_fin']);

        $res = collect($res);
        $res = $res->groupBy('codigo');
        $pallets = [];

        foreach ($res as $item){
            $pallet = new Obj();
            $pallet->codigo = $item[0]->codigo;
            $pallet->calibre = $item[0]->calibre;
            $pallet->t_caja = $item[0]->t_caja;
            $pallet->cant_cajas = count($item);
            $pallet->fecha_registro = $item[0]->fecha_registro;
            $pallet->detalles = $item;
            $pallet->detail_show = false;

            array_push($pallets,$pallet);
        }

        return \Response::json($pallets);
    }


    //excel -

    public function getExcelPalletByFechas(){

        $data= \Input::all();

        $fecha = $data['fecha'];
        $fecha = explode('-',$fecha);

        $f_inicio = explode('/',$fecha[0]);
        $f_inicio = trim($f_inicio[2]).'-'.trim($f_inicio[1]).'-'.trim($f_inicio[0]);
        $f_fin = explode('/',$fecha[1]);
        $f_fin = trim($f_fin[2]).'-'.trim($f_fin[1]).'-'.trim($f_fin[0]);

        $res = $this->palletRep->getPalletByFechas($f_inicio,$f_fin);

        $pallet= [];

        foreach ($res as $item){

            $i = (array)$item;
            unset($i['fecha_vencimiento']);
            unset($i['id']);
            array_push($pallet,$i);
        }


        \Excel::create('pallet_data', function($excel) use ($pallet) {

            $excel->sheet('pallet', function($sheet) use ($pallet) {

                $sheet->fromArray($pallet);

            });
        })->export('xls');
    }


}