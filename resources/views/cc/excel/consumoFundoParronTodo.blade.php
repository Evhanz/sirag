<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>


<table>

    @if(isset($otros))

        <hr>
        <tr>
            <td> </td>
        </tr>

        <tr>
            <td><h4>Consumo de productos en el codigo 17000 </h4></td>
            <td>en fecha {{ $f_otros_i }} al {{ $f_otros_f }}</td>
        </tr>
        <tr>
            <td></td>
            <td>CODIGO</td>
            <td>DESCRIPCION</td>
            <td>CANTIDAD</td>
            <td>TOTAL</td>
        </tr>
        @foreach ($otros as $p)
            <tr class="">
                <td></td>
                <td>{{ $p->PRODUCTO }}</td>
                <td>{{ $p->DESCRIPCION }}</td>
                <td>{{ $p->cantidad }}</td>
                <td>{{ $p->total }}</td>
            </tr>
        @endforeach
    @endif


</table>

<style>


    table > .data > td:nth-child(3n+1){

        border-left: 200px solid #000;
        /*	background-color: #344;
            color: #333;
            */

    }


</style>



</body>
</html>