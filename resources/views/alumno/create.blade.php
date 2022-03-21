@extends('layouts.app-prueba')
@section('content')
	<div class="container p-2">
		<h2 class="h1">
			Inscribir alumno en {{ $carrera->nombre }}
		</h2>
		<hr>
		<div class="col-md-5">
			@if(@session('message'))
				<div class="alert alert-success">
					{{ @session('message') }}
				</div>
			@endif
			@include('includes.inscribir')
		</div>
	</div>
@endsection