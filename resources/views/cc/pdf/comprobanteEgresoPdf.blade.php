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
                CAL.EUCHAIZ NRO. 170 DPTO. 401 URB. LA FLORESTA-SANTIAGO DE SURCO - LIMA
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
                   <td>{{$res[0]->fecha_actual}}</td>

               </tr>

           </table>

        </div>
    </div>


    <div class="title">

        <p>COMPROBANTE DE EGRESO: {{$res[0]->CORRELATIVO}}</p>
    </div>
    <div class="subTitle">
        <table>
            <tr>
                <td>T. CAMBIO:</td>
                <td>&nbsp;</td>
            </tr>
            <tr class="valor">
                <td>&nbsp;</td>
                <td class="monto"> <span class="moneda">S/.</span> <span class="cantidad">{{$totales->t_haber_s}}</span></td>
            </tr>
        </table>
    </div>



    <div class="row1" style="clear:both">
        <table>
            <tr>
                <td>FECHA:</td>
                <td colspan="3"> {{$res[0]->FECHA}}</td>
            </tr>
            <tr>
                <td style="width: 90px">GIRADO A:</td>
                <td style="width: 250px">{{$res[0]->GIRADO_A}}</td>
                <td>RUC/DNI:</td>
                <td></td>
            </tr>
        </table>
    </div>

    <div class="detail">
        <table class="tbl_detail">
            <tr>
                <th>CUENTA</th>
                <th>DOCUMENTO</th>
                <th>NRO.</th>
                <th>PROVEEDOR</th>
                <th>DEBE $</th>
                <th>HABER $</th>
                <th>DEBE S/.</th>
                <th>HABER S/.</th>
            </tr>

               <?php $banco = ''; ?>
            @foreach($res as $item)
            <tr>
                <td>{{$item->CUENTA}}</td>
                @if($item->BANCO != null)
                    <td>CHEQUE</td>
                    <td>{{$item->N_CHEQUE}}</td>
                    <?php $banco = $item->BANCO; ?>

                @else
                    <td></td>
                    <td></td>
                @endif

                <td>{{$item->PROVEEDOR}}</td>
                <td class="monto">{{$item->DEBE_DOLAR}}</td>
                <td class="monto">{{$item->HABER_DOLAR}}</td>
                <td class="monto">{{$item->DEBE_S}}</td>
                <td class="monto">{{$item->HABER_S}}</td>
            </tr>
            @endforeach

            <tr class="resultado">
                <td colspan="6">&nbsp;</td>
                <td class="monto">{{$totales->t_haber_s}}</td>
                <td class="monto">{{$totales->t_debe_s}}</td>
            </tr>

        </table>
    </div>

    <br><br><br><br>

    <div class="row2">
        <table>
            <tr>
                <td> <strong>CONCEPTO:</strong> </td>
                <td> PAGO CON CHEQUE</td>
            </tr>
            <tr>
                <td><strong> N° CHEQUE/OPERACION: </strong></td>
                <td >{{$res[0]->N_CHEQUE}}</td>
                <td> <strong> BANCO: </strong></td>
                <td>{{$banco}}</td>
            </tr>
        </table>

    </div>

    <div class="row3">
        <ul>
            <li><strong>PREPARADO</strong></li>
            <li>{{$res[0]->usuario}}</li>
        </ul>
        <ul>
            <li><strong>APROBADO</strong></li>
            <li>&nbsp;</li>
        </ul>
        <ul>
            <li><strong>CONTABILIZADO</strong></li>
            <li>&nbsp;</li>
        </ul>
    </div>


    <div class="firma">
        FIRMA RECIBIDO
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


        width: 200px;
        float: left;

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



    @page {
        margin-top: 0.3cm;
        margin-bottom: 1cm;
    }

    @media print {
        body {
            margin-top: 50mm;
            margin-bottom: 50mm;
            margin-left: 0mm;
            margin-right: 0mm}
    }


</style>


</html>