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
use sirag\Helpers\HelpFunct;
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

    public function editPallet(){

        $data = \Input::all();

        /*primero limpiamos las cajas hy dejamos en null */
        /*0: quiere decir que esta hábil y 1 que está ocupado*/

        $pallet = [];
        $pallet['codigo'] = $data['pallet'];

        /*eliminamos los detalles que ya tiene el pallet*/

        $r = $this->palletRep->deleteDetailPallet($pallet['codigo']);



        /*luego agregamos los nuevois detalles */


        $this->palletRep->editPallet($data['detalles'],$pallet['codigo'],1);
        $res = ['code'=>200,'codigo'=>$pallet['codigo']];



        return \Response::json($res);

    }




    public function getDetailsPallet($id){

        $res = $this->palletRep->getDetailsPallet($id);

        return \Response::json($res);
    }

    public function getPalletByCodigo($codigo){
        $response = [];
        $res = $this->palletRep->getPalletByCodigo($codigo);

        if(count($res)>0){
            $response['detalles']= $this->palletRep->getDetailsPallet($res[0]->codigo);
        }

        $response['data'] = $res;
        $response['existe'] = count($res);

        return \Response::json($response);
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

    /**
     * Esto es para mostrarlo en el view , y trae todo el pallet
     * -- como no se a usado este trae el pallet de acuerdo a su codigo de una forma lite
    */
    public function getPalletCodigo($codigo){

        $response = [];
        $pallet = $this->palletRep->getPalletByCodigo($codigo);
        $response['existe'] = 0;
        $p = new Obj();
        if(count($pallet)>0){

            $response['existe'] = 1;
            $detalle= $this->palletRep->getDetailsPallet($pallet[0]->codigo,1);
            $p->codigo = $pallet[0]->codigo;
            $p->calibre = $detalle[0]->calibre;
            $p->t_caja = $detalle[0]->t_caja;
            $p->calibre = $detalle[0]->calibre;
            $p->uva = $detalle[0]->uva;

        }

        $response['data'] = $p;


        return \Response::json($response);

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