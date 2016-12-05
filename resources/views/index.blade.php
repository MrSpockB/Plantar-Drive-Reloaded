<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Plantar Drive</title>
    <link rel="stylesheet" href="{{ asset('lib/font/material-icons/material-icons.css') }}"/>
    <link rel="stylesheet" href="{{ asset('lib/css/materialize.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"/>
</head>
<body>
    <nav>
        <div class="navbar-fixed">
            <a class="brand-logo">
                <img src="img/logo-plantar.png">
            </a>
        </div>
    </nav>
    <div class="login container">
        <div class="login-header">
            <h4>Iniciar Sesión</h4>
        </div>
        {!! Form::open(array('url' => 'login', 'method' => 'POST', 'class' => 'loginForm')) !!}
            <div class="input-field">
                <i class="material-icons prefix">perm_identity</i>
                <input type="text" id="email" name="email" >
                <label for="email">Usuario</label>
            </div>
            <div class="input-field">
                <i class="material-icons prefix">lock_outline</i>
                <input type="password" id="password" name="password" >
                <label for="password">Contraseña</label>
            </div>
            @if(session('message'))
                <div class="alert alert-danger">
                    {{ session('message') }}
                </div>
            @endif
            <div class="ingreso">
                <a href="#" id="recuperarDatos">No puedo ingresar a mi cuenta</a>
                <input type="submit" value="Iniciar Sesión" class="btn waves-effect waves-light">
            </div>
        {!! Form::close() !!}
    </div>
    <script src="{{ asset('lib/js/jquery.min.js')}}"></script>
    <script src="{{ asset('lib/js/materialize.min.js')}}"></script>
</body>
</html>