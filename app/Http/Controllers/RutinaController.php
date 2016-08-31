<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Monolog\Handler\ElasticSearchHandler;

class RutinaController extends Controller
{

    public function changeProveedores(){


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


        return \Response::Json($res);


    }


}
