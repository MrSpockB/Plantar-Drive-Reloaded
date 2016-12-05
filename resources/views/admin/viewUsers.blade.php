@extends('admin.layout')

@section('content')
<div class="row" style="margin-bottom: 0;">
    <div class="col m4 l4 s4">
        <h4>Lista de Usuarios</h4>
    </div>
</div>
<div class="divider" style="margin-bottom: 20px;"></div>
<div class="row">
    <div class="col m4 s4 center"><b>Nombre</b></div>
    <div class="col m4 s4 center"><b>Email</b></div>
    <div class="col m4 s4 center"><b>Rol</b></div>
</div>
<div class="divider" style="margin-bottom: 20px"></div>
@foreach($users as $user)
	 <div class="row" style="display: flex; align-items: center;">
		 <div class="col m4 s4 center">{{ $user->first_name.' '.$user->last_name }}</div>
		 <div class="col m4 s4 center">{{ $user->email }}</div>
		 <div class="col m4 s4 center">{{ isset($user->client) ? 'Usuario de '.$user->client->name : 'Administrador'}}</div>
	 </div>
@endforeach
@endsection