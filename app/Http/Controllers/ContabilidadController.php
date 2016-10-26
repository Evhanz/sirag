<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use sirag\Repositories\ContabilidadRep;

class ContabilidadController extends Controller
{

    protected $contabilidadRep;


    function __construct(ContabilidadRep $contabilidadRep)
    {
        $this->contabilidadRep = $contabilidadRep;
    }


    public function viewBalanceGeneral(){

        return view('cc/viewBalanceGeneral');

    }


    public function viewControlOrdenCompra()
    {
        return view('cc/viewControlOrdenCompra');
    }

    public function viewPDB()
    {
        return view('cc/viewPDB');
    }


    
    //APIS

    public function getBalanceByNiveles()
    {
        # code...

        $data = \Input::all();

        $res = $this->contabilidadRep->getBalanceByNiveles($data);


        return \Response::json($res);

    }
    //funcion para el control de las ordenes de compras 
    public function getOrdenCompraForControl()
    {
        # code...

        $data = \Input::all();

        $res = $this->contabilidadRep->getOrdenCompraForControl($data);


        return \Response::json($res);

    }

    public function getGuiasAtendidasOfOC()
    {
        $data = \Input::all();

        $res = $this->contabilidadRep->getGuiasAtendidasOfOC($data);


        return \Response::json($res);


    }


    // -- esto es para el txt

    public function pdbTxtCompras()
    {

        //aumente el timpo

            set_time_limit (180);
        //

        $data  = \Input::all();

        
        // traemos la data de acuerdo a la fecha 

        $res = $this->contabilidadRep->pdbCompras($data['periodo']);
        $row = "";
        $body = "";

        foreach ($res as $item) {

           foreach ($item as $val){

               if ($val != '|')
                   $row.=$val.'|';
               else
                   $row.=$val;

           }

           $row .= "\r\n";
        }


        $name_file= "C20518803078".$data['periodo'].".txt";


        $f['body'] = $row;
        $url ="C20518803078".$data['periodo'];

        try {
            $file = fopen(base_path()."/storage/logs/$name_file", "w");
            fputs($file,$f['body'] );
            fclose($file);




            return "correcto";
            
        } catch (\Exception $e) {
            return "error :-";
        }

        

    }

    public function getTxtCompras($periodo){
        return response()->download(base_path()."/storage/logs/C20518803078$periodo.txt");
    }

    
    
}
