<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;
use sirag\Entities\Obj;
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

    public function viewGetLiquidacion(){
        return view('rh/viewGetLiquidacion');
    }


    public  function viewGetAFPNet(){
        return view('rh/viewGetAFPNet');
    }

    public function viewGetCostoMOFundoParron(){
        return view('rh/viewGetCostoMOFundoParron');
    }

    public function viewRegJornales(){
        return view('rh/viewRegJornales');
    }

    public function viewDeleteMovimientos(){
        return view('rh/viewDeleteMovimientos');
    }

    public function viewGetBoletaPago(){
        return view('rh/viewGetBoletaPago');
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

    public function getAllTrabajadores(){
        $res = $this->personalRep->getAllTrabajadores();
        return \Response::Json($res);
    }

    public function getCentroCostoInterno(){
        $res = $this->personalRep->getCentroCostoInterno();
        return \Response::Json($res);
    }

    public function getLaborByCodigo(){

        $data = \Input::all();
        $codigo = $data['codigo'];

        $res = $this->personalRep->getLaborByCodigo($codigo);

        return $res;

    }

    public function CodigoActividad(){
        $res = $this->personalRep->CodigoActividad();
        return $res;
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

      //  return \Response::json($res);

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


    public function getPlameRemSNL(){

        $data = \Input::all();
        /*
        $data['periodo'] = '201612';
        $data['f_inicio'] = '2016-12-01';
        $data['f_fin'] = '2016-12-31';
        */

        $res = $this->personalRep->getPlameSnl($data);

        $text = '';

        foreach ($res as $i){

            $row = $i->C1.'|'.$i->DNI.'|'.$i->CODIGO.'|'.$i->CANTIDAD.'|';

            $text = $text.$row."\r\n";
        }


        $file = fopen(base_path()."/storage/logs/plamesnl.txt", "w");
        fputs($file,$text);
        fclose($file);


        return \Response::json(\URL::route('getTxtPlameSNL',['periodo'=>$data['periodo']]));
        //return \Response::json($res);

    }

    public function getTxtPlameSNL($periodo){


        $name_txt = '0601'.$periodo.'20518803078';

        return response()->download(base_path()."/storage/logs/plamesnl.txt", $name_txt.'.snl');
    }

    public function getPlameJOR(){

        $data = \Input::all();
        /*
        $data['periodo'] = '201612';
        $data['f_inicio'] = '2016-12-01';
        $data['f_fin'] = '2016-12-31';
        */

        $res = $this->personalRep->getPlameJOR($data);


        $text = '';

        foreach ($res as $i){

            $row = $i->C1.'|'.$i->DNI.'|'.$i->H_L_ORDINARIAS.'|0|'.$i->H_L_EXTRAS.'|0|';
            $text = $text.$row."\r\n";
        }


        $file = fopen(base_path()."/storage/logs/plameJOR.txt", "w");
        fputs($file,$text);
        fclose($file);


        return \Response::json(\URL::route('getTxtPlameJOR',['periodo'=>$data['periodo']]));
        //return \Response::json($res);

    }

    public function getTxtPlameJOR($periodo){


        $name_txt = '0601'.$periodo.'20518803078';

        return response()->download(base_path()."/storage/logs/plameJOR.txt", $name_txt.'.jor');
    }


    public function getDetailLiquidacion(){


        $data  = \Input::all();

        $res = $this->personalRep->getDetailLiquidacion($data);

        return \Response::json($res);
    }

    public function getMovimientosByFichaAndPeriodo(){

        $data = \Input::all();


        $res = $this->personalRep->getMovimientosByFichaAndPeriodo($data);

        return \Response::json($res);

    }


    public function deleteMovimientoByPeriodoFicha(){

        $data = \Input::all();

        $item = $data['item'];
        $res = $this->personalRep->deleteMovimientoByPeriodoFicha($item);
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

    public function getLiquidacion(){

        $input = \Input::all();

        $periodo = explode("/", $input['fecha']);

        $input['periodo'] = $periodo[2].$periodo[1].$periodo[0];
        $input['inicio_periodo'] = $periodo[2].$periodo[1].'01';

        $data = $this->personalRep->getDetailLiquidacion($input);

        $view =  \View::make('rh.pdf.liquidacionPdf',compact('data'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
       // return $pdf->stream('invoice');
        return $pdf->download('liquidaciones:'.$input['fecha']);

       //return view('rh.pdf.liquidacionPdf');

    }


    public function getExcelAFPNet(){

        $data = \Input::all();

        $res = $this->personalRep->getAFPNet($data);


        \Excel::create('AFP NET ', function($excel) use($res) {

            $excel->sheet('Datos', function($sheet) use($res) {

                //$sheet->fromArray($res);
                //$sheet->fromArray($res, null, 'A1', true);
                //esto es para que que no salga l fila 1
                $sheet->fromArray($res, null, 'A1', false, false);

            });

        })->export('xls');


     //  return \Response::json($res);

    }


    public function getExcelCostoMOPorFundo(){

        set_time_limit (250);

        $data =  \Input::all();


        $res = $this->personalRep->getCostoMOPorFundo($data);

        $general = $this->personalRep->getCostoMOPor5CCI($data);

        $packing = $this->personalRep->getCostoMOPor5CCI($data,'packing');


        if(count($res['res_actividades'])<1){
            return back();
        }

        /**
         * sacaremos por cada
        */

        //solo por prueba -- pasar toda esta orecacion a otra capa

        $a_codigos = [];
        $codigos = $res['codigos'];
        $a_actividades = $res['res_actividades'];

        foreach ($codigos as $item){

            $codigo = new Obj();
            $codigo->campain = $item->campain;
            $codigo->det_fundos = array();

            foreach ($item->fundos as $fundo){
                $f = new Obj();
                $f->fundo = $fundo->fundo;
                $f->actividades = array();
                $f->parrones = $fundo->parron;
                //ahora buscamos por cada actividad los detalles que tiene

                foreach ($a_actividades as $activi){

                    $dellates_actividades = ($activi->detalles);
                    $o_actividad = new Obj();
                    $o_actividad->descripcion = $activi->descripcion;
                    $o_actividad->detalles = array();

                    foreach ($fundo->parron as $parron){
                        //recorremos por la cantidad de parron buscar los
                        //formateamos el codigo en ccfppxx = c: campania, f:fundo, p:parron
                        $p =substr($parron,0,2);
                        $codigo_format =$item->campain.$fundo->fundo.$p.'1';
                        $dets = $this->getItemDetalleCodigoParron($dellates_actividades,$codigo_format);

                        //$dets = $dellates_actividades->where('item',$codigo_format);
                        array_push($o_actividad->detalles,$dets);

                    }
                    array_push($f->actividades,$o_actividad);

                }
                array_push($codigo->det_fundos,$f);
            }

            array_push($a_codigos,$codigo);
        }

        //return \Response::json($a_codigos);


        Excel::create('COMSUMO MO FUNDO ', function($excel) use($res,$general,$packing,$a_codigos) {

            $excel->sheet('Consumo', function($sheet) use($res) {

                $res_actividades = $res['res_actividades'];
                $totales = $res['totales'];
                $codigos = $res['codigos'];
                $title = 'FUNDOS Y PARRONES ';

                $sheet->loadView('rh.excel.costoMOFundoParron',compact('res_actividades','totales','codigos','title'));


            });


            $excel->sheet('General', function($sheet) use($general) {

                $cabecera = $general['cabecera'];
                $actividades = $general['actividades'];


                $sheet->loadView('rh.excel.costoMOFundoParronGeneral',compact('actividades','cabecera'));

            });

            $excel->sheet('packing', function($sheet) use($packing) {

                $cabecera = $packing['cabecera'];
                $actividades = $packing['actividades'];


                $sheet->loadView('rh.excel.costoMOFundoParronPacking',compact('actividades','cabecera'));

            });

            /* por cada una de las campañas */

            foreach ($a_codigos as $camp){

                foreach ($camp->det_fundos as $fundos){


                    $fundo          =   $fundos->fundo;
                    $campain        =   $camp->campain;
                    $actividades    =   $fundos->actividades;
                    $parrones       =   $fundos->parrones;
                    $codigos        =   collect($actividades[0]->detalles);
                    $codes        =   $codigos->groupBy('item')->keys()->toArray();

                    $excel->sheet('Fundo'.$fundo, function($sheet) use($fundo,$campain,$actividades,$parrones,$codes) {

                        $sheet->loadView('rh.excel.costoMOFundoParronCU',
                            compact('fundo','campain','actividades','parrones','codes'));

                    });

                }

            }



        })->export('xls');


    }






    //funciones store

    public function regJornales(){

        $data = \Input::all();

        $detalle = $data['detalle'];
        $bandera = 0;


        $response = ['res'=>'200','mensaje'=>''];


        //primero averiguaremos si es que encontramaos algun registro igual

       // $res =  $this->personalRep->getJornalByParameters($detalle);


        //averiguamos si el total de registro excede a lo permitido por 24 h

        $total_horas =  $this->personalRep->getTotalHoras($detalle,''); //nos da el total de horas registrados

        $pre_cant_horas = $total_horas + $detalle['hora'];

        if($pre_cant_horas >24){

            $response['res'] = '500';

            $response['mensaje'] = $response['mensaje'].'La cantidad de hora a ingresar supera lo permisible  \\n';
            $bandera=1;

        }
        else{


            /*averiguaremos que tipo de labor se está registrando*/


            $actividad = $detalle['actividad'];

            switch ($actividad){

                case 'HORA-NORMAL' :

                    $monto_activity = $this->personalRep->getTotalHoras($detalle,$actividad);



                    $pre_cant_horas_activity = $monto_activity + $detalle['hora'];

                    if($pre_cant_horas_activity>8){

                        $response['res'] = '500';

                        $response['mensaje'] = $response['mensaje'].'La cantidad de hora a ingresar supera lo permisible  \\n';
                        $bandera = 1;

                    }else{
                        //registrar
                    }
                    break;
                case 'HORA-EXTRA-25%' :

                    $monto_activity = $this->personalRep->getTotalHoras($detalle,$actividad);

                    $response['data'] = $monto_activity;

                    $pre_cant_horas_activity = $monto_activity + $detalle['hora'];

                    if($pre_cant_horas_activity>2){

                        $response['res'] = '500';

                        $response['mensaje'] = $response['mensaje'].'La cantidad de hora a ingresar supera lo permisible  \\n';
                        $bandera = 1;

                    }else{
                        //registrar
                    }

                    break;
                default:

                    //registrar
                    break;
            }



        }

        if($bandera == 0){
            $response['mensaje']='ok';
            $res = $this->personalRep->regJornales($detalle);
        }



        return \Response::Json($response);


    }


    public function getMarcacionDICONTrabajadorByFecha(){

        $data = \Input::all();
        $res = $this->personalRep->getMarcacionDICONTrabajadorByFecha($data);


        return \Response::Json($res);

    }



    public function deleteJornales(){

        $data = \Input::all();

        $res = $this->personalRep->deleteJornal($data['item']);

        return \Response::Json('ok');

    }


    public function getJornalesByFechas(){

        $data = \Input::all();

        $res = $this->personalRep->getJornalesByFechas($data);

        return \Response::Json($res);

    }

    public function processdominical(){

        $data = \Input::all();



        $fechaI = $data['f_i'];
        $fechaF = $data['f_f'];
        $val = '';

        /*
        $fechaI = '2017-01-30';
        $fechaF = '2017-02-04';
        */

        $f_I = explode('-',$fechaI);
        $f_F = explode('-',$fechaF);

        $pass = [];

        //quiere decir que abarca dos meses
        if($f_I[1] != $f_F[1]){

            //1. hacemos el primer caso del  mes

            //1.- sacamos el ultimo dia del mes de la fecha inicial

            $f_inicio = $fechaI;
            $f_1_fin = $f_I[0].'-'.$f_I[1].'-'.HelpFunct::getUltimoDiaMes($f_I[0],$f_I[1]);
            $res = $this->personalRep->processdominical($f_inicio,$f_1_fin);

            //var_dump($res);

            $this->personalRep->deleteJornalVolume($f_1_fin);

            foreach ($res as $item){

                $item->fecha =  $f_1_fin;

                $d['ficha']     =   $item->TRABAJADOR;
                $d['fecha']     =    $f_1_fin;
                $d['actividad'] =   'HORA-DOMINICAL';
                $d['hora']      =   round($item->CANTIDAD,2);
                $d['cci']       =   '696969';//aux_valor5
                $d['codigo']    =   '9100';//aux_valor16
                $d['user']      =   'EHERNANDEZ';//aux_valor16
                $d['ubigeo']    =   'L02';//aux_valor20

                $reg = $this->personalRep->regJornales($d);

                $p['trabajador'] = $item->TRABAJADOR;
                $p['res']        = $reg;

                array_push($pass,$p);

            }

            $val = $this->personalRep->getJornalesByFechas($f_1_fin,'dominical');

             //2 . hacemos el segundo caso del mes


            $f_inicio = $f_F[0].'-'.$f_F[1].'-'.'01';
            $f_1_fin = $fechaF;
            $res = $this->personalRep->processdominical($f_inicio,$f_1_fin);

            $f = HelpFunct::getNextDia($fechaF);

            $this->personalRep->deleteJornalVolume($f->format('Y-m-d'));

            foreach ($res as $item){

                $item->fecha = $f->format('d-m-Y');

                $d['ficha']     =   $item->TRABAJADOR;
                $d['fecha']     =   $f->format('d-m-Y');
                $d['actividad'] =   'HORA-DOMINICAL';
                $d['hora']      =   round($item->CANTIDAD,2);
                $d['cci']       =   '696969';//aux_valor5
                $d['codigo']    =   '9100';//aux_valor16
                $d['user']      =   'EHERNANDEZ';//aux_valor16
                $d['ubigeo']    =   'L02';//aux_valor20

                $reg = $this->personalRep->regJornales($d);

                $p['trabajador'] = $item->TRABAJADOR;
                $p['res']        = $reg;

                array_push($pass,$p);

            }

            $temp = $this->personalRep->getJornalesByFechas($f->format('Y-m-d'),'dominical');
            array_push($val,$temp);


            //return \Response::Json($pass);


        }
        else{



            $res = $this->personalRep->processdominical($fechaI,$fechaF);

            $f = HelpFunct::getNextDia($fechaF);

            $this->personalRep->deleteJornalVolume($f->format('Y-m-d'));

            foreach ($res as $item){

                $item->fecha = $f->format('d-m-Y');

                $d['ficha']     =   $item->TRABAJADOR;
                $d['fecha']     =   $f->format('d-m-Y');
                $d['actividad'] =   'HORA-DOMINICAL';
                $d['hora']      =   round($item->CANTIDAD,2);
                $d['cci']       =   '696969';//aux_valor5
                $d['codigo']    =   '9100';//aux_valor16
                $d['user']      =   'EHERNANDEZ';//aux_valor16
                $d['ubigeo']    =   'L02';//aux_valor20

                $reg = $this->personalRep->regJornales($d);

                $p['trabajador'] = $item->TRABAJADOR;
                $p['res']        = $reg;

                array_push($pass,$p);

            }


           // return \Response::Json($pass);

            $val = $this->personalRep->getJornalesByFechas($f->format('d-m-Y'),'dominical');

        }



        //luego obtenemos los valores procesados

        //sacamos el dia siguiente

        return \Response::Json($val);


    }


    public function getJefeByFicha($ficha){

        $res = $this->personalRep->getJefeByFicha($ficha);

        return \Response::Json($res);

    }


    public function getBoletaPago()
    {

        set_time_limit (180);


        $data = \Input::all();
        $fecha = $data['periodo'];
        $fecha = explode('/', $fecha);


        $f = Carbon::createFromDate($fecha[2], $fecha[1], $fecha[0]);

        $f_f = $f->format('d/m/Y');

        $f_i = $f->subDay(6)->format('d/m/Y');


        $fecha = $fecha[2] . '-' . $fecha[1] . '-' . $fecha[0];
        $data['periodo'] = $fecha;


        $res = $this->personalRep->getBoletaDePago($data);


        $view = \View::make('rh.pdf.boletaPagoPdf', compact('res', 'f_i', 'f_f'))->render();
        $snappy = \App::make('snappy.pdf');
        //To file
                $html = '<h1>Bill</h1><p>You owe me money, dude.</p>';

        /*
                $snappy->generateFromHtml($html, '/tmp/bill-124.pdf');
                $snappy->generate('http://www.github.com', '/tmp/github.pdf');
        */


        return \PDFS::loadView('rh.pdf.boletaPagoPdf', compact('res', 'f_i', 'f_f'))->setPaper('a4')->stream('nombre-archivo.pdf');



        //$pdf = \App::make('dompdf.wrapper');
        //$pdf->loadHTML($view)->setPaper('a4');
        // return $pdf->download('invoice');

        //dd($view);


    }






    //funcion helper , pasar a la caa helpers

    public function getItemDetalleCodigoParron($detalles , $item){

        $response = '';

        foreach ($detalles as $detalle){

            if ($detalle->item == $item){
                $response =$detalle;
                break;
            }
        }

        return $response;

    }





}
