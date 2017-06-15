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
use sirag\Entities\Obj;
use sirag\Repositories\packing\EtapaRep;

class InicioController extends Controller
{

    protected $etapaRep;

    public function __construct(EtapaRep $etapaRep)
    {
        $this->etapaRep = $etapaRep;

    }

    public function index(){
        return view('packing/main');
    }

    public function getOpcionesGenerales($tipo){

        $response = [];

        switch ($tipo){
            case 'packing_mobile':
                $response['calibre'] = $this->etapaRep->getCalibresUva();
                $response['tipo_caja'] = $this->etapaRep->getTiposCaja();
                break;
        }

        return \Response::json($response);
    }

    public function getBarCajas($f_i,$f_f,$tipo){

        if($tipo=='t_caja'){

            if($f_i == '-'){
                $hoy = getdate();

                if($hoy['mon']<10)$hoy['mon'] = '0'.$hoy['mon'];
                if($hoy['mday']<10)$hoy['mday'] = '06';

                $f_i = $hoy['year'].'-'.$hoy['mon'].'-'.$hoy['mday'];
                $f_f = $hoy['year'].'-'.$hoy['mon'].'-'.$hoy['mday'];

            }

            //primero obtenemos a todos los tipos de caja

            $tipos_caja = $this->etapaRep->getTiposCaja();
            $res = [];

            foreach ($tipos_caja as $item){
                $codigo = $item->CODIGO;
                $cant = count($this->etapaRep->getEtapaByTipoCaja($f_i,$f_f,$codigo));
                $obj = new Obj();
                $obj->codigo = $codigo;
                $obj->cantidad = $cant;
                array_push($res,$obj);
            }

            return  \Response::json($res);



        }else{
            if($f_i == '-'){
                $hoy = getdate();

                if($hoy['mon']<10)$hoy['mon'] = '0'.$hoy['mon'];
                if($hoy['mday']<10)$hoy['mday'] = '06';

                $f_i = $hoy['year'].'-'.$hoy['mon'].'-'.$hoy['mday'];
                $f_f = $hoy['year'].'-'.$hoy['mon'].'-'.$hoy['mday'];

            }

            //primero obtenemos a todos los tipos de caja

            $tipos_caja = $this->etapaRep->getCalibresUva();
            $res = [];

            foreach ($tipos_caja as $item){
                $codigo = $item->CODIGO;
                $cant = count($this->etapaRep->getEtapaByCalibreCaja($f_i,$f_f,$codigo));
                $obj = new Obj();
                $obj->codigo = $codigo;
                $obj->cantidad = $cant;
                array_push($res,$obj);
            }

            return  \Response::json($res);

        }

    }

}