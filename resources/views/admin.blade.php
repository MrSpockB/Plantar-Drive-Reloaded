<!DOCTYPE html>
<html lang="en" ng-app="APP">
<head>
    <meta charset="UTF-8">
    <base href="{{ url('/admin/') }}">
    <title>Plantar Drive</title>
    <link rel="stylesheet" href="{{ asset('lib/css/jquery-ui.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('lib/font/material-icons/material-icons.css') }}"/>
    <link rel="stylesheet" href="{{ asset('lib/css/materialize.min.css') }}"/>
    <script>
        var url = '{{ url('/') }}';
    </script>
    <script src="{{ asset('lib/js/jquery.min.js') }}"></script>
    <script src="{{ asset('lib/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('lib/js/angular.min.js') }}"></script>
    <script src="{{ asset('lib/js/angular-route.min') }}.js"></script>
    <script src="{{ asset('lib/js/materialize.min.js') }}"></script>
    <script src="{{ asset('lib/js/moment.min.js') }}"></script>
    <script src="{{ asset('lib/js/ng-file-upload-shim.min.js') }}"></script> <!-- for no html5 browsers support -->
    <script src="{{ asset('lib/js/ng-file-upload.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <style>
        nav ul a:hover {
            background-color: rgba(255,255,255,0.1);
        }
    </style>
</head>
<body>
    <ul id="menuAdmin" class="dropdown-content">
        <li><a href="#">Perfil</a></li>
        <li class="divider"></li>
        <li><a href="{{url('/admin/crearUsuario')}}">Crear Usuario</a></li>
        <li><a href="{{url('/admin/crearEmpresa')}}">Crear Empresa</a>
        <li class="divider"></li>
        <li><a href="#">Cerrar Sesión</a></li>
    </ul>
    <nav style="background-color: #1F1D1D">
        <div class="navbar-fixed">
            <a class="brand-logo"><img src="{{ asset('img/logo-plantar.png') }}" style="width: 57%;"></a>
            <ul class="right" style="display: flex; align-items: center;">
                <li style="width: 30px; height: 30px; overflow: hidden;" class="circle">
                    <div style="background-image: url({{ asset('img/Recortado.jpg') }}); height: 100%; width: 100%; background-size: cover; background-position: 50%;"></div>
                </li>
                <li>
                    <a href="#" class="dropdown-button" data-activates="menuAdmin" style="display: inline-block;">Usuario</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container" ng-view>

    </div>
</body>
</html>