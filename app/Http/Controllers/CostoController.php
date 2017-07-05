<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use sirag\Helpers\HelpFunct;
use sirag\Repositories\CostoRep;

class CostoController extends Controller
{
    protected $costoRep;

    public function __construct(CostoRep $costoRep)
    {
        $this->costoRep = $costoRep;

    }

    public function viewDistribucionCosto(){

        #$data = \Input::all();

        set_time_limit (9900);

        ini_set('memory_limit', '1024M');

        $hora = HelpFunct::getFechaActual('Y-m-d H:i:s');
        HelpFunct::writeLog("proceso_costo.txt","Empezó .............. : $hora",'a');

        $fecha_input = "2017-02-28";

        $t_cambio = $this->costoRep->getTipoCambio('2017-02-28');

        $data =['f_fin'=>'2017-02-28','TIPO_COMPROBANTE'=>'AS. DESTINO','EMPRESA' => 'E01','FECHA'=>'20170228'
            ,'CORRELATIVO'=>'999999','GLOSA'=>'AS. DESTINO CENTRO DE COSTO ENERO 2017'
            ,'NUMERO_EXTERNO'=>null,'MONEDA' => 'S/.','TASA' => 1,'ORIGEN'=>'CONTAB'
            ,'TOTAL'=>0,'ESTADO'=>'A','USUARIO'=>'MPONCE','FECHA_MODIFICACION'=>'20170313'
            ,'FOLIO'=>null,'ASOCIADA'=>null,'OCUPADO'=>'N','PROCESO'=>'GENERA','TASA2'=>$t_cambio
            ,'PERIODO'=>'2017','TIPOPREP'=>null,'USUARIOCREACION'=>null,'CONSOLIDA'=>null,'idTransaccion'=>null
            ,'PROCESOPE'=>null];

        unset($data['f_fin']);


        //primero actualizamos los anteriores
        $this->costoRep->deleteCabeceraDistribucion('N',$data['FECHA'],$data['CORRELATIVO']);
        $this->costoRep->deleteDetallesDistribucion('N',$data['FECHA'],$data['CORRELATIVO']);


        //luego regstramos los demas



        $res_reg = $this->costoRep->insertCabeceraDistribucion($data);


        //aca se coloca los insert de la cabecera de asiento

        if($res_reg==true){
            //registramos los detalles
            $res = $this->costoRep->insertDetallesDistribucion($data['CORRELATIVO'],$fecha_input,$t_cambio);
        }else{
            throw new \Exception('Error al registrar el dato');
        }

        $hora = HelpFunct::getFechaActual('Y-m-d H:i:s');
        HelpFunct::writeLog("proceso_costo.txt","Terminó .............. : $hora",'a');



        dd($res);


    }




}
