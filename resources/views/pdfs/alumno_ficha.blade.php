@extends('layouts.pdf')
<div class="container alumno">
	<h2 class="h1">
		Datos de {{ $alumno->nombres.' '.$alumno->apellidos }}
	</h2>
	<hr>
	<div class="col-md-12">
		<div class="">
			<div class="imagen-alumno ml-4">
				<img src="{{ route('ver_imagen',['foto'=>$alumno->imagen]) }}">
			</div>
			<div class="datos-alumno">
				<ul>
					<li><strong>Nombre:</strong> {{ $alumno->nombres }}</li>
					<li><strong>Apellidos:</strong> {{ $alumno->apellidos }}</li>
					<li><strong>Edad:</strong> {{ $alumno->edad }} años</li>
					<li><strong>Telefono:</strong> {{ $alumno->telefono }}</li>
				</ul>
			</div>
		</div>
		<br>
		<div class="">
			<ul class="datos-academicos">
				<li><h2>Datos Académicos</h3></li>
				<li><strong>Carrera:</strong> {{ $alumno->carrera->nombre }}</li>
				<li><strong>Año de carrera:</strong> {{ $alumno->año }}</li>
				<li><strong>Título secundario:</strong> 
					{{ ucwords($alumno->escolaridad) }}
				</li>
				<li><strong>Situación escolar</strong>
					{{ucwords($alumno->condicion_s)}}
				</li>
				<li><strong>Estudió en:</strong> {{ $alumno->escuela_s }}</li>
				<li><strong>Debe materias:</strong> {{ ucwords($alumno->materias_s) }}</li>
				<li>
					<strong>Partida de nacimiento:</strong>
					@if($alumno->partida_archivo)
						Archivo subido
					@else
						No hay un archivo subido
					@endif
				</li>
				<li>
					<strong>Título de nivel Secundario:</strong>
					@if($alumno->titulo_archivo)
						Archivo subido
					@else
						No hay un archivo subido
					@endif
				</li>
				<li>
					<strong>Certificado de nivel Secundario:</strong>
					@if($alumno->certificado_archivo)
						Archivo subido
					@else
						No hay un archivo subido
					@endif
				</li>
				<li>
					<strong>Psicofisico:</strong>
					@if($alumno->psicofisico_archivo)
						Archivo subido
					@else
						No hay un archivo subido
					@endif
				</li>
			</ul>
			<ul class="datos-academicos">
				<li><h2>Datos Personales</h3></li>
				<li><strong>Email:</strong> {{ $alumno->email }}</li>
				<li><strong>Fecha de nacimiento: </strong> {{ $alumno->fecha }}</li>
				<li><strong>N° de documento: </strong> {{ $alumno->dni }}</li>
				<li><strong>CUIL:</strong> {{ $alumno->cuil }}</li>
				<li><strong>Nacionalidad:</strong> {{ $alumno->nacionalidad }}</li>
				<li><strong>Residencia:</strong> {{ $alumno->residencia }}</li>
				<li><strong>Domicilio:</strong> {{ $alumno->domicilio }}</li>
				<li><strong>Conexión a internet:</strong> {{ ucwords($alumno->conexion) }}</li>
				<li><strong>DNI:</strong>
					 @if($alumno->dni_archivo)
						Archivo subido
					@else
						No hay un archivo subido
					@endif
				</li>
			</ul>
		</div>
	</div>
</div>