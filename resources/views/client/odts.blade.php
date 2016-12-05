 @extends('client.layout')

 @section('content')
    <div class="row" style="margin-bottom: 0;">
        <div class="col m4 l4 s4">
            <h4>{{ $client->name }}</h4>
        </div>
        <div class="col m4 l4 s4" style="margin: 1.14rem 0 0.912rem 0;">
            <a href="{{ url('cliente/'.$client->slug.'/crearOrden') }}" class="btn waves-effect waves-light right">Crear Nueva</a>
        </div>
        <div class="col m4 l4 s4">
            <div class="row" style="margin-bottom: 0;">
                <div class="col s7" style="margin: 0.4rem 0 0.912rem 0;">
                    <input type="text" placeholder="Buscar">
                </div>
                <div class="col s5" style="margin: 1rem 0 0.912rem 0;">
                    <a class="btn-floating waves-effect waves-light"><i class="material-icons">search</i></a>
                </div>
            </div>
        </div>
    </div>
    @if(session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <div class="divider" style="margin-bottom: 20px;"></div>
    @if (count($client->odts)>0)
        <table class="highlight centered">
            <thead>
                <tr>
                    <th><b>Orden de trabajo</b></th>
                    <th><b>Encargado</b></th>
                    <th><b>Fecha Inicial</b></th>
                    <th><b>Fecha Final</b></th>
                    <th><b>Progreso</b></th>
                    <th><b>Salida</b></th>
                </tr>
            </thead>
            <tbody>
                @foreach($client->odts as $ODT)
                    <tr>
                        <td><a href="{{ url('cliente/'.$client->slug.'/ODT/'.$ODT->id) }}">{{ $ODT->name }}</a></td>
                        <td>Encargado 1</td>
                        <td>{{ $ODT->startDate->format('l jS \\of F Y')  }}</td>
                        <td>{{ $ODT->endDate->format('l jS \\of F Y')  }}</td>
                        <td>
                            <div class="progress">
                                <div class="determinate" style="width: {{ $ODT->time_progress }}%"></div>
                            </div>
                            <div class="progress">
                                <div class="determinate" style="width: {{ $ODT->progress_real }}%"></div>
                            </div>
                        </td>
                        <td>
                            <a class="btn-floating waves-light waves-effect green"></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <h3>No hay ordenes de trabajo</h3>
    @endif
 @endsection