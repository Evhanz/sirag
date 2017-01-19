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
            <td rowspan="3">-</td>
            @foreach($codigos as $item)
                <td colspan="{{$item->cant}}">Campaña 200{{$item->campain}}</td>
            @endforeach
        </tr>

        <!--Fundos-->

        <tr>
            <td></td>
            @foreach($codigos as $item)
                @foreach($item->fundos as $i)
                    <td colspan="{{count($i->parron)}}" >Fundo {{$i->fundo}}</td>
                @endforeach
            @endforeach
        </tr>



        <tr>
            <td></td>
            @foreach($codigos as $item)
                @foreach($item->codigos as $i)
                    <td>{{$i}}</td>
                @endforeach
            @endforeach
        </tr>
        </thead>
        <tbody>

        @foreach($res_actividades as $item)
        <tr>
            <td>{{$item->descripcion}}</td>
            @foreach($item->detalles as $detalle)
                <td>{{$detalle->cantidad}}</td>
            @endforeach
        </tr>
        @endforeach

        <!-- aca los resultados -->
        <tr>
            @foreach($totales as $total)
                <td>{{$total}}</td>
            @endforeach
        </tr>

        </tbody>
    </table>

    <style>
       .data thead tr td {
           text-align: center;
           font-weight: bold;
       }
    </style>


</body>
</html>