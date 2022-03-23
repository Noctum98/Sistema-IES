@extends('layouts.pdf')
<div class="container alumno">
	<h2 class="h1">
		Matriculación de {{ $alumno->nombres.' '.$alumno->apellidos }}
	</h2>
	<hr>
	<div class="col-md-12">
		<div class="">
			<div class="datos-alumno">
				<ul class="col-md-6">
					<h2>Datos de Personales</h3>
					<li><strong>Nombre:</strong> {{ $alumno->nombres }}</li>
					<li><strong>Apellidos:</strong> {{ $alumno->apellidos }}</li>
					<li><strong>Edad:</strong> {{ $alumno->edad }} años</li>
					<li><strong>Telefono:</strong> {{ $alumno->telefono }}</li>
					<li><strong>Email:</strong> {{ $alumno->email }}</li>
					<li><strong>Fecha de nacimiento: </strong> {{ $alumno->fecha }}</li>
					<li><strong>N° de documento: </strong> {{ $alumno->dni }}</li>
					<li><strong>CUIL: </strong> {{ $alumno->cuil }}</li>
					<li><strong>Género: </strong> {{ ucwords($alumno->genero) }}</li>
				</ul>
			</div>
		</div>
		<br>
		<div class="">
			<ul class="datos-academicos col-md-6">
				<li>
					<h2>Datos de Inscripción</h3>
				</li>
				<li>
					<strong>Inscripto a:</strong>
					<br>
					@foreach($alumno->carreras as $carrera)
					_ {{ $carrera->nombre.' ('.ucwords($carrera->turno).') - '.$carrera->sede->nombre }} 
					<br>
					Año: {{ $alumno->procesoCarrera($carrera->id,$alumno->id)->año }}
					@endforeach
				</li>
				<li><strong>Situación:</strong>{{ str_replace('_',' ',ucwords($alumno->regularidad)) }}</li>
				<li><strong>Escuela Secundaria: </strong> {{ $alumno->escuela_s }}</li>
				<li><strong>Articulo Séptimo: </strong> {{ $alumno->articulo_septimo ? 'Si' : 'No' }} </li>
				<li><strong>Finalizo Escuela Secundaria: </strong> {{ $alumno->condicion_s ? 'Si' : 'No' }}</li>
				<li><strong>Materias que adeuda de secundario: </strong> 
					@if(!$alumno->materias_s)
						Ninguna
					@else
						{{ str_replace(';',' - ',$alumno->materias_s) }}
					@endif
				</li>
				<li><strong>Presento título secundario:</strong> {{$alumno->titulo_s ? 'Si' : 'No'}} </li>
			</ul>
		</div>
		<div class="">
			<ul class="datos-academicos col-md-6">
				<li>
					<h2>Datos de Domicilio</h3>
				</li>
				<li><strong>Nacionalidad:</strong> {{ $alumno->nacionalidad }}</li>
				<li><strong>Provincia:</strong> {{ $alumno->provincia }}</li>
				<li><strong>Localidad:</strong> {{ $alumno->localidad }}</li>
				<li><strong>Calle: </strong> {{ $alumno->calle }}</li>
				<li><strong>N° de calle: </strong> {{ $alumno->n_calle }}</li>
				<li><strong>Barrio: </strong> {{ $alumno->barrio }}</li>
				<li><strong>Manzana: </strong> {{ $alumno->manzana }} </li>
				<li><strong>Casa: </strong> {{ $alumno->casa }}</li>
				<li><strong>Código Postal: </strong> {{ $alumno->codigo_postal }}</li>
			</ul>
		</div>
	</div>
</div>