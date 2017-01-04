<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;
use sirag\Helpers\HelpFunct;
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


    public function viewPlanilla(){

        return view('rh/viewPlanilla');
    }

    public function viewPlame(){
        return view('rh/viewPlame');
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


    public function getCostoMOPorFundo(){

        $data = \Input::all();


        $res = $this->personalRep->getCostoMOPorFundo($data);

        return \Response::Json($res);

    }


    //--- esto es para exportar telecredito
    public function gettxt(){

        $data = \Input::all();


        if($data['tipo']=='empleado'){
            $data['periodo']= $data['filAnio'].'-'.$data['filMes'].'-'.$this->getUltimoDiaMes($data['filAnio'],$data['filMes']);
        }else{


            if($data['filDia']<10){

                $data['filDia'] = '0'.$data['filDia'];
            }
            if($data['filMes']<10){

                $data['filMes'] = '0'.$data['filMes'];
            }

            $data['periodo'] =  $data['filAnio'].'-'.$data['filMes'].'-'.$data['filDia'];
        }




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
        $ceros = $this->getceros(strlen($sumaMonto),17);
        $cabecera = $cabecera.$ceros.$sumaMonto;
        //9.-se agrega la referencia de planilla
        $cabecera = $cabecera.$data['ref_planilla'].$this->getEspacioBlanco(strlen($data['ref_planilla']),40);
        //10.-sumamos todas las cuentas de abono

        /*
        $suma_cta_abono = $this->getSumaCuentaAbonados($res,$c_cargo);
        $suma_cta_abono .= $this->getSumaDigitoControl($res,$c_cargo);
        $ceros = $this->getceros(strlen($suma_cta_abono),15);

        $suma_cta_abono = trim($ceros.$suma_cta_abono);

        $cabecera = $cabecera.$suma_cta_abono;
        */

        $checksum = $this->getCheckSum($this->getSumaCuentaAbonados($res,$c_cargo),$this->getSumaDigitoControl($res,$c_cargo));
        $checksum = $this->getceros(strlen($checksum),15).$checksum;

        $cabecera = $cabecera.$checksum;
        //---- se termina la cabecera
        
        //damos inicio al body
        $body = "";
        $row = "";
        $error = "";


        for ($x=0;$x< count($res);$x++){

            $i = $res[$x];

            //1.- primero se coloca valor fijo 2
            $row = $row.'2';
            //2.- se asigna valor fijo A
            $row = $row.'A';
            //3.- se agrega la cuenta
            $row = $row.$i->CUENTAS_ABONO.$this->getEspacioBlanco(strlen($i->CUENTAS_ABONO),20);
            //4.- e coloca el valor fijo tipo de DNI(1,3,5) seguido del DNI
            $row = $row.$i->TIPO_DOCUMENTO.$i->DNI.$this->getEspacioBlanco(strlen($i->DNI),15);
            //5.- se coloca el nombre 75 max

            if (mb_detect_encoding($i->Nombre) == "UTF-8"){
                //$row = $row.utf8_encode($i->Nombre).$this->getEspacioBlanco(strlen(utf8_decode($i->Nombre)),76);
                $nom = HelpFunct::sanear_string($i->Nombre);

                $row = $row.$nom.$this->getEspacioBlanco(strlen($nom),75);
            }else{
                $row = $row.utf8_encode($i->Nombre).$this->getEspacioBlanco(strlen(utf8_decode($i->Nombre)),75);
            }




            //6.- referencia Beneficiario
            $row = $row.'Referencia Beneficiario '.$i->DNI.$this->getEspacioBlanco(strlen($i->DNI),16);
            //7.- referencia del empleado
            $row =$row.'Ref Emp '.$i->DNI.$this->getEspacioBlanco(strlen($i->DNI),12);
            //8.- e coloca 001 y al finl S
            $row .='0001';
            $m = number_format($i->MONTO, 2, ".", "");

            if($x==(count($res)-1)){
                $row  =$row.$this->getceros(strlen($m),17).number_format($i->MONTO, 2, ".", "").'S';
            }else{
                $row  =$row.$this->getceros(strlen($m),17).number_format($i->MONTO, 2, ".", "").'S'."\r\n";
            }

            $body = $row."\r";

        }


        $f['cabecera'] = $cabecera."\r\n";
        $f['body'] = $body;

        $url =base_path()."/storage/logs/telecredito.txt";

        $file = fopen(base_path()."/storage/logs/telecredito.txt", "w");
        fputs($file,$f['cabecera'] );
        //esto es desde hasya osea desde UTF-7 a EUC-JP
        //ejemplo mb_convert_encoding($str, "UTF-7", "EUC-JP");*/
        //fputs($file,mb_convert_encoding($f['body'], 'UTF-8'));
        fputs($file,$f['body']);
        fclose($file);

        //return response()->download(base_path()."/storage/logs/telecredito.txt", "telecredito.txt");

        return \Response::json(\URL::route('getTxtTelecredito'));

    }

    public function getTxtTelecredito(){
        return response()->download(base_path()."/storage/logs/telecredito.txt", "telecredito.txt");
    }


    public function getCargos(){

        $res = $this->personalRep->getCargos();

        return \Response::json($res);
    }


    public function getDepartamentos(){

        $res = $this->personalRep->getDepartamentos();

        return \Response::json($res);
    }



    public function getPlanilla(){

        $data = \Input::all();

        $res = $this->personalRep->getPlanilla($data['periodo']);
        return \Response::json($res);

    }

    public function getPlanillaAgrario(){
        $data = \Input::all();

        $res = $this->personalRep->getPlanillaAgrario($data['periodo']);
        return \Response::json($res);
    }

    public function getPlameRem(){

        $data = \Input::all();
        $periodo = $data['periodo'];

        $res = $this->personalRep->getPlameRem($periodo);


        $text = '';

        foreach ($res as $i){

            $row = $i->C1.'|'.$i->DNI.'|'.$i->CODIGO.'|'.$i->sum_monto_codigo.'|'.$i->sum_monto_codigo.'|';

            $text = $text.$row."\r\n";
        }


        $file = fopen(base_path()."/storage/logs/plame.txt", "w");
        fputs($file,$text);
        fclose($file);


        return \Response::json(\URL::route('getTxtPlameRem',['periodo'=>$periodo]));
        //return \Response::json($data);

    }

    public function getTxtPlameRem($periodo){


        $name_txt = '0601'.$periodo.'20518803078';

        return response()->download(base_path()."/storage/logs/plame.txt", $name_txt.'.rem');
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

            $suma +=floatval(substr($i->CUENTAS_ABONO, 3, 8)) ;
        }

        //sumamos primero las cuentas de abono
        $suma = $suma + floatval(substr($c_cargo, 3, 7));
    
        return $suma;
    }


    public function getSumaDigitoControl($data,$c_cargo){
        $suma =0;
       
        foreach ($data as $i){

            $suma = $suma + floatval(substr($i->CUENTAS_ABONO, 12, 2));
        }
       

        //sumamos primero las cuentas de abono
        $suma = $suma + floatval(substr($c_cargo, 11, 2));

        return $suma;
    }

    public function getEspacioBlanco($cant,$bandera){

        $espacios = '';

        for ($i=0;$i<$bandera-$cant;$i++){
            $espacios.=' ';
        }

        return $espacios;
    }

    public function getCheckSum($val_cuenta,$val_control)
    {
        
        //para realizar este algoritmo se toma lo siguiente
        // Para el valor de $a se obtine todos los primeros digitos excepto los 2 últimos 
        // Para el valor de $b son los dos ultimos digitos de val_cuenta
        // Para el valor de $c  son los primeros dígitos menos los 3 ultimos val_control
        // para el valor de $d son los 3 ultimos digitos de val control
         
        $a = substr($val_cuenta, 0, (strlen($val_cuenta)-2));
        
        $b = substr($val_cuenta, (strlen($val_cuenta)-2), 2);
        $cant_len_val_control = strlen($val_control);

        if ($cant_len_val_control <3) {
            
            $c = 0;

        } else {
            
           $c = substr($val_control, 0,-3);
        }

        $d = substr($val_control,$cant_len_val_control-3,3);


        /*SI EN CASO $B + $C ES MAYOR A 99 SE TIENE QUE QUITAR EL PRIMER DIGITO DE LA SUMA*/
        //p_cambio : fzelada
        //dia: 25/11/16

        $suma_a_b = $b+$c;

        if ($suma_a_b > 99) {
            # code...
             $val = ($a+1).(($b+$c)-100).$d;

        } else {
            # code...
             $val = $a.($b+$c).$d;
        }
        

        return $val;



    }

}
