<?php
/**
 * Created by PhpStorm.
 * User: ehernandez
 * Date: 26/06/2017
 * Time: 01:00 PM
 */

namespace sirag\Helpers;


class Maker
{

    public static function getArrayJornales($personal,$fecha,$cci,$cod_labor,$usuario,$aux_20)
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
            $obj['CANTIDAD'] = 8;
            $obj['MONTO'] = 8;
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
            $obj['MONTO_INICIAL'] = 8;
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

}