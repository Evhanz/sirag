<?php

namespace App\Http\Controllers\Packing;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use sirag\Entities\Obj;
use sirag\Helpers\HelpFunct;
use sirag\Repositories\packing\MovimientoRep;
use sirag\Repositories\packing\PalletRep;

class MovimientosPalletController extends Controller
{


    protected $movimientoRep ;
    protected $palletRep;

    public function __construct(MovimientoRep $movimientoRep,PalletRep $palletRep)
    {
        $this->movimientoRep = $movimientoRep;
        $this->palletRep = $palletRep;
    }

    public function viewMantMovimientosPallet(){

        return view('packing/movimientos/viewMantMovimientosPallet');
    }

    public function getMovimientosPalletParams(){


        $data = \Input::all();

        $data['daterange'];

        /*la fecha viene en formato dd/mm/yyyy - dd/mm/yyyy, se necesita en yyyymmdd*/
        $fechas  = explode('-',$data['daterange']);
        $f_i = explode('/',$fechas[0]);
        $f_i = trim($f_i[2]).trim($f_i[1]).trim($f_i[0]);
        $f_f = explode('/',$fechas[1]);
        $f_f = trim($f_f[2]).trim($f_f[1]).trim($f_f[0]);
        $tipo = $data['tipo'];

        $movimientos = $this->movimientoRep->getMovimientosByParams($f_i,$f_f,$tipo);


        return view('packing/movimientos/viewMantMovimientosPallet',compact('movimientos'));

    }

    public function insertOrUpdateMovimiento(){

        $data = \Input::all();
        $response = [];

       if($data['tipo'] == 'entrada'){


       }else{

           /*----fecha Actual----*/
            #se necesita el fomato YYYYMMDD
            $fecha = HelpFunct::getFechaActual('Ymd');
           #-----------------
           $value = [];
           $value['tipo'] = $data['tipo'];
           $value['fecha'] = $fecha;
           $value['codigo'] = $data['codigo'];
           $value['descripcion'] = 'traslado';
           $value['origen'] = $data['origen'];
           $value['destino'] = $data['destino'];


           \DB::beginTransaction();
           try {

               /*se inserta el movimiento*/
               $res = $this->movimientoRep->insert($value);
               # se inserta los detalles
               foreach ($data['detalle'] as $item){
                   $det = [];
                   $det['id_movimiento'] = $res;
                   $det['id_entidad'] = $item;
                   $det['tipo'] = $data['tipo'];
                   $det['fecha'] = $fecha;
                   $det['origen'] = $data['origen'];
                   $det['destino'] = $data['destino'];

                   $this->movimientoRep->insertDetails($det);
               }

               \DB::commit();
               $response['accion'] = 1;
               // all good
           } catch (\Exception $e) {
               \DB::rollback();
               // something went wrong
               $response['accion'] = 0;
           }
       }


       return back()->with('accion',$response['accion']);

        //ALM. CAMARAS

    }

    public function getMovimiento($id){

    }

    /**
     * esto traerá el pallet para saber si existe , tomando la funcion del
     * palletRep y ver si ya existe un registro del mismo tipo y de origen
     */
    public function getPalletByCodigoMovimiento(){

        $data = \Input::all();

        $res = $this->palletRep->getPalletByCodigo($data['codigo_pallet']);
        $response = [];
        $response['existe'] = 0;
        $response['mensaje'] = '';
        $p = new Obj();
        #si existe entonces verificamos si tiene el mismo
        if(count($res)>0){

            #verificamos si el pallet se encuentra registrado en el tipo de ingreso
            #quese va a realizar
            $movimientos = $this->movimientoRep->getCheckDetalleMovimiento($data['codigo_pallet'],$data['origen'],$data['destino'],$data['tipo']);

            if(count($movimientos) >0){
                $response['mensaje'] = 'El valor ya tiene una salida';
            }else{
                $response['existe'] = 1;
                $detalle= $this->palletRep->getDetailsPallet($res[0]->codigo,1);
                $p->codigo = $res[0]->codigo;
                $p->calibre = $detalle[0]->calibre;
                $p->t_caja = $detalle[0]->t_caja;
                $p->calibre = $detalle[0]->calibre;
                $p->uva = $detalle[0]->uva;
            }

        }else{

            $response['mensaje'] = 'El valor no existe';
        }

        $response['data'] = $p;

        return \Response::json($response);
    }





}
