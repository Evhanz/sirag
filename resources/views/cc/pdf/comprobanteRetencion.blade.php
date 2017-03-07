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

    <table class="cabecera">
        <tr>
            <td> {{ $cabecera['razon'] }} </td>

        </tr>
        <tr>
            <td> <span style="padding-left: 1.5em">{{$cabecera['ruc'] }}</span>  </td>
        </tr>
        <tr>
            <td><span style="padding-left: 2em">  {{ $cabecera['fecha_emision1'] }} </span> </td>
        </tr>
    </table>

    <table class="detail">

        @foreach($res as $item)
        <tr>
            <td>{{$item->tipo}}</td>
            <td>{{$item->serie}}</td>
            <td>{{$item->correlativo}}</td>
            <td>{{$item->fecha_emision}}</td>
            <td>{{$item->monto_pago}}</td>
            <td>{{$item->monto_retenido}}</td>

        </tr>
        @endforeach


    </table>

    <table class="totales">
        <tr>
            <td colspan="4" style="text-align: center">
                {{$total['monto_letras']}}
            </td>
            <TD></TD>
            <td>
                {{$total['monto'] }}
            </td>

        </tr>
    </table>

</body>


<style>
    body{

        font-family: "Courier New", Courier, monospace;
        font-size: 12px;

    }

    .cabecera tr td{

        padding-top: 0.8em;

    }

    .cabecera{
        position: absolute;
        left: 11em;
        top: 37px;
    }

    .detail {
        position: absolute;
        left: 40px;
        top: 150px;
    }

    .detail  tr td{
        padding-left: 6em;
    }
    .totales {
        position: absolute;
        top: 340px;
        left: 90px;
    }


</style>


</html>