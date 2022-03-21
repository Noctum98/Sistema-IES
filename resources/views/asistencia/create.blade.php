@extends('layouts.app-prueba')
@section('content')
	<div class="container">
		<h2 class="h1">
			Tomar asistencias {{ $asistencia->materia->nombre }}
		</h2>
		<hr>
		<div class="col-md-8 asistencia-lista">
			<ul>
				@foreach($procesos as $proceso)
					<li class="row mt-4">
						<h4 class="col-md-8 ">
						{{ $proceso->alumno->nombres.' '.$proceso->alumno->apellidos }}
						</h4>
						<div class="row" id="botones-asistencia">
							
							<button class="btn-sm btn-outline-success mr-2 bn-presente" id="{{$proceso->alumno->id.'/'.$asistencia->id.'/presente'}}">
								Presente
							</button>
							<button class="btn-sm btn-outline-danger bn-presente" id="{{$proceso->alumno->id.'/'.$asistencia->id.'/ausente'}}">
								Ausente
							</button>
						</div>
					</li>
				@endforeach
			</ul>
			<a href="
			{{ route('asis.admin',['id'=>$asistencia->materia->id]) }}
			" class="btn btn-secondary ml-4">
				Guardar Planilla
			</a>
		</div>
		
	</div>
@endsection