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

}