<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Plantar Drive</title>
    <link rel="stylesheet" href="lib/font/material-icons/material-icons.css"/>
    <link rel="stylesheet" href="lib/css/materialize.min.css"/>
    <script src="lib/js/jquery.min.js"></script>
    <script src="lib/js/angular.min.js"></script>
    <script src="lib/js/angular-route.min.js"></script>
    <script src="lib/js/materialize.min.js"></script>
    <style>
        .login{
            padding: 0px;
            border: 1px #9E9E9E solid;
            border-radius: 10px;
            width: 700px;
            margin: 100px auto;
        }
        form{
            margin-left: 20px;
            margin-right: 20px;
        }
        .login-header{
            margin: 0;
            background-color: #1F1D1D;
            height: 100px;
            border-radius: 7px 7px 0 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-header h4{
            color: #FFFFFF;
            margin: 0;
        }
        #recuperarDatos{
            margin-right: 10px;
        }
        #recuperarDatos:hover{
            text-decoration: underline;
        }
        .ingreso{
            width: 100%;
            margin: 20px 0;
            text-align: right;
        }
    </style>
</head>
<body>
    <nav style="background-color: #1F1D1D">
        <div class="navbar-fixed">
            <a class="brand-logo"><img src="img/logo-plantar.png" style="width: 57%;"></a>
        </div>
    </nav>
    <div class="login container">
        <div class="login-header">
            <h4>Iniciar Sesión</h4>
        </div>
        <form>
            <div class="input-field" style="margin-top: 30px">
                <i class="material-icons prefix" style="color: #757575;">perm_identity</i>
                <input type="text" id="user">
                <label for="user">Usuario</label>
            </div>
            <div class="input-field">
                <i class="material-icons prefix" style="color: #757575;">lock_outline</i>
                <input type="password" id="pass">
                <label for="pass">Contraseña</label>
            </div>
            <div class="ingreso" style="">
                <a href="#" id="recuperarDatos">No puedo ingresar a mi cuenta</a>
                <a href="admin" class="btn waves-effect waves-light">Iniciar Sesión</a>
            </div>
        </form>
    </div>
</body>
</html>