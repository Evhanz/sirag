<?php
/**
 * Created by PhpStorm.
 * User: ehernandez
 * Date: 26/08/2016
 * Time: 05:40 PM
 */

namespace sirag\Repositories;
use Carbon\Carbon;
use DateTime;


class PersonalRep
{

    public function getAllTrabajadoresByParameter($data)
    {

        $categoria = $data['categoria'];
        $vigencia = $data['vigencia'];
        $f_i = $data['f_i'];
        $f_f = $data['f_f'];

        $res = \DB::select("EXEC sp_getTrabajadoresByParametes @categoria = '%$categoria%' , @vigencia = '$vigencia' , @f_i = '$f_i', @f_f = '$f_f'");

        return $res;
    }

    public function getTrabajadoresByParamOutDates ($data)
    {
        $categoria = $data['categoria'];
        $vigencia = $data['vigencia'];

        $res = \DB::select("EXEC sp_getTrabajadoresByParamOutDates @categoria = '%$categoria%' , @vigencia = '$vigencia' ;");



        foreach ($res as $item) {
            
            $item->NOMBRE = utf8_encode($item->NOMBRE);
            $item->DIRECCION = utf8_encode($item->DIRECCION);
            $item->PAIS = utf8_encode($item->PAIS);
            $item->DEPARTAMENTO = utf8_encode($item->DEPARTAMENTO);
            $item->PROVINCIA = utf8_encode($item->PROVINCIA);
            $item->CARGO = utf8_encode($item->CARGO);
            $item->CATEGORIA = utf8_encode($item->CATEGORIA);
            $item->DISTRITO = utf8_encode($item->DISTRITO);
            $item->CTA_CENTRA = utf8_encode($item->CTA_CENTRA);
            $item->CENTRO_COSTO = utf8_encode($item->CENTRO_COSTO);
            $item->MOTIVO_SALIDA = utf8_encode($item->MOTIVO_SALIDA);
            $item->FECHA_RENOVA_1 = utf8_encode($item->FECHA_RENOVA_1);
            $item->FECHA_RENOVA_2 = utf8_encode($item->FECHA_RENOVA_2);
            $item->FECHA_RENOVA_3 = utf8_encode($item->FECHA_RENOVA_3);
            $item->TIPO_TRABAJADOR = utf8_encode($item->TIPO_TRABAJADOR);

            $vac_acumuladas = $item->vac;

            
            if ($item->TIPO_TRABAJADOR == 'EMPLEADO') {

                $f_i  = explode("/", $item->FECHA_INICIO);
                $f_f  = explode("/", $item->FECHA_TERMINO);
               
                $datetime1 = new DateTime($f_i[2].'-'.$f_i[1].'-'.$f_i[0]);

                //sacar condicion si es que a la fecha de hoy se le adeuda 
                $datetime2 = new DateTime($f_f[2].'-'.$f_f[1].'-'.$f_f[0]);

                $now = new DateTime("now");
                $bandera = $datetime2->diff($now);
                if ($bandera->format('%R%a')>0) {
                    $datetime2 = $datetime2;
                }else{
                    $datetime2 = $now;
                }
                
                

                $interval = $datetime1->diff($datetime2);
                $interval = round($interval->format('%a')*0.082,1);

                $item->cant_vac = $interval;

                $item->CANTIDA_DIF = $interval-$vac_acumuladas;

                $item->now =$datetime2->diff($now);


            } else {
               
                $f_i  = explode("/", $item->FECHA_INICIO);
                $f_f  = explode("/", $item->FECHA_TERMINO);
               
                $datetime1 = new DateTime($f_i[2].'-'.$f_i[1].'-'.$f_i[0]);

                //sacar condicion si es que a la fecha de hoy se le adeuda 
                $datetime2 = new DateTime($f_f[2].'-'.$f_f[1].'-'.$f_f[0]);

                $now = new DateTime("now");
                $bandera = $datetime2->diff($now);
                if ($bandera->format('%R%a')>0) {
                    $datetime2 = $datetime2;
                }else{
                    $datetime2 = $now;
                }
                
                

                $interval = $datetime1->diff($datetime2);
                $interval = round($interval->format('%a')*0.041,1);

                $item->cant_vac = $interval;

                $item->CANTIDA_DIF = $interval-$vac_acumuladas;

                $item->now =$datetime2->diff($now);


            }
            


        }

        return $res;

    }


    public function getTrabajadorByFicha($ficha)
    {
        $query = "select * from v_allTrabajadores where FICHA = '$ficha'";

        $res = \DB::select($query);
        return $res[0];
    }

    public function getContratos($ficha){
        $res = \DB::select("SELECT FICHA,CONVERT(decimal(9,2),REMUNERACION) as remuneracion
                            , CONVERT(date, CAST(FECHA_INICIO AS CHAR(8)), 112) as fecha_inicio
                            , CONVERT(date, CAST(FECHA_TERMINO AS CHAR(8)), 112) as fecha_fin
                            FROM flexline.PER_REM_HIS where FICHA = '$ficha' order by fecha_inicio desc");

        return $res;
    }

    public function getRenovaionesByFicha($ficha){

        $query = " select * from renov_contract  where FICHA = '$ficha'";

        $res = \DB::select($query);

        return $res;

    }


    public function addNewRenovacion($data){


        $tipo = 'renovacion';
        $fecha_inicio = $data['f_i'];
        $fecha_fin = $data['f_f'];
        $f_fin_cambiada = $data['f_fin_cambiada'];
        $observacion = $data['observacion'];
        $ficha = $data['ficha'];
        $res ='ok';
        //primero insertamos los valores y luego actualizaremos los valores de las tablas
        //PER_TRABJADOR & PER_REM_HIS

        \DB::transaction(function () use ($tipo,$fecha_inicio,$fecha_fin,$f_fin_cambiada,$observacion,$ficha) {
            \DB::insert("INSERT INTO renov_contract (tipo,fecha_inicio,fecha_fin,observacion,f_fin_cambiada,FICHA,estado)
                              values ('$tipo','$fecha_inicio','$fecha_fin','$observacion','$f_fin_cambiada','$ficha',1)");
            //luego cambiamos el formato en la funcion

            $f_f = $this->changeFormat($fecha_fin);

            \DB::update("UPDATE flexline.PER_TRABAJADOR
                        SET FECHA_TERMINO='$f_f'
                        WHERE FICHA='$ficha';");

            \DB::update("UPDATE flexline.PER_REM_HIS
                        SET FECHA_TERMINO='$f_f'
                        WHERE FICHA='$ficha';");

        });

        return $res;

    }


    public function deleteRenovacion($id,$ficha,$fecha_fin){

        //$fecha_fin : es la fecha que fue almacenada en la renovacion de contrato para poder
        // resguardar de que fecha se
        //modifico


        \DB::transaction(function () use ($id,$ficha,$fecha_fin) {

            $f_f = $this->changeFormat($fecha_fin);

            \DB::delete("DELETE FROM renov_contract
                        WHERE id=$id;");

            \DB::update("UPDATE flexline.PER_TRABAJADOR
                        SET FECHA_TERMINO='$f_f'
                        WHERE FICHA='$ficha';");

            \DB::update("UPDATE flexline.PER_REM_HIS
                        SET FECHA_TERMINO='$f_f'
                        WHERE FICHA='$ficha';");

        });

        
    }


    public function getVacacionesByFicha ($ficha)
    {

        $query = "SELECT TIPO_TRANS,ESTADO,
                            ID_VACA,CONVERT(date, CAST(FEC_FINSOL AS CHAR(8)), 112) FEC_FINSOL,
                            CONVERT(date, CAST(FEC_INISOL AS CHAR(8)), 112) FEC_INISOL 
                            FROM flexline.PER_VACACIONES
                            where TIPO_TRANS = 'APROBACION' AND FICHA = '$ficha'";

        $res = \DB::select($query);

        return $res;
    }


    //funciones helpers
    public function changeFormat ($fecha){

        $fecha = explode("-", $fecha);

        $fecha = $fecha[2].$fecha[1].$fecha[0];
        return $fecha;
    }


    public function getContratosPorVencer()
    {

        $now = Carbon::now();
        $hoy = $now->format('d-m-Y');
        $nowAdd = $now->addDay(5)->format('d-m-Y');


        $query = "SELECT FICHA, EMPLEADO DNI, NOMBRE,
         CONVERT(VARCHAR,FECHA_INICIO,103) AS FECHA_INICIO, 
         CONVERT(VARCHAR,FECHA_TERMINO,103) AS FECHA_TERMINO 
         FROM v_allTrabajadores where FECHA_TERMINO <= '$nowAdd'  AND FECHA_TERMINO >= '$hoy' ";

        $contratos = \DB::select($query);

        return $contratos;


    }


    public function getTelecredito($data){

        if(!isset($data['nombre'])){
            $data['nombre'] = '';
        }

        $periodo = $data['periodo'];
        $nombre = $data['nombre'];
        $t_pago = $data['t_pago'];
        $sq1="";

        $error="";

        if($t_pago == 'q'){
            $sq = "QUINCENA AS MONTO";
            $gq = "QUINCENA";
        }else{
            $sq = "FIN_MES AS MONTO";
            $gq = "FIN_MES";
        }
        //aca para los subquerys 1 por que es para

       
        if (isset($data['data_include'])){

            $sq1 = "AND ( ";

            for ($i = 0;$i<count($data['data_include']);$i++){
                if($i==0){
                    $sq1 .= " DNI = '".$data['data_include'][$i]."'";
                }else{
                    $sq1 .= " OR DNI = '".$data['data_include'][$i]."'";
                }
            }
            $sq1 .= " ) ";
        }


          
            $query = "SELECT Nombre,CUENTAS_ABONO,TIPO_DOCUMENTO,CATEGORIA,
                    DNI,PERIODO,TIPO_REGISTRO,TIPO_CUENTA_ABONO,
                    VALIDACION_IDC,TIPO_MONEDA,$sq,CARGO,DEPARTAMENTO
                    FROM v_telecredito
                    WHERE PERIODO = '$periodo'
                    AND Nombre like '%$nombre%'
                    AND $gq >0  $sq1
                    --AND LEN(CUENTAS_ABONO) > 0 
                    GROUP BY Nombre,CUENTAS_ABONO,TIPO_DOCUMENTO,CATEGORIA,
                    DNI,PERIODO,TIPO_REGISTRO,TIPO_CUENTA_ABONO,
                    VALIDACION_IDC,TIPO_MONEDA,$gq,CARGO,DEPARTAMENTO     order by Nombre";



            $telecredito = \DB::select($query);

           
       
        $i = 0;

        foreach ($telecredito as $item){
            $item->correlativo = $i;
            $item->Nombre = utf8_encode($item->Nombre);
            $i++;
        }


        return $telecredito;

    }

    public function getCargos ()
    {

        $query = "select CARGO AS CODIGO from 
                    v_telecredito
                    GROUP BY CARGO
                    ";

        $res = \DB::select($query);

        return $res;
    }


    public function getDepartamentos ()
    {

        $query = "SELECT CODIGO,ALIAS FROM flexline.PER_DEPARTAMENTO 
                  WHERE EMPRESA='E01' ORDER BY ALIAS";

        $res = \DB::select($query);

        return $res;
    }




}