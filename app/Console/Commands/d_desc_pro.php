<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class d_desc_pro extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'divide:proveedor';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Divide el campo de descripcion de la tabla gen_tabcod de proveedores en campos correspondientes';

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
        //


        $res  = \DB::select("select CODIGO , DESCRIPCION 
                from flexline.gen_tabcod
                where EMPRESA='e01'
                and TIPO='CON_PROVEE'
                AND CODIGO LIKE '10%'");



        foreach ($res as $item){

            //array que contendra la cadena de caracteres
            $a = explode(" ", $item->DESCRIPCION);
            $item->cant = count($a);

            if(count($a)<4){

                $ra = \DB::update("UPDATE flexline.gen_tabcod SET TEXTO2='$a[0]',TEXTO3='$a[1]',TEXTO4='$a[2]' WHERE EMPRESA='e01'
                                and TIPO='CON_PROVEE'
                                AND CODIGO LIKE '$item->CODIGO'");

                //$ra = "cumple-$item->cant";
            }else if (count($a)==4){

                $ra = \DB::update("UPDATE flexline.gen_tabcod SET TEXTO2='$a[0]',TEXTO3='$a[1]',TEXTO4='$a[2]',TEXTO5='$a[3]' WHERE EMPRESA='e01' 
                                and TIPO='CON_PROVEE'
                                AND CODIGO LIKE '$item->CODIGO'");
                // $ra = 'cumple 4';
            }else{
                $ra='nada';
            }

            $item->up = $ra;

        }



        $file = fopen(base_path()."/storage/logs/reg_accion_divide_provee.log", "a");

        fwrite($file, "Correctamente se modifico ".count($res)." hora y fecha ".date('d-m-Y h:i:s') . PHP_EOL);
        fclose($file);


        $this->info('Correcto'.count($res));


    }
}
