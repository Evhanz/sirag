<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>


    <table class="data">
        <thead >

        <!--Periodos-->
        <tr>
            <td rowspan="4"></td>
            @foreach($codigos as $item)
                <td colspan="{{($item->cant)*3}}">Campaña 200{{$item->campain}}</td>
            @endforeach
        </tr>

        <!--Fundos-->

        <tr>
            <td></td>
            @foreach($codigos as $item)
                @foreach($item->fundos as $i)
                    <td colspan="{{(count($i->parron))*3}}" >Fundo {{$i->fundo}}</td>
                @endforeach
            @endforeach
        </tr>



        <tr>
            <td></td>
            @foreach($codigos as $item)
                @foreach($item->codigos as $i)
                    <td colspan="3" style="border: 4px solid #0a0a0b">{{$i}}</td>
                @endforeach
            @endforeach
            <td colspan="3">TOTALES</td>
        </tr>

        <tr>
            <td></td>

            @foreach($res_actividades[0]->detalles as $detalle)
                <td>Cant.</td>
                <td>V/H</td>
                <td>C/Ha.</td>
            @endforeach
            <td >T: Cant.</td>
            <td >T: V/H </td>
            <td >T: C/Ha.</td>
        </tr>

        </thead>
        <tbody>

        @foreach($res_actividades as $item)
            <?php $t_cantidad = 0;$t_valor_x_hora = 0;$t_cost_x_hectarea = 0;     ?>
        <tr>
            <td>{{$item->descripcion}}</td>
            @foreach($item->detalles as $detalle)
                <td>{{$detalle->cantidad}}</td>
                <td>{{$detalle->valor_x_hora}}</td>
                <td>{{$detalle->cost_x_hectarea}}</td>

                <?php
                    $t_cantidad += $detalle->cantidad;
                    $t_valor_x_hora += $detalle->valor_x_hora;
                    $t_cost_x_hectarea += $detalle->cost_x_hectarea;
                ?>
            @endforeach
            <td>{{ $t_cantidad }}</td>
            <td>{{ $t_valor_x_hora }}</td>
            <td>{{ $t_cost_x_hectarea }}</td>

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