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


    <div class="header-info">
        <h1>Login</h1>
        {!!Form::open(['route'=>'log.store', 'method'=>'POST'])!!}
        <div class="form-group">
            {!!Form::label('usuario','usuario:')!!}
            {!!Form::text('usuario',null,['class'=>'form-control', 'placeholder'=>'Ingresa tu Usuario'])!!}
        </div>
        <div class="form-group">
            {!!Form::label('pwd','Contraseña:')!!}
            {!!Form::password('pwd',['class'=>'form-control', 'placeholder'=>'Ingresa tu contraseña'])!!}
        </div>
        {!!Form::submit('Iniciar',['class'=>'btn btn-primary'])!!}
        {!!Form::close()!!}
    </div>

</body>
</html>