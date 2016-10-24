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


    <h1>Usuarios</h1>


    <div style="width: 80%">
        <table>


                @foreach($usuarios as $item)
                <tr>
                    <td>{{ $item->USR }}</td>
                    <td>{{ $item->DESCRIPCION }}</td>
                    <td>{{ $item->EMPRESA }}</td>
                    <td>{{ $item->hasRole('Admin')}}</td>
                </tr>
                @endforeach

        </table>
    </div>



</body>
</html>