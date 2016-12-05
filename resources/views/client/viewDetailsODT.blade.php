 @extends('client.layout')

@section('classes')
detailODT
@endsection

 @section('content')
	<h4>ODT: {{ $odt->name }}</h4>
	<hr>
	<h5><a href="{{ url('/cliente/'.$odt->client->slug) }}">{{ $odt->client->name }}</a></h5>
	<div class="row">
		<div class="col s8">
			<div class="card">
				<div class="card-content">
					<span class="card-title">Descripción del Proyecto</span>
					<hr>
					<p>{!! nl2br(e($odt->description)) !!}</p>
				</div>
			</div>
			<div class="card">
				<div class="card-content">
					<span class="card-title">Comentarios</span>
					<ul class="collection">
					@foreach($odt->comments as $comment)
						<li class="collection-item">
							<span class="title">{{ $comment->user->first_name.' '.$comment->user->last_name }}</span>
							<hr>
							<p>{{ nl2br(e($comment->comment)) }}</p>
						</li>
					@endforeach
					</ul>
					<div class="row">
						<form id="formComs" action="" class="col s12 row">
							<div class="input-field col s12">
								<input type="text" id="comentario">
								<label for="comentario">Agregar Comentario</label>
								<input type="submit" hidden>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="col s4">
			<div class="card">
				<div class="card-content">
					<span class="card-title">Características</span>
					<hr>
					<p>
						<h6>Fecha de creación:</h6>
						<blockquote>{{ $odt->creationDate->format('l jS \\of F Y')  }}</blockquote><br>
						<h6>Área:</h6>
						<blockquote>{{ $odt->area  }}</blockquote><br>
						<h6>Estado:</h6>
						<blockquote>{{ $odt->status  }}</blockquote><br>
						<h6>Fecha Inicial:</h6>
						<blockquote>{{ $odt->startDate->format('l jS \\of F Y')  }}</blockquote><br>
						<h6>Fecha Final:</h6>
						<blockquote>{{ $odt->endDate->format('l jS \\of F Y')  }}</blockquote><br>
					</p>
				</div>
			</div>
			<div class="card">
				<div class="card-content">
					<span class="card-title">Responsables</span>
					<hr>
					<p>
						@foreach($odt->users as $user)
							{{ $user->full_name }}<br>
						@endforeach
					</p>
				</div>
			</div>
			<div class="card">
				<div class="card-content">
					<span class="card-title">Archivos Adjuntos</span>
					<hr>
					<p>
						@foreach($odt->files as $file)
							{{ $file->name }}<br>
						@endforeach
					</p>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#formComs').submit(function(event){
				console.log("form submitting");
				event.preventDefault();
			})
		});
	</script>
 @endsection