<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>FUNDO {{$fundo}}</title>
</head>
<body>


    <table class="data">
        <thead >


        <tr>
            <td colspan="5">CAMPAÑA : {{$campain}}</td>
        </tr>

        <!--Fundos-->

        <tr>
            <td rowspan="3"> FUNDO {{$fundo}}</td>
            @foreach($parrones as $item)
               <td colspan="4">PARRON: {{substr($item,0,2)}}</td>
            @endforeach
            <td colspan="4" rowspan="2" >TOTALES</td>
            <td colspan="2" rowspan="2" >JORNALES X Ha</td>
            <td colspan="2" rowspan="2">TOTALES X PLANTA</td>


        </tr>


        <tr>
            <td></td>
          @foreach($codes as $i)
            <td colspan="4">{{$i}}</td>
          @endforeach
            <td colspan="4"></td>
            <td colspan="2"></td>
        </tr>

        <tr>
            <td> </td>

            @foreach($parrones as $item)
                <td>Cant.</td>
                <td>V/H</td>
                <td>C/Ha.</td>
                <td>Area</td>
            @endforeach

            <td>T. Cant.</td>
            <td>T. V/H</td>
            <td>T. C/Ha.</td>
            <td>T. Area</td>

            <td>HORAS X Ha</td>
            <td>JORNALES X Ha</td>

            <td>PLANTAS</td>
            <td>PLANTAS X JORNALES</td>


        </tr>

        </thead>
        <tbody>

        @foreach($actividades as $item)
            <?php $t_cantidad = 0;$t_valor_x_hora = 0;$t_cost_x_hectarea = 0; $t_total_area = 0; $t_plantas = 0;   ?>
        <tr>
            <td>{{$item->descripcion}}</td>
            @foreach($item->detalles as $detalle)
                <td>{{$detalle->cantidad}}</td>
                <td>{{$detalle->valor_x_hora}}</td>
                <td>{{$detalle->cost_x_hectarea}}</td>
                <td>{{$detalle->area}}</td>


                <?php
                $t_cantidad += $detalle->cantidad;
                $t_valor_x_hora += $detalle->valor_x_hora;
                $t_cost_x_hectarea += $detalle->cost_x_hectarea;
                $t_total_area += $detalle->area;
                $t_plantas += $detalle->plantas ;

                ?>
            @endforeach
            <td>{{ $t_cantidad }}</td>
            <td>{{ $t_valor_x_hora }}</td>
            <td>{{ $t_cost_x_hectarea }}</td>
            <td>{{ $t_total_area }}</td>

            <?php $jornal = 0  ?>

            @if($t_total_area != 0)

            <td>{{ round($t_cantidad /$t_total_area,2) }}</td>
            <td>{{ round(($t_cantidad /$t_total_area)/8,2) }}</td>
                <?php $jornal = ($t_cantidad /$t_total_area)/8 ?>

            @else
                <td>{{ round($t_cantidad ,2) }}</td>
                <td>{{ round(($t_cantidad )/8,2) }}</td>
            @endif
            <td>{{ $t_plantas }}</td>
            @if($jornal != 0)
                <td>{{ round(($t_plantas/$t_total_area) / $jornal,2)  }}</td> <!-- SON PLANTAS ENTRE JORNALES -->
            @else
                <td>{{ $t_plantas }}</td>
            @endif

        </tr>
        @endforeach

        <!-- aca los resultados -->

        <!--
        <tr>
            <td style="font-weight: bold; font-size: 18PX;text-align: center;">TOTALES</td>
            @foreach($totales as $total)
                <td style=" border: 2px solid #0a0a0b; font-weight: bold; text-align:right;" colspan="3">{{$total}}</td>
            @endforeach
        </tr>
        -->
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