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
use sirag\Repositories\packing\EtapaRep;

class EtapaController extends Controller
{

    protected $etapaRep;

    public function __construct(EtapaRep $etapaRep)
    {
        $this->etapaRep = $etapaRep;
    }

    public function index(){



    }

    public function viewEtapaReg(){

        $opcion = 'nuevo';

        return view('packing/etapa/viewEtapa',compact('opcion'));

    }

    public function viewEdit($id){

        $opcion = 'editar';
        $etapa = $id;

        return view('packing/etapa/viewEtapa',compact('id','opcion','etapa'));

    }

    public function viewAllEtapa(){

        $etapa = $this->etapaRep->getAllEtapa();

        return view('packing/etapa/viewAllEtapa',compact('etapa'));
    }

    public function viewEtapaByCodigo($codigo){

        $etapa = $this->etapaRep->getEtapaByCodigo($codigo,'');

        return view('packing/etapa/viewAllEtapa',compact('etapa'));
    }







    public function apiSeleccionReg(){
        $data  = \Input::all();
        $bandera = 0;

        $carbon = new \Carbon\Carbon();
        $date = $carbon->now();
        $date = $date->format('Y-M-d H:i:s');
        $data['fecha'] = $date;

        $etapa = $data['etapa'];
        $etapa['fecha'] =   $data['fecha'];

        $res = $this->etapaRep->regEtapa($etapa);

        if($bandera == 0) {
            $response = ['code'=>200,'codigo'=>$res];
        }else{
            $response = ['code'=>500,'mensaje'=>'error'];
        }


        return \Response::Json($response);

    }

    public function apiSeleccionEdit(){

        $data  = \Input::all();

        $etapa = $data['etapa'];

        $bandera = 0;
        $res = 0;



        try{

            $res = $this->etapaRep->updateEtapa($etapa);
            $response = ['code'=>200,'codigo'=>$res];
        }catch (\Exception $e){
            $bandera =$e;
            $response = ['code'=>500,'mensaje'=>'error'];
        }



        return \Response::Json($response);
    }

    public function getEtapaByParameter(){
        $data = \Input::all();

        $fechas = $data['fecha'];
        $fechas = explode('-',$fechas);
        $f_inicio = trim($fechas[0]);
        $f_fin = trim($fechas[1]);
        $etapa = $this->etapaRep->getEtapaByParameter($f_inicio,$f_fin);

        if($data['opcion']=='buscar'){

            return view('packing/etapa/viewAllEtapa',compact('etapa'));

        }

        if($data['opcion']=='excel'){

            $etapas= [];

            foreach ($etapa as $item){

                $i = (array)$item;

                array_push($etapas,$i);
            }


            \Excel::create('etapa_data', function($excel) use ($etapas) {

                $excel->sheet('pallet', function($sheet) use ($etapas) {

                    $sheet->fromArray($etapas);

                });
            })->export('xls');

        }



    }

    public function apiGetById($id){

        $res = $this->etapaRep->getEtapaById($id);

        return \Response::json($res);

    }

    public function apiGetByCodigo($codigo,$opcion){

        $res = $this->etapaRep->getEtapaByCodigo($codigo,$opcion);

        return count($res);
    }

    public function getEmpleadoByFichaTipo($ficha,$tipo){

        switch ($tipo){
            case 's': $tipo = 'SELECCION';break;
            case 'p': $tipo = 'PESADO';break;
            case 'e': $tipo = 'EMBALAJE';break;
            case 'f': $tipo = 'PESADO';break;
        }

        $res = $this->etapaRep->getEmpleadoByFichaTipo($ficha,$tipo);

        return count($res);
    }


    public function apiGetEtapaByCodigoPallet($codigo){

        $res = $this->etapaRep->getEtapaByCodigoPallet($codigo);
        return \Response::json($res);
    }






}