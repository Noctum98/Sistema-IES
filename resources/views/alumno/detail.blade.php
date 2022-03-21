@extends('layouts.app-prueba')
@section('content')
<div class="container alumno">
	<h2 class="h1">
		Datos de {{ $alumno->nombres.' '.$alumno->apellidos }}
	</h2>
	<hr>
	<div class="col-md-12">
		@if(@session('mensaje_exitoso'))
			<div class="alert alert-success">
				{{ @session('mensaje_exitoso') }}
			</div>
		@endif
		@if(@session('mensaje_procesos'))
			<div class="alert alert-warning">
				{{ @session('mensaje_procesos') }}
			</div>
		@endif
		@if(@session('mensaje_editado'))
			<div class="alert alert-success">
				{{ @session('mensaje_editado') }}
			</div>
		@endif
		@if(@session('mensaje_error'))
			<div class="alert alert-danger">
				{{ @session('mensaje_error') }}
			</div>
		@endif
		<div class="row">
			<div class="imagen-alumno ml-4 mb-3 col-md-2">
				@if(!$alumno->imagen)
				<img src="{{ asset('images/alumno-default.png') }}" alt="default-profile" class="col-md-12">
				@else
				<img src="{{ route('ver_imagen',['foto'=>$alumno->imagen]) }}" class="col-md-12">
				@endif
			</div>
			<div class="datos-alumno">
				<ul>
					<li><strong>Nombre:</strong> {{ $alumno->nombres }}</li>
					<li><strong>Apellidos:</strong> {{ $alumno->apellidos }}</li>
					<li><strong>Edad:</strong> {{ $alumno->edad }} años</li>
					<li><strong>Teléfono Celular:</strong> {{ $alumno->telefono }}</li>
					<li><strong>Teléfono Fijo:</strong> {{ $alumno->telefono_fijo }}</li>

				</ul>
			</div>
		</div>
		<br>
		<div class="row col-md-12">
			<ul class="datos-generales col-md-6">
				<li>
					<h2>Datos Generales</h3>
				</li>
				<li><strong>Email:</strong> {{ $alumno->email }}</li>
				<li><strong>Fecha de nacimiento: </strong> {{ $alumno->fecha }}</li>
				<li><strong>N° de documento: </strong> {{ $alumno->dni }}</li>
				<li><strong>CUIL: </strong> {{ $alumno->cuil }}</li>
				<li><strong>Edad: </strong> {{ $alumno->edad }} años</li>
				<li><strong>Género: </strong> {{ ucwords($alumno->genero) }}</li>
				<li><strong>Nacionalidad: </strong> {{ ucwords($alumno->nacionalidad) }}</li>

			</ul>
			<ul class="datos-domicilio col-md-6">
				<li>
					<h2>Datos Domicilio</h3>
				</li>
				<li><strong>Localidad:</strong> {{ $alumno->localidad }}</li>
				<li><strong>Calle: </strong> {{ $alumno->calle }}</li>
				<li><strong>N° de calle: </strong> {{ $alumno->n_calle }}</li>
				<li><strong>Barrio: </strong> {{ $alumno->barrio }}</li>
				<li><strong>Manzana: </strong> {{ $alumno->manzana }} </li>
				<li><strong>Casa: </strong> {{ $alumno->casa }}</li>
				<li><strong>Código Postal: </strong> {{ $alumno->codigo_postal }}</li>

			</ul>
			<ul class="datos-domicilio col-md-6">
				<li>
					<h2>Datos Personales</h3>
				</li>
				<li><strong>Estado Civil:</strong> {{ ucwords($alumno->estado_civil) }}</li>
				<li><strong>Ocupación: </strong> {{ ucwords($alumno->ocupacion) }}</li>
				<li><strong>Grupo Sanguineo: </strong> {{ ucwords($alumno->g_sanguineo) }}</li>
				<li><strong>Escuela Secundaria: </strong> {{ $alumno->escuela_s }}</li>
				<li><strong>Articulo Séptimo: </strong> {{ $alumno->articulo_septimo ? 'Si' : 'No' }} </li>
				<li><strong>Finalizo Escuela Secundaria: </strong> {{ $alumno->condicion_s ? 'Si' : 'No' }}</li>
				<li><strong>Código Postal: </strong> {{ $alumno->codigo_postal }}</li>
				<li><strong>Materias que adeuda de secundario: </strong> 
					@if(!$alumno->materias_s)
						Ninguna
					@else
						{{ str_replace(';',' - ',$alumno->materias_s) }}
					@endif
				</li>
				<li><strong>Presento título secundario:</strong> {{$alumno->titulo_s ? 'Si' : 'No'}} </li>
				<li><strong>Estudiante de población indigena:</strong> {{$alumno->poblacion_indigena ? 'Si' : 'No'}} </li>
				<li><strong>Privación de libertad o en regímenes semi-abiertos:</strong> {{$alumno->privacidad ? 'Si' : 'No'}} </li>
			</ul>
			<ul class="datos-academicos col-md-6">
				<li>
					<h2>Datos de Inscripción</h3>
				</li>
				<li>
					<strong>Inscripto a:</strong>
					<br>
					@foreach($alumno->carreras as $carrera)
					_ {{ $carrera->nombre.' ('.ucwords($carrera->turno).') - '.$carrera->sede->nombre }}

					@if(Auth::user()->hasRole('coordinador'))
						<button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#carrerasMatriculacionModal{{$carrera->id}}">Ver materias inscriptas</button>
						@include('alumno.modals.carreras_matriculacion')
					@endif
					@endforeach
				</li>

			</ul>


		</div>

		@if(Auth::user()->hasRole('coordinador'))
		<div class="row col-md-6">
			@if(!$alumno->user_id)
				<a href="{{ route('crear_usuario_alumno',['id'=>$alumno->id]) }}" class="col-md-5 mt-4 btn btn-success">
					Crear Usuario
				</a>
			@endif
			<a href="{{ route('matriculacion.edit',['alumno_id'=>$alumno->id,'carrera_id'=>$carrera->id]) }}" class="col-md-5 ml-2 mt-4 btn btn-warning">
				Corregir datos
			</a>
		</div>
		@endif
	</div>
</div>
@endsection