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


    //--- esto es para exportar telecredito
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
        $ceros = $this->getceros(strlen($sumaMonto),17);
        $cabecera = $cabecera.$ceros.$sumaMonto;
        //9.-se agrega la referencia de planilla
        $cabecera = $cabecera.$data['ref_planilla'].$this->getEspacioBlanco(strlen($data['ref_planilla']),40);
        //10.-sumamos todas las cuentas de abono
        $suma_cta_abono = $this->getSumaCuentaAbonados($res,$c_cargo);
        //$suma_cta_abono .= $this->getSumaDigitoControl($res,$c_cargo);
        //$suma_cta_abono = $this->getceros(strlen($suma_cta_abono),15);
        $cabecera = $cabecera.$suma_cta_abono;

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
            $row = $row.$i->Nombre.$this->getEspacioBlanco(strlen(utf8_decode($i->Nombre)),75);
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
        fputs($file,$f['body'] );
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

            $suma = $suma + floatval(substr($i->CUENTAS_ABONO, 3, 8)) ;
        }

        //sumamos primero las cuentas de abono
        $suma = $suma + floatval(substr($c_cargo, 3, 7));
        


        
        //return $suma;
        return count($data)+1;
    }


    public function getSumaDigitoControl($data,$c_cargo){
        $suma =0;
        foreach ($data as $i){

            $suma = $suma + floatval(substr($i->CUENTAS_ABONO, 11, 2));
        }

        //sumamos primero las cuentas de abono
        $suma = $suma + floatval(substr($c_cargo, 12, 2));

        return $suma;
    }

    public function getEspacioBlanco($cant,$bandera){

        $espacios = '';

        for ($i=0;$i<$bandera-$cant;$i++){
            $espacios.=' ';
        }

        return $espacios;
    }

}
