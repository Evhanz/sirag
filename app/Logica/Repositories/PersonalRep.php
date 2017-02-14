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
use sirag\Helpers\NumberToLetter;


class PersonalRep
{

    public function getAllTrabajadores(){

        $query = "SELECT EMPLEADO ,(APELLIDO_PATERNO+' '+APELLIDO_MATERNO+' '+NOMBRE) nombre , FICHA ficha
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

        $query = "EXEC sp_getTrabajadoresByParametes @categoria = '%$categoria%' , @vigencia = '$vigencia' , @f_i = '$f_i', @f_f = '$f_f'";

        $res = \DB::select($query);


        foreach ($res as $item){
            $vac_acumuladas = $item->vac;//estas son las vacaciones que ya gozo
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


            }
            else {

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
                // $item->CANTIDA_DIF = $interval;

                $item->now =$datetime2->diff($now);


            }
        }


       // HelpFunct::writeQuery($query);

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


            }
            else {
               
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
               // $item->CANTIDA_DIF = $interval;

                $item->now =$datetime2->diff($now);


            }
            


        }

        return $res;

    }


    public function getTrabajadorByFicha($ficha)
    {
        $query = "select * from v_allTrabajadores where FICHA = '$ficha'";

        $res = \DB::select($query);

        if(count($res)>0){
            return $res[0];
        }else{
            return 0;
        }


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
                            where TIPO_TRANS = 'APROBACION' AND ESTADO='A' AND FICHA = '$ficha'";

        $res = \DB::select($query);

        return $res;
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

        $obj = new Obj();
        $obj->query = $query;
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
        $t_exceso_pago          =   0; //FZ 270117
        $t_reembolso_movilidad  =   0;
        $t_adelanto_remuneraci  =   0; //agregado por frank zelada 04/01/2017
        $t_pacifico             =   0; //agregado por frank zelada 19/01/2017
        $t_desc_venta           =   0;
        $t_descuentos           =   0;
        $t_essalud              =   0;


        /*
         * Se quito eso del siguiente query
         * and MOVIMIENTO='99005'
         * */

        /*
        $query = "
                    select 
                    A.FICHA, A.VALOR , A.MOVIMIENTO
                    FROM 
                    flexline.PER_DET_LIQ A,
                    flexline.PER_TRABAJADOR B
                    WHERE 
                    A.EMPRESA=B.EMPRESA
                    AND A.FICHA=B.FICHA
                    AND A.EMPRESA='e01'
                    AND B.CATEGORIA='OPERARIO'
                    and A.periodo='$periodo' --- FILTRAR POR PERIODO '$periodo'
                    and A.MOVIMIENTO IN ('10','10001','10011','10002','10004','10007','10050','10010','10016','10020','10025','10032','10033','10036','10041','10501','10502','10538','10503','10514','10527','10504','10534','10535','10542','10545','10547','10804','11','99005') --- LOS MOVIMIENTOSA DEBEN SALIR COMO COLUMNA
                    ORDER by A.FICHA";
                    */
        $query = "--esta fecha se usará para saber que dia se consultará el detalle 
                    DECLARE @fecha date;

                  --luego se sacara la fecha de inicio para sacar el rango de consulta
                    DECLARE @fecha_inicio DATE;

                    SET @fecha = '$periodo'; --aca se cambia por la variable
                    SET @fecha_inicio= DATEADD(day,-6,@fecha); 

                    select 
                    A.FICHA, SUM(a.VALOR) AS VALOR , A.MOVIMIENTO
                    FROM 
                    flexline.PER_DET_LIQ A,
                    flexline.PER_TRABAJADOR B
                    WHERE 
                    A.EMPRESA=B.EMPRESA
                    AND A.FICHA=B.FICHA
                    AND A.EMPRESA='e01'
                    AND B.CATEGORIA='OPERARIO'
                    and CONVERT(DATE,CONVERT(VARCHAR(8),A.PERIODO),113) BETWEEN @fecha_inicio AND @fecha --- FILTRAR POR PERIODO '$periodo'
                    and A.MOVIMIENTO IN ('10','10001','10011','10002','10004','10007','10050','10010','10016','10020','10025','10032','10033','10036','10041','10501','10502','10538','10503','10514','10527','10504','10534','10535','10542','10545','10547','10804','11','99005') --- LOS MOVIMIENTOSA DEBEN SALIR COMO COLUMNA
                    GROUP BY A.FICHA, A.MOVIMIENTO
                    ORDER by A.FICHA
                    ";



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

             //10514
            $pacifico = $item->where('MOVIMIENTO','10514')->first();

            if ($pacifico == null){
                $pacifico=0;

            }else{
                $pacifico = $pacifico->VALOR;
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

            //10538
            $exceso_pago = $item->where('MOVIMIENTO','10538')->first(); //FZ 27012017

            if ($exceso_pago == null){
                $exceso_pago=0;

            }else{
                $exceso_pago = $exceso_pago->VALOR;
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
            $t_pacifico += $pacifico; //FZ
            $t_liquidacion += $liquidacion;
            $t_desc_movilidad_con += $desc_movilidad_con;
            $t_exceso_pago += $exceso_pago; //FZ 27012017
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
            $obj->pacifico              = number_format($pacifico,2,'.',','); //FZ
            $obj->liquidacion           = number_format($liquidacion,2,'.',',');
            $obj->desc_movilidad_con    = number_format($desc_movilidad_con,2,'.',',');
            $obj->exceso_pago           = number_format($exceso_pago,2,'.',','); //FZ 27012017
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
        $totales['t_pacifico']              = number_format($t_pacifico,2,'.',',');//FZ
        $totales['t_liquidacion']           = number_format($t_liquidacion,2,'.',',');
        $totales['t_desc_movilidad_con']    = number_format($t_desc_movilidad_con,2,'.',',');
        $totales['t_exceso_pago']           = number_format($t_exceso_pago,2,'.',','); //FZ 27012017
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

        $fecha      =   $data['fecha'];
        $fecha      =   explode('/',$fecha);
        $periodo    =   $fecha[2];
        $fecha      =   $fecha[2].'-'.$fecha[1].'-'.$fecha[0];

        //$fecha = '2016-12-14';

        $query      =   "
        --esta fecha se usará para saber que dia se consultará el detalle 
        DECLARE @fecha date;
        
        --luego se sacara la fecha de inicio para sacar el rango de consulta
        DECLARE @fecha_inicio DATE;
        -- seteamos la fecha de inicio restandole 6 dias a la fecha dada
        SET @fecha = '$fecha'; --aca se cambia por la variable
        SET @fecha_inicio= DATEADD(day,-6,@fecha); 
        select GC.CODIGO, GT.descripcion,SUM(DT.CANTIDAD) CANTIDAD,CONVERT(DATE,DT.FECHA,113) FECHA
        ,(SELECT SUM(DEBE_INGRESO) FROM flexline.CON_MOVCOM
            WHERE EMPRESA='E01'
            AND TIPO_COMPROBANTE='PLANILLAS'
            --AND PERIODO='$periodo'
            --AND CONVERT(DATE,FECHA) = @fecha
            AND ((PERIODO=YEAR(@fecha)) OR (PERIODO=YEAR(@fecha_inicio)))
            AND CONVERT(DATE,FECHA) BETWEEN @fecha_inicio AND @fecha
            AND AUX_VALOR19 = GC.CODIGO
            AND ESTADO='A'
            AND AUX_VALOR19 IS NOT NULL) MONTO,
            (SELECT SUM(CANTIDAD) FROM flexline.PER_DETALLETRATO
            WHERE EMPRESA='E01'
            AND CONVERT(DATE,FECHA) BETWEEN @fecha_inicio and @fecha
            AND AUX_VALOR5 = GC.CODIGO
            ) CANTIDAD_H
            
        from
        dbo.GEN_TABLA as GT INNER JOIN 
        flexline.PER_DETALLETRATO DT 
        ON GT.codigo1=DT.AUX_VALOR16 AND GT.empresa = DT.EMPRESA INNER JOIN
        flexline.GEN_TABCOD GC ON DT.AUX_VALOR5 = GC.CODIGO AND DT.EMPRESA = GC.EMPRESA
        where 
        DT.EMPRESA='e01'
        AND GC.TIPO = 'CON_CCOSTO_INTERNO'
        and GT.vigencia='S'
        and GT.cod_tabla='per_labor'
        and DT.TRATO='TRATO_HORA'
        AND GC.CODIGO <> '696969'
        AND LEN(GC.CODIGO) = 6
        AND CONVERT(DATE,DT.FECHA) BETWEEN @fecha_inicio and @fecha
        GROUP BY GC.CODIGO, GT.descripcion,CONVERT(DATE,DT.FECHA,113)";

        HelpFunct::writeQuery($query);

        $res = \DB::select($query);

        $res = collect($res);


        //sacamos los codigos para que sean nuestra scolumnas a cruzar
        //$keys = $res->groupBy('CODIGO')->sortByDesc('CODIGO')->keys();
        $keys =  $res->groupBy('CODIGO')->keys()->toArray();

        //sacamos los codigos de fundo y parron , para ordenarlos
        $a = HelpFunct::orderArrayNumberAsc($keys);
        //luego sacamos solo los que tinen 6 dígitos , por que son lo que tienen normal
        $codigo_ordenados = HelpFunct::getItemsByLenOfArray(6,$a);
        //obtenemos los codigos ordenados por campaña , fundo y parron
        $array_codigos = HelpFunct::getItemsByFundoAndParron($codigo_ordenados);
        /**
         * Obtenemos de los codigos los fundos que se encuentran las horas registradas
         */
        $array_codigos = $this->getFundosParronesFormatedWithAreas($array_codigos);

        foreach ($array_codigos as $item){
            $item->cant = count($item->codigos);
        }



        //por cada


        $actividades = $res->groupBy('descripcion');

        /*por cada personal vamos a llenar los detalles de su consumo*/

        $res_actividades = [];
        $totales = [];

        foreach ($actividades as $actividad){

            /**
             * para poder formatear el array de respuesta
             * sacamos de cada ctividad que codigos
             * tienen consumo , para poder obtener el total por
             * cada codigo
            */
            $i = collect($actividad);
            $codigos_values = $i->groupBy('CODIGO')->keys();
            $codigos  = HelpFunct::orderArrayNumberAsc($codigos_values);
            $codigos = $codigos->toArray(); /*esta variable son los codigos de cada actividad*/

            /**
             * ahora recorremos todos los codigos que se encuntran
             * si la actividad no registran
             * colocaar cero
            */

            $detalles = [];


            foreach ($codigo_ordenados as $item)
            {


                $obj = new Obj();
                /*$obj->descripcion = $actividad[0]->descripcion;*/
                $obj->item = $item;

                if(in_array($item,$codigos)){

                    $cantidad = $i->where('CODIGO',"$item")->sum('CANTIDAD');
                    $obj->cantidad = $cantidad;
                    $valor_item = $i->where('CODIGO',"$item")->first();
                    $obj->valor_x_hora = round(($valor_item->MONTO / $valor_item->CANTIDAD_H)* $cantidad,2);

                    /**
                     * Obtenemos el area si del parron encontrado, por su codigo
                     * */


                    $area = $this->getAreaByParron($item,$array_codigos);
                    $obj->area = $area;

                    /**
                     * Para obtener el costo por hcarea al costo / cant. hectareas
                     * tenemos el resultado
                     */

                    if($obj->area == null || $obj->area ==0){
                        $obj->cost_x_hectarea = round($obj->valor_x_hora/1,2).'N . H . A '. $obj->area;
                    }else{
                        $obj->cost_x_hectarea = round($obj->valor_x_hora/$obj->area,2);
                    }


                    /**
                     * si encontramos el dato,
                     * como se tiene el valor sumado
                     * para la fila final de resultados
                     * se guarda ese valor
                     */

                    $total = new Obj();
                    $total->CODIGO = $valor_item->CODIGO;
                    $total->MONTO = $valor_item->MONTO;
                    $total->CANTIDAD_H = $valor_item->CANTIDAD_H;

                    array_push($totales,$total);

                }else{
                    $obj->cantidad = 0;
                    $obj->valor_x_hora = 0;
                    $obj->area = 0;
                    $obj->cost_x_hectarea = 0;
                }

                array_push( $detalles,$obj);
            }



            /**
             * Ahora agregamos al array formateado la data necesariacon sus detalles
             *
             ***/
            $obj = new Obj();
            $obj->descripcion = $actividad[0]->descripcion;
            //$obj->item = $actividad[0];
            $obj->detalles = $detalles;
            array_push($res_actividades,$obj);

        }


        $uniques = array();
        foreach ($totales as $t) {
            $uniques[$t->CODIGO] = round($t->MONTO,2); // Get unique country by code.
        }


        $response = [];
        $response['res_actividades'] = $res_actividades;
        $response['totales'] = $uniques;
        $response['codigos'] = $array_codigos;

        return $response;

    }

    /**
     * es funcion saca los que son de 5 cci
    */

    public function getCostoMOPor5CCI($data,$t='general')
    {


        $fecha      =   $data['fecha'];
        $fecha      =   explode('/',$fecha);
        $periodo    =   $fecha[2];
        $fecha      =   $fecha[2].'-'.$fecha[1].'-'.$fecha[0];

        $tipo       =   $t;

        if($tipo == 'general')
        {
           // ESTE CONDICION AGARRA EL CODIGO CCI 17000
              $q1 = "AND (CONVERT(INT,(SUBSTRING(GC.CODIGO, 3, 1)+ SUBSTRING(GC.CODIGO, 5, 1)))=0 OR CONVERT(INT,( SUBSTRING(GC.CODIGO, 3, 1)+ SUBSTRING(GC.CODIGO, 5, 1)))>9)";

        }else{ // ESTA CONDICION ES PARA LA CONVERSION DE LOS NUMEROS Y NO COGER EL CODIGO 17000
            $q1 = "AND (CONVERT(INT,(SUBSTRING(GC.CODIGO, 3, 1)+ SUBSTRING(GC.CODIGO, 5, 1)))>0 AND CONVERT(INT,(SUBSTRING(GC.CODIGO, 3, 1)+ SUBSTRING(GC.CODIGO, 5, 1)))<10)";
        }


        $query = "
        --esta fecha se usará para saber que dia se consultará el detalle 
        DECLARE @fecha date;
        
        --luego se sacara la fecha de inicio para sacar el rango de consulta
        DECLARE @fecha_inicio DATE;
        -- seteamos la fecha de inicio restandole 6 dias a la fecha dada
        SET @fecha = '$fecha'; --aca se cambia por la variable
        SET @fecha_inicio= DATEADD(day,-6,@fecha); 
        select GC.CODIGO, GT.descripcion,SUM(DT.CANTIDAD) CANTIDAD
        ,(SELECT SUM(DEBE_INGRESO) FROM flexline.CON_MOVCOM
            WHERE EMPRESA='E01'
            AND TIPO_COMPROBANTE='PLANILLAS'
            --AND PERIODO='$periodo'
            --AND CONVERT(DATE,FECHA) = @fecha
            AND ((PERIODO=YEAR(@fecha)) OR (PERIODO=YEAR(@fecha_inicio)))
            AND CONVERT(DATE,FECHA) BETWEEN @fecha_inicio AND @fecha
            AND ESTADO='A'
            AND AUX_VALOR19 = GC.CODIGO
            AND AUX_VALOR19 IS NOT NULL) MONTO,
            (SELECT SUM(CANTIDAD) FROM flexline.PER_DETALLETRATO
            WHERE EMPRESA='E01'
            AND CONVERT(DATE,FECHA) BETWEEN @fecha_inicio and @fecha
            AND AUX_VALOR5 = GC.CODIGO
            ) CANTIDAD_H
            
        from
        dbo.GEN_TABLA as GT INNER JOIN 
        flexline.PER_DETALLETRATO DT 
        ON GT.codigo1=DT.AUX_VALOR16 AND GT.empresa = DT.EMPRESA INNER JOIN
        flexline.GEN_TABCOD GC ON DT.AUX_VALOR5 = GC.CODIGO AND DT.EMPRESA = GC.EMPRESA
        where 
        DT.EMPRESA='e01'
        AND GC.TIPO = 'CON_CCOSTO_INTERNO'
        and GT.vigencia='S'
        and GT.cod_tabla='per_labor'
        and DT.TRATO='TRATO_HORA'
        AND GC.CODIGO <> '696969'
        AND LEN(GC.CODIGO) = 5
        $q1
        AND CONVERT(DATE,DT.FECHA) BETWEEN @fecha_inicio and @fecha
        GROUP BY GC.CODIGO, GT.descripcion
        ORDER BY GC.CODIGO";


        $res = \DB::select($query);

        $res = collect($res);
        //se saca los codigos que se ncuentran

        $codigos = $res->groupBy('CODIGO')->keys();

        //separamos en actividades
        $actividades = $res->groupBy('descripcion');

        $a_actividades = array();

        foreach ($actividades as $actividad){

            $act = new Obj();
            $act->descripcion = $actividad[0]->descripcion;
            $detalles = array();


            foreach ($codigos as $codigo){
                $detalle = new Obj();
                //$detalle->monto = '';
                $detalle->codigo = $codigo;
                $detalle->horas = 0;
                $detalle->costo_x_hora = 0;
                $detalle->area = 0;

                foreach ($actividad as $item){

                    if($codigo == $item->CODIGO){
                        $detalle->horas = intval($item->CANTIDAD);

                        //calculo
                        $detalle->costo_x_hora = round(($item->MONTO/$item->CANTIDAD_H)*$item->CANTIDAD,2);

                        /*luego ver por el area del fundo*/

                        if(substr($codigo,2,1) != 0){

                            $detalle->area = $this->getAreaFundo(substr($codigo,2,1));
                        }

                    }
                   // $detalle->help  .=  ' '.$item->CANTIDAD.' - '.$item->CODIGO.' : '.$codigo ;
                }

                array_push($detalles,$detalle);
            }

            $act->detalles = $detalles;

            array_push($a_actividades,$act);
        }


        $campanias = HelpFunct::getUniqueValueOfArrayOfNPosition($codigos,0,2);

        $f_cabeceras = [];

        foreach ($campanias as $cam)
        {
            $obj = new Obj();
            $obj->cam = $cam;
            $cabeceras = [];

            foreach ($codigos as $codigo){

                if($cam == substr($codigo,0,2)){

                    array_push($cabeceras,$codigo);
                }
            }

            $obj->codigos = $cabeceras;
            array_push($f_cabeceras,$obj);
        }


        //$cabecera = HelpFunct::getUniqueValueOfArrayOfNPosition($codigos);

        $response = array();
       // $response['codigos'] = $codigos;
        $response['actividades'] = $a_actividades;
        $response['cabecera'] = $f_cabeceras;
        //$response['campanias'] = $campanias;

        return $response;

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
				,(select 
					CASE   
						WHEN CONVERT(INT,(SELECT EMPLEADO FROM 
							flexline.PER_TRABAJADOR
							WHERE FICHA = flexline.PER_DET_LIQ.FICHA)) < 999999 THEN '04'   
						ELSE '01'   
					END
				)C1	
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

                $row->DESCRIPCION = $x[0]->DESCRIPCION;
                $row->FICHA = $x[0]->FICHA;
                $row->DNI = $x[0]->DNI;
                $row->CODIGO = $x[0]->CODIGO;
                $row->C1 = $x[0]->C1;
                $row->sum_monto_codigo = HelpFunct::fillZerosLeft(9,number_format($sum_monto_codigo,2,'.',''))  ;
                array_push($response, $row);

                //number_format($t_movilidad_condicion,2,'.',',');
            }

            //-----------------------------
            $quinta = collect($item);

            $quinta = $quinta->where('CODIGO','0605')->first();

            $obj = new Obj();
            $obj->DESCRIPCION = '5° CATEGORIA';
            $obj->FICHA = $item[0]->FICHA;
            $obj->DNI = $item[0]->DNI;
            $obj->C1 = $item[0]->C1;

            if( count($quinta) > 0){

               // $obj->CODIGO = $quinta;
                $obj->sum_monto_codigo = HelpFunct::fillZerosLeft(9,number_format($quinta->MONTO,2,'.',''))  ;
                $obj->DESCRIPCION .= '_*';
                $obj->CODIGO = $quinta->CODIGO;
            }else{

                //$obj->CODIGO = $item;
                $obj->sum_monto_codigo = HelpFunct::fillZerosLeft(9,number_format(0.00,2,'.',''))  ;
                $obj->CODIGO = '0605';
            }

            array_push($response, $obj);


            //---------------------



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

    public function getPlameSnl($data){


        /*
         * El perioo tiene que estar en formato YYYYMM
         * */

        $f_inicio = $data['f_inicio'];
        $f_fin = $data['f_fin'];
        $periodo = $data['periodo'];

        $query = "
        
        /**
        la siguiente query nos trae de cada trabajador 
        los dias laborados y lo dias de acaciones
        para btener las faltas que tubo en el periodo
        dado, eso se usara para la plame 
        LA FECHA TIENE QUE ESTAR EN FORMATO YYYY-MM-DD
        */
        
        
        SELECT TRABAJADOR, COUNT( DISTINCT (CONVERT(DATE,FECHA,113))) DLABORADOS
        ,(SELECT dbo.DiasEnMes('$f_inicio')) dias       --aca entra la fecha de inicio
        ,(SELECT dbo.DiasLaboralesObligtoriosByMes('$f_fin',TRABAJADOR)) DIAS_NO_DEBE_TRABAJAR --aca entra la fecha_fin
        ,(SELECT dbo.diasLaboralesByContrato('$f_inicio','$f_fin',TRABAJADOR)) AS DIAS_OBLIGATORIO_TRABAJAR
        /*
        CASE WHEN (SELECT dbo.DiasLaboralesObligtoriosByMes('2016-12-31',TRABAJADOR)) < 0 --aca entra la fecha_fin
            THEN  (SELECT dbo.DiasEnMes('2016-12-01')) --aca va f_inicio
            ELSE ((SELECT dbo.DiasEnMes('2016-12-01')) - (SELECT dbo.DiasLaboralesObligtoriosByMes('2016-12-31',TRABAJADOR))) --aca entra la fecha_fin
        END  AS DIAS_OBLIGATORIO_TRABAJAR
        */
        ,coalesce ( (SELECT SUM(valor) from flexline.PER_DET_LIQ
        where EMPRESA='e01'
        and periodo like '$periodo%' --se modifica por periodo
        and MOVIMIENTO='110899'  -- dato estatico
        and FICHA = TRABAJADOR
        ),0)vacaciones
        ,(SELECT EMPLEADO FROM 
        flexline.PER_TRABAJADOR
        WHERE EMPRESA = 'E01'
        AND FICHA = TRABAJADOR) DNI
        FROM flexline.PER_DETALLETRATO
        WHERE EMPRESA='E01' 
        AND CONVERT(DATE,FECHA,113) BETWEEN '$f_inicio' AND '$f_fin'  --aqui cambiar por fecha inicio y fin
        AND LEN(TRABAJADOR) >1
        GROUP BY TRABAJADOR
        HAVING COUNT( DISTINCT (CONVERT(DATE,FECHA,113))) <> (SELECT dbo.DiasEnMes('$f_inicio')) --colocar la fecha inicio
        ORDER BY TRABAJADOR";


        $res = \DB::select($query);

        /*
         * primero evaluamos al personal agrario
         * codigo 07 insasistencia , 23 vacaciones
         * */

        $response = [];

        foreach ($res as $item)
        {
            $obj = new Obj();
            $vacaciones  = 0;

            if($item->vacaciones > 0)
            {
                $o = new Obj();

                $o->C1 = '01';
                $o->DNI = $item->DNI;
                $o->CODIGO = '23';
                $o->CANTIDAD = intval($item->vacaciones) ;

                $vacaciones =  $item->vacaciones;

                array_push($response,$o);
            }

            //ACA ENTRA EL CALCULO
            $t_dias_laborados = $item->DLABORADOS + $vacaciones;

            $faltas = $item->DIAS_OBLIGATORIO_TRABAJAR - $t_dias_laborados;

            if($faltas > 0){

                /*se llena lso datos del objeto*/
                $obj->C1 = '01';
                $obj->DNI = $item->DNI;
                $obj->CODIGO = '07';
                $obj->CANTIDAD = $faltas;

                array_push($response,$obj);
            }


        }

        //ESTA QUERY ES PARA UNIRLOS CON LOS EMPLEADOS

        $query_empleado = "select A.FICHA,B.EMPLEADO DNI, SUM(VALOR) CANTIDAD ,
        '07' CODIGO
        from 
        flexline.PER_DET_LIQ A,
        FLEXLINE.PER_TRABAJADOR B
        where 
        A.EMPRESA=B.EMPRESA
        AND A.FICHA=B.FICHA
        AND A.EMPRESA='e01'
        AND B.VIGENCIA='ACTIVO'
        AND B.CATEGORIA='EMPLEADO'
        AND A.PERIODO like '$periodo%'
        AND A.MOVIMIENTO IN ('20011','20012')
        GROUP BY A.FICHA,B.EMPLEADO
        UNION
        select A.FICHA,B.EMPLEADO DNI, SUM(VALOR) CANTIDAD 
        ,'05' CODIGO
        from 
        flexline.PER_DET_LIQ A,
        FLEXLINE.PER_TRABAJADOR B
        where 
        A.EMPRESA=B.EMPRESA
        AND A.FICHA=B.FICHA
        AND A.EMPRESA='e01'
        AND B.VIGENCIA='ACTIVO'
        AND B.CATEGORIA='EMPLEADO'
        AND A.PERIODO like '$periodo%'
        AND A.MOVIMIENTO IN ('20013','20014')
        GROUP BY A.FICHA,B.EMPLEADO
        UNION
        select 
         A.FICHA,B.EMPLEADO DNI, SUM(VALOR) CANTIDAD 
        ,'23' CODIGO
        from 
        flexline.PER_DET_LIQ A,
        FLEXLINE.PER_TRABAJADOR B
        where 
        A.EMPRESA=B.EMPRESA
        AND A.FICHA=B.FICHA
        AND A.EMPRESA='e01'
        AND B.VIGENCIA='ACTIVO'
        AND B.CATEGORIA='EMPLEADO'
        and a.MOVIMIENTO='119999'
        AND A.PERIODO like '$periodo%'
        GROUP BY A.FICHA,B.EMPLEADO
        ";

        $r = \DB::select($query_empleado);

        foreach ($r as $item){

            $c1 = '01';

            if($item->DNI < 999999){
                $c1 = '04';
            }

            $obj = new Obj();

            $obj->C1 = $c1;
            $obj->DNI = $item->DNI;
            $obj->CODIGO = $item->CODIGO;
            $obj->CANTIDAD = intval($item->CANTIDAD) ;

            array_push($response,$obj);

        }


        return $response;


    }

    public function getPlameJOR($data){

        $f_inicio = $data['f_inicio'];
        $f_fin = $data['f_fin'];
        $periodo = $data['periodo'];
        $fomat_f_inicio = HelpFunct::divideStringForBanderaAndUnite($f_inicio,'-');
        $fomat_f_fin = HelpFunct::divideStringForBanderaAndUnite($f_fin,'-');

        $query = "
        --Es para agrario
        SELECT TRABAJADOR,SUM(CANTIDAD) AS H_L_ORDINARIAS --- SUMA DE HORAS ORDINARIAS
        ,coalesce ((
        SELECT SUM(CANTIDAD)H_L_EXTRAS 
        FROM flexline.PER_DETALLETRATO --- SUMA DE HORAR EXTRAS
        WHERE EMPRESA='E01'
        AND TRATO='TRATO_HORA'
        AND CODACTIVIDAD IN ('HORA-EXTRA-25%','HORA-EXTRA-35%','HORA-EXTRA-100%','HORA-FERIADO')
        AND CONVERT(DATE,FECHA,113) BETWEEN '$f_inicio' AND '$f_fin' --ACA VA LA FECHA INICIO Y EL FIN
        AND TRABAJADOR = D.TRABAJADOR),0) H_L_EXTRAS
        ,P.EMPLEADO DNI
        FROM flexline.PER_DETALLETRATO D inner join 
        flexline.PER_TRABAJADOR P ON D.EMPRESA = P.EMPRESA AND P.FICHA = D.TRABAJADOR
        WHERE D.EMPRESA='E01'
        AND D.TRATO='TRATO_HORA'
        AND P.CATEGORIA = 'OPERARIO'
        AND D.CODACTIVIDAD='HORA-NORMAL'
        AND CONVERT(DATE,D.FECHA,113) BETWEEN '$f_inicio' AND '$f_fin'--ACA VA LA FECHA INICIO Y EL FIN
        GROUP BY D.TRABAJADOR,P.EMPLEADO
        
        ";

        $query_empleado = " /* UNION */
        --ESTO ES PARA EMPLEADO
        select B.FICHA TRABAJADOR,
        ((select COUNT(CODIGO) AS H_OBLIGATORIA
        from FLEXLINE.gen_tabcod 
        where empresa = 'E01' 
        and tipo = 'GEN_CALEND'
        AND VALOR3 is null --aca acontinuacion en el codigo se coloca la f_inicio y fecha fin en formato yyyymmdd
        and codigo >= '$fomat_f_inicio' and codigo <= '$fomat_f_fin') -
        COALESCE(
        (select SUM(PD.VALOR) CANTIDAD_FALTAS 
                from 
                flexline.PER_DET_LIQ PD,
                FLEXLINE.PER_TRABAJADOR PT
                where 
                PD.EMPRESA=PT.EMPRESA
                AND PD.FICHA=PT.FICHA
                AND PD.EMPRESA='e01'
                AND PT.CATEGORIA='EMPLEADO'
                AND PD.PERIODO like '$periodo%' --aca va el periodo
                AND PD.MOVIMIENTO IN ('20011','20012','119999')
                    AND PD.FICHA = B.FICHA
        ),0)  )*8 H_L_ORDINARIAS
        ,COALESCE((select SUM(valor) from flexline.PER_DET_LIQ
        where EMPRESA=b.EMPRESA
        and FICHA=b.FICHA
        and MOVIMIENTO IN ('20101','20102','20103') 
        and periodo='$periodo'),0) as H_L_EXTRAS --- SE DEBE COLOCAR EL PERIODO
        ,B.EMPLEADO DNI
        from
        FLEXLINE.PER_DET_LIQ P,
        FLEXLINE.PER_TRABAJADOR B
        where
        B.EMPRESA=P.EMPRESA
        AND B.FICHA=P.FICHA
        AND b.EMPRESA='e01'
        AND P.PERIODO='$fomat_f_fin' -- ACA COLOCAR F_FIN_FORMATEADA
        AND B.CATEGORIA='EMPLEADO'
        GROUP BY B.FICHA,B.EMPLEADO,B.EMPRESA

        ";



        $response = [];

        $res = \DB::select($query);

        $res_empleado = \DB::select($query_empleado);

       // array_push($res,$res_empleado);


        foreach ($res as $item){

            $obj = new Obj();


            if($item->DNI < 999999){
                $item->C1 = '04';
            }else{
                $item->C1 = '01';
            }

            /*
            $item->H_L_ORDINARIAS = intval($item->H_L_ORDINARIAS);
            $item->H_L_EXTRAS = intval($item->H_L_EXTRAS);
            */

            $obj->C1 = $item->C1;
            $obj->DNI = $item->DNI;
            $obj->H_L_ORDINARIAS = intval($item->H_L_ORDINARIAS);
            $obj->H_L_EXTRAS = intval($item->H_L_EXTRAS);

            array_push($response,$obj);
        }


        foreach ($res_empleado as $item){

            $obj = new Obj();


            if($item->DNI < 999999){
                $item->C1 = '04';
            }else{
                $item->C1 = '01';
            }



            $obj->C1 = $item->C1;
            $obj->DNI = $item->DNI;
            $obj->H_L_ORDINARIAS = intval($item->H_L_ORDINARIAS);
            $obj->H_L_EXTRAS = intval($item->H_L_EXTRAS);

            array_push($response,$obj);
        }


        return $response;



    }

    public function getDetailLiquidacion($data){

       // $periodo = '20170104';
        //$inicio_periodo = '20170101';
        $periodo = $data['periodo'];
        $inicio_periodo = $data['inicio_periodo'];

        $query = "select 
        (E.APELLIDO_PATERNO+' '+E.APELLIDO_MATERNO+', '+E.NOMBRE) NOMBRE,
        E.FECHA_INICIO,
        E.FECHA_TERMINO,
        E.EMPLEADO DNI,
        A.FICHA,
        A.VALOR AS VT,
        B.VALOR AS AFP,
        D.VALOR AS FLUJO_MIXTO,
        ROUND(CASE WHEN B.VALOR='ONP' THEN A.VALOR*0.13 ELSE A.VALOR*0.10 END,2) AS FONDO,
        ROUND(CASE WHEN B.VALOR='ONP' THEN 0 ELSE(C.valor3/100)*A.VALOR END,2) AS SEGURO_AFP,
        ROUND(CASE WHEN D.VALOR='FLUJO' AND B.VALOR<>'ONP' THEN (C.valor1/100)*A.VALOR ELSE 0 END,2) AS CO_FLUJO,
        ROUND(CASE WHEN D.VALOR='MIXTA' AND B.VALOR<>'ONP' THEN (C.valor2/100)*A.VALOR ELSE 0 END,2) AS CO_MIXTO,
        coalesce( (select SUM(DIAS_EFE) 
        from flexline.PER_VACACIONES 
        where EMPRESA = 'e01'
        AND FICHA = E.FICHA
        AND ( CONVERT(date,CONVERT(VARCHAR(8),E.FECHA_INICIO),103) <= CONVERT(date,CONVERT(VARCHAR(8),FEC_INIEFE),103)
            AND CONVERT(date,CONVERT(VARCHAR(8),E.FECHA_TERMINO),103) >= CONVERT(date,CONVERT(VARCHAR(8),FEC_INIEFE),103)) AND 
            ( CONVERT(date,CONVERT(VARCHAR(8),E.FECHA_INICIO),103) <= CONVERT(date,CONVERT(VARCHAR(8),FEC_FINEFE),103)
            AND CONVERT(date,CONVERT(VARCHAR(8),E.FECHA_TERMINO),103) >= CONVERT(date,CONVERT(VARCHAR(8),FEC_FINEFE),103))
        AND TIPO_TRANS = 'APROBACION'
        AND ESTADO = 'A'),0 )VACACIONES_GOZADAS,
        DATEDIFF(DAY,CONVERT(date,CONVERT(VARCHAR(8),E.FECHA_INICIO),103),
        CONVERT(date,CONVERT(VARCHAR(8),E.FECHA_TERMINO),103)) DIAS_CONTRATO,
        E.REMUNERACION AS SUELDO,
        CASE WHEN E.CATEGORIA='EMPLEADO' THEN '0' ELSE ROUND((E.REMUNERACION * 0.042635),2) END AS CTS_LEY_27360,
        CASE WHEN E.CATEGORIA='EMPLEADO' THEN '0' ELSE ROUND((E.REMUNERACION * 0.127905),2) END AS GRATI_LEY_27360,
        ROUND(CASE WHEN F.VALOR='CONASIGFAM' THEN '85.00' ELSE '0.00' END,2) AS ASIG_FAMILIAR,
        E.CATEGORIA AS CAT
        FROM
        flexline.PER_DET_LIQ A,
        flexline.PER_ATRIB_TRAB B,
        DBO.GEN_TABLA C,
        flexline.PER_ATRIB_TRAB D,
        flexline.PER_TRABAJADOR E,
        flexline.PER_ATRIB_TRAB F
        WHERE
        A.EMPRESA=B.EMPRESA
        AND A.FICHA=B.FICHA
        AND B.EMPRESA=C.empresa
        AND B.VALOR=C.codigo2
        AND A.EMPRESA=D.EMPRESA
        AND A.FICHA=D.FICHA
        AND A.FICHA = E.FICHA
        AND A.EMPRESA = E.EMPRESA
        AND A.EMPRESA=F.EMPRESA
        AND A.FICHA=F.FICHA
        AND A.EMPRESA='E01'
        AND A.MOVIMIENTO='10025'
        AND B.ATRIBUTO='AFP'
        AND D.ATRIBUTO='TIPCOMAFP'
        AND F.ATRIBUTO='ASIGFAM'
        AND A.VALOR > 0
        AND C.codigo1='$inicio_periodo' -- INICIO DE MES DE LA SEMANA QUE SE CONSULTA
        AND A.PERIODO='$periodo' -- ACA VA EL PERIODO
        ORDER BY E.APELLIDO_PATERNO,E.APELLIDO_MATERNO  ";


        $res = \DB::select($query);

        foreach ($res as $item)
        {
            $item->FECHA_INICIO = HelpFunct::transformStringToDate($item->FECHA_INICIO,'103');
            $item->FECHA_TERMINO = HelpFunct::transformStringToDate($item->FECHA_TERMINO,'103');

            /*calculo para las vacaciones ESTO ES EL CASO DE EMPLEADO*/
            $vacaciones_ganadas = $item->DIAS_CONTRATO * 0.042;

            $item->vacaciones_truncas = round($vacaciones_ganadas)-$item->VACACIONES_GOZADAS;

            $item->periodo = HelpFunct::NameMonth(intval(substr($periodo,4,2))).' '.substr($periodo,0,4);

            /*TENEMOS QUE SACAR CUANTOS AÑOS DIAS Y MESES TRABAJO EL EMPLEADO*/
            $aux = $item->DIAS_CONTRATO;
            $item->anio_contratado = intval($aux/360);
            $aux = $aux%360;
            $item->mes_contratado = intval($aux / 30);
            $aux = $aux%30;
            $item->dias_contratado = $aux;

            /*luego sacamos lo de la cantidad de vacaciones truncas */
            $aux = $item->vacaciones_truncas;
            $item->anio_VT = intval($aux/360);
            $aux = $aux%360;
            $item->mes_VT = intval($aux / 30);
            $aux = $aux%30;
            $item->dias_VT = $aux;

            /*luego sacamos lo de la cantidad de vacaciones GOZADAS */
            $aux = $item->VACACIONES_GOZADAS;
            $item->mes_VG = intval($aux / 30);
            $aux = $aux%30;
            $item->dias_VG = $aux;

            /*CONCEPTOS DE REMUNERACION COMPUTABLE*/ // FZ

            $item->CTS_LEY_27360 = round($item->CTS_LEY_27360,2);//FZ
            $item->GRATI_LEY_27360 = round($item->GRATI_LEY_27360,2);//FZ
            $item->ASIG_FAMILIAR = round($item->ASIG_FAMILIAR,2);//FZ
            $item->SUELDO = round($item->SUELDO,2);//FZ


            $item->ONP = round(($item->VT*13)/100,2); 
            $item->VT = round($item->VT,2);
            $item->FONDO = round($item->FONDO,2);
            $item->SEGURO_AFP = round($item->SEGURO_AFP,2);

            if($item->AFP == 'ONP'){
                $item->FONDO = round(0.00,2);
            }

            if($item->AFP != 'ONP'){
                $item->ONP = round(0.00,2);
            }

            if($item->FLUJO_MIXTO == 'MIXTA'){
                $item->COMISION_AFP = round($item->CO_MIXTO,2);
            }else{
                $item->COMISION_AFP = round($item->CO_FLUJO,2);
            }

            $item->total_remune = $item->CTS_LEY_27360+ $item->GRATI_LEY_27360+$item->ASIG_FAMILIAR+$item->SUELDO;//fFZ

            $item->deducciones = $item->ONP+ $item->FONDO+$item->COMISION_AFP+$item->SEGURO_AFP;

            $item->neto = $item->VT -  $item->deducciones;

            if($item->neto > 0){
                $item->monto =NumberToLetter::convert( round($item->neto,2));
            }else{
                $item->monto = 'CERO';
            }


        }

        return $res;
    }

    public function getAFPNet($data)
    {
        $anio = $data['anio'];
        $mes = $data['mes'];
        //$anio = 2016;
        //$mes = 12;

        $query = "SELECT 
ROW_NUMBER() OVER (ORDER BY P.EMPLEADO) 'Secuencia',
'' as 'Codigo_CUSPP',
(SELECT 
CASE (Valor) WHEN '01' THEN '0'
WHEN '04' THEN '4' ELSE 'SIN_TIPO' END
FROM
flexline.PER_ATRIB_TRAB
WHERE EMPRESA=L.EMPRESA
AND FICHA=L.FICHA
and Atributo='TIPDOCTOI') AS 'TIPO_DOCUM',
P.EMPLEADO as 'DNI_Trabajador',
P.APELLIDO_PATERNO as 'Apellido_Paterno',
P.APELLIDO_MATERNO as 'Apellido_Materno',
P.NOMBRE as 'Nombres',
'S' as 'RELACION_LABORAL',
MAX(case SUBSTRING (CONVERT (CHAR , L.PERIODO), 1, 6 ) when SUBSTRING (CONVERT (CHAR , P.FECHA_INICIO), 1, 6 ) then 'S' else 'N' end ) AS 'INICIO_DE_RL',
MAX(case SUBSTRING (CONVERT (CHAR , L.PERIODO), 1, 6 ) when SUBSTRING (CONVERT (CHAR , P.FECHA_TERMINO), 1, 6 ) then 'S' else 'N' end ) AS 'CESE_DE_RL',
'' AS 'EXCEPCION_DE_APORTAR',
Sum(L.Valor) as 'Remuneracion_Asegurable',
'0' as 'Aporte_Voluntario_c/fin_Previsional',
'0' as 'Aporte_Voluntario_s/fin_Previsional',
'0' as 'Aporte_Voluntario_del_Empleador',
'N' as 'TIPO_DE_TRABAJADOR',
' ' as 'AFP'
FROM 
flexline.PER_DET_LIQ L,
flexline.PER_TRABAJADOR P,
FLEXLINE.PER_ATRIB_TRAB A
WHERE 
L.EMPRESA=P.EMPRESA
AND L.FICHA=P.FICHA
AND L.EMPRESA=A.EMPRESA
AND L.FICHA=A.FICHA
AND P.EMPRESA=A.EMPRESA
AND P.FICHA=A.FICHA
and A.Atributo='AFP'
and A.VALOR<>'ONP'
AND L.EMPRESA='E01'
AND L.Movimiento in ('10001','10007','10002','10003','10020','10030',
'10031','10037','10021','10016','10034','10010','10027','10025','10044','10040')
--and L.periodo like '201612%'
AND SUBSTRING(CONVERT(VARCHAR(20),L.PERIODO),1,4)=$anio ---- COLOCAR AÑO
AND SUBSTRING(CONVERT(VARCHAR(20),L.PERIODO),5,2)=$mes --- COLCOAR PERIODO DEL MES QUE CORRESPONDE
GROUP BY P.EMPLEADO,P.APELLIDO_MATERNO,P.APELLIDO_PATERNO,P.NOMBRE,L.EMPRESA,L.FICHA
ORDER BY P.EMPLEADO
";

        $res = \DB::select($query);


        foreach ($res as $item){

            $item->Apellido_Paterno = utf8_encode($item->Apellido_Paterno);
            $item->Apellido_Materno = utf8_encode($item->Apellido_Materno);
            $item->Nombres = utf8_encode($item->Nombres);
            $item->Remuneracion_Asegurable = floatval($item->Remuneracion_Asegurable);

        }


        $response = array();

        foreach ($res as $item)
        {
            $i = array();

            foreach ($item as $x){
                array_push($i,$x);
            }

            array_push($response,$i);

        }



        return $response;
    }


    public function getMovimientosByFichaAndPeriodo($data){

        $f_i= $data['f_inicio'];
        $f_f= $data['f_fin'];
        $movimiento = $data['movimiento'];
        $ficha = $data['ficha'];

        $query = "SELECT FICHA,PERIODO,MOVIMIENTO,DESCRIPCION,MONTO
                 FROM flexline.PER_MOV_MES
                where EMPRESA='e01'
                and FICHA like '%$ficha%' --- FILTRO POR FICHA
                and MOVIMIENTO like '%$movimiento%'
                and convert(date,convert(varchar(8),PERIODO),103)  BETWEEN  '$f_i' AND '$f_f'
                ORDER BY  PERIODO
                ";

        $res = \DB::select($query);

        foreach ($res as $item){
            $item->FECHA = substr($item->PERIODO,6,2).'-'.substr($item->PERIODO,4,2).'-'.substr($item->PERIODO,0,4);
        }


        return $res;
    }

    public function deleteMovimientoByPeriodoFicha($data){

        $FICHA = $data['FICHA'];
        $MOVIMIENTO = $data['MOVIMIENTO'];
        $PERIODO = $data['PERIODO'];

        $query = "DELETE
                 FROM flexline.PER_MOV_MES
                where EMPRESA='e01'
                and FICHA = '$FICHA' --- FILTRO POR FICHA
                and MOVIMIENTO = '$MOVIMIENTO'
                and PERIODO = $PERIODO  ";
        $res = \DB::delete($query);

        return $res;

    }


    public function getCentroCostoInterno(){

        $query = "select CODIGO,DESCRIPCION,TEXTO1 from flexline.GEN_TABCOD
                WHERE EMPRESA = 'E01'
                AND TIPO = 'CON_CCOSTO_INTERNO'
                AND VIGENCIA = 'S'";

        $res = \DB::select($query);

        return $res;
    }

    public function getLaborByCodigo($codigo){

        $query = "SELECT CODIGO,DESCRIPCION FROM
                flexline.GEN_TABCOD 
                WHERE EMPRESA = 'E01'
                AND TIPO LIKE 'PER_ACTIVIDADES'
                AND CODIGO = '$codigo'";

        $res = \DB::select($query);

        if(count($res)>0){

            return json_encode($res[0]);
        }else{
            return 0;
        }


    }

    public function CodigoActividad(){

        $query = "select (convert(varchar,ROW_NUMBER() OVER(ORDER BY DESCCODIGO ASC))+'-'+DESCCODIGO) as codigo,  DESCCODIGO value from 
flexline.PER_TRATOS
where EMPRESA = 'e01'";

        $res = \DB::select($query);

        return $res;

    }



    public function getMarcacionDICONTrabajadorByFecha($data){


        $dni = $data['dni'];
        $fecha = $data['fecha']; //formato yyyymmdd

        $query = "select Documento,CONVERT(DATE,Fecha) Fecha,Estado 
        from BDASISTENCIA10_AGROGRACE.dbo.Marcaciones m inner join BDASISTENCIA10_AGROGRACE.dbo.Trabajadores t ON
        m.CodTrabajador = t.CodTrabajador
        where m.Estado = 'E'
        AND Fecha = '$fecha'
        AND Documento = '$dni'";


        $res =  \DB::select($query);

        if(count($res)==0){
            return 0;
        }else{
            return 1;
        }


    }


    public function regJornales($data){

        //--cambiando e formato de dd-mm-yyyy a yyyy-dd-mm
        $f = explode('-',$data['fecha']);
        $f = $f[2].'-'.$f[0].'-'.$f[1];



        $trabajador     =   $data['ficha'];
        $fecha          =   $f;
        $trato          =   'TRATO_HORA';
        $codactividad   =   $data['actividad'];
        $hinicio        =   0;
        $hfin           =   0;
        $thoras         =   null;
        $monto          =   $data['hora'];
        $cantidad       =   $data['hora'];
        $estado         =   'NRPT';
        $aux_valor5     =   $data['cci'];
        $aux_valor11    =   'J';
        $aux_valor16    =   $data['codigo'];
        $aux_valor19    =   $data['user'];
        $aux_valor20    =   $data['ubigeo'];
        $monto_inicial  =   $data['hora'];
        $tipo_trab      =   'TRABAJADOR';
        $correlativop   =   0;
        $correlativoact =   0;



        $query = "INSERT INTO flexline.PER_DETALLETRATO
                 (EMPRESA,TRABAJADOR,FECHA,TRATO,CODACTIVIDAD,HINICIO,HFIN,CANTIDAD,MONTO,ESTADO,AUX_VALOR5,AUX_VALOR11
                 ,AUX_VALOR16,AUX_VALOR19,AUX_VALOR20,MONTO_INICIAL,TIPO_TRAB,CORRELATIVOP,CORRELATIVOACT) 
                 values 
                 ('E01','$trabajador','$fecha','$trato','$codactividad','$hinicio','$hfin',$cantidad,$monto,
                 '$estado','$aux_valor5','$aux_valor11','$aux_valor16','$aux_valor19','$aux_valor20',$monto_inicial,
                 '$tipo_trab','$correlativop','$correlativoact');";

        $val = \DB::insert($query);

        return $val;
    }


    public function getJornalByParameters($data){


        //--cambiando e formato de dd-mm-yyyy a yyyy-dd-mm
        $f = explode('-',$data['fecha']);
        $f = $f[2].'-'.$f[0].'-'.$f[1];
        $trabajador = $data['ficha'];
        $codactividad = $data['actividad'];
        $codigo = $data['codigo'];
        $cci    = $data['cci'];


        $query = "select TRABAJADOR,MONTO, * from 
                    flexline.PER_DETALLETRATO
                    WHERE FECHA = '$f'
                    AND TRABAJADOR = '$trabajador'
                    AND CODACTIVIDAD = '$codactividad'
                    AND AUX_VALOR16 = '$codigo'
                    AND AUX_VALOR5 = '$cci'";

        $res = \DB::select($query);

        return $res;
    }

    public function getTotalHoras($data,$actividad){


        //--cambiando e formato de dd-mm-yyyy a yyyy-dd-mm
        $f = explode('-',$data['fecha']);
        $f = $f[2].'-'.$f[0].'-'.$f[1];
        $trabajador = $data['ficha'];


        $query = "select sum(MONTO) MONTO from 
                    flexline.PER_DETALLETRATO
                    WHERE FECHA = '$f'
                    AND TRABAJADOR = '$trabajador'
                    AND CODACTIVIDAD like '%$actividad%'";


        $res = \DB::select($query);

        if(count($res)>0){
            $monto = round($res[0]->MONTO,2);
        }else{
            $monto = 0;
        }


        return $monto;
    }


    public function deleteJornal($data){


        $f = explode('-',$data['fecha']);//viene en formato dd-mm-yyyy
        $f = $f[2].'-'.$f[1].'-'.$f[0];
        $trabajador = $data['ficha'];
        $codactividad = $data['actividad'];
        $codigo = $data['codigo'];
        $cci    = $data['cci'];
        $hora   = $data['hora'];


        $query = "delete top(1) from 
                    flexline.PER_DETALLETRATO
                    WHERE convert(date,FECHA,113)  = '$f'
                    AND TRABAJADOR = '$trabajador'
                    AND CODACTIVIDAD = '$codactividad'
                    AND AUX_VALOR16 = '$codigo'
                    AND AUX_VALOR5 = '$cci' 
                    AND CANTIDAD = $hora ";


        $res = \DB::delete($query);

        return $res;

    }

    //sirve para limpiar los registros ya hechos en es misma fecha para dominicar
    public function deleteJornalVolume($fecha){


        //fecha tiene que estar en formato YYYY-mm-dd


        $query = "delete from 
        flexline.PER_DETALLETRATO
        where CODACTIVIDAD like '%DOMINICAL%'
        AND CONVERT(DATE,FECHA,113) = '$fecha'";


        $res = \DB::delete($query);

        return $res;

    }


    public function getJornalesByFechas($data)
    {
        $f_i = $data['f_i'];
        $f_f = $data['f_f'];
        $codigo = $data['codigo'];

        $query = "select CONVERT(DATE,FECHA,113) fecha,TRABAJADOR ficha,CODACTIVIDAD 
actividad,AUX_VALOR16 codigo, AUX_VALOR5 cci,CANTIDAD hora,
(select NOMBRE+' '+APELLIDO_PATERNO+' '+APELLIDO_MATERNO
         from flexline.PER_TRABAJADOR
        WHERE FICHA = TRABAJADOR) nombre
        from 
        flexline.PER_DETALLETRATO
        WHERE FECHA  between  '$f_i' and '$f_f'
        AND TRATO = 'TRATO_HORA'
        AND TRABAJADOR LIKE '%$codigo%'";

        $res = \DB::select($query);

        foreach ($res as $i){

            $f =  explode('-',$i->fecha) ; //yyyy-mm-dd
            $i->fecha = $f[2].'-'.$f[1].'-'.$f[0];
            $i->hora = round($i->hora,2);

        }

        return $res;
    }


    public function processdominical($f_i,$f_f){

        $query = "select TRABAJADOR, ROUND(SUM(CANTIDAD)/6,2) CANTIDAD
        from flexline.PER_DETALLETRATO
        where CONVERT(DATE,FECHA,113) BETWEEN '$f_i' AND '$f_f'
        AND CODACTIVIDAD = 'HORA-NORMAL'
        group by TRABAJADOR";



        $res = \DB::select($query);

        return $res;

    }






    //funciones helpers
    /**
     * estas funciones sirven solo para este módulo
     *
     */
    public function changeFormat ($fecha){

        $fecha = explode("-", $fecha);

        $fecha = $fecha[2].$fecha[1].$fecha[0];
        return $fecha;
    }


    public function getFundosParronesFormatedWithAreas($array)
    {
        /**
         * primero obtenemos los periodos que se encuentren
         */


        $formated = [];

        foreach ($array as $periodo){

            $fundos = HelpFunct::getUniqueValueOfArrayOfNPosition($periodo->codigos);
            $fundos_array  = [];

            foreach ($fundos as $i){

                $parron = [];

                /**
                 * Recorremos todos los codigos
                 * para revisar si ese codigo pertenece
                 * a ese fundo
                 */

                foreach ($periodo->codigos as $codigo){
                    if(substr($codigo,2,1)==$i){


                        $p = substr($codigo,3,2);

                        /*
                        if(substr($codigo,4,1)== 'A' ){
                            $p = substr($codigo,0,1).'1';

                        }

                        if(substr($codigo,4,1)== 'B' ){
                            $p = substr($codigo,0,1).'2';

                        }
                        */

                        $f = "PARRON_0".$p."_F".substr($codigo,2,1);



                        $contabilidadRep = new ContabilidadRep();
                        $area = $contabilidadRep->getParronByFundo($f);
                      //  var_dump($area);
                        if(count($area)>0){
                            $area = round($area[0]->VALOR1,2);
                        }else{
                            $area = 0;
                        }
                        $p = $p.'-'.$area;

                        array_push($parron,$p);
                    }
                }

                $obj = new Obj();
                $obj->fundo = $i;
                $obj->parron = $parron;




                array_push($fundos_array,$obj);
            }

            $periodo->fundos =$fundos_array;

        }


        return $array;

    }

    /**
     * la siguiente funcion devuelve el area
     * del parron consultado , de acuerdo a la entrada
     * y l array que se pase
     *
     * C: campaña
     * F: fundo
     * P: parron
     * O: otros
     * $codigo : CCFPPO
     */
    public function getAreaByParron($codigo,$array)
    {
        $res = 0;


        foreach ($array as $item)
        {
            if ($item->campain == substr($codigo,0,2)){

               /* ahra entramos a compar fundos*/
                foreach ($item->fundos as $f){

                    if(substr($codigo,2,1)== $f->fundo){

                        /*entramos a los parrones*/
                        foreach ($f->parron as $p){

                            $temp = explode("-",$p);
                            $parron_num = $temp[0];
                            $area  = $temp[1];

                            if($parron_num == substr($codigo,3,2)){
                                $res = $area;
                            }
                        }
                    }
                }
            }
        }

        return $res;
    }






    /**
     * la funcion trae la cantidad de hectareas
     * de acuerdo al funo
     */
    public function getAreaFundo($fundo){

        $query = "SELECT VALOR1 FROM flexline.GEN_TABCOD
            WHERE EMPRESA='E01'
            AND TIPO='GEN_FUNDO'
            AND VIGENCIA <> 'N'
            AND CODIGO = 'FUNDO_00$fundo'";

        $response = \DB::select($query);

        if($response != null || count($response)>0){

            return round($response[0]->VALOR1,2);
        }else{
            return 0;
        }

    }
}