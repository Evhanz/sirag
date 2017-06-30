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
    $maestro = [0];
    ?>

    <div class="boleta">
        <div class="title">
            <div class="l$itemogo">
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
        <p>
        <H5 style="padding: 0px;margin: 0px;font-size: 14px;letter-spacing: 0.2em">TRABAJADOR: <STRONG>{{$maestro->NOMBRE}}</STRONG></H5>
        </p>

        <table style="margin: 0px;padding: 0px;" id="details">
            <tr>
                <td valign="top">
                    <table style="margin: 0;padding: 0;" class="details_1">
                        <tr>
                            <td><strong>Concepto</strong></td>
                            <td><strong>Descripcion</strong></td>
                        </tr>
                        <tr>
                            <td>Código:</td>
                            <td>{{$maestro->CODIGO}}</td>
                        </tr>
                        <tr>
                            <td>D.N.I / C.E.</td>
                            <td>{{$maestro->DNI}}</td>
                        </tr>
                        <tr>
                            <td>Categoria:</td>
                            <td>{{$maestro->CATEGORIA}}</td>
                        </tr>
                        <tr>
                            <td>Cargo:</td>
                            <td>{{$maestro->CARGO}}</td>
                        </tr>
                        <tr>
                            <td>Fecha Ingreso:</td>
                            <?php $fecha_i = $item->where('MOVIMIENTO','130')->first();

                            $fecha_i = explode('.', $fecha_i->VALOR);
                            $fecha_i = $fecha_i[0];
                            $fecha_i = substr($fecha_i, 6, 2).'/'.substr($fecha_i, 4, 2).'/'.substr($fecha_i, 0, 4);
                            ?>
                            <td>{{$fecha_i}}</td>
                        </tr>
                        <tr>
                            <td>Fecha Termino:</td>
                            <?php $fecha_i = $item->where('MOVIMIENTO','131')->first();
                            $fecha_i = explode('.', $fecha_i->VALOR);
                            $fecha_i = $fecha_i[0];
                            $fecha_i = substr($fecha_i, 6, 2).'/'.substr($fecha_i, 4, 2).'/'.substr($fecha_i, 0, 4);
                            ?>
                            <td>{{$fecha_i}}</td>
                        </tr>
                        <tr>
                            <td>T. Trabajador</td>
                            <td>{{$maestro->T_TRABAJADOR}}</td>
                        </tr>
                        <tr >
                            <td>A.F.P.</td>
                            <td>{{$maestro->AFP}}</td>
                        </tr>
                        <tr >
                            <td>N° Dias Vac.</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr >
                            <td>F. Inicio Vac.</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr >
                            <td>F. Fin Vac.</td>
                            <td>&nbsp;</td>
                        </tr>
                    </table>
                </td>
                <td width="5px"></td>

                <td valign="top">
                    <table style="margin: 0px;padding: 0px;" class="details_2" >
                        <thead>

                        <tr>
                            <th colspan="9">DETALLE DE TAREO</th>
                        </tr>

                        <tr>
                            <th>TIPO</th>
                            <th>LUNES</th>
                            <th>MARTES</th>
                            <th>MIERCOLES</th>
                            <th>JUEVES</th>
                            <th>VIERNES</th>
                            <th>SABADO</th>
                            <th>DOMINGO</th>
                            <th>TOTAL</th>
                        </tr>

                        </thead>
                        <tbody>
                        <tr>
                            <td>SELECCION</td>
                            <td>1</td>
                            <td>2</td>
                            <td>3</td>
                            <td>4</td>
                            <td>5</td>
                            <td>8</td>
                            <td>19</td>
                            <td>60</td>
                        </tr>
                        <tr>
                            <td>PESAJE</td>
                            <td>1</td>
                            <td>2</td>
                            <td>3</td>
                            <td>4</td>
                            <td>5</td>
                            <td>8</td>
                            <td>19</td>
                            <td>60</td>
                        </tr>
                        <tr>
                            <td>EMBALAJE</td>
                            <td>1</td>
                            <td>2</td>
                            <td>3</td>
                            <td>4</td>
                            <td>5</td>
                            <td>8</td>
                            <td>19</td>
                            <td>60</td>
                        </tr>
                        <tr> <td>PESO FIJO</td>
                            <td>1</td>
                            <td>2</td>
                            <td>3</td>
                            <td>4</td>
                            <td>5</td>
                            <td>8</td>
                            <td>19</td>
                            <td>60</td>
                        </tr>
                        <tr>
                            <td COLSPAN="8"><strong>TOTAL</strong></td>
                            <td>180</td>
                        </tr>

                        </tbody>
                    </table>
                    <table class="firmas"  cellpadding="0" cellspacing="0">
                        <tr>
                            <th valign="bottom" scope="col">
                                as <br>
                                <hr>
                            </th>
                            <th width="14" scope="col">&nbsp;</th>
                            <th valign="bottom" scope="col"><hr></th>
                        </tr>
                        <tr>
                            <td align="center" scope="row">					KAI KROGH FLLORES <BR>
                                GERENTE GENERAL <BR> AGROEXPORTACIONES GRACE SAC</td>
                            <td>&nbsp;</td>
                            <td align="center">VB. TRABAJADOR</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <hr>

        <?php
        //aca se hallará lacantiad de descuentos e ingresos
        $ingresos = $item->where('TIPO_MOVTO','H');
        $descuentos = $item->where('TIPO_MOVTO','D');
        ?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_3">
            <thead>
            <tr>
                <th >INGRESOS</th>
                <th scope="col">DESCUENTOS</th>
                <th scope="col">APORTACIONES</th>
                <th scope="col">TOTALES</th>
            </tr>

            </thead>

            <tbody>

            <tr>
                <td >
                    <table id="sub_ingreso">
                        @foreach($ingresos as $i)
                            <tr>
                                <td>{{$i->DESCRIPCION}}</td>
                                <td>{{number_format($i->VALOR,2,'.','')}}</td>
                            </tr>
                        @endforeach
                    </table>
                </td>
                <td>
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
                    <table id="sub_descuento">
                        <tr>
                            <td>ESSALUD</td>

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
                </td>
                <td>
                    <table class="neto_pagar">
                        <tr>
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

                </td>
            </tr>
            <tr>
                <td>
                    <table class="total_ingreso">
                        <tbody>
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

                        </tr>

                        </tbody>

                    </table>

                </td>
                <td>
                    <table class="total_descuento">
                        <tr>
                            <td>Total Descuento:</td>
                            <?php $temp = $item->where('MOVIMIENTO','11')->first();
                            if($temp != null){
                                $temp = $temp->VALOR;
                            }ELSE{
                                $temp = '0.00';
                            }
                            ?>
                            <td >{{ number_format($temp,2,'.','')}}</td>

                        </tr>
                    </table>

                </td>
                <td>
                    <table class="total_descuento">
                        <tr>
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
                    </table>

                </td>

                <td>
                    <span class="importe_letras"><strong>Son: {{$let}}</strong></span>
                </td>



            </tr>

            </tbody>

        </table>


    </div>


    <br>
    <div class="espacio"></div>
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
        /*background-color: grey;*/
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

    .details_1{
        border: #000 1px solid;
    }

    .details_1 tr td{
        border: #333333 1px solid;
        padding: 1px 5px 1px 2px;
    }

    .details_1 tr:nth-child(1) td{
        width: 90px;
        background-color: #1b6d85;
        color: white;
    }

    .details_1 tr td:nth-child(2){
        width: 150px;
        text-align:right;
    }

    .details_2{
        border: #000000 1px solid;
    }

    .details_2 thead tr th{
        background-color: #1b6d85;
        color: white;
        padding: 2px;
    }

    .details_2 thead tr:nth-child(2) th{
        background-color: #799eb9 !important;
        color: white;
    }

    .details_2 tbody tr td{
        border: #333333 1px solid;
        text-align: center;
    }

    .details_2 tbody tr td:nth-child(1){

        text-align: left !important;
        padding: 2px;
    }


    .details_2 tr td{
        width: 70px;
    }

    .detail_3{
        border: #333 1px solid;
    }

    .detail_3 thead tr th{
        background-color:  #1b6d85;
        color: white;
        width: 25%;
        font-size: 10px;
        padding: 2px;

    }

    .detail_3 tbody tr td{
        font-size: 9px;
        vertical-align: top;
        border-right: #333 0.5px solid;
    }

    .detail_3 tbody tr:nth-child(1) td{
        height: 85px ;
    }

    .detail_3 tbody tr:nth-child(2) td{
        height: auto ;

    }

    .espacio{
        width: 100%;
        height: 215px;
    }

    .firmas{
        border: 0;
        margin-top: 15px;
        width: 100%;
    }

    .firmas tr td{
        width: 33%;
        font-size: 10px;
    }

    .importe_letras{
        font-size: 10px;
    }

    .neto_pagar{
        width: 100%;
        border: 0 !important;
    }

    .neto_pagar tr td{

        border: 0 !important;
    }



    #sub_ingreso tr td:nth-child(2){
        text-align: right;
        padding-right: 10px;
        border: #333 0px solid !important;
        height: auto !important;

    }

    #sub_ingreso tr td{

        border: #333 0px solid !important;
        height: auto !important;

    }

    #sub_ingreso {
        width: 100%;
    }

    #sub_descuento{
        width: 100%;
    }

    #sub_descuento tr td{

        border: #333 0px solid !important;

    }

    #sub_descuento tr td:nth-child(2){
        text-align: right;
        padding-right: 20px;
        border: #333 0px solid !important;

    }

    .total_ingreso{
        width: 100%;
        border-top: #333 1px solid;
    }


    .total_ingreso tbody tr td {

        border: 0px;

    }

    .total_ingreso tbody tr td:nth-child(2){

        border: 0px;
        text-align: right;
        padding-right: 10px;

    }

    .total_descuento{
        width: 100%;
        border-top: #333 1px solid;
    }

    .total_descuento tbody tr td {

        border: 0px;

    }

    .total_descuento tbody tr td:nth-child(2){

        border: 0px;
        text-align: right;
        padding-right: 10px;

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