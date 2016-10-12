<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>

    <h1>Reporte de costo por Producto y proveedores</h1>

    <hr>

    <table>
        <thead>
        <tr>
            <th>Descripcion Producto</th>
            <th>Proveedor</th>
            <th>Moneda</th>
            <th>UND</th>
            <th>Ult. Precio</th>
        </tr>
        </thead>

        <tbody>
        @foreach( $productos as $item )
            <tr>
                <td>{{$item->GLOSA}}</td>
                <td>{{ $item->RazonSocial }}</td>
                <td>{{ $item->Moneda }}</td>
                <td>{{ $item->UnidadIngreso }}</td>
                <td>{{ $item->last_precio }}</td>
            </tr>
        @endforeach
        </tbody>

    </table>


</body>
</html>