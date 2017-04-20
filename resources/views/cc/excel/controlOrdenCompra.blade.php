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

<table class="general">
    <thead>
    <tr>
        <td> <strong>Orden de Compra</strong> </td>
        <td> <strong>Proveedor</strong> </td>
        <td> <strong>Fecha</strong> </td>
    </tr>
    </thead>
    <tbody>
    @foreach($ordenes as $item)
        <tr class="cabecera" >
            <td>{{$item[0]->Numero}}</td>
            <td>{{$item[0]->RazonSocial}}</td>
            <td>{{$item[0]->FECHA}}</td>
        </tr>
        <tr>
            <td colspan="3" class="td_detail">
                <table class="detalles">
                    <thead>
                    <tr>
                        <td> <strong>GLOSA</strong></td>
                        <td> <strong>UND</strong> </td>
                        <td> <strong>Cant.</strong> </td>
                        <td> <strong>Cant. Atendida</strong> </td>
                        <td> <strong>Estado</strong> </td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($item as $detalle)
                        <tr>
                            <td>{{$detalle->GLOSA}}</td>
                            <td>{{$detalle->UnidadIngreso}}</td>
                            <td>{{$detalle->Cantidad}}</td>
                            <td>{{$detalle->ATENDIDO}}</td>
                            <td>{{$detalle->estado}}</td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>

            </td>
        </tr>
    @endforeach
    </tbody>
</table>


<style>

    body{
        font-size: 10px;
    }

    .cabecera{


    }

    .cabecera td{
        border-top: 8px solid transparent;
    }

    .general{
        width: 100%;
        border-spacing: 0px;
    }

    .general thead tr td{
        background-color: #2b688c;
        color: white;
    }

    .td_detail{
        border-top: 8px solid transparent;
        border-bottom: 2px solid grey;
    }

    .detalles{
        width: 100%;
    }

    .detalles  thead tr td{
        background-color: transparent;
        color: #333;
    }

    .detalles  tbody tr td{
       text-align: center;
    }

    .detalles  thead tr td{
        text-align: center;
    }

    .detalles  thead tr td:nth-child(1){
        text-align: left;
    }

    .detalles  tbody tr td:nth-child(1){
        width: 250px;
        text-align: left;
    }

</style>



</body>
</html>