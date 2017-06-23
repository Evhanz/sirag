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
                <td>
                    <table style="margin: 0px;padding: 0px;" class="details_1">
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
                    </table>
                </td>
                <td width="15px"></td>
                <td>
                    <table style="margin: 0px;padding: 0px;" class="details_2" >
                        <tr>
                            <td>TIPO</td>
                            <td>LUNES</td>
                            <td>MARTES</td>
                            <td>MIERCOLES</td>
                            <td>JUEVES</td>
                            <td>VIERNES</td>
                            <td>SABADO</td>
                            <td>DOMINGO</td>
                            <td>TOTAL</td>
                        </tr>
                        <tr>
                            <td>SELECCION</td>
                        </tr>
                        <tr>
                            <td>PESAJE</td>
                        </tr>
                        <tr>
                            <td>EMBALAJE</td>
                        </tr>
                        <tr></tr>
                        <tr></tr>
                        <tr></tr>
                        <tr></tr>
                    </table>
                </td>
            </tr>
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

    .details_1 tr td{
        width: 80px;
        background-color: red;

    }

    .details_1 tr td:nth-child(2){
        width: 130px;
        background-color: grey;

    }


    .details_2 tr td{ 
        width: 70px;     
        background-color: green;
    }



  

    .espacio{
        width: 100%;
        height: 215px;
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