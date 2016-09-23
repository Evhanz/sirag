<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;
use sirag\Repositories\PersonalRep;

class RecursoshController extends Controller
{

    protected $personalRep;

    public function __construct(PersonalRep $personalRep)
    {
        $this->personalRep = $personalRep;
    }

    public function viewPersonal()
    {
        return view('rh/viewPersonal');
    }
    public function viewHistoryContract($ficha)
    {

        //echo $ficha;
        return view('rh/viewHistoryContract',compact('ficha'));
    }

    public function viewTelecredito(){

        return view('rh/viewTelecredito');
    }




    //API para traer a los trbajadores

    public function getAllTrabajadoresByParameter()
    {
        $data = \Input::all();

        $res = $this->personalRep->getAllTrabajadoresByParameter($data);

        return \Response::Json($res);

    }

    public function getTrabajadoresByParamOutDates(){

        $data = \Input::all();

        $res = $this->personalRep->getTrabajadoresByParamOutDates($data);

        return \Response::Json($res);

    }


    public function getTrabajadorByFicha($ficha)
    {
        $res = $this->personalRep->getTrabajadorByFicha($ficha);

        return \Response::Json($res);
    }

    public function getContratos($ficha){

        $res = $this->personalRep->getContratos($ficha);

        return \Response::Json($res);

    }

    public function getRenovacionesByFicha($ficha){

        $res = $this->personalRep->getRenovaionesByFicha($ficha);

        return \Response::Json($res);
    }


    public function addNewRenovacion(){

        $data = \Input::all();

        $res = $this->personalRep->addNewRenovacion($data);

        return \Response::Json($res);
    }

    public function deleteRenovacion(){
        $data = \Input::all();

        $this->personalRep->deleteRenovacion($data['id'],$data['ficha'],$data['fecha_fin']);

        return \Response::Json("ok");

    }

    public function getVacacionesByFicha($ficha)
    {
        $res = $this->personalRep->getVacacionesByFicha($ficha);

        return \Response::Json($res);

    }

    public function getContratosPorVencer()
    {
        $res = $this->personalRep->getContratosPorVencer();

        //return \Response::Json($res);

        $data['body'] = "prueba de contenido";

        $res['contratos'] = $res;


        //se envia el array y la vista lo recibe en llaves individuales {{ $email }} , {{ $subject }}...
        \Mail::send('email', $res, function($message)
        {
            //remitente
            $message->from('ehernandez@agrograce.com.pe', 'Sistema Sirag');

            //asunto
            $message->subject('Contratos por vencer');

            //receptor
            $message->to('eidelhs@gmail.com','Eidelman ');

        });


        echo 'si salio';

    }


    public function getTelecredito(){

        $data  = \Input::all();

        $res = $this->personalRep->getTelecredito($data);

        return \Response::Json($res);


    }


    //--- esto es para exportar
    public function gettxt(){

        $data = \Input::all();

        $data['periodo']= $this->getUltimoDiaMes($data['filAnio'],$data['filMes']).'/'.$data['filMes'].'/'.$data['filAnio'];


        $res = $this->personalRep->getTelecredito($data);

        $cabecera = '';


        //primero obtendremos los valores de cabecera

        //1.- colocar el numero 1 (es fijo)
        $cabecera .='1';
        //2.- contar la cantidad de personas abonadas y llenar de cero de acuerdo a la cantidad de digitos
        $cant_abonados = count($res);

        $ceros = '';

        for ($i = 0;$i<(6- strlen($cant_abonados));$i++){
            $ceros = $ceros.'0';
        }

        $cant_abonados = $ceros.$cant_abonados;

        $cabecera = $cabecera.$cant_abonados;

        //3.- traemos l fecha en formato aaaammdd
        $now = Carbon::now();
        $hoy = $now->format('Ymd');
        $cabecera = $cabecera.$hoy;
        //4.- de acuerdo al tipo de pago si es de 5 o de 4 o alguna en este caso X por ser fijo de 5° categoria
        $cabecera = $cabecera.'X';
        //5.- de acuerdo al tipo cuenta cargo , en este caso C
        $cabecera = $cabecera.'C';
        //6.- Moneda de cuenta de cargo
        $cabecera = $cabecera.'0001';
        //7.- Numero de la cuenta de cargo que es fija
        $c_cargo = '1941975780072';
        $cabecera = $cabecera."$c_cargo       ";
        //8.- sumamos la cantidad abonada y llenamos hasta tenener
        $sumaMonto = str_replace(',','.',number_format($this->getSumaAbonados($res),2,',','')) ;
        $ceros = $this->getceros(9,17);
        $cabecera = $cabecera.$ceros.$sumaMonto;
        //9.-se agrega la referencia de planilla
        $cabecera = $cabecera.$data['ref_planilla'].'              ';
        //10.-sumamos todas las cuentas de abono
        $suma_cta_abono = $this->getSumaCuentaAbonados($res,$c_cargo);
        $suma_cta_abono = $this->getceros(strlen($suma_cta_abono),15).$suma_cta_abono;
        $cabecera = $cabecera.$suma_cta_abono;

        //---- se termina la cabecera

        //damos inicio al body
        $body = "";
        $row = "";

        foreach ($res as $i){


            //1.- primero se coloca valor fijo 2
            $row .='2';
            //2.- se asigna valor fijo A
            $row .= 'A';
            //3.- se agrega la cuenta
            $row .= $i->CUENTAS_ABONO.'      ';
            //4.- e coloca el valor fijo 1 seguido del DNI



        }












        $fileText = "$cabecera - This is some text\r\nThis test belongs to my file download\nBooyah";
        $myName = "ThisDownload.txt";
        $headers = ['Content-type'=>'text/plain', 'test'=>'YoYo', 'Content-Disposition'=>sprintf('attachment; filename="%s"', $myName),'X-BooYAH'=>'WorkyWorky','Content-Length'=>sizeof($fileText)];
        return \Response::make($fileText, 200, $headers);

    }

    /*funciiones helpers */
    public function getSumaAbonados($data){

        $suma = 0;

        foreach ($data as $i){

            $suma +=$i->MONTO;
        }

        return $suma;

    }

    public function getceros($cant,$bandera){

        $ceros = '';

        for ($i=0;$i<$bandera-$cant;$i++){
            $ceros.='0';
        }

        return $ceros;
    }

    public function getSumaCuentas(){

        $suma = 0;

    }

    public function getUltimoDiaMes($elAnio,$elMes) {
        return date("d",(mktime(0,0,0,$elMes+1,1,$elAnio)-1));
    }

    public function getSumaCuentaAbonados($data,$c_cargo){

        $suma = 0;

        foreach ($data as $i){

            $suma += floatval(substr($i->CUENTAS_ABONO, 3, 8)) ;
        }

        //sumamos primero las cuentas de abono
        $suma = $suma + floatval(substr($c_cargo, 3, 8));

        return $suma;

    }


}
