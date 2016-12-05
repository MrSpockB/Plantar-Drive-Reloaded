@extends('admin.layout')

@section('content')

<div class="row">
    @foreach($clients as $client)
        <div class="col s12 m3">
            <a href="{{ url('cliente/'.$client->slug) }}">
                <div class="card-panel" style="border-radius: 20px;">
                    <div class="row valign-wrapper" style="margin-bottom: 0;">
                        <div class="col s5">
                            <div style="width: 60px; height: 60px; overflow: hidden;" class="circle">
                                <div style="background-image: url({{ $client->path_image }}); height: 100%; width:100%; background-size: cover; background-position: 50%;"></div>
                            </div>
                        </div>
                        <div class="col s7">
                            <span class="black-text">{{ $client->name }}</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    @endforeach
</div>

@endsection