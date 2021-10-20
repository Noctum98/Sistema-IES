@extends('layouts.app')
@section('content')
	<div class="container alumno">
		<h2 class="h1">
			Datos de {{ $alumno->nombres.' '.$alumno->apellidos }}
		</h2>
		<hr>
		<div class="col-md-12">
			<div class="row">
				<div class="imagen-alumno ml-4">
					@if(!$alumno->imagen)
					<img src="{{ asset('images/alumno-default.png') }}" alt="default-profile">
					@else
					<img src="{{ route('ver_imagen',['foto'=>$alumno->imagen]) }}">
					@endif
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
				</ul>
				<ul class="datos-academicos">
					<li><h2>Datos Personales</h3></li>
					<li><strong>Email:</strong> {{ $alumno->email }}</li>
					<li><strong>Fecha de nacimiento: </strong> {{ $alumno->fecha }}</li>
					<li><strong>N° de documento: </strong> {{ $alumno->dni }}</li>
				</ul>
			</div>
			<div class="row">
				<a href="{{ route('alumno.editar',['id'=>$alumno->id]) }}" class="ml-4 mt-4 btn btn-warning">
					Editar datos
				</a>
				<a href="{{ route('descargar_ficha',['id'=>$alumno->id]) }}" class="ml-4 mt-4 btn btn-danger">
					Descargar datos
				</a>
			</div>
		</div>
	</div>
@endsection