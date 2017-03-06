<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport">
    <title>Document</title>
</head>
<body>

<div class="cabecera">
    <div class="cabecera_left">

        AGRO EXPORTACIONES S.A.C. <br>
        AGRICOLA <br>
        AV. RAMON CASTILLA 688 OFC 305 - URB. LA AURORA MIRAFLORES LIMA
    </div>
    <div class="cabecera_RIGTH">

        <table>
            <tr>
                <td>Página</td>
                <td>:</td>
                <td>1.0</td>
            </tr>
            <tr>
                <td>Fecha Emision</td>
                <td>:</td>
                <td>{{$fecha_actual}} </td>

            </tr>

        </table>

    </div>
</div>


<div class="title">

    <p>LIBRO DE RETENCIONES</p>
</div>

<div class="row2" style="clear:both">

   <div id="fecha">
       <strong>Mes: </strong> <span>{{$mes}}</span>   <strong>Año: </strong> <span>{{$anio}}</span>
   </div>

</div>

<div class="detail">
    <table class="tbl_detail">
        <tr>
            <th>F. Pago</th>
            <th>T.D.</th>
            <th>N° Documento de identidad</th>
            <th>Apellidos y Nombres</th>
            <th>N° Retencion</th>
            <th>Monto Bruto</th>
            <th>Ret. Efectuada</th>
            <th>Monto Neto</th>
        </tr>
        <?php $t_bruto=0;$t_retencion=0;$t_neto=0; ?>
        @foreach($res as $item)
            <tr>
                <td>{{$item->c4}}</td>
                <td>6</td>
                <td>{{$item->c5}}</td>
                <td>{{$item->c7}}</td>
                <td>001-{{$item->c3}}</td>
                <td>{{ round($item->c20,2) }}</td>
                <td>{{ round($item->c22,2) }}</td>
                <td>{{ round($item->c24,2) }}</td>
            </tr>

            <?php   $t_bruto += round($item->c20,2);
                    $t_retencion += round($item->c22,2);
                    $t_neto += round($item->c24,2); ?>
        @endforeach

        <tr class="resultado">
            <td colspan="4">&nbsp;</td>
            <td>TOTAL:</td>
            <td>{{$t_bruto}}</td>
            <td>{{$t_retencion}}</td>
            <td>{{$t_neto}}</td>


        </tr>

    </table>
</div>








</body>


<style>

    body{
        font-size: 12px;
    }


    .cabecera{

        font-family: "Courier New", Courier, monospace;
        font-size: 10px;

    }

    .cabecera_left{


        width: 500px;
        float: left;

    }

    .cabecera_RIGTH{

        right: 30px;
       /* width: 200px;*/
       /* float: left;*/
        position: absolute;

    }

    .firma{
        width: 300px;
        font-weight: bold;
        text-align: center;
        border-top: 1px solid black;
        position: absolute;
        bottom: 80px;
        right: 0px;
    }

    .row1 table tr td{

        padding-right: 80px;
    }

    .row2 div {
        text-align: center;
    }


    .row3{
        display: inline-block;
    }
    .row3 ul{
        width: 120px;
        padding: 10px;
        margin: 10px;
        float: left;
        list-style: none;
        text-align: center;
    }

    .row3 ul li:first-child{
        border-top: 1px solid black;
    }
    .row3 ul li{
        border-bottom: 1px solid black;
        border-left: 1px solid black;
        border-right: 1px solid black;
    }


    .subTitle table{

        float: right;
    }
    .subTitle table:after{
        clear: both;
    }

    .subTitle:after {

        clear: both;
    }

    table .valor .cantidad{
        margin-left: 30px;
    }

    table .valor .monto{

        border: 2px solid black;
        padding: 5px;
    }

    .detail{
        width: 100%;
    }
    .detail .tbl_detail{
        width: 100%;
    }

    .tbl_detail{
        margin-top: 20px;
        border-collapse: collapse;
    }

    .tbl_detail tr th {

        border-top:0.8pt solid black;
        border-bottom:0.8pt solid black;
        text-align: center;
        padding-top: 20px;

    }

    .tbl_detail tr td {

        text-align: center;
        font-family: "Courier New", Courier, monospace;
        padding-top: 4px;

    }

    .tbl_detail tr .monto {

        text-align: right;
    }

    .tbl_detail .resultado td {
        /* styles */
        border-top:0.5pt solid black;
    }

    .title{
        text-align: center;
        margin-top: 80px;
        font-weight: bold;
        padding-top: 35px;
    }

    .title p{

        font-size: 16px;

    }



    @page {
        margin-top: 0.3cm;
        margin-bottom: 1cm;
        margin-left: 0.2cm;
        margin-right: 0.1cm;
    }

    @media print {
        body {
            margin-top: 50mm;
            margin-bottom: 50mm;
            margin-left: -10mm;
            margin-right: -10mm}
    }


</style>


</html>