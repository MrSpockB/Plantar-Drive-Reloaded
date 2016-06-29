var app = angular.module('APP',['ngRoute','ngFileUpload']);
// Rutas
app.config(["$routeProvider","$locationProvider", function (rP, lP) {
    rP
        .when("/admin", {templateUrl: url+"/templates/inicioAdmin.html", controller: "inicioAdmin"})
        .when("/admin/clientes/:nombre", {templateUrl: url+"/templates/odts.html", controller: "ODTs"})
        .when("/admin/crearODT/:nombre", {templateUrl: url+"/templates/crearODT.html", controller: "crearODT"})
        .when("/admin/crearEmpresa", {templateUrl: url+"/templates/crearEmpresa.html", controller:"crearEmpresa"})
        .when("/admin/crearUsuario", {templateUrl: url+"/templates/crearUsuario.html", controller:"crearUsuario"})
        .otherwise({redirectTo: "/"});
    lP.html5Mode(true);
}]);
// Filtros
app.filter("firstCharToLowerCase", function () {
    return function (input) {
        if(input != null)
            return input.charAt(0).toUpperCase() + input.substr(1);
        return "";
    }
});
// Inicio Administrador
app.controller("inicioAdmin", ["$scope", "$http", function (s, http) {
    s.empresas = [];
    http.get(url+"/data/clientes").then(function (response) {
        s.empresas = response.data.data;
    }, function (response) {
        console.log("ERROR: ", response);
    })
}]);
// Ordenes de trabajo
app.controller("ODTs", ["$scope", "$http", "$location", function (s, http, l) {
    s.Cliente = "";
    s.ODTs = [];
    http.get(url+"/data/clientes/" + l.path().split('/')[3]).then(function (response) {
        if(response.data.success){
            s.Cliente = response.data.data.name;
            s.ODTs = response.data.data.odts;
        }
    }, function (response) {
        console.log("ERROR: ", response);
    })
}]);
// Crear orden de trabajo
app.controller("crearODT", ["$scope", "$http", "$location", function (s, http, l) {
    s.Cliente = l.path().split('/')[3];
    s.NombreProyecto = ""; // Nombre de la ODT
    s.Descripcion = "" // Descripcion general de ODT
    s.files = []; // Lista de archivos seleccionados
    s.filesSelected = ""; // String de atributo name de un archivo
    s.Fecha = moment().format('YYYY-MM-DD'); // Fecha actual
    s.RespPrincipal = {}; // Responsable principal (Plantar)
    s.Areas = { // Areas de trabajo para combobox
        selected: null, // Aqui se guarda el seleccionado
        "options": [ // Distintas opciones a elegir
            "Web",
            "Diseño",
            "Contenido",
            "Multimedia",
            "Estrategia",
            "Cotizaciónes"
        ]
    };
    s.dateInicio = ""; // Fecha de Inicio
    s.dateFin = ""; // Fecha de Fin
    s.Responsables = []; // Lista de responsables
    s.SelectedResponsables = []; // Lista de responsables seleccionados
    s.loadData = function () {
        // Se carga el responsable principal
        http.get(url+"/data/user/gustavo@plantar.mx").then(function (response) {
            if(response.data.success){
                s.RespPrincipal = response.data.user; // Se guarda en su respectiva variable
            }
        }, function (response) {
            console.log("ERROR: ", response);
        });
        // Se cargan los usuarios que correspondan al cliente
        http.get(url+"/data/users/" + s.Cliente).then(function (response) {
            if(response.data.success){
                s.Responsables = response.data.data; // Guarda usuarios como posibles reesponsables
            }
        }, function (response) {
            console.log("ERROR: ", response);
        });
    };

    s.onFileSelect = function ($files) {
        for(var i = 0; i < $files.length; i++){
            if(!existFile($files[i]))
                s.files.push($files[i]);
        }
    };

    function existFile(file) {
        for(var i = 0; i < s.files.length; i++){
            if(s.files[i].name == file.name)
                return true;
        }
        return false;
    }

    s.complete = function () {
        $("#txtResponsables").autocomplete({
            minLength: 1,
            source: function (request, response) {
                response($.map(s.Responsables, function (value, key) {
                    return {
                        label: value.first_name + " " + value.last_name,
                        value: value.client_id
                    }
                }));
            },
            select: function (event, ui) {
                var label = ui.item.label;
                var value = ui.item.value;
                addResponsable(value);
                //alert("label: " + label + ", value: " + value);
                return false;
            },
            focus: function (event, ui) {
                var label = ui.item.label;
                var value = ui.item.value;
                $("#txtResponsables").val(label);
                //alert("label: " + label + ", value: " + value);
                return false;
            }
        });
    };
    
    function addResponsable(rId) {
        for(var i = 0; i < s.Responsables.length; i++) {
            if(rId == s.Responsables[i].client_id && !existResp(rId)) {
                s.SelectedResponsables.push(s.Responsables[i]);
                $("#txtResponsables").val("");
                break;
            }
        }
    }

    function existResp(rId){
        for(var i = 0; i < s.SelectedResponsables.length; i++){
            if(rId == s.SelectedResponsables[i].client_id)
                return true;
        }
        return false;
    }
    
    s.deleteResp= function (rId) {
        for(var i = 0; i < s.SelectedResponsables.length; i++){
            if(rId == s.SelectedResponsables[i].client_id){
                s.SelectedResponsables.splice(i, 1);
                break;
            }
        }
    };

    s.deleteFile= function (name) {
        for(var i = 0; i < s.files.length; i++){
            if(name == s.files[i].name){
                s.files.splice(i, 1);
                break;
            }
        }
    };

    s.send = function () {
        var dtInicio = moment(s.dateInicio, 'dddd MMMM DD YYYY HH:mm:ss ZZ').format('YYYY-MM-DD');
        var dtFin = moment(s.dateFin, 'dddd MMMM DD YYYY HH:mm:ss ZZ').format('YYYY-MM-DD');
        alert(dtInicio + " ### " + dtFin);
    };
}]);
// Crear Empresa
app.controller("crearEmpresa", ["$scope", "Upload", function (s, Upload) {
    var MSG_SUCCESS = "<span>Se creo un nuevo cliente.</span>";
    var MSG_ERROR = "<span>Error al crear el cliente.</span>";
    var file = null;
    s.nombre = "";
    s.fileString = "";
    s.onFileSelect = function ($files) {
        file = $files[0];
    };
    
    s.sendData = function () {
        Upload.upload({
            url: url+'/data/clientes',
            data: {nombre: s.nombre, logo: file}
        }).then(function (data, status, headers, config) {
            console.log(status);
            s.nombre = "";
            file = null;
            s.fileString = "";
            Materialize.toast(MSG_SUCCESS, 5000, "rounded");
        }, function (data, status, headers, config) {
            console.log("STATUS: ", status);
            console.log("ERROR: ", data);
            Materialize.toast(MSG_ERROR, 5000, "rounded");
        });
    };
}]);
// Crear Usuario
app.controller("crearUsuario", ["$scope", "$http", "Upload", function (s, http, Upload) {
    var MSG_SUCCESS = "<span>Se creo un nuevo usuario.</span>";
    var MSG_ERROR = "<span>Error al crear el usuario.</span>";
    s.re = /\S{6}\S*\d+/;
    s.tipos_usuario= {
        selected: null,
        options: [
            "Administrador",
            "Normal"
        ]
    };
    s.showEmpresa = false;
    s.nombre = "";
    s.apellido = "";
    s.email = "";
    s.mailClassValid = "";
    s.r_email = "";
    s.pass = "";
    s.theClassPass = "";
    s.r_pass = "";
    s.passClassValid = "";
    s.empresas = {
        selected: null,
        options: []
    };
    var urlTipoUsuario = "";
    s.loadData = function () {
        http.get(url+"/data/clientes").then(function (response) {
            for(var i = 0; i < response.data.data.length; i++)
                s.empresas.options.push(response.data.data[i]);
        })
    };
    s.validatePass = function () {
        if(s.re.test(s.pass))
            s.theClassPass = "valid";
        else
            s.theClassPass = "invalid";
        s.validatePassword();
    };
    s.validateEMAIL = function () {
        s.validateMail();
    };
    s.validateMail = function () {
        if(s.email == s.r_email)
            s.mailClassValid = "valid";
        else
            s.mailClassValid = "invalid";
    };

    s.validatePassword = function () {
        if(s.pass == s.r_pass)
            s.passClassValid = "valid";
        else
            s.passClassValid = "invalid";
    };

    s.send = function () {
        if(validFilledFields()){

            if(s.mailClassValid == "valid" && s.passClassValid == "valid" && s.theClassPass == "valid"){
                getTipoUsuario();
                Upload.upload({
                    url: url+urlTipoUsuario,
                    data: {
                        email: s.email,
                        password: s.pass,
                        first_name: s.nombre,
                        last_name: s.apellido,
                        cliente: s.empresas.selected
                    }
                }).then(function (data, status, headers, config) {
                    console.log(status);
                    s.nombre = "";
                    s.apellido = "";
                    s.email = "";
                    s.mailClassValid = "";
                    s.r_email = "";
                    s.pass = "";
                    s.theClassPass = "";
                    s.r_pass = "";
                    s.passClassValid = "";
                    Materialize.toast(MSG_SUCCESS, 5000, "rounded");
                }, function (data, status, headers, config) {
                    console.log("STATUS: ", status);
                    console.log("ERROR: ", data);
                    Materialize.toast(MSG_ERROR, 5000, "rounded");
                });
            }
            else{
                Materialize.toast("Algunos campos son incorrectos.", 5000, "rounded");
            }

        }else{
            Materialize.toast("Debes llenar todos los campos.", 5000, "rounded");
        }
    };
    
    
    function validFilledFields() {
        switch (s.tipos_usuario.selected){
            case s.tipos_usuario.options[0]:
                return (s.nombre != "" && s.apellido != "" && s.email != "" && s.mailClassValid != "" && s.r_email != ""
                && s.pass != "" && s.r_pass != "" && s.tipos_usuario.selected != null);
            case s.tipos_usuario.options[1]:
                return (s.nombre != "" && s.apellido != "" && s.email != "" && s.mailClassValid != "" && s.r_email != ""
                && s.pass != "" && s.r_pass != "" && s.empresas.selected != null && s.tipos_usuario.selected != null);
            default:
                return false;
        }
    }

    s.validShowEmpresa = function(){
        s.showEmpresa = (s.tipos_usuario.selected == s.tipos_usuario.options[0]);
    };
    function getTipoUsuario() {
        switch (s.tipos_usuario.selected)
        {
            case s.tipos_usuario.options[0]:
                urlTipoUsuario = "/registerAdmin";
                break;
            case s.tipos_usuario.options[1]:
                urlTipoUsuario = "/registerUser";
                break;
        }
    }


}]);