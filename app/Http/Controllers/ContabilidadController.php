<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use sirag\Repositories\ContabilidadRep;

use Maatwebsite\Excel\Facades\Excel;

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

            $bandera = 0;

            $row.=trim($item->c1).'|';
            $row.=trim($item->c2).'|';
            $row.=$this->changeFormatFecha($item->c3).'|';
            $row.=trim($item->c4).'|';
            $row.=trim($item->c5).'|';
            $row.=trim($item->c6).'|';
            $row.=trim($item->c7).'|';
            $row.=trim($item->c8).'|';
            $row.=trim($item->c9).'|';
            $row.=trim($item->c10).'|';
            $row.=trim($item->c11).'|';
            $row.=trim($item->c12).'|';
            $row.=trim($item->c13).'|';
            $row.=trim($item->c14).'|';
            $row.=trim($item->c15).'|';
            $row.=trim($item->c16).'|';
            $row.=number_format(trim($item->c17), 2, ".", "").'|';
            $row.=trim($item->c18).'|';
            $row.=number_format(trim($item->c19), 2, ".", "").'|';
            $row.=number_format(trim($item->c20), 2, ".", "").'|';
            $row.=trim($item->c21).'|';
            $row.=trim($item->c22).'|';
            $row.=trim($item->c23).'|';
            $row.=trim($item->c24).'|';
            $row.=trim($item->c25).'|';
            $row.=trim($item->c26).'|';
            $row.=trim($item->c27).'|';
            $row.=trim($item->c28).'|';
            $row.=trim($item->c29).'|';
            $row.=trim($item->c30).'|';


            /*

           foreach ($item as $val){

               if ($val != '|'){


                   if ($bandera == 2) {
                       $val = $this->changeFormatFecha($val);
                   }


                   $row.=trim($val).'|';
               }
               else
                   $row.=$val;




               $bandera++;

           }*/

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


    public function pdbTxtVentas()
    {
        # code...
        //aumente el timpo

            set_time_limit (180);
        //

        $data  = \Input::all();

        
        // traemos la data de acuerdo a la fecha 

        $res = $this->contabilidadRep->pdbVentas($data['periodo']);
        $row = "";
        $body = "";
        $row = "";


        foreach ($res as $item) {

            $bandera = 0;

            $row.=trim($item->c1).'|';
            $row.=trim($item->c2).'|';
            $row.=$this->changeFormatFecha($item->c3).'|';
            $row.=trim($item->c4).'|';
            $row.=trim($item->c5).'|';
            $row.=trim($item->c6).'|';
            $row.=trim($item->c7).'|';
            $row.=trim($item->c8).'|';
            $row.=trim($item->c9).'|';
            $row.=trim($item->c10).'|';
            $row.=trim($item->c11).'|';
            $row.=trim($item->c12).'|';
            $row.=trim($item->c13).'|';
            $row.=trim($item->c14).'|';
            $row.=trim($item->c15).'|';
            $row.=trim($item->c16).'|';
            $row.=number_format(trim($item->c17), 2,".", "").'|';
            $row.=trim($item->c18).'|';
            $row.=trim($item->c19).'|';
            $row.=trim($item->c20).'|';
            $row.=trim($item->c21).'|';
            $row.=trim($item->c22).'|';
            $row.=trim($item->c23).'|';
            $row.=trim($item->c24).'|';
            $row.=trim($item->c25).'|';
            $row.=trim($item->c26).'|';
            $row.=trim($item->c27).'|';
            $row.= ($item->c28='' || is_null($item->c28)) ? ''.'|' : $this->changeFormatFecha($item->c28).'|' ;
            //$row.=$this->changeFormatFecha($item->c28).'|';
            $row.=number_format(trim($item->c29), 2, ".", "").'|';
            $row.=number_format(trim($item->c30), 2, ".", "").'|';

           $row .= "\r\n";
        }
        

        $name_file= "V20518803078".$data['periodo'].".txt";


        $f['body'] = $row;
        $url ="V20518803078".$data['periodo'];

        try {
            $file = fopen(base_path()."/storage/logs/$name_file", "w");
            fputs($file,$f['body'] );
            fclose($file);
            return "correcto";
            
        } catch (\Exception $e) {
            return "error :-";
        }

    }

    public function getTxtVentas($periodo){
        return response()->download(base_path()."/storage/logs/V20518803078$periodo.txt");
    }


    //--
    public function getTipoCambio()
    {
        $data = \Input::all();

        $res = $this->contabilidadRep->getTipoCambio($data);

        $row = "";
        $body = "";
        

       
        foreach ($res as $item) {

           
            $row.=$this->changeFormatFecha($item->c1).'|';
            $row.=trim($item->c2).'|';
            $row.='|';

            $row .= "\r\n";
        }
        

        $name_file= "20518803078.tc";


        $f['body'] = $row;
        $url ="20518803078";

        try {
            $file = fopen(base_path()."/storage/logs/$name_file", "w");
            fputs($file,$f['body'] );
            fclose($file);
            return "correcto";
            
        } catch (\Exception $e) {
            return "error :-";
        }
    }


    public function getTxtTipoCambio(){
        return response()->download(base_path()."/storage/logs/20518803078.tc");
    }






    // -- esto es para excel


    public function pdbExcelCompras($periodo)
    {   

      //aumente el timpo

            set_time_limit (180);
        //

        $res = $this->contabilidadRep->pdbCompras($periodo);
    
        Excel::create('C20518803078', function($excel) use ($res){
 
            $excel->sheet('Productos', function($sheet) use ($res){
 
                
                $sheet->fromArray($res);
 
            });
        })->export('csv');
            
       
         
       
    }


    //funciones helpers

    //-- change formato de fechas de yyyy-mm-dd

    public function changeFormatFecha($fecha)
    {
        
        $fecha = explode("-", $fecha);

        if(count($fecha)== 3){

        $fecha = $fecha[2]."/".$fecha[1]."/".$fecha[0];

        }else{
            $fecha = "** no hay fecha **";
        }


        return $fecha;

    }

    
    
}
