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
use sirag\Entities\Obj;
use sirag\Helpers\HelpFunct;


class PersonalRep
{

    public function getAllTrabajadores(){

        $query = "SELECT EMPLEADO dni,(APELLIDO_PATERNO+' '+APELLIDO_MATERNO+' '+NOMBRE) nombre
                    FROM flexline.PER_TRABAJADOR
                    where EMPRESA = 'e01'
                    AND VIGENCIA = 'ACTIVO'
                    ORDER BY nombre";

        $res = \DB::select($query);

        foreach ($res as $i){
            $i->nombre = utf8_encode( $i->nombre);
        }

        return $res;

    }





    //esto funcion con procedimiento almacenado
    //para data formateada
    public function getAllTrabajadoresByParameter($data)
    {

        $categoria = $data['categoria'];
        $vigencia = $data['vigencia'];
        $f_i = $data['f_i'];
        $f_f = $data['f_f'];

        $res = \DB::select("EXEC sp_getTrabajadoresByParametes @categoria = '%$categoria%' , @vigencia = '$vigencia' , @f_i = '$f_i', @f_f = '$f_f'");

        return $res;
    }
    //esto funcion con procedimiento almacenado
    //para data formateada
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
                $interval = round($interval->format('%a')*0.082,1);//el valor 0.082 es que por año se le da 30 dias

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

        $periodo    =   $data['periodo'];
        $nombre     =   $data['nombre'];
        $t_pago     =   $data['t_pago'];
        $tipo       =   $data['tipo'];
        $sq1="";

        $error="";

        if($t_pago == 'q'){
            $sq = "QUINCENA AS MONTO";
            $gq = "QUINCENA";
        }elseif ($t_pago == 'f'){
            $sq = "FIN_MES AS MONTO";
            $gq = "FIN_MES";
        }
        else  if($t_pago == 's'){
            $sq = "SEMANAL AS MONTO";
            $gq = "SEMANAL";
        }
        else{
            $sq = "LIQUIDACION AS MONTO";
            $gq = "LIQUIDACION";
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


        //vemos que tipo de empleado es apra llamar a la vistta corresppndoente
        if ($tipo == 'empleado'){
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
        }else{
            $query = "SELECT Nombre,CUENTAS_ABONO,TIPO_DOCUMENTO,CATEGORIA,
                    DNI,PERIODO,TIPO_REGISTRO,TIPO_CUENTA_ABONO,
                    VALIDACION_IDC,TIPO_MONEDA,$sq,CARGO,DEPARTAMENTO
                    FROM v_telecreditoOperario
                    WHERE PERIODO = '$periodo'
                    AND Nombre like '%$nombre%'
                    AND $gq >0  $sq1
                    --AND LEN(CUENTAS_ABONO) > 0 
                    GROUP BY Nombre,CUENTAS_ABONO,TIPO_DOCUMENTO,CATEGORIA,
                    DNI,PERIODO,TIPO_REGISTRO,TIPO_CUENTA_ABONO,
                    VALIDACION_IDC,TIPO_MONEDA,$gq,CARGO,DEPARTAMENTO     order by Nombre";
        }






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


    public function getPlanilla($periodo)
{
    $response       = new Obj();
    $totales        = new Obj();
    $data           = [];
    $t_quincena     = 0;
    $t_f_mes        = 0;
    $t_liquidacion  = 0;




    $query = "select FICHA, VALOR , MOVIMIENTO
                    FROM flexline.PER_DET_LIQ
                    WHERE EMPRESA='e01'
                    and periodo='$periodo' --- FILTRAR POR PERIODO
                    AND MOVIMIENTO in ('10505','100001','10535') --- LOS MOVIMIENTOSA DEBEN SALIR COMO COLUMNA
                    ORDER by FICHA";

    $res = \DB::select($query);

    $res = collect($res);

    //primero agrupamos por las ficha

    $result = $res->groupBy('FICHA')->toArray();

    foreach ($result as $item)
    {

        //sacamos primero el trabajador

        //var_dump($item[0]);

        $first = $item[0];


        $q = "SELECT TOP 1 *
                    from dbo.v_allTrabajadores
                    where FICHA = '$first->FICHA'";

        $q = \DB::select($q);

        $q = $q[0];

        $obj = new Obj();
        $obj->FICHA     = $q->FICHA;
        $obj->NOMBRE    = utf8_encode($q->NOMBRE);
        $obj->BANCO     = $q->BANCO;
        $obj->DNI       = $q->EMPLEADO;

        //modelamos el resultado

        $item = collect($item);


        $QUINCENA = $item->where('MOVIMIENTO','10505')->first();
        $F_MES = $item->where('MOVIMIENTO','100001')->first();
        $LIQUIDACION = $item->where('MOVIMIENTO','10535')->first();

        if ($QUINCENA == null){
            $QUINCENA=0;

        }else{
            $QUINCENA = $QUINCENA->VALOR;
        }

        if ($F_MES == null){
            $F_MES = 0;
        }else{
            $F_MES = $F_MES->VALOR;
        }
        if ($LIQUIDACION == null){
            $LIQUIDACION =0;

        }else{
            $LIQUIDACION = $LIQUIDACION->VALOR;

        }

        $t_liquidacion += $LIQUIDACION;
        $t_f_mes += $F_MES;
        $t_quincena += $QUINCENA;


        $obj->QUINCENA = number_format($QUINCENA,2,'.',',');
        $obj->F_MES = number_format($F_MES,2,'.',',');
        $obj->LIQUIDACION = number_format($LIQUIDACION,2,'.',',');
        $obj->TOTAL = number_format($item->sum('VALOR'),2,'.',',');

        array_push($data,$obj);

    }

    $response->t_liquidacion = number_format($t_liquidacion,2,'.',',');
    $response->t_f_mes = number_format($t_f_mes,2,'.',',');
    $response->t_quincena = number_format($t_quincena,2,'.',',');
    $response->total = number_format(($t_liquidacion+$t_f_mes+$t_quincena),2,'.',',');
    $response->data = $data;


    return $response;



}

    //esto es la planilla para los chamberos
    //arreglar para que se una sola funcion
    //
    public function getPlanillaAgrario($periodo)
    {
        $response       = new Obj();
        $totales        = [];
        $data           = [];
        $t_quincena     = 0;
        $t_f_mes        = 0;
        $t_liquidacion  = 0;
        $t_semanal      = 0;

        //estos conceptos se agregaron ra si total
        $t_remuneracion_basica  =   0;
        $t_importe_hs_extras_25 =   0;
        $t_haber_movilidad      =   0;
        $t_asignacion_familiar  =   0;
        $t_reintegros           =   0;
        $t_vacaciones_gozadas   =   0;
        $t_importe_hs_100       =   0;
        $t_vacaciones_truncas   =   0;
        $t_cts_ley              =   0;
        $t_gratificacion        =   0;
        $t_gratificacio_extraor =   0; //agregado por frank zelada 04/01/2017
        $t_movilidad_condicion  =   0;
        $t_bonificacion_extraor =   0;
        $t_total_haber          =   0;
        $t_snp                  =   0;
        $t_fondo_afp            =   0;
        $t_comision_afp         =   0;
        $t_seguro_afp           =   0;
        $t_liquidacion          =   0;
        $t_desc_movilidad_con   =   0;
        $t_reembolso_movilidad  =   0;
        $t_adelanto_remuneraci  =   0; //agregado por frank zelada 04/01/2017
        $t_desc_venta           =   0;
        $t_descuentos           =   0;
        $t_essalud              =   0;


        /*
         * Se quito eso del siguiente query
         * and MOVIMIENTO='99005'
         * */
        $query = "select FICHA, VALOR , MOVIMIENTO
                    FROM flexline.PER_DET_LIQ
                    WHERE EMPRESA='e01'
                    and periodo='20161221' --- FILTRAR POR PERIODO
                    and MOVIMIENTO IN ('10','10001','10011','10002','10004','10007','10050','10010','10016','10020','10025','10032','10033','10036','10041','10501','10502','10503','10527','10504','10534','10535','10542','10545','10547','10804','11','99005') --- LOS MOVIMIENTOSA DEBEN SALIR COMO COLUMNA
                    ORDER by FICHA";

        $res = \DB::select($query);

        $res = collect($res);

        //primero agrupamos por las ficha

        $result = $res->groupBy('FICHA')->toArray();

        foreach ($result as $item)
        {

            //sacamos primero el trabajador

            //var_dump($item[0]);

            $first = $item[0];


            $q = "SELECT TOP 1 *
                    from dbo.v_allTrabajadores
                    where FICHA = '$first->FICHA'";

            $q = \DB::select($q);

            $q = $q[0];

            $obj = new Obj();
            $obj->FICHA = $q->FICHA;
            $obj->NOMBRE = utf8_encode($q->NOMBRE);
            $obj->BANCO     = $q->BANCO;
            $obj->DNI       = $q->EMPLEADO;

            //modelamos el resultado

            $item = collect($item);

            $semanal = $item->where('MOVIMIENTO','99005')->first();

            if ($semanal == null){
                $semanal=0;

            }else{
                $semanal = $semanal->VALOR;
            }


            /*Se agrega conceptos necesarios para lo necesario*/

            //10001
            $remuneracion_basica = $item->where('MOVIMIENTO','10001')->first();

            if ($remuneracion_basica == null){
                $remuneracion_basica=0;

            }else{
                $remuneracion_basica = $remuneracion_basica->VALOR;
            }

            //10002
            $importe_hs_extras_25 = $item->where('MOVIMIENTO','10002')->first();

            if ($importe_hs_extras_25 == null){
                $importe_hs_extras_25=0;

            }else{
                $importe_hs_extras_25 = $importe_hs_extras_25->VALOR;
            }

            //10004
            $haber_movilidad = $item->where('MOVIMIENTO','10004')->first();

            if ($haber_movilidad == null){
                $haber_movilidad=0;

            }else{
                $haber_movilidad = $haber_movilidad->VALOR;
            }


            //10007
            $asignacion_familiar = $item->where('MOVIMIENTO','10007')->first();

            if ($asignacion_familiar == null){
                $asignacion_familiar=0;

            }else{
                $asignacion_familiar = $asignacion_familiar->VALOR;
            }


            //10010
            $reintegros = $item->where('MOVIMIENTO','10010')->first();

            if ($reintegros == null){
                $reintegros=0;

            }else{
                $reintegros = $reintegros->VALOR;
            }


            //10016
            $vacaciones_gozadas = $item->where('MOVIMIENTO','10016')->first();

            if ($vacaciones_gozadas == null){
                $vacaciones_gozadas=0;

            }else{
                $vacaciones_gozadas = $vacaciones_gozadas->VALOR;
            }


            //10020
            $importe_hs_100 = $item->where('MOVIMIENTO','10020')->first();

            if ($importe_hs_100 == null){
                $importe_hs_100=0;

            }else{
                $importe_hs_100 = $importe_hs_100->VALOR;
            }


            //10025
            $vacaciones_truncas = $item->where('MOVIMIENTO','10025')->first();

            if ($vacaciones_truncas == null){
                $vacaciones_truncas=0;

            }else{
                $vacaciones_truncas = $vacaciones_truncas->VALOR;
            }



            //10032
            $cts_ley = $item->where('MOVIMIENTO','10032')->first();

            if ($cts_ley == null){
                $cts_ley=0;

            }else{
                $cts_ley = $cts_ley->VALOR;
            }


            //10033
            $gratificacion = $item->where('MOVIMIENTO','10033')->first();

            if ($gratificacion == null){
                $gratificacion=0;

            }else{
                $gratificacion = $gratificacion->VALOR;
            }


            //10011
            $gratificacio_extraor = $item->where('MOVIMIENTO','10011')->first(); //frank zelada 04/01/2017

            if ($gratificacio_extraor == null){
                $gratificacio_extraor=0;

            }else{
                $gratificacio_extraor = $gratificacio_extraor->VALOR;
            }


            //10036
            $movilidad_condicion = $item->where('MOVIMIENTO','10036')->first();

            if ($movilidad_condicion == null){
                $movilidad_condicion=0;

            }else{
                $movilidad_condicion = $movilidad_condicion->VALOR;
            }


            //10041
            $bonificacion_extraor = $item->where('MOVIMIENTO','10041')->first();

            if ($bonificacion_extraor == null){
                $bonificacion_extraor=0;

            }else{
                $bonificacion_extraor = $bonificacion_extraor->VALOR;
            }


            //10
            $total_haber = $item->where('MOVIMIENTO','10')->first();

            if ($total_haber == null){
                $total_haber=0;

            }else{
                $total_haber = $total_haber->VALOR;
            }


            //10501
            $snp = $item->where('MOVIMIENTO','10501')->first();

            if ($snp == null){
                $snp=0;

            }else{
                $snp = $snp->VALOR;
            }


            //10502
            $fondo_afp = $item->where('MOVIMIENTO','10502')->first();

            if ($fondo_afp == null){
                $fondo_afp=0;

            }else{
                $fondo_afp = $fondo_afp->VALOR;
            }


            //10503
            $comision_afp = $item->where('MOVIMIENTO','10503')->first();

            if ($comision_afp == null){
                $comision_afp=0;

            }else{
                $comision_afp = $comision_afp->VALOR;
            }


            //10504
            $seguro_afp = $item->where('MOVIMIENTO','10504')->first();

            if ($seguro_afp == null){
                $seguro_afp=0;

            }else{
                $seguro_afp = $seguro_afp->VALOR;
            }


            //10535
            $liquidacion = $item->where('MOVIMIENTO','10535')->first();

            if ($liquidacion == null){
                $liquidacion=0;

            }else{
                $liquidacion = $liquidacion->VALOR;
            }

            //10542
            $desc_movilidad_con = $item->where('MOVIMIENTO','10542')->first();

            if ($desc_movilidad_con == null){
                $desc_movilidad_con=0;

            }else{
                $desc_movilidad_con = $desc_movilidad_con->VALOR;
            }

            //10545
            $reembolso_movilidad = $item->where('MOVIMIENTO','10545')->first();

            if ($reembolso_movilidad == null){
                $reembolso_movilidad=0;

            }else{
                $reembolso_movilidad = $reembolso_movilidad->VALOR;
            }

            //10534
            $adelanto_remuneraci = $item->where('MOVIMIENTO','10534')->first(); // FZ 040117

            if ($adelanto_remuneraci == null){
                $adelanto_remuneraci=0;

            }else{
                $adelanto_remuneraci = $adelanto_remuneraci->VALOR;
            }


            //10547
            $desc_venta = $item->where('MOVIMIENTO','10547')->first();

            if ($desc_venta == null){
                $desc_venta=0;

            }else{
                $desc_venta = $desc_venta->VALOR;
            }


            //10804
            $essalud = $item->where('MOVIMIENTO','10804')->first();

            if ($essalud == null){
                $essalud=0;

            }else{
                $essalud = $essalud->VALOR;
            }

            //11
            $descuentos = $item->where('MOVIMIENTO','11')->first();

            if ($descuentos == null){
                $descuentos=0;

            }else{
                $descuentos = $descuentos->VALOR;
            }

            /**/


            /*
            $QUINCENA = $item->where('MOVIMIENTO','10505')->first();
            $F_MES = $item->where('MOVIMIENTO','100001')->first();
            $LIQUIDACION = $item->where('MOVIMIENTO','10535')->first();

            if ($QUINCENA == null){
                $QUINCENA=0;

            }else{
                $QUINCENA = $QUINCENA->VALOR;
            }

            if ($F_MES == null){
                $F_MES = 0;
            }else{
                $F_MES = $F_MES->VALOR;
            }
            if ($LIQUIDACION == null){
                $LIQUIDACION =0;

            }else{
                $LIQUIDACION = $LIQUIDACION->VALOR;

            }

            $t_liquidacion += $LIQUIDACION;
            $t_f_mes += $F_MES;
            $t_quincena += $QUINCENA;


            $obj->QUINCENA = number_format($QUINCENA,2,'.',',');
            $obj->F_MES = number_format($F_MES,2,'.',',');
            $obj->LIQUIDACION = number_format($LIQUIDACION,2,'.',',');
            $obj->TOTAL = number_format($item->sum('VALOR'),2,'.',',');

            */

            $t_semanal += $semanal;
            $t_remuneracion_basica += $remuneracion_basica;
            $t_importe_hs_extras_25 += $importe_hs_extras_25;
            $t_haber_movilidad += $haber_movilidad;
            $t_asignacion_familiar += $asignacion_familiar;
            $t_reintegros += $reintegros;
            $t_vacaciones_gozadas += $vacaciones_gozadas;
            $t_importe_hs_100 += $importe_hs_100;
            $t_vacaciones_truncas += $vacaciones_truncas;
            $t_cts_ley += $cts_ley;
            $t_gratificacion += $gratificacion;
            $t_gratificacio_extraor += $gratificacio_extraor; //frank zelada 04/01/2017
            $t_movilidad_condicion += $movilidad_condicion;
            $t_bonificacion_extraor += $bonificacion_extraor;
            $t_total_haber += $total_haber;
            $t_snp += $snp;
            $t_fondo_afp += $fondo_afp;
            $t_seguro_afp += $seguro_afp;
            $t_liquidacion += $liquidacion;
            $t_desc_movilidad_con += $desc_movilidad_con;
            $t_reembolso_movilidad += $reembolso_movilidad;
            $t_adelanto_remuneraci += $adelanto_remuneraci; //FZ 041217
            $t_desc_venta += $desc_venta;
            $t_essalud += $essalud;
            $t_descuentos += $descuentos;
            $t_comision_afp += $comision_afp;

            $obj->semanal               = number_format($semanal,2,'.',',');
            $obj->remuneracion_basica   = number_format($remuneracion_basica,2,'.',',');
            $obj->importe_hs_extras_25  = number_format($importe_hs_extras_25,2,'.',',');
            $obj->haber_movilidad       = number_format($haber_movilidad,2,'.',',');
            $obj->asignacion_familiar   = number_format($asignacion_familiar,2,'.',',');
            $obj->reintegros            = number_format($reintegros,2,'.',',');
            $obj->vacaciones_gozadas    = number_format($vacaciones_gozadas,2,'.',',');
            $obj->importe_hs_100        = number_format($importe_hs_100,2,'.',',');
            $obj->vacaciones_truncas    = number_format($vacaciones_truncas,2,'.',',');
            $obj->cts_ley               = number_format($cts_ley,2,'.',',');
            $obj->gratificacion         = number_format($gratificacion,2,'.',',');
            $obj->gratificacio_extraor  = number_format($gratificacio_extraor,2,'.',','); //frank zelada 04/01/2017
            $obj->movilidad_condicion   = number_format($movilidad_condicion,2,'.',',');
            $obj->bonificacion_extraor  = number_format($bonificacion_extraor,2,'.',',');
            $obj->total_haber           = number_format($total_haber,2,'.',',');
            $obj->snp                   = number_format($snp,2,'.',',');
            $obj->fondo_afp             = number_format($fondo_afp,2,'.',',');
            $obj->comision_afp          = number_format($comision_afp,2,'.',',');
            $obj->seguro_afp            = number_format($seguro_afp,2,'.',',');
            $obj->liquidacion           = number_format($liquidacion,2,'.',',');
            $obj->desc_movilidad_con    = number_format($desc_movilidad_con,2,'.',',');
            $obj->reembolso_movilidad   = number_format($reembolso_movilidad,2,'.',',');
            $obj->adelanto_remuneraci   = number_format($adelanto_remuneraci,2,'.',','); // FZ 040117
            $obj->desc_venta            = number_format($desc_venta,2,'.',',');
            $obj->essalud               = number_format($essalud,2,'.',',');
            $obj->descuentos            = number_format($descuentos,2,'.',',');



            array_push($data,$obj);
        }


        //para ordenar la colecion
        $data = collect($data);
        $data = $data->sortBy('NOMBRE');
        $data = $data->values()->all();



        $response->t_semanal = number_format($t_semanal,2,'.',',');

        /*Se Agregan los totales
         *
         *
         *
         * */


        $totales['t_remuneracion_basica']   = number_format($t_remuneracion_basica,2,'.',',');

        $totales['t_importe_hs_extras_25']  = number_format($t_importe_hs_extras_25,2,'.',',');
        $totales['t_haber_movilidad']       = number_format($t_haber_movilidad,2,'.',',');
        $totales['t_asignacion_familiar']   = number_format($t_asignacion_familiar,2,'.',',');
        $totales['t_reintegros']            = number_format($t_reintegros,2,'.',',');
        $totales['t_vacaciones_gozadas']    = number_format($t_vacaciones_gozadas,2,'.',',');
        $totales['t_importe_hs_100']        = number_format($t_importe_hs_100,2,'.',',');
        $totales['t_vacaciones_truncas']    = number_format($t_vacaciones_truncas,2,'.',',');
        $totales['t_cts_ley']               = number_format($t_cts_ley,2,'.',',');
        $totales['t_gratificacion']         = number_format($t_gratificacion,2,'.',',');
        $totales['t_gratificacio_extraor']  = number_format($t_gratificacio_extraor,2,'.',','); // FZ 040117
        $totales['t_movilidad_condicion']   = number_format($t_movilidad_condicion,2,'.',',');
        $totales['t_bonificacion_extraor']  = number_format($t_bonificacion_extraor,2,'.',',');
        $totales['t_total_haber']           = number_format($t_total_haber,2,'.',',');
        $totales['t_snp']                   = number_format($t_snp,2,'.',',');
        $totales['t_fondo_afp']             = number_format($t_fondo_afp,2,'.',',');
        $totales['t_seguro_afp']            = number_format($t_seguro_afp,2,'.',',');
        $totales['t_liquidacion']           = number_format($t_liquidacion,2,'.',',');
        $totales['t_desc_movilidad_con']    = number_format($t_desc_movilidad_con,2,'.',',');
        $totales['t_reembolso_movilidad']   = number_format($t_reembolso_movilidad,2,'.',',');
        $totales['t_adelanto_remuneraci']   = number_format($t_adelanto_remuneraci,2,'.',','); // FZ 040117
        $totales['t_desc_venta']            = number_format($t_desc_venta,2,'.',',');
        $totales['t_essalud']               = number_format($t_essalud,2,'.',',');
        $totales['t_descuentos']            = number_format($t_descuentos,2,'.',',');
        $totales['t_comision_afp']          = number_format($t_comision_afp ,2,'.',',');


        /*
        $response->t_f_mes = number_format($t_f_mes,2,'.',',');
        $response->t_quincena = number_format($t_quincena,2,'.',',');
        $response->total = number_format(($t_liquidacion+$t_f_mes+$t_quincena),2,'.',',');
        */
        $response->data = $data;
        $response->totales = $totales;


        return $response;



    }


    //para traer el consumo de mano de obra
    //por fundo y parro de acuerdo a una fecha esablecido

    public function getCostoMOPorFundo($data){

        //$fecha      =   $data['fecha'];

        $query      =   "
        --esta fecha se usará para saber que dia se consultará el detalle 
        DECLARE @fecha date;
        
        --luego se sacara la fecha de inicio para sacar el rango de consulta
        DECLARE @fecha_inicio DATE;
        -- seteamos la fecha de inicio restandole 6 dias a la fecha dada
        SET @fecha = '2016-12-14';
        SET @fecha_inicio= DATEADD(day,-6,@fecha); 
        select GC.CODIGO, GT.descripcion, GC.RELACIONTIPO1,GC.RELACIONCODIGO1,DT.CANTIDAD,DT.FECHA
        ,(SELECT SUM(DEBE_INGRESO) FROM flexline.CON_MOVCOM
            WHERE EMPRESA='E01'
            AND TIPO_COMPROBANTE='PLANILLAS'
            AND PERIODO='2016'
            AND CONVERT(DATE,FECHA) = @fecha
            AND AUX_VALOR19 = GC.CODIGO
            AND AUX_VALOR19 IS NOT NULL) MONTO
        from
        dbo.GEN_TABLA as GT INNER JOIN 
        flexline.PER_DETALLETRATO DT 
        ON GT.codigo1=DT.AUX_VALOR16 AND GT.empresa = DT.EMPRESA INNER JOIN
        flexline.GEN_TABCOD GC ON DT.AUX_VALOR5 = GC.CODIGO
        where 
        DT.EMPRESA='e01'
        AND GC.TIPO = 'CON_CCOSTO_INTERNO'
        and GT.vigencia='S'
        and GT.cod_tabla='per_labor'
        and DT.TRATO='TRATO_HORA'
        AND GC.CODIGO <> '696969'
        AND CONVERT(DATE,DT.FECHA) BETWEEN @fecha_inicio and @fecha";

        $res = \DB::select($query);

        $res = collect($res);


        //sacamos los codigos para que sean nuestra scolumnas a cruzar
        //$keys = $res->groupBy('CODIGO')->sortByDesc('CODIGO')->keys();
        $keys =  $res->groupBy('CODIGO')->keys()->toArray();

        //sacamos los codigos de fundo y parron , para ordenarlos
        $a = HelpFunct::orderArrayNumberAsc($keys);
        //luego sacamos solo los que tinen 6 dígitos , por que son lo que tienen normal
        $a = HelpFunct::getItemsByLenOfArray(6,$a);
        //obtenemos los codigos ordenados por campaña , fundo y parron
        $a = HelpFunct::getItemsByFundoAndParron($a);
        //por cada




        $personal = $res->groupBy('descripcion');




        return $a;


    }

    /**
     * Plame :REM
     * en la siguiente funcion se trae a los datos formateados para generar
     * el txt del PLAME
     */

    public function getPlameRem($data){


        $response = array();

        $query = "SELECT FICHA, MOVIMIENTO, DESCRIPCION, SUM(VALOR) MONTO
                ,(SELECT top 1 CODIGO FROM flexline.GEN_TABCOD
                WHERE EMPRESA='E01'
                AND TIPO='PER_CONCEPTO_REM'
                AND TEXTO IS NOT NULL AND TEXTO <> ''
                AND (TEXTO2 LIKE '%'+flexline.PER_DET_LIQ.MOVIMIENTO+'%' 
                or TEXTO3 LIKE '%'+flexline.PER_DET_LIQ.MOVIMIENTO+'%')) CODIGO
                ,( SELECT EMPLEADO FROM 
					flexline.PER_TRABAJADOR
					WHERE FICHA = flexline.PER_DET_LIQ.FICHA) DNI
                FROM flexline.PER_DET_LIQ
                WHERE EMPRESA='E01'
                AND PERIODO LIKE '$data%' --aca insertar la fecha que viene de la data
                AND (TIPO_MOVTO IN ('H','D'))
                AND MOVIMIENTO <> '10501'
                GROUP BY FICHA, MOVIMIENTO,DESCRIPCION
                ORDER BY MOVIMIENTO";

        $res = \DB::select($query);

        $res = collect($res);
        //primero agrupamos los resultados por DNI
        $res = $res->groupBy('DNI');
        //luego de cada uno agrupamos los resultados por codigo
        foreach ($res as $item){

            $obj = new Obj();

            $i = collect($item);
            //agrupamos por codigo , el codigo el es codigo del PLEM
            $i = $i->groupBy('CODIGO');

            $movs = 0;
            //por cada item
            foreach ($i as $x){

                $row = new Obj();

                $val = collect($x);
                $sum_monto_codigo = $val->sum('MONTO');

                $row->FICHA = $x[0]->FICHA;
                $row->DNI = $x[0]->DNI;
                $row->CODIGO = $x[0]->CODIGO;
                $row->sum_monto_codigo = HelpFunct::fillZerosLeft(9,number_format($sum_monto_codigo,2,'.',''))  ;
                array_push($response, $row);

                //number_format($t_movilidad_condicion,2,'.',',');

            }

            /*
            $obj->FICHA = $item[0]->FICHA;
            $obj->DNI = $item[0]->DNI;
            $obj->CODIGO = $item[0]->CODIGO;
            $obj->MOVS  =   $i;
            array_push($response, $obj);

            */
            //var_dump($item);


        }



        return $response;

    }


}