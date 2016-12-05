@extends('client.layout')
@section('classes')
    large
@endsection

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('lib/css/dropzone.css') }}">
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('lib/js/dropzone.js') }}"></script>
@endsection

@section('content')
<div class="col m4 l4 s4">
    <h3>{{ $client->name }}</h3>
    <h5>Crear Orden de Trabajo</h5>
</div>
<div class="divider" style="margin-bottom: 20px;"></div>
<form class="form-odt" id="formODT" method="POST" action="{{ url('/cliente/'.$client->slug.'/crearOrden') }}">
    <div class="input-field">
        <input type="text" id="txtNombreProyecto" name="nombre">
        <label for="txtNombreProyecto">Nombre del Proyecto</label>
    </div>
    <div class="input-field">
        <input id="txtCliente" type="text" disabled value="{{ $client->name }}">
        <label for="txtCliente" class="active">Cliente</label>
    </div>
    <div class="input-field">
        <input type="text" id="fechaCreacion" name="fechaCreacion" readonly>
        <label for="txtFecha" class="active">Fecha</label>
    </div>
    <div class="input-field" style="margin-bottom: 35px;">
        <select name="area">
            <option value="" disabled selected>Areas</option>
            <option value="web">Web</option>
            <option value="diseño">Diseño</option>
            <option value="contenido">Contenido</option>
            <option value="multimedia">Multimedia</option>
            <option value="estrategia">Estrategia</option>
            <option value="cotizaciones">Cotizaciónes</option>
            <label>Área</label>
        </select>
    </div>
    <div class="input-field">
        <textarea id="txtadescProyecto" class="materialize-textarea" name="descripcion"></textarea>
        <label for="txtadescProyecto">Descripcion del Proyecto</label>
    </div>
    <div class="input-field">
        <input type="text" id="txtResponsables" autocomplete="off">
        <label for="txtResponsables">Responsables</label>
    </div>
    <div id="listResp">
        <div class="chip">Plantar</div>
    </div>
    <div class="input-field">
        <input type="date" class="datepicker" id="dtInicio" name="fechaInicio">
        <label for="dtInicio">Fecha de Inicio</label>
    </div>
    <div class="input-field">
        <input type="date" class="datepicker" id="dtFin" name="fechaFin">
        <label for="dtFin">Fecha de Fin</label>
    </div>
    <input type="hidden" name="filesIDs" id="filesIDs">
    <input type="hidden" name="usuariosIDs" id="usuariosIDs">
</form>
<form action="{{url('/cliente/'.$client->slug.'/uploadFile')}}" class="dropzone" id="filesDropzone"></form>
<div class="wrap-form">
    <input type="submit" value="Crear Orden de Trabajo" class="btn waves-effect waves-light btnCreateODT">
</div>
<script>
	var usersJson = {!! (string) $client->users !!};
	var users = []
	var usersResp = [0];
    var ids = [];
	usersJson.forEach(function(client)
	{
		var temp = {}
		temp.label = client.first_name + " " + client.last_name;
		temp.value = client.id;
		users.push(temp);
	});
	function removeChip(value)
	{
		$('.chip[data-id="'+value+'"]').remove();
		var pos = usersResp.indexOf(value);
		usersResp.splice(pos,1);
        $('#usuariosIDs').val(usersResp.join());
	}
	function addChipToHtml(label, value)
	{
		$('#listResp').append('<div class="chip" data-id="'+value+'">'+label+'<i class="material-icons" onClick="removeChip('+value+')">close</i></div>');
		$("#txtResponsables").val("");
	}
	$(document).ready(function() {
        Dropzone.options.filesDropzone =
        {
            dictDefaultMessage: "Arrastra los archivos para subirlos",
            paramName: "file",
            init: function()
            {
                this.on("success", function(file, res)
                {
                    ids.push(res.id);
                    $('#filesIDs').val(ids.join());
                });
            }
        };
		$('select').material_select();
		$('.datepicker').pickadate({
                selectMonths: true,
                selectYears: 15,
                formatSubmit: 'yyyy-mm-dd',
        });
        $("#txtResponsables").autocomplete({
        	minLength: 1,
        	source: users,
        	select: function (event, ui) {
                var label = ui.item.label;
                var value = ui.item.value;
                usersResp.push(value);
                $('#usuariosIDs').val(usersResp.join());
                addChipToHtml(label, value);
                return false;
            },
            focus: function (event, ui) {
                var label = ui.item.label;
                var value = ui.item.value;
                $("#txtResponsables").val(label);
                return false;
            }
        });
        $('.btnCreateODT').click(function(){
            $('#formODT').submit();
        });
		var time = moment().format("YYYY-MM-DD");
		$('#fechaCreacion').val(time);
	});
</script>

@endsection