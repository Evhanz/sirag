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
            <td rowspan="3"></td>
            @foreach($cabecera as $item)
                <td colspan="{{ count($item->codigos)*2}}">Campaña 200{{$item->cam}}</td>
            @endforeach
        </tr>

        <!--Fundos-->

        <tr>
            <td></td>
            @foreach($cabecera as $item)
                @foreach($item->codigos as $i)
                    <td colspan="2" >{{$i}}</td>
                @endforeach
            @endforeach
            <td colspan="2">TOTALES</td>
        </tr>


        <tr>
            <td></td>
            @foreach($actividades[0]->detalles as $detalle)
                <td>Cant.</td>
                <td>V/H</td>
            @endforeach
            <td >T: Cant.</td>
            <td >T: V/H </td>
        </tr>

        </thead>
        <tbody>

        @foreach($actividades as $item)
            <?php $t_cantidad = 0;$t_valor_x_hora = 0;    ?>
        <tr>
            <td>{{$item->descripcion}}</td>
            @foreach($item->detalles as $detalle)
                <td>{{$detalle->horas}}</td>
                <td>{{$detalle->costo_x_hora}}</td>

                <?php

                    $t_cantidad += $detalle->horas;
                    $t_valor_x_hora += $detalle->costo_x_hora;

                ?>
            @endforeach
            <td>{{ $t_cantidad }}</td>
            <td>{{ $t_valor_x_hora }}</td>

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