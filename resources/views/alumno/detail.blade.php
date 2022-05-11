@extends('layouts.app-prueba')
@section('content')
<div class="container alumno">
	<h2 class="h1 text-info">
		Datos de {{ ucwords($alumno->nombres.' '.$alumno->apellidos) }}
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
		@if(@session('mensaje_error'))
		<div class="alert alert-danger">
			{{ @session('mensaje_error') }}
		</div>
		@endif

		<div class="m-0 p-0 col-md-12">
			<ul>
				<li><strong>Nombre:</strong> {{ ucwords($alumno->nombres) }}</li>
				<li><strong>Apellidos:</strong> {{ ucwords($alumno->apellidos) }}</li>
				<li><strong>Edad:</strong> {{ $alumno->edad }} años</li>
				<li><strong>Teléfono Celular:</strong> {{ $alumno->telefono }}</li>
				<li><strong>Teléfono Fijo:</strong> {{ $alumno->telefono_fijo }}</li>
			</ul>
		</div>

		<br>
		<div class="row col-md-12">
			<ul class="datos-generales col-md-6">
				<li>
                    <h2 class="text-info"><u>Datos Generales</u></h2>
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
                    <h2 class="text-info"><u>Datos Domicilio</u></h2>
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
                    <h2 class="text-info"><u>Datos Personales</u></h2>
				</li>
				<li><strong>Estado Civil:</strong> {{ ucwords($alumno->estado_civil) }}</li>
				<li><strong>Ocupación: </strong> {{ ucwords($alumno->ocupacion) }}</li>
				<li><strong>Grupo Sanguíneo: </strong> {{ strtoupper($alumno->g_sanguineo) }}</li>
				@if($alumno->año == 1)
				<li><strong>Escuela Secundaria: </strong> {{ $alumno->escuela_s }}</li>
				<li><strong>Articulo Séptimo: </strong> {{ $alumno->articulo_septimo ? 'Si' : 'No' }} </li>
				<li><strong>Finalizo Escuela Secundaria: </strong> {{ $alumno->escolaridad ? 'Si' : 'No' }}</li>
				<li><strong>Materias que adeuda de secundario: </strong>
					@if(!$alumno->materias_s)
					Ninguna
					@else
					{{ str_replace(';',' - ',$alumno->materias_s) }}
					@endif
				</li>
				<li><strong>Presento título secundario:</strong> {{$alumno->titulo_s ? 'Si' : 'No'}} </li>
				@endif
				<li><strong>Código Postal: </strong> {{ $alumno->codigo_postal }}</li>
				<li><strong>Estudiante de población indígena:</strong> {{$alumno->poblacion_indigena ? 'Si' : 'No'}} </li>
				<li><strong>Privación de libertad o en regímenes semi-abiertos:</strong> {{$alumno->privacidad ? 'Si' : 'No'}} </li>
			</ul>

			<ul class="datos-academicos col-md-6">
				<li>
                    <h2 class="text-info"><u>Datos de Inscripción</u></h2>
				</li>
				<li> <strong>Condición: </strong>{{ explode("_",ucwords($alumno->regularidad))[0].' '.explode("_",ucwords($alumno->regularidad))[1] }} </li>
				<li>
					<strong>Inscripto a:</strong>
					<br>
					@foreach($alumno->carreras as $carrera)
                        _ {{ $carrera->nombre.' ('.ucwords($carrera->turno).') - '.$carrera->sede->nombre }}
                        <br>
                        Año: {{ $alumno->procesoCarrera($carrera->id,$alumno->id)->año }}
                        <br>

                        <div class="row">
                            @if(Auth::user()->hasRole('regente') || Auth::user()->hasRole('coordinador') || Auth::user()->hasRole('seccionAlumnos'))
                                <button class="btn btn-sm btn-primary col-md-3 mr-2" data-bs-toggle="modal" data-bs-target="#carrerasMatriculacionModal{{$carrera->id}}">Ver materias</button>
                                @include('alumno.modals.carreras_matriculacion')

                                <button class="btn btn-sm btn-primary col-md-3 mr-2" data-bs-toggle="modal" data-bs-target="#carrerasAñoModal{{$carrera->id}}">Cambiar año</button>
                                @include('alumno.modals.carreras_year')
                            @endif

                            @if(Auth::user()->hasRole('regente') || Auth::user()->hasRole('coordinador'))
                                <button class="btn btn-sm btn-danger col-md-3" data-bs-toggle="modal" data-bs-target="#eliminarMatriculacionModal{{$carrera->id}}">Eliminar</button>
                                @include('alumno.modals.correo_eliminar')
                            @endif
                        </div>
					@endforeach
				</li>
			</ul>
		</div>

		<div class="d-inline col-md-12">
			@if(Auth::user()->hasRole('regente') || Auth::user()->hasRole('coordinador') || Auth::user()->hasRole('seccionAlumnos'))

				@if(!$alumno->user_id)
				<a href="{{ route('crear_usuario_alumno',['id'=>$alumno->id]) }}" class="col-md-2 mt-4 btn btn-sm btn-success">
					Crear Usuario
				</a>
				@endif
				<a href="{{ route('matriculacion.edit',['alumno_id'=>$alumno->id,'carrera_id'=>$carrera->id]) }}" class="col-md-2 ml-2 mr-2 mt-4 btn btn-sm btn-warning">
					Corregir datos
				</a>

			@endif
			<a href="{{ route('descargar_ficha',$alumno->id) }}" class="col-md-2 mt-4 btn btn-sm btn-primary">Descargar PDF</a>
		</div>
	</div>
</div>
@endsection
