<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use sirag\Helpers\HelpFunct;
use sirag\Helpers\Maker;
use sirag\Repositories\PersonalRep;

class InsertJornalPacking extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process:insert_jornal_packing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ingresa los jornales diarios del dia aterior, para los procesos packing';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        set_time_limit (999);


        //
        $personalRep = new PersonalRep();
        $log = '';

        //obetenemos la fecha anterior al dia que corre el proceso

        $fecha = HelpFunct::addElementFecha('day','1','-');


        /*El proceso debe estar descrito en un documento, buscar las referencias*/

        /*se limpia los registros que ya hayan sido registrados , po si se vuelve a correr el proceso*/
        $personalRep->cleanRegDestajo($fecha);


        #1seleccion
        //primero se hace un selecct de todos los que se insertaran
        $pers_seleccion = $personalRep->getCantCajasPacking('u_seleccion', $fecha, $fecha);

        $a_seleccion = Maker::getArrayJornales($pers_seleccion,$fecha,'17006','121','EHERNANDEZ','L02');

        //------------ insert -------------------------

        $res_seleccion = $personalRep->insertJornalPacking($a_seleccion);


        //-------------- Area de log----
        if($res_seleccion !== true){
            //ingresar el error
            $log .= "<seleccion>: error : $res_seleccion|";
        }else{
            $cant = count($pers_seleccion);
            $log .= "<seleccion>: correcto: $cant|";
        }

        //-----------------------------------------------

        #2pesado
        //primero se hace un selecct de todos los que se insertaran
        $pers_seleccion = $personalRep->getCantCajasPacking('u_pesaje', $fecha, $fecha);

        $a_seleccion = Maker::getArrayJornales($pers_seleccion,$fecha,'17008','119','EHERNANDEZ','L02');

        //------------ insert -------------------------

        $res_seleccion = $personalRep->insertJornalPacking($a_seleccion);

        //-------------- Area de log----
        if($res_seleccion !== true){
            //ingresar el error
            $log .= "<pesaje>: error : $res_seleccion|";
        }else{
            $cant = count($pers_seleccion);
            $log .= "<pesaje>: correcto: $cant|";
        }

        //------------------------------------------------------------------


        #3embalaje

        //primero se hace un selecct de todos los que se insertaran
        $pers_seleccion = $personalRep->getCantCajasPacking('u_embalaje', $fecha, $fecha);

        $a_seleccion = Maker::getArrayJornales($pers_seleccion,$fecha,'17006','121','EHERNANDEZ','L02');

        //------------ insert -------------------------

        $res_seleccion = $personalRep->insertJornalPacking($a_seleccion);

        //-------------- Area de log----
        if($res_seleccion !== true){
            //ingresar el error
            $log .= "<embalaje>: error : $res_seleccion|";
        }else{
            $cant = count($pers_seleccion);
            $log .= "<embalaje>: correcto: $cant|";
        }

        $fecha_actual = HelpFunct::getFechaActual('Y-m-d H:i:s');

        $texto = 'Proceso ejecutado :'.$fecha_actual.' Resultado: '.$log;

        HelpFunct::writeLog('process_packing_jornal.txt',$texto,'a');

        $this->info('Concluyo!! .. revisar log');
        return 'ok';
    }


    private function information(){

        /**************Tabla de Equivalencia*****************
         * Labor        |   Codigo  |   Tipo    |   CCI     *
         * -------------------------------------------------*
         * Seleccion    |   121     |   TAREO   |   17006   *
         * Pesado       |   119     |   TAREO   |   17008   *
         * Embalaje     |   122     |   TAreo   |   17009   *
         * -------------------------------------------------*/

    }
}
