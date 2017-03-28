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
            <p>BOLETA DE PAGO</p>
        </div>
        <hr >
        <H5 style="padding: 0px;margin: 0px;"><STRONG>{{$maestro->NOMBRE}}</STRONG></H5>
        <table style="margin: 0px;padding: 0px;" id="details">
            <tr>
                <td>Código:</td>
                <td>{{$maestro->CODIGO}}</td>
                <td>N° Días Trabajados:</td>
                <?php $d_trabajador =  $item->where('MOVIMIENTO','52')->first();
                $d_trabajador = $d_trabajador->VALOR;
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
                <td>{{$d_nocturno}}</td>
                <td>N° Horas Extras 25%:</td>
                <?php $temp = $item->where('MOVIMIENTO','20101')->first();
                if($temp != null){
                    $temp = $temp->VALOR;
                }ELSE{
                    $temp = '0.00';
                }
                ?>
                <td>{{$temp}}</td>
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
                <td>N°Horas Extras Noche 25%:</td>
                <td>0.00</td>
                <td>N° Horas Extras 100%:</td>
                <?php $temp = $item->where('MOVIMIENTO','20103')->first();
                if($temp != null){
                    $temp = $temp->VALOR;
                }ELSE{
                    $temp = '0.00';
                }
                ?>
                <td>{{$temp}}</td>
            </tr>
            <tr>
                <td>Fecha Ingreso:</td>
                <?php $fecha_i = $item->where('MOVIMIENTO','130')->first();

                $fecha_i = explode('.', $fecha_i->VALOR);
                $fecha_i = $fecha_i[0];
                $fecha_i = substr($fecha_i, 6, 2).'/'.substr($fecha_i, 4, 2).'/'.substr($fecha_i, 0, 4);
                ?>
                <td>{{$fecha_i}}</td>
                <td>N°Horas Extras Noche 35%:</td>
                <td>0.00</td>
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
                <td>N°Horas Extras Noche 100%:</td>
                <td>0.00</td>
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
                <td>{{$temp}}</td>
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
                <td ><strong>INGRESOS</strong></td>
                <td ><strong>DESCUENTOS</strong></td>
                <td ><strong>APORTACIONES</strong></td>
            </tr>
            <tr>
                <td>
                    <table id="sub_ingreso">
                        @foreach($ingresos as $item)
                        <tr>
                            <td>{{$item->DESCRIPCION}}</td>
                            <td>{{number_format($item->VALOR,2,'.','')}}</td>

                        </tr>
                        @endforeach
                    </table>
                </td>

            </tr>
        </table>


    </div>






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

    hr{
        size: 2px;
        border-style: solid;
        border-width: 0px 0px 1px 0px;
        margin:0px;
    }
    table{
        font-size: 12px;
        border-collapse:collapse;
        border: none;
    }



    #details tr td:nth-child(2) {

        width: 180px;
        text-align: left;
    }

    #details tr td:nth-child(4) {

        width: 80px;
        text-align: right;
        padding-right: 40px;
    }

    #details tr td:nth-child(6) {
        width: 60px;
        text-align: right;
    }



    .page-break {
        page-break-after: always;
    }


</style>


</html>