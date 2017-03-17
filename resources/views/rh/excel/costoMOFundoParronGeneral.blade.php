<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>FUNDOS</title>
</head>
<body>


    <table class="data">
        <thead >

        <!--Periodos-->
        <tr>
            <td rowspan="3">GENERALES</td>
            @foreach($cabecera as $item)
                <td colspan="{{ count($item->codigos)*3}}">Campaña 200{{$item->cam}}</td>
            @endforeach
        </tr>

        <!--Fundos-->

        <tr>
            <td></td>
            @foreach($cabecera as $item)
                @foreach($item->codigos as $i)
                    <td colspan="4" >{{$i}}</td>
                @endforeach
            @endforeach
            <td colspan="4">TOTALES</td>
            <td colspan="2">JORNALES X Ha</td>
            <td colspan="2">TOTALES X PLANTAS</td>
        </tr>


        <tr>
            <td></td>
            @foreach($actividades[0]->detalles as $detalle)
                <td>Cant.</td>
                <td>V/H</td>
                <td>C/Ha.</td>
                <td>Area</td>
            @endforeach
            <td >T: Cant.</td>
            <td >T: V/H </td>
            <td >T: C/Ha.</td>
            <td >T: Area.</td>

            <td > HORAS X HECTAREA</td>
            <td > JORNALES X HECTAREA</td>
            <td > TOTALES PLANTAS </td>
            <td > PLANTAS X JORNALES</td>



        </tr>

        </thead>
        <tbody>

        @foreach($actividades as $item)
            <?php $t_cantidad = 0;$t_valor_x_hora = 0;$t_cost_x_hectarea = 0; $t_total_area = 0; $t_plantas = 0;   ?>
        <tr>
            <td>{{$item->descripcion}}</td>
            @foreach($item->detalles as $detalle)
                <?php $temp_area = 1; ?>
                <td>{{$detalle->horas}}</td>
                <td>{{$detalle->costo_x_hora}}</td> <!-- este es el costo de todas las horas de $detalle->horas -->
                @if($detalle->area == 0)
                        <td>{{$detalle->costo_x_hora / 1 }}</td>
                @else
                        <td>{{ round($detalle->costo_x_hora / $detalle->area,2) }}</td> <!-- saca el costo x hectarea -->
                @endif

                <td>{{$detalle->area}}</td>

                <?php

                    $t_cantidad += $detalle->horas;
                    $t_valor_x_hora += $detalle->costo_x_hora;

                    if($detalle->area == 0){
                        $t_cost_x_hectarea += ($detalle->costo_x_hora / 1);
                    }else{
                        $t_cost_x_hectarea += ($detalle->costo_x_hora / $detalle->area);
                    }


                    $t_total_area += $detalle->area;
                    $t_plantas += $detalle->plantas;
                ?>
            @endforeach
            <td>{{ $t_cantidad }}</td>
            <td>{{ $t_valor_x_hora }}</td>
            <td>{{ $t_cost_x_hectarea }}</td>
            <td>{{ $t_total_area }}</td>

            <?php if ($t_total_area == 0) $t_total_area =1; ?>

            <td>{{ round ($t_cantidad/$t_total_area,2) }}</td>
            <td>{{ round (($t_cantidad/$t_total_area)/8,2) }}</td>

            <?php $jornales = round (($t_cantidad/$t_total_area)/8,2) ; ?>

            <td>{{ $t_plantas}}</td>

            @if($jornales == 0)
                <td>{{ $jornales }}</td>
            @else
                <td>{{ round(($t_plantas/$t_total_area)  / $jornales ,2) }}</td>
            @endif





        </tr>
        @endforeach


        </tbody>
    </table>

    <style>
       .data thead tr td {
           text-align: center;
           font-weight: bold;
           border: 2px solid #0a0a0b;
       }
    </style>


</body>
</html>