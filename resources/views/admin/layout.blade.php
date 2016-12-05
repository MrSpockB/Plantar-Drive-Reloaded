<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Plantar Drive</title>
    <link rel="stylesheet" href="{{ asset('lib/css/jquery-ui.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('lib/font/material-icons/material-icons.css') }}"/>
    <link rel="stylesheet" href="{{ asset('lib/css/materialize.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"/>
    @yield('styles')
</head>
<body>
    <ul id="menuAdmin" class="dropdown-content">
        <li><a href="#">Perfil</a></li>
        <li class="divider"></li>
        <li><a href="{{url('/admin/usuarios')}}">Ver Usuarios</a></li>
        <li><a href="{{url('/admin/crearUsuario')}}">Crear Usuario</a></li>
        <li><a href="{{url('/admin/crearEmpresa')}}">Crear Empresa</a></li>
        <li class="divider"></li>
        <li><a href="{{ url('/logout') }}">Cerrar Sesión</a></li>
    </ul>
    <nav>
        <div class="navbar-fixed">
            <a class="brand-logo" href="{{ url('admin') }}"><img src="{{ asset('img/logo-plantar.png') }}"></a>
            <ul class="right profile">
                <li class="circle img">
                    <div style="background-image: url({{ asset('img/Recortado.jpg') }}); height: 100%; width: 100%; background-size: cover; background-position: 50%;"></div>
                </li>
                <li>
                    <a href="#" class="dropdown-button" data-activates="menuAdmin" style="display: inline-block;">{{ Sentinel::getUser()->first_name }}</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container">
        @yield('content')
    </div>
    <script src="{{ asset('lib/js/jquery.min.js') }}"></script>
    <script src="{{ asset('lib/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('lib/js/materialize.min.js') }}"></script>
    <script src="{{ asset('lib/js/moment.min.js') }}"></script>
    @yield('scripts')
</body>
</html>