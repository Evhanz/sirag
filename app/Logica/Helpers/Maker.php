<?php
/**
 * Created by PhpStorm.
 * User: ehernandez
 * Date: 26/06/2017
 * Time: 01:00 PM
 */

namespace sirag\Helpers;


use sirag\Entities\Obj;

class Maker
{

    public static function getArrayJornales($personal,$fecha,$cci,$cod_labor,$usuario,$aux_20,$factor)
    {

        $res = [];

        $fecha = explode('-',$fecha);
        $fecha = implode('',$fecha);

        foreach ($personal as $item){
            $obj = [];
            $obj['EMPRESA'] = 'E01';
            $obj['TRABAJADOR'] = $item->ficha;
            $obj['FECHA'] = $fecha;
            $obj['TRATO'] = 'TRATO_HORA';
            $obj['CODACTIVIDAD'] = 'HORA-NORMAL';
            $obj['HINICIO'] = 0;
            $obj['HFIN'] = 0;
            $obj['THORAS'] = $item->cant_cajas;
            $obj['CANTIDAD'] = round($item->cant_cajas*$factor ,2 )  ;
            $obj['MONTO'] =  round($item->cant_cajas*$factor ,2 )  ;
            $obj['ESTADO'] = 'NRPT';
            $obj['AUX_VALOR1'] = '';
            $obj['AUX_VALOR2'] = '';
            $obj['AUX_VALOR3'] = '';
            $obj['AUX_VALOR4'] = '';
            $obj['AUX_VALOR5'] = $cci;
            $obj['AUX_VALOR6'] = '';
            $obj['AUX_VALOR7'] = '';
            $obj['AUX_VALOR8'] = '';
            $obj['AUX_VALOR9'] = '';
            $obj['AUX_VALOR10'] = '';
            $obj['AUX_VALOR11'] = 'T';
            $obj['AUX_VALOR12'] = '';
            $obj['AUX_VALOR13'] = '';
            $obj['AUX_VALOR14'] = '';
            $obj['AUX_VALOR15'] = '';
            $obj['AUX_VALOR16'] = $cod_labor;
            $obj['AUX_VALOR17'] = '';
            $obj['AUX_VALOR18'] = '';
            $obj['AUX_VALOR19'] = $usuario;
            $obj['AUX_VALOR20'] = $aux_20;
            $obj['MONTO_INICIAL'] =  round($item->cant_cajas*$factor ,2 ) ;
            $obj['TIPO_TRAB'] = 'TRABAJADOR';
            $obj['TIPODOCTOP'] = '';
            $obj['CORRELATIVOP'] = 0;
            $obj['TIPODOCTOACT'] = '';
            $obj['CORRELATIVOACT'] = 0;
            $obj['COMENTARIO'] = 'SIRAG-PACKING';

            array_push($res,$obj);
        }

        return $res;
    }


    public static function getArrayCodigosCajas($cod_inicio,$cant,$t_caja,$uva,$calibre,$lote){


        $res =[];

        for ($i = 0 ;$i<$cant;$i++){

            $item = [];
            $item['codigo'] = $cod_inicio+$i;
            $item['t_caja'] = $t_caja;
            $item['uva'] = $uva;
            $item['calibre'] = $calibre;
            $item['estado'] = 0;
            $item['usuario'] = 'EHERNANDEZ';
            $item['lote'] = $lote;

            array_push($res,$item);
        }


        return $res;


    }

    /**
     * Esta funcion trae el array de acuerdo al cruce de columnas que se haran ,
     * devolvera cada parron con su fundo dependiente
     */
    public static function getArrayModActivityKey($periodo){

        $a_keys = [];

        $o = new Obj();
        $o->fundo = '6';
        $o->parrones= [$periodo.'6011',$periodo.'6012',$periodo.'6013'];

        array_push($a_keys,$o);

        $o = new Obj();
        $o->fundo = '6';
        $o->parrones= [$periodo.'6041',$periodo.'6051',$periodo.'6061'];

        array_push($a_keys,$o);

        $o = new Obj();
        $o->fundo = '3';
        $o->parrones= [$periodo.'3011',$periodo.'3021'];

        array_push($a_keys,$o);

        $o = new Obj();
        $o->fundo = '1';
        $o->parrones= [$periodo.'1011',$periodo.'1031'];

        array_push($a_keys,$o);

        $o = new Obj();
        $o->fundo = '1';
        $o->parrones= [$periodo.'1021',$periodo.'1041'];

        array_push($a_keys,$o);

        $o = new Obj();
        $o->fundo = '1';
        $o->parrones= [$periodo.'1051',$periodo.'1061'];

        array_push($a_keys,$o);

        $o = new Obj();
        $o->fundo = '5';
        $o->parrones= [$periodo.'5011',$periodo.'5021',$periodo.'5031',$periodo.'5041',$periodo.'5051'
            ,$periodo.'5061',$periodo.'5071',$periodo.'5081',$periodo.'5091',$periodo.'5101'];

        array_push($a_keys,$o);

        $o = new Obj();
        $o->fundo = '1';
        $o->parrones= [$periodo.'1071',$periodo.'1081',$periodo.'1091',$periodo.'1101'];

        array_push($a_keys,$o);


        $o = new Obj();
        $o->fundo = '1';
        $o->parrones= [$periodo.'1111',$periodo.'1121',$periodo.'1131',$periodo.'1141'];

        array_push($a_keys,$o);

        $o = new Obj();
        $o->fundo = '4';
        $o->parrones= [$periodo.'4011',$periodo.'4021',$periodo.'4031',$periodo.'4041'];

        array_push($a_keys,$o);

        $o = new Obj();
        $o->fundo = '4';
        $o->parrones= [$periodo.'4081',$periodo.'4091',$periodo.'4101'];

        array_push($a_keys,$o);

        $o = new Obj();
        $o->fundo = '4';
        $o->parrones= [$periodo.'4111',$periodo.'4121',$periodo.'4131',$periodo.'4141',$periodo.'4151',$periodo.'4161'
            ,$periodo.'4171',$periodo.'4181',$periodo.'4191'];

        array_push($a_keys,$o);

        $o = new Obj();
        $o->fundo = '2';
        $o->parrones= [$periodo.'2021',$periodo.'2031'];

        array_push($a_keys,$o);

        $o = new Obj();
        $o->fundo = '2';
        $o->parrones= [$periodo.'2011',$periodo.'2041'];

        array_push($a_keys,$o);

        $o = new Obj();
        $o->fundo = '4';
        $o->parrones= [$periodo.'4051'];

        array_push($a_keys,$o);

        $o = new Obj();
        $o->fundo = '4';
        $o->parrones= [$periodo.'4061',$periodo.'4711',$periodo.'4721'];

        array_push($a_keys,$o);


        return $a_keys;



    }

    public static function getArrayUpdateChangeCajas($caja_saliente,$caja_cambiar,$codigo_motivo){

        //para B

        $update_B = [];
        $update_B['u_embalaje']     = $caja_saliente['u_embalaje'] ;
        $update_B['u_pesaje']       = $caja_saliente['u_pesaje'] ;
        $update_B['u_peso_fijo']    = $caja_saliente['u_peso_fijo'] ;
        $update_B['u_seleccion']    = $caja_saliente['u_seleccion'] ;
        $update_B['estado']         = $caja_saliente['estado'] ;
        $update_B['cod_pallet']     = $caja_saliente['cod_pallet'] ;

        //Detalle cambio

        $fecha = HelpFunct::getFechaActual('ymd');

        $d_cambio = [];
        $d_cambio['codigo_origen']  =   $caja_saliente['codigo'];
        $d_cambio['codigo_destino'] =   $caja_cambiar['codigo'];
        $d_cambio['data_origen']    =   implode('|',$caja_saliente);
        $d_cambio['data_destino']   =   implode('|',$caja_cambiar);
        $d_cambio['fecha']          =   $fecha;
        $d_cambio['codigo_motivo']  =   $codigo_motivo;


        $response = [];
        $response['update_B'] = $update_B;
        $response['d_cambio'] = $d_cambio;


        return $response;


    }

}