@extends('admin.layout')

@section('content')
<div>
    <h4>Nuevo Cliente</h4>
    <div class="divider" style="margin-bottom: 20px;"></div>
    {!! Form::open(array('url' => 'data/clientes', 'method' => 'POST', 'id' => 'form-empresa', 'files' => true)) !!}
        <div class="input-field">
            <input type="text" id="txtNombre" name="nombre">
            <label for="txtNombre">Nombre</label>
        </div>
        <div class="file-field input-field">
            <div class="btn">
                <span>Imagen</span>
                <input type="file" name="logo">
            </div>
            <div class="file-path-wrapper">
                <input class="file-path" type="text">
            </div>
        </div>
        <input type="submit" value="Crear" class="btn waves-effect waves-light right">
    {!! Form::close() !!}
</div>
@endsection