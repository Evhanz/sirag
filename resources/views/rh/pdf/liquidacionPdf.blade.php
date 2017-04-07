<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport">
    <title>Document</title>
</head>
<body>


@foreach($data as $item)

    <div class="title">
        <p>LIQUIDACION DE BENEFICIOS SOCIALES</p>
    </div>
    <div class="subTitle">
        {{$item->periodo}}
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
                <td colspan="6">{{$item->NOMBRE}}</td>
            </tr>
            <tr>
                <td>DNI / CE</td>
                <td>:</td>
                <td><span>{{$item->DNI}}</span></td>
                <td>FECHA DE INGRESO</td>
                <td>:</td>
                <td>{{$item->FECHA_INICIO}}</td>
            </tr>
            <tr>
                <td>CATEGORIA</td>
                <td>:</td>
                <td><span>{{$item->CAT}}</span></td>
                <td>FECHA DE TERMINO</td>
                <td>:</td>
                <td>{{$item->FECHA_TERMINO}}</td>

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
                <td>{{$item->anio_contratado}}</td>
            </tr>
            <tr>
                <td colspan="5"> &nbsp; </td>
                <td>Meses</td>
                <td>:</td>
                <td>{{$item->mes_contratado}}</td>
            </tr>
            <tr>
                <td colspan="5"> &nbsp; </td>
                <td>Días</td>
                <td>:</td>
                <td>{{$item->dias_contratado}}</td>
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
                <td>REMUNERACION BASICA (TC) </td>
                <td class="valor">{{ $item->SUELDO  }}</td>
            </tr>
            <tr>
                <td>ASIGNACION FAMILIAR (TC)</td>
                <td class="valor">{{ $item->ASIG_FAMILIAR  }}</td>
            </tr>
            <tr>
                <td>GRATIFICACION LEY 27360 </td>
                <td class="valor">{{ $item->GRATI_LEY_27360  }}</td>
            </tr>
            <tr>
                <td>CTS LEY 27360 </td>
                <td class="valor">{{ $item->CTS_LEY_27360  }}</td>
            </tr>

            <tr>
                <td><strong>TOTAL, REMUNERCION COMPUTABLE</strong> &nbsp;&nbsp;&nbsp; </td>
                <td class="sub_total"><strong>{{ $item->total_remune  }}</strong></td>
            </tr>

        </table>
    </div>

    <hr>
    <!--Fila 4-->
    <strong>INGRESOS</strong><br>

    <table class="tbl_row4" >
        <tr>
            <td colspan="8"><strong>VACACIONES TRUNCAS</strong></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>Por</td>
            <td>{{$item->mes_VT}}</td>
            <td>Meses,</td>
            <td>{{$item->dias_VT}}</td>
            <td>Días</td>
            <td class="space_1"> -------></td>
            <td class="valor">{{$item->VT}}</td>
        </tr>
        <tr>
            <td colspan="8" ><strong>VACACIONES GOZADAS</strong></td>
            <td  style="padding-left: 80px; width:250px"><strong>FALTAS EN EL PERIODO</strong></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>Por</td>
            <td>{{$item->mes_VG}}</td>
            <td>Meses,</td>
            <td>{{$item->dias_VG}}</td>
            <td>Días</td>
            <td></td>
            <td></td>
            <td style="padding-left: 80px; width:250px">Por -----> {{$item->DIAS_FALTAS}}</td>
            
        </tr>
        <tr>
            <td colspan="4"><strong>TOTAL, INGRESOS</strong></td>
            <td colspan="3">&nbsp;</td>
            <td class="sub_total">{{$item->VT}}</td>
        </tr>
    </table>

    <br>
    <strong>DEDUCCIONES</strong><br>
    <table class="tbl_row41">
        <tr>
            <td colspan="2">ONP (TC)</td>
            <td>:</td>
            <td class="valor">{{ $item->ONP  }}</td>
        </tr>
        <tr>
            <td colspan="2">FONDO AFP (TC)</td>
            <td>:</td>
            <td class="valor">{{$item->FONDO}}</td>
        </tr>
        <tr>
            <td colspan="2">COMISION AFP (TC)</td>
            <td>:</td>
            <td class="valor">{{$item->COMISION_AFP}}</td>
        </tr>
        <tr>
            <td colspan="2">SEGURO AFP (TC)</td>
            <td>:</td>
            <td class="valor">{{$item->SEGURO_AFP}}</td>
        </tr>
        <tr>
            <td><strong>TOTAL, DEDUCCIONES</strong></td>
            <td class="space_1"><strong>---------------></strong></td>
            <td>&nbsp;</td>
            <td class="valor valor_deducciones">{{$item->deducciones}}</td>
        </tr>
    </table>
    <hr>

    <div style="clear-after: both;">

        <div class="row1_left neto_title">
            <strong>NETO A LIQUIDAR (Nuevos Soles)</strong>
        </div>


        <div class="row1_rigth neto_liquidar">
            {{$item->neto}}
        </div>

    </div>
    <br>
    <hr>

    SON:  {{$item->monto}}

    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <table class="firmas">
        <tr class="lineas">
            <td class="linea"> &nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td class="linea">&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr class="concepto">
            <td class="linea"> V°B° EMPLEADOR</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td class="linea">V°B° TRABAJADOR</td>
            <td>&nbsp;</td>
        </tr>
    </table>

    <div class="page-break"></div>

@endforeach



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

    .firmas .lineas td{
        width: 170px;
    }

    .firmas .lineas .linea{
        border-bottom: 1px solid black;
    }

    .firmas .concepto .linea{
        text-align: center;
    }


    hr{
        size: 1px;
        border-style: solid;
        border-width: 0px 0px 0.3px 0px;
    }

    .neto_liquidar{
        margin-left: 20px;
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

        border-right-width: 40px;
        border-right-style: solid;
        border-right-color: white;
        border-left-width: 5px;
        border-left-style: solid;
        border-left-color: white;

    }

    .tbl_row41 tr .valor_deducciones{

        border-top: 1px solid black;

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

    .page-break {
        page-break-after: always;
    }


</style>


</html>