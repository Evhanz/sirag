<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport">
    <title>Document</title>
</head>
<body>

<div class="title">
    <p>LIQUIDACION DE BENEFICIOS SOCIALES</p>
</div>
<div class="subTitle">
    {periodo}
</div>

<hr >
<H3><STRONG>DATOS DEL EMPLEADOR</STRONG></H3>

<!--fila 1  -->
<div class="row1">
    <div class="row1_left">
        <span>NOMBRE DEL EMPLEADOR</span><br>
        <span>RUC</span><br>
        <span>DIRECCION</span>
    </div>

    <div class="row1_rigth">
        <span>AGRO EXPORTACIONS GRACE S.A.C.</span><br>
        <span>20516603078</span><br>
        <span>AV. RAMON CASTILLA 688 OFC 305 - URB. LA AURORA</span>
    </div>

</div>


<!-- fila 2 -->

<div class="row_2">
    <H3><STRONG>DATOS DEL TRABAJADOR</STRONG></H3>

    <table>
        <tr>
            <td>APELLIDO Y NOMBRES</td>
            <td>:</td>
            <td colspan="6">{CAMPO VERDE RIVERA, EDUARDO}</td>
        </tr>
        <tr>
            <td>DNI / CE</td>
            <td>:</td>
            <td><span>{44786412}</span></td>
            <td>FECHA DE INGRESO</td>
            <td>:</td>
            <td>19/09/2016</td>
        </tr>
        <tr>
            <td>CATEGORIA</td>
            <td>:</td>
            <td><span>OPERARIO</span></td>
            <td>FECHA DE TERMINO</td>
            <td>:</td>
            <td>19/09/2016</td>

        </tr>
        <tr>
            <td>CARGO</td>
            <td>:</td>
            <td>OPERARIO AGRARIO </td>
            <td>MOTIVO DEL CESE</td>
            <td>:</td>
            <td>RENUNCIA</td>
        </tr>
        <tr>
            <td colspan="5"> &nbsp; </td>
            <td>Años</td>
            <td>:</td>
            <td>0.00</td>
        </tr>
        <tr>
            <td colspan="5"> &nbsp; </td>
            <td>Meses</td>
            <td>:</td>
            <td>0.00</td>
        </tr>
        <tr>
            <td colspan="5"> &nbsp; </td>
            <td>Días</td>
            <td>:</td>
            <td>0.00</td>
        </tr>
    </table>

</div>



<hr>
<!--Fila 3-->
<strong>REMUNERACION COMPUTABLE(AGRARIO)</strong>

<div class="row_3">
    <table>
        <tr>
            <td><strong>Movimiento </strong></td>
            <td><strong>Valor</strong></td>
        </tr>
        <tr>
            <td>CTS LEY 27360 </td>
            <td class="valor">36.00</td>
        </tr>
        <tr>
            <td>REMUNERACION BASICA (TC) </td>
            <td class="valor">850.00</td>
        </tr>
        <tr>
            <td>ASIGNACION FAMILIAR (TC)</td>
            <td class="valor">0.00</td>
        </tr>
        <tr>
            <td>GRATIFICACION LEY 27360 </td>
            <td class="valor">109.00</td>
        </tr>

        <tr>
            <td><strong>TOTAL, REMUNERCION COMPUTABLE</strong> &nbsp;&nbsp;&nbsp; </td>
            <td class="sub_total"><strong>995.00</strong></td>
        </tr>

    </table>
</div>

<hr>
<!--Fila 4-->
<strong>INGRESOS</strong><br>

<table class="tbl_row4">
    <tr>
        <td colspan="8"><strong>VACACIONES TRUNCAS</strong></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>Por</td>
        <td>1</td>
        <td>Meses,</td>
        <td>29</td>
        <td>Días</td>
        <td class="space_1"> -------></td>
        <td class="valor">139.5</td>
    </tr>
    <tr>
        <td colspan="8"><strong>VACACIONES GOZADAS</strong></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>Por</td>
        <td>1</td>
        <td>Meses,</td>
        <td>29</td>
        <td>Días</td>
        <td class="space_1">-------></td>
        <td class="valor">139.5</td>
    </tr>
    <tr>
        <td colspan="4"><strong>TOTAL, INGRESOS</strong></td>
        <td colspan="3">&nbsp;</td>
        <td class="sub_total">139.5</td>
    </tr>
</table>

<br>
<strong>DEDUCCIONES</strong><br>
<table class="tbl_row41">
    <tr>
        <td colspan="2">ONP (TC)</td>
        <td>:</td>
        <td class="valor">18.14</td>
    </tr>
    <tr>
        <td colspan="2">FONDO AFP (TC)</td>
        <td>:</td>
        <td class="valor">0.00</td>
    </tr>
    <tr>
        <td colspan="2">COMISION AFP (TC)</td>
        <td>:</td>
        <td class="valor">0.00</td>
    </tr>
    <tr>
        <td colspan="2">SEGURO AFP (TC)</td>
        <td>:</td>
        <td class="valor">0.00</td>
    </tr>
    <tr>
        <td><strong>TOTAL, DEDUCCIONES</strong></td>
        <td class="space_1"><strong>---------------></strong></td>
        <td>&nbsp;</td>
        <td class="valor">18.14</td>
    </tr>
</table>
<hr>

<div style="clear-after: both;">

    <div class="row1_left neto_title">
        <strong>NETO A LIQUIDAR (Nuevos Soles)</strong>
    </div>


    <div class="row1_rigth neto_liquidar">
        121.36
    </div>

</div>
<br>
<hr>


{monto en nombre}


<table>

</table>

</body>


<style>

    body{
        font-size: 12px;
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
        size: 1px;
        border-style: solid;
        border-width: 0px 0px 0.3px 0px;
    }


    .row1_left{

        width: 200px;
        /*background-color: #00a65a;*/
        float: left;

    }
    .row1_rigth{
        width: 320px;
       /* background-color: red;*/
        float: left;

    }

    .row1{
        position: relative;
    }

    .row_2{
        clear: both;
    }

    .sub_total{
        border-top: 1px solid black;
    }




    .tbl_row4 tr .space_1{

        border-right-width: 50px;
        border-right-style: solid;
        border-right-color: white;
        border-left-width: 5px;
        border-left-style: solid;
        border-left-color: white;
    }

    .tbl_row41 tr .space_1{

        border-right-width: 25px;
        border-right-style: solid;
        border-right-color: white;
        border-left-width: 5px;
        border-left-style: solid;
        border-left-color: white;
    }

    table{
        margin-left: 10px;
    }

    table tr .valor{
        text-align: right;
    }

    .neto_title{
        border-right-width: 60px;
        border-right-style: solid;
        border-right-color: white;
    }



</style>


</html>