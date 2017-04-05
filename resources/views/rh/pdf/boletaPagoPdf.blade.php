<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport">
    <title>Document</title>
</head>
<body>


@foreach($res as $item)

    <?php
        $maestro = $item[0];
    ?>

    <div class="boleta">
        <div class="title">
            <div class="logo">
                <IMG SRC="{{ asset('img/logo.jpg') }}">
            </div>
            <div class="razon">
                <span><strong>AGRO EXPORTACIONES GRACE S.A.C.</strong></span><br>
                <SPAN>R.U.C. 20518803078</SPAN><br>
                <span>Av. Mariscal Ramón Castilla N°688,Dpto. 305 C.C. La Aurora, Miraflores-Lima</span>
            </div>
            <div class="titulo">
                <p>BOLETA DE PAGO</p>
            </div>
            <div class="fecha">
                Del {{$f_i}}  al  {{$f_f}}
            </div>


        </div>
        <hr >
        <H5 style="padding: 0px;margin: 0px;font-size: 14px;letter-spacing: 0.2em"><STRONG>{{$maestro->NOMBRE}}</STRONG></H5>
        <table style="margin: 0px;padding: 0px;" id="details">
            <tr>
                <td>Código:</td>
                <td>{{$maestro->CODIGO}}</td>
                <td>N° Días Trabajados:</td>
                <?php
                $d_trabajador =  $item->where('MOVIMIENTO','52500')->first();
                if($d_trabajador != null){
                    $d_trabajador = $d_trabajador->VALOR;
                }ELSE{
                    $d_trabajador = '0.00';
                }
                //$d_trabajador = $d_trabajador->VALOR;
                ?>
                <td>{{number_format($d_trabajador, 2, '.', ',')}}</td>
                <td>N° Horas Trabajadas:</td>
                <?php $h_trabajadas = $item->where('MOVIMIENTO','70060')->first();
                if($h_trabajadas != null){
                    $h_trabajadas = $h_trabajadas->VALOR;
                }ELSE{
                    $h_trabajadas = 0;
                }
                ?>
                <td>{{number_format($h_trabajadas, 2, '.', ',')}}</td>
            </tr>
            <tr>
                <td>D.N.I / C.E.</td>
                <td>{{$maestro->DNI}}</td>
                <?php $d_nocturno = $item->where('MOVIMIENTO','52200')->first();
                if($d_nocturno != null){
                    $d_nocturno = $d_nocturno->VALOR;
                }ELSE{
                    $d_nocturno = '0.00';
                }
                ?>
                <td>N° Días Nocturno:</td>
                <td>{{number_format($d_nocturno, 2, '.', ',')}}</td>
                <td>N° Horas Extras 25%:</td>
                <?php $temp = $item->where('MOVIMIENTO','20101')->first();
                if($temp != null){
                    $temp = $temp->VALOR;
                }ELSE{
                    $temp = '0.00';
                }
                ?>
                <td>{{number_format($temp, 2, '.', ',')}}</td>
            </tr>
            <tr>
                <td>Categoria:</td>
                <td>{{$maestro->CATEGORIA}}</td>
                <td>Fecha Termino:</td>
                <?php $fecha_i = $item->where('MOVIMIENTO','131')->first();

                $fecha_i = explode('.', $fecha_i->VALOR);
                $fecha_i = $fecha_i[0];
                $fecha_i = substr($fecha_i, 6, 2).'/'.substr($fecha_i, 4, 2).'/'.substr($fecha_i, 0, 4);
                ?>
                <td>{{$fecha_i}}</td>
                <td>N° Horas Extras 35%:</td>
                <?php $temp = $item->where('MOVIMIENTO','20102')->first();
                if($temp != null){
                    $temp = $temp->VALOR;
                }ELSE{
                    $temp = '0.00';
                }
                ?>
                <td>{{$temp}}</td>
            </tr>
            <tr>
                <td>Cargo:</td>
                <td>{{$maestro->CARGO}}</td>
                <td>N° Dias Descanso Medico:</td>
                <?php $h_trabajadas = $item->where('MOVIMIENTO','20104')->first();
                if($h_trabajadas != null){
                    $h_trabajadas = $h_trabajadas->VALOR;
                }ELSE{
                    $h_trabajadas = 0;
                }
                ?>
                <td>{{number_format($h_trabajadas, 2, '.', ',')}}</td>
                <td>N° Horas Extras 100%:</td>
                <?php $temp = $item->where('MOVIMIENTO','20103')->first();
                if($temp != null){
                    $temp = $temp->VALOR;
                }ELSE{
                    $temp = '0.00';
                }
                ?>
                <td>{{number_format($temp, 2, '.', ',')}}</td>
            </tr>
            <tr>
                <td>Fecha Ingreso:</td>
                <?php $fecha_i = $item->where('MOVIMIENTO','130')->first();

                $fecha_i = explode('.', $fecha_i->VALOR);
                $fecha_i = $fecha_i[0];
                $fecha_i = substr($fecha_i, 6, 2).'/'.substr($fecha_i, 4, 2).'/'.substr($fecha_i, 0, 4);
                ?>
                <td>{{$fecha_i}}</td>
                <td>N° Dias Subcidio Enfermed.:</td>
                <?php $h_trabajadas = $item->where('MOVIMIENTO','20105')->first();
                if($h_trabajadas != null){
                    $h_trabajadas = $h_trabajadas->VALOR;
                }ELSE{
                    $h_trabajadas = 0;
                }
                ?>
                <td>{{number_format($h_trabajadas, 2, '.', ',')}}</td>
                <td>N° Horas Noche:</td>
                <?php $temp = $item->where('MOVIMIENTO','20106')->first();
                if($temp != null){
                    $temp = $temp->VALOR;
                }ELSE{
                    $temp = '0.00';
                }
                ?>
                <td>{{$temp}}</td>
            </tr>
            <tr>
                <td>A.F.P.</td>
                <td>{{$maestro->AFP}}</td>
                <td>N°Dias Subcidio Maternidad:</td>
                <?php $h_trabajadas = $item->where('MOVIMIENTO','20109')->first();
                if($h_trabajadas != null){
                    $h_trabajadas = $h_trabajadas->VALOR;
                }ELSE{
                    $h_trabajadas = 0;
                }
                ?>
                <td>{{number_format($h_trabajadas, 2, '.', ',')}}</td>
                <td>F. Inicio Vacaciones:</td>
                <?php $temp = $item->where('MOVIMIENTO','6002')->first();
                if($temp != null){
                    $temp = $temp->VALOR;
                    $temp = explode('.', $temp);
                    $temp = $temp[0];
                    $temp = substr($temp, 6, 2).'/'.substr($temp, 4, 2).'/'.substr($temp, 0, 4);

                }ELSE{
                    $temp = '-';
                }
                ?>
                <td>{{$temp}}</td>
            </tr>
            <tr>
                <td>T. Trabajador</td>
                <td>{{$maestro->T_TRABAJADOR}}</td>
                <td>N°Dias Vacaciones:</td>
                <?php $temp = $item->where('MOVIMIENTO','110899')->first();
                if($temp != null){
                    $temp = $temp->VALOR;
                }ELSE{
                    $temp = '0.00';
                }
                ?>
                <td>{{number_format($temp, 2, '.', ',')}}</td>
                <td>F. Final Vacaciones:</td>
                <?php $temp = $item->where('MOVIMIENTO','6003')->first();
                if($temp != null){
                    $temp = $temp->VALOR;
                    $temp = explode('.', $temp);
                    $temp = $temp[0];
                    $temp = substr($temp, 6, 2).'/'.substr($temp, 4, 2).'/'.substr($temp, 0, 4);

                }ELSE{
                    $temp = '-';
                }
                ?>
                <td>{{$temp}}</td>
            </tr>
        </table>
        <HR>

        <?php
            //aca se hallará lacantiad de descuentos e ingresos
            $ingresos = $item->where('TIPO_MOVTO','H');
            $descuentos = $item->where('TIPO_MOVTO','D');
        ?>

        <table id="detail2">
            <tr>
                <td style="letter-spacing: 0.2em"><strong>INGRESOS</strong></td>
                <td style="letter-spacing: 0.2em"><strong>DESCUENTOS</strong></td>
                <td colspan="2" style="letter-spacing: 0.2em"><strong>APORTACIONES</strong></td>
            </tr>
            <tr>
                <td>
                    <table id="sub_ingreso">
                        @foreach($ingresos as $i)
                        <tr>
                            <td>{{$i->DESCRIPCION}}</td>
                            <td>{{number_format($i->VALOR,2,'.','')}}</td>

                        </tr>
                        @endforeach
                    </table>
                </td>
                <td >
                    <table id="sub_descuento">
                        @foreach($descuentos as $i)
                            <tr>
                                <td>{{$i->DESCRIPCION}}</td>
                                <td>{{number_format($i->VALOR,2,'.','')}}</td>

                            </tr>
                        @endforeach
                    </table>

                </td>
                <td>
                    ESSALUD
                </td>
                <?php $temp = $item->where('MOVIMIENTO','10804')->first();
                if($temp != null){
                    $temp = $temp->VALOR;
                }ELSE{
                    $temp = '0.00';
                }
                ?>
                <td class="monto_essalud">{{ number_format($temp,2,'.','')}}</td>

            </tr>
        </table>

        <div class="foot">
            <hr>
            <table id="tab_foot">
                <tr>
                    <td>Total Ingresos</td>
                    <?php $temp = $item->where('MOVIMIENTO','10')->first();
                    if($temp != null){
                        $temp = $temp->VALOR;
                    }ELSE{
                        $temp = '0.00';
                    }
                    ?>
                    <td >{{ number_format($temp,2,'.','')}}</td>

                    <td>Total Descuento:</td>
                    <?php $temp = $item->where('MOVIMIENTO','11')->first();
                    if($temp != null){
                        $temp = $temp->VALOR;
                    }ELSE{
                        $temp = '0.00';
                    }
                    ?>
                    <td >{{ number_format($temp,2,'.','')}}</td>
                    <td>Total Aportes:</td>
                    <?php $temp = $item->where('MOVIMIENTO','10804')->first();
                    if($temp != null){
                        $temp = $temp->VALOR;
                    }ELSE{
                        $temp = '0.00';
                    }
                    ?>
                    <td >{{ number_format($temp,2,'.','')}}</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><strong style="letter-spacing: 0.1em">NETO A PAGAR (E):</strong></td>
                    <?php $temp = $item->where('MOVIMIENTO','99005')->first();
                    if($temp != null){
                        $temp = $temp->VALOR;
                    }ELSE{
                        $temp = '0.00';
                    }

                    try{

                        $let =  \sirag\Helpers\NumberToLetter::convert(number_format($temp,2,'.',''));

                    }catch(\Exception $e){
                        $let = 'error'.$temp;

                    }
                    ?>
                    <td >{{ number_format($temp,2,'.','')}} </td>
                </tr>

            </table>
            <hr>
            <span class="importe_letras"><strong>Son: {{$let}}</strong></span>
        </div>

        <div class="firmas" width="100%">
            <div class="firma_k">
                <img src="{{asset('img/Firma_RRHH.jpg')}}" alt="">
            </div>
            <div class="kai">
                KAI KROGH FLORES <BR>
                GERENTE GENERAL <BR>
                AGRO EXPORTACIONES GRACE S.A.C
            </div>

            <div class="trabajador">
                V°B° Trabajador
            </div>

        </div>


    </div>

    <br>
    <div class="espacio"></div>

    <div class="boleta">
        <div class="title">
            <div class="logo">
                <IMG SRC="{{ asset('img/logo.jpg') }}">
            </div>
            <div class="razon">
                <span><strong>AGRO EXPORTACIONES GRACE S.A.C.</strong></span><br>
                <SPAN>R.U.C. 20518803078</SPAN><br>
                <span>Av. Mariscal Ramón Castilla N°688,Dpto. 305 C.C. La Aurora, Miraflores-Lima</span>
            </div>
            <div class="titulo">
                <p>BOLETA DE PAGO</p>
            </div>
            <div class="fecha">
                Del {{$f_i}}  al  {{$f_f}}
            </div>


        </div>
        <hr >
        <H5 style="padding: 0px;margin: 0px;font-size: 14px;letter-spacing: 0.2em"><STRONG>{{$maestro->NOMBRE}}</STRONG></H5>
        <table style="margin: 0px;padding: 0px;" id="details">
            <tr>
                <td>Código:</td>
                <td>{{$maestro->CODIGO}}</td>
                <td>N° Días Trabajados:</td>
                <?php
                $d_trabajador =  $item->where('MOVIMIENTO','52500')->first();
                if($d_trabajador != null){
                    $d_trabajador = $d_trabajador->VALOR;
                }ELSE{
                    $d_trabajador = '0.00';
                }
                //$d_trabajador = $d_trabajador->VALOR;
                ?>
                <td>{{number_format($d_trabajador, 2, '.', ',')}}</td>
                <td>N° Horas Trabajadas:</td>
                <?php $h_trabajadas = $item->where('MOVIMIENTO','70060')->first();
                if($h_trabajadas != null){
                    $h_trabajadas = $h_trabajadas->VALOR;
                }ELSE{
                    $h_trabajadas = 0;
                }
                ?>
                <td>{{number_format($h_trabajadas, 2, '.', ',')}}</td>
            </tr>
            <tr>
                <td>D.N.I / C.E.</td>
                <td>{{$maestro->DNI}}</td>
                <?php $d_nocturno = $item->where('MOVIMIENTO','52200')->first();
                if($d_nocturno != null){
                    $d_nocturno = $d_nocturno->VALOR;
                }ELSE{
                    $d_nocturno = '0.00';
                }
                ?>
                <td>N° Días Nocturno:</td>
                <td>{{number_format($d_nocturno, 2, '.', ',')}}</td>
                <td>N° Horas Extras 25%:</td>
                <?php $temp = $item->where('MOVIMIENTO','20101')->first();
                if($temp != null){
                    $temp = $temp->VALOR;
                }ELSE{
                    $temp = '0.00';
                }
                ?>
                <td>{{number_format($temp, 2, '.', ',')}}</td>
            </tr>
            <tr>
                <td>Categoria:</td>
                <td>{{$maestro->CATEGORIA}}</td>
                <td>Fecha Termino:</td>
                <?php $fecha_i = $item->where('MOVIMIENTO','131')->first();

                $fecha_i = explode('.', $fecha_i->VALOR);
                $fecha_i = $fecha_i[0];
                $fecha_i = substr($fecha_i, 6, 2).'/'.substr($fecha_i, 4, 2).'/'.substr($fecha_i, 0, 4);
                ?>
                <td>{{$fecha_i}}</td>
                <td>N° Horas Extras 35%:</td>
                <?php $temp = $item->where('MOVIMIENTO','20102')->first();
                if($temp != null){
                    $temp = $temp->VALOR;
                }ELSE{
                    $temp = '0.00';
                }
                ?>
                <td>{{$temp}}</td>
            </tr>
            <tr>
                <td>Cargo:</td>
                <td>{{$maestro->CARGO}}</td>
                <td>N° Dias Descanso Medico:</td>
                <?php $h_trabajadas = $item->where('MOVIMIENTO','20104')->first();
                if($h_trabajadas != null){
                    $h_trabajadas = $h_trabajadas->VALOR;
                }ELSE{
                    $h_trabajadas = 0;
                }
                ?>
                <td>{{number_format($h_trabajadas, 2, '.', ',')}}</td>
                <td>N° Horas Extras 100%:</td>
                <?php $temp = $item->where('MOVIMIENTO','20103')->first();
                if($temp != null){
                    $temp = $temp->VALOR;
                }ELSE{
                    $temp = '0.00';
                }
                ?>
                <td>{{number_format($temp, 2, '.', ',')}}</td>
            </tr>
            <tr>
                <td>Fecha Ingreso:</td>
                <?php $fecha_i = $item->where('MOVIMIENTO','130')->first();

                $fecha_i = explode('.', $fecha_i->VALOR);
                $fecha_i = $fecha_i[0];
                $fecha_i = substr($fecha_i, 6, 2).'/'.substr($fecha_i, 4, 2).'/'.substr($fecha_i, 0, 4);
                ?>
                <td>{{$fecha_i}}</td>
                <td>N° Dias Subcidio Enfermed.:</td>
                <?php $h_trabajadas = $item->where('MOVIMIENTO','20105')->first();
                if($h_trabajadas != null){
                    $h_trabajadas = $h_trabajadas->VALOR;
                }ELSE{
                    $h_trabajadas = 0;
                }
                ?>
                <td>{{number_format($h_trabajadas, 2, '.', ',')}}</td>
                <td>N° Horas Noche:</td>
                <?php $temp = $item->where('MOVIMIENTO','20106')->first();
                if($temp != null){
                    $temp = $temp->VALOR;
                }ELSE{
                    $temp = '0.00';
                }
                ?>
                <td>{{$temp}}</td>
            </tr>
            <tr>
                <td>A.F.P.</td>
                <td>{{$maestro->AFP}}</td>
                <td>N°Dias Subcidio Maternidad:</td>
                <?php $h_trabajadas = $item->where('MOVIMIENTO','20109')->first();
                if($h_trabajadas != null){
                    $h_trabajadas = $h_trabajadas->VALOR;
                }ELSE{
                    $h_trabajadas = 0;
                }
                ?>
                <td>{{number_format($h_trabajadas, 2, '.', ',')}}</td>
                <td>F. Inicio Vacaciones:</td>
                <?php $temp = $item->where('MOVIMIENTO','6002')->first();
                if($temp != null){
                    $temp = $temp->VALOR;
                    $temp = explode('.', $temp);
                    $temp = $temp[0];
                    $temp = substr($temp, 6, 2).'/'.substr($temp, 4, 2).'/'.substr($temp, 0, 4);

                }ELSE{
                    $temp = '-';
                }
                ?>
                <td>{{$temp}}</td>
            </tr>
            <tr>
                <td>T. Trabajador</td>
                <td>{{$maestro->T_TRABAJADOR}}</td>
                <td>N°Dias Vacaciones:</td>
                <?php $temp = $item->where('MOVIMIENTO','110899')->first();
                if($temp != null){
                    $temp = $temp->VALOR;
                }ELSE{
                    $temp = '0.00';
                }
                ?>
                <td>{{number_format($temp, 2, '.', ',')}}</td>
                <td>F. Final Vacaciones:</td>
                <?php $temp = $item->where('MOVIMIENTO','6003')->first();
                if($temp != null){
                    $temp = $temp->VALOR;
                    $temp = explode('.', $temp);
                    $temp = $temp[0];
                    $temp = substr($temp, 6, 2).'/'.substr($temp, 4, 2).'/'.substr($temp, 0, 4);

                }ELSE{
                    $temp = '-';
                }
                ?>
                <td>{{$temp}}</td>
            </tr>
        </table>
        <HR>

        <?php
        //aca se hallará lacantiad de descuentos e ingresos
        $ingresos = $item->where('TIPO_MOVTO','H');
        $descuentos = $item->where('TIPO_MOVTO','D');
        ?>

        <table id="detail2">
            <tr>
                <td style="letter-spacing: 0.2em"><strong>INGRESOS</strong></td>
                <td style="letter-spacing: 0.2em"><strong>DESCUENTOS</strong></td>
                <td colspan="2" style="letter-spacing: 0.2em"><strong>APORTACIONES</strong></td>
            </tr>
            <tr>
                <td>
                    <table id="sub_ingreso">
                        @foreach($ingresos as $i)
                            <tr>
                                <td>{{$i->DESCRIPCION}}</td>
                                <td>{{number_format($i->VALOR,2,'.','')}}</td>

                            </tr>
                        @endforeach
                    </table>
                </td>
                <td >
                    <table id="sub_descuento">
                        @foreach($descuentos as $i)
                            <tr>
                                <td>{{$i->DESCRIPCION}}</td>
                                <td>{{number_format($i->VALOR,2,'.','')}}</td>

                            </tr>
                        @endforeach
                    </table>

                </td>
                <td>
                    ESSALUD
                </td>
                <?php $temp = $item->where('MOVIMIENTO','10804')->first();
                if($temp != null){
                    $temp = $temp->VALOR;
                }ELSE{
                    $temp = '0.00';
                }
                ?>
                <td class="monto_essalud">{{ number_format($temp,2,'.','')}}</td>

            </tr>
        </table>

        <div class="foot">
            <hr>
            <table id="tab_foot">
                <tr>
                    <td>Total Ingresos</td>
                    <?php $temp = $item->where('MOVIMIENTO','10')->first();
                    if($temp != null){
                        $temp = $temp->VALOR;
                    }ELSE{
                        $temp = '0.00';
                    }
                    ?>
                    <td >{{ number_format($temp,2,'.','')}}</td>

                    <td>Total Descuento:</td>
                    <?php $temp = $item->where('MOVIMIENTO','11')->first();
                    if($temp != null){
                        $temp = $temp->VALOR;
                    }ELSE{
                        $temp = '0.00';
                    }
                    ?>
                    <td >{{ number_format($temp,2,'.','')}}</td>
                    <td>Total Aportes:</td>
                    <?php $temp = $item->where('MOVIMIENTO','10804')->first();
                    if($temp != null){
                        $temp = $temp->VALOR;
                    }ELSE{
                        $temp = '0.00';
                    }
                    ?>
                    <td >{{ number_format($temp,2,'.','')}}</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><strong style="letter-spacing: 0.1em">NETO A PAGAR (E):</strong></td>
                    <?php $temp = $item->where('MOVIMIENTO','99005')->first();
                    if($temp != null){
                        $temp = $temp->VALOR;
                    }ELSE{
                        $temp = '0.00';
                    }

                    if($temp!='0.00'){
                        $let =  \sirag\Helpers\NumberToLetter::convert(number_format($temp,2,'.',''));
                    }else{
                        $let = 'cero con 00/100 soles';
                    }


                    ?>
                    <td >{{ number_format($temp,2,'.','')}} </td>
                </tr>

            </table>
            <hr>
            <span class="importe_letras"><strong>Son: {{$let}}</strong></span>
        </div>

        <div class="firmas" width="100%">
            <div class="firma_k">
                <img src="{{asset('img/Firma_RRHH.jpg')}}" alt="">
            </div>
            <div class="kai">
                KAI KROGH FLORES <BR>
                GERENTE GENERAL <BR>
                AGRO EXPORTACIONES GRACE S.A.C
            </div>

            <div class="trabajador">
                V°B° Trabajador
            </div>

        </div>


    </div>

    <div class="page-break"></div>
@endforeach



</body>


<style>

    body{
        font-size: 12px
    }

    .boleta{
        height: 450px;
        /*background-color: grey;*/
        position: relative;
    }
    .title  p{
        font-size: 16px;
        text-align: center;
        font-weight: bold;
    }
    .subTitle{
        font-size: 11px;
        text-align: center;
    }

    hr{
        size: 2px;
        border-style: solid;
        border-width: 0px 0px 1px 0px;
        margin:0px;
    }
    table{
        border-collapse:collapse;
        border: none;
    }

    #detail2{
        font-size: 14px;
    }

    #detail2 tr:nth-child(1) td:nth-child(3) {
        padding-left: 60px;

    }

    #detail2 tr:nth-child(2) td {

        padding: 0;
        margin: 0;
        vertical-align: top;

    }

    #detail2 tr:nth-child(2) .monto_essalud  {
        text-align: right;
        width: 140px;

    }

    #detail2 tr:nth-child(2) td:nth-child(3) {
        text-align: right;
        width: 120px;
    }



    #details{
        font-size: 13.5px;
    }

    #details tr td:nth-child(2) {

        width: 180px;
        text-align: left;
    }

    #details tr td:nth-child(3) {

        padding-left: 60px;
    }

    #details tr td:nth-child(4) {

        width: 80px;
        text-align: right;
        padding-right: 80px;
    }

    #details tr td:nth-child(6) {
        width: 60px;
        text-align: right;
    }

    .espacio{
        width: 100%;
        height: 215px;
    }


    .foot{
        position: absolute;
        top:380px;
        width: 100%;
    }

    .firmas{

        position: absolute;
        top: 460px;
    }
    .firmas .firma_k{

        position: absolute;
        top: -20px;
        left: 120px;
    }

    .firmas .firma_k img{

       width: 150px;
    }

    .firmas .kai{


        position: absolute;
        top: 50px;
        left: 80px;
        text-align: center;
        font-size: 9px;
        border-top: solid 1px black;
        width: 250px;


     }

    .firmas .trabajador{

        width: 180px;
        position: absolute;
        top: 50px;
        left: 550px;
        text-align: center;
        font-size: 9px;
        border-top: solid 1px black;

    }


    #tab_foot{
        font-size: 14px;
        border-collapse:collapse;
        border: none;
    }

    #tab_foot tr td:nth-child(1){
        width: 180px;
        padding-right: 70px;
    }
    #tab_foot tr td:nth-child(2){
        width: 50px;
        text-align: right;
        padding-right: 20px;
    }
    #tab_foot tr td:nth-child(3){
        width: 180px;
        padding-right: 30px;
    }
    #tab_foot tr td:nth-child(4){
        width: 50px;
        text-align: right;
        padding-right: 30px;
    }
    #tab_foot tr td:nth-child(5){
        width: 160px;
        padding-left: 40px;
    }
    #tab_foot tr td:nth-child(6){
        width: 50px;
        text-align: right;
    }

    #sub_ingreso tr td:nth-child(2) {

        width: 120px;
        text-align: right;
        padding-right: 30px;

    }

    #sub_descuento{
        margin: 0;
        padding: 0;
    }

    #sub_descuento tr td:nth-child(1) {
        width: 135px;
        text-align: left;
        padding-right: 15px;
    }

    #sub_descuento tr td:nth-child(2) {
        width: 100px;
        text-align: right;
        padding-right: 15px;
    }

    .title{
        width: 100%;
        position: relative;
    }

    .title .logo img{
        width: 60px;
        height: 40px;
    }
    .title .razon{
        font-size: 8px;
        position: absolute;
        top: 5px;
        left: 62px;
    }

    .title .titulo{
        margin: 0;
        padding: 0;
        position: absolute;
        top: -10px;
        left: 352px;

        width: 145px;
    }
    .title .fecha{
        font-size: 14px;
        position: absolute;
        top: 28px;
        right: 12px;
    }


    @page {
        margin-top: 0.5cm;
        margin-bottom: 0.2cm;
    }

    @media print {
        body {
            margin-top: 50mm;
            margin-bottom: 50mm;
            margin-left: 0mm;
            margin-right: 0mm}
    }


    .page-break {
        page-break-after: always;
    }


</style>


</html>