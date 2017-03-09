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
            <td> <span style="padding-left: -1em">{{$cabecera['ruc'] }}</span>  </td>
        </tr>
        <tr>
            <td><span style="padding-left: 3em">  {{ $cabecera['fecha_emision1'] }} </span> </td>
        </tr>
    </table>

    <table class="detail">

        @foreach($res as $item)
        <tr>
            <td style="">{{$item->tipo}}</td>
            <td style="padding-left: 40px">{{$item->serie}}</td>
            <td style="padding-left: 80px">{{$item->correlativo}}</td>
            <td style="padding-left: 80px">{{$item->fecha_emision}}</td>
            <td style="padding-left: 95px;text-align: right;">{{ number_format($item->monto_pago,2,'.',',') }}</td>
            <td style="padding-left: 80px ;text-align: right;">{{ number_format($item->monto_retenido,2,'.',',') }}</td>

        </tr>
        @endforeach


    </table>


    <div class="totales">

        <div class="nonto_letras" style="font-size: 14px">
            {{$total['monto_letras']}}
        </div>

        <div class="monton">
            {{ number_format($total['monto'],2,'.',',') }}
        </div>

    </div>



</body>


<style>
    body{

      /*  font-family: "Courier New", Courier, monospace; */

        font-size: 12px;


    }

    .cabecera tr td{

        padding-top: 0.8em;

    }

    .cabecera{
        position: absolute;
        left: 40px;
        top: 85px;
    }

    .detail {
        position: absolute;
        left: 20px;
        top: 205px;
    }


    .totales {
        position: absolute;
        top: 400px;
        left: 120px;

        width: 100%;

    }

    .nonto_letras{

        width: 400px;
        position: absolute;
        top: 20px;
        text-align: center;

    }

    .monton{
        width: 200px;
        position: absolute;
        top: 20px;
        left: 420px;
        text-align: center;
    }


</style>


</html>