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
                   <td>04/01/2017</td>

               </tr>

           </table>

        </div>
    </div>


    <div class="title">

        <p>COMPROBANTE DE EGRESO</p>
    </div>
    <div class="subTitle">
        <table>
            <tr>
                <td>T. CAMBIO:</td>
                <td>&nbsp;</td>
            </tr>
            <tr class="valor">
                <td>&nbsp;</td>
                <td class="monto"> <span class="moneda">S/.</span> <span class="cantidad">116.14</span></td>
            </tr>
        </table>
    </div>



    <div class="row1" style="clear: both">
        <table>
            <tr>
                <td>FECHA:</td>
                <td colspan="3"> 10/12/2016</td>
            </tr>
            <tr>
                <td>GIRADO A:</td>
                <td>{GLOSA DE GIRADO A ALGUIEN}</td>
                <td>RUC/DNI:</td>
                <td>{78986545}</td>
            </tr>
        </table>
    </div>





    <div class="page-break"></div>

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

    .subTitle table{
        float: right;
        margin-left: -200px;
    }


    .title{
        text-align: center;
        margin-top: 80px;
        font-weight: bold;
        padding-top: 35px;
    }

    table .valor .cantidad{
        margin-left: 30px;
    }

    table .valor .monto{

        border: 2px solid black;
        padding: 5px;
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