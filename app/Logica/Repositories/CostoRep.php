<?php
/**
 * Created by PhpStorm.
 * User: ehernandez
 * Date: 16/05/2017
 * Time: 05:36 PM
 */

namespace sirag\Repositories;


use sirag\Entities\Obj;
use sirag\Helpers\HelpFunct;

class CostoRep
{
    public function getDistribucion($correlativo){

    }

    public function insertCabeceraDistribucion($data){


        $keys= array_keys($data);
        $key  = implode(',',$keys);
        //$values = implode("','",$data);
        $values = '';
        foreach ($data as $val){

            if($val == null || $val == ''){
                $values .="null,";

            }else{
                $values .= "'$val',";
            }

        }
        $values = trim($values,',');

        $table = 'flexline.CON_ENCCOM';

       /* \DB::insert('insert into ');
        $table = '##TablaTemporal';
            $bandera = $this->processTemporalTable($keys,'##TablaTemporal');

            */

        $query = "INSERT INTO $table ($key) values($values)";

        $res = \DB::insert($query);

        return $res;

    }

    public function insertDetallesDistribucion($correlativo,$fecha,$t_cambio){

        //primero debemos sacar los select para el insert

        $fechas = explode('-',$fecha);
        $periodo = $fechas[0];
        $fecha_i = $fechas[0].$fechas[1].'01';
        $fecha_f = $fechas[0].$fechas[1].$fechas[2];
        $key = [];
        $table = 'flexline.CON_MOVCOM';

        $fecha = str_replace('-','',$fecha);

        $query = "SELECT AUX_VALOR1 CENTRO_COSTO,CUENTA,DEBE_INGRESO MONTO,AUX_VALOR19 CCI,
                (convert(varchar,TIPO_COMPROBANTE)+'-'+convert(varchar,CORRELATIVO)+' Linea: '+convert(varchar,SECUENCIA))GLOSA
                ,(SELECT TEXTO2 FROM flexline.GEN_TABCOD
                WHERE EMPRESA='E01'
                AND TIPO='CFG.CONTAB.DISTRIB'
                AND TEXTO = AUX_VALOR1
                AND TEXTO1 = CUENTA
                )CUENTA_DEBE
                ,(SELECT TEXTO3 FROM flexline.GEN_TABCOD
                WHERE EMPRESA='E01'
                AND TIPO='CFG.CONTAB.DISTRIB'
                AND TEXTO = AUX_VALOR1
                AND TEXTO1 = CUENTA
                )CUENTA_HABER
                ,(SELECT TEXTO FROM flexline.GEN_TABCOD
                WHERE EMPRESA='E01'
                AND TIPO='CFG.CONTAB.DISTRIB'
                AND TEXTO = AUX_VALOR1
                AND TEXTO1 = CUENTA
                )CENTRO_COSTO
                FROM flexline.CON_MOVCOM
                WHERE EMPRESA='E01'
                AND ESTADO='A'
                AND FECHA BETWEEN '$fecha_i' AND '$fecha_f'
                AND TIPO_COMPROBANTE NOT IN ('AS. DESTINO')
                AND LEN(AUX_VALOR1)>0
                AND (SELECT TEXTO2 FROM flexline.GEN_TABCOD
                WHERE EMPRESA='E01'
                AND TIPO='CFG.CONTAB.DISTRIB'
                AND TEXTO = AUX_VALOR1
                AND TEXTO1 = CUENTA
                AND DESCRIPCION = 'CENTROCOSTO'
                ) IS NOT NULL
                AND AUX_VALOR19 NOT IN ('ALIMENTACION OBREROS','BONO','CONASIGFAM','CTS','DIST_H.EXT.100%',
                'DIST_H.EXT.25%','DIST_H.EXT.35%','DIST_H.EXT_NOCH_100%','DIST_H.EXT_NOCH_25%','DIST_H.EXT_NOCH_35%'
                ,'DIST_H.NOCTURNO','DIST_H.NORMAL','ESSALUD','GRATIFICACION','VACACIONES')
                ";



        $select_base_value = \DB::select($query);
        $a_registros_asiento = [];
        $bandera = 0;
        foreach ($select_base_value as $item){
            $bandera++;
            $asiento = [];
            //creamos los detalles y lo colocamos en un array
            #1.-creamos el del debe
            $asiento['EMPRESA'] = 'E01';
            $asiento['FECHA'] = "$fecha";
            $asiento['TIPO_COMPROBANTE'] = 'AS. DESTINO';
            $asiento['CORRELATIVO'] = "$correlativo";
            $asiento['SECUENCIA'] = "$bandera";
            $asiento['ESTADO'] = 'A';
            $asiento['TIPO_DOCUMENTO'] = '';
            $asiento['REFERENCIA'] = '';
            #---- esto es para el siento debe
            $asiento['CUENTA'] = $item->CUENTA_DEBE;
            $asiento['DEBE_INGRESO'] = round($item->MONTO,2);
            $asiento['HABER_INGRESO'] = 0;
            $asiento['DEBE_ORIGEN'] = round($item->MONTO,2);
            $asiento['HABER_ORIGEN'] = 0;
            $asiento['DEBE_CUOTA'] = round($item->MONTO/$t_cambio,2);
            $asiento['HABER_CUOTA'] = 0;
            #-------------------------------
            $asiento['GLOSA'] = $item->GLOSA." ($fecha)";
            $asiento['FECHAVCTO'] = '1900-01-01 00:00:00';
            $asiento['PARIDAD'] = 0;
            $asiento['PERIODO'] =$periodo;
            $asiento['PROCESO'] = "GENERA";
            $asiento['AUX_VALOR1'] = '';
            $asiento['AUX_VALOR2'] = '';
            $asiento['AUX_VALOR3'] = '';
            $asiento['AUX_VALOR4'] = '';
            $asiento['AUX_VALOR5'] = '';
            $asiento['AUX_VALOR6'] = '';
            $asiento['AUX_VALOR7'] = '';
            $asiento['AUX_VALOR8'] = '';
            $asiento['AUX_VALOR9'] = '';
            $asiento['AUX_VALOR10'] = '';
            $asiento['AUX_VALOR11'] = '';
            $asiento['AUX_VALOR12'] = '';
            $asiento['AUX_VALOR13'] = '';
            $asiento['AUX_VALOR14'] = '';
            $asiento['AUX_VALOR15'] = '';
            $asiento['AUX_VALOR16'] = '';
            $asiento['AUX_VALOR17'] = '';
            $asiento['AUX_VALOR18'] = '';
            $asiento['AUX_VALOR19'] = $item->CCI;
            $asiento['AUX_VALOR20'] = '';
            $asiento['VALOR1'] = '';
            $asiento['VALOR2'] = '';
            $asiento['VALOR3'] = '';
            $asiento['VALOR4'] = '';
            $asiento['VALOR5'] = '';
            $asiento['VALOR6'] = '';
            $asiento['VALOR7'] = '';
            $asiento['VALOR8'] = '';
            $asiento['VALOR9'] = '';
            $asiento['VALOR10'] = '';
            $asiento['VALOR11'] = '';
            $asiento['VALOR12'] = '';
            $asiento['VALOR13'] = '';
            $asiento['VALOR14'] = '';
            $asiento['VALOR15'] = '';
            $asiento['VALOR16'] = '';
            $asiento['VALOR17'] = '';
            $asiento['VALOR18'] = '';
            $asiento['VALOR19'] = '';
            $asiento['VALOR20'] = '';
            $asiento['FECHAORIG'] = $fecha;


            $asiento_debe = "('".implode("','",$asiento)."')";

            #ahora agrgamos el haber
            $asiento['CUENTA'] = $item->CUENTA_HABER;
            $asiento['DEBE_INGRESO'] = 0;
            $asiento['HABER_INGRESO'] = round($item->MONTO,2);
            $asiento['DEBE_ORIGEN'] = 0;
            $asiento['HABER_ORIGEN'] = round($item->MONTO,2);
            $asiento['DEBE_CUOTA'] = 0;
            $asiento['HABER_CUOTA'] = round($item->MONTO/$t_cambio,2);
            #-------------------------------
            $asiento_haber = "('".implode("','",$asiento)."')";

            array_push($a_registros_asiento,$asiento_debe);
            array_push($a_registros_asiento,$asiento_haber);

            $key = array_keys($asiento);

        }


        //creamos la tabla temporal
        #------$this->processTemporalTable($key,'##TempDetalles');
        $keys = implode(',',$key);

        #aremos un algoritmo para insertar de 500 en 500
        $cant_registros = count($a_registros_asiento);
        $cat_lote = 200;
        $cant_bucle = $cant_registros / $cat_lote;
        $temp_reg_asientos = $a_registros_asiento;

        for ($i=0;$i<$cant_bucle;$i++){

           $bandera = count($temp_reg_asientos);

           if($bandera<$cat_lote){
                //insertar de 0 y contamos la bandera
              // echo '--final'.count($temp_reg_asientos);
               $values =implode($temp_reg_asientos,',');

               $query = "insert into $table ($keys) values $values";

           }else{
               //insertarmos los registros
               #slice te trae el numero de elementos que quieres
               #estos son los que se insertan
               $a_registros_insertar = array_slice($temp_reg_asientos,0,$cat_lote);

               $values =implode($a_registros_insertar,',');

               $query = "insert into $table ($keys) values $values";

               //luego reducimos la cantidad de elementos
               $temp_reg_asientos = array_slice($temp_reg_asientos,$cat_lote);

              //echo 'Registro: '.$i.'-'.count($a_registros_insertar).'<br>';

           }


           \DB::insert($query);



        }


        /*

        $values =implode($a_registros_asiento,',');

        $query = "insert into ##TempDetalles values $values";

        */

        return '0';


    }

    public function getCabeceraDistribucion($correlativo){

    }

    public function getDetallesDistribucion($correlativo){

    }


    public function deleteDetallesDistribucion($estado,$fecha, $correlativo){

        $query  = "delete from flexline.CON_MOVCOM
                    WHERE CONVERT (DATE ,FECHA,113) = '$fecha'
                    AND CORRELATIVO = '$correlativo'
                    AND EMPRESA = 'E01'";
        \DB::delete($query);
    }

    public function deleteCabeceraDistribucion($estado,$fecha, $correlativo){
        $query  = "delete from flexline.CON_ENCCOM
                    WHERE CONVERT (DATE ,FECHA,113) = '$fecha'
                    AND CORRELATIVO = '$correlativo'
                    AND EMPRESA = 'E01'";
        \DB::delete($query);
    }


    //pasar a una clase helper

    /**
     * @param $keys= es e array de keys que se van a crear la tabla
     * @param $tabla = nombre de la tabla a crear
     * @return int = bandea que vali
     */

    public function processTemporalTable($keys,$tabla){



        $keys  = implode(' varchar(200),',$keys);
        $keys .= ' varchar(200)';

        $bandera = 0;

        $query = "if object_id('tempdb..$tabla') > 0 
            begin
                drop  table $tabla
            end
        else
        CREATE TABLE $tabla ($keys)
                    ";

        \DB::statement($query);

        HelpFunct::writeQuery($query);


        return $bandera;

    }

    /*Pasar a genérico*/

    public function getTipoCambio($fecha){

        $t_cambio = 1;

        $query = "select VALOR from 
                flexline.GEN_TASCAM
                where CONVERT(date, FECHA,113) = '$fecha'";

        $res = \DB::select($query);

        if(count($res)>0){
            $t_cambio = $res[0]->VALOR;
        }

        RETURN $t_cambio;


    }

}