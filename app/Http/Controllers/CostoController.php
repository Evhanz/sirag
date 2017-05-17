<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CostoController extends Controller
{

    public function viewDistribucionCosto(){

        #$data = \Input::all();
        $data =['f_fin'=>'2017-01-31','tipo_comprobante'=>'AS. DESTINO'
            ,'CORRELATIVO'=>'1007','GLOSA'=>'AS. DESTINO CENTRO DE COSTO ENERO 2017'
            ,'NUMERO_EXTERNO'=>null,'MONEDA' => 'S/.','TASA' => 1,'ORIGEN'=>'CONTAB'
            ,'TOTAL'=>0,'ESTADO'=>'A','USUARIO'=>'MPONCE','FECHA_MODIFICACION'=>'2017-03-13 10:11:42'
            ,'FOLIO'=>null,'ASOCIADA'=>null,'OCUPADO'=>'N','PROCESO'=>'GENERA','TASA2'=>'9.115885'
            ,'PERIODO'=>'2017','TIPOPREP'=>null,'USUARIOCREACION'=>null,'CONSOLIDA'=>null,'idTransaccion'=>null
            ,'PROCESOPE'=>null];

        //aca se coloca los insert




    }




}
