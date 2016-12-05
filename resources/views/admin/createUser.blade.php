@extends('admin.layout')

@section('content')
	<div>
	    <h4>Nuevo Usuario</h4>
	    @if(session('message'))
	    	<div class="alert alert-success">
	    		{{ session('message') }}
	    	</div>
	    @endif
	    <div class="divider" style="margin-bottom: 20px;"></div>
	    {!! Form::open(array('url' => 'admin/crearUsuario', 'method' => 'POST', 'class' => 'form-user')) !!}
	        <select name="tipo">
	            <option value="" disabled selected>Tipo de usuario</option>
	            <option value="admin">Administrador</option>
	            <option value="user">Usuario</option>
	        </select>
	        <div class="input-field">
	        	<input type="text" name="first_name" id="txtNombre">
	        	<label for="txtNombre">Nombre</label>
	        </div>
	        <div class="input-field">
	        	<input type="text" name="last_name" id="txtApellido">
	        	<label for="txtApellido">Apellido</label>
	        </div>
	        <div class="input-field">
	            <input type="email" name="email" id="txtMail" class="validate">
	            <label for="txtMail">Correo</label>
	        </div>
	        <div class="input-field">
	        	<input type="email" name="r_email" id="txtRMail" class="validate">
	        	<label for="txtRMail">Repetir Correo</label>
	        </div>
	        <div class="input-field">
	        	<input type="password" name="password" id="txtPass">
	        	<label for="txtPass">Contraseña</label>
	        </div>
	        <div class="input-field">
	        	<input type="password" name="r_pass" id="txtRPass">
	        	<label for="txtRPass">Repetir Contraseña</label>
	        </div>
	        <select name="cliente">
	            <option value="" disabled selected>Empresa</option>
	            @foreach($clients as $client)
	            <option value="{{ $client->slug }}">{{ $client->name }}</option>
	            @endforeach
	        </select>
	        <input type="submit" class="btn waves-effect waves-light" value="Crear">
	    {!! Form::close() !!}
	</div>
	<script>
	    setTimeout(function () {
	        $(document).ready(function() {
	            $('select').material_select();
	        });
	    }, 300);
	</script>
@endsection