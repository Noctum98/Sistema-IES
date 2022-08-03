@extends('layouts.app-prueba')
@section('content')
<div class="container">
	<h2 class="text-info">
		Administrar asistencias {{ $materia->nombre }}
		<br/>
	</h2>
	<hr>
	<div class="col-md-12">
		<br>
		@if($materia->carrera->tipo == 'tradicional')
			@include('asistencia.tables.table_tradicional')
		@elseif($materia->carrera->tipo == 'tradicional2')
			@include('asistencia.tables.table_tradicional_7030')
		@elseif($materia->carrera->tipo == 'modular')
			@include('asistencia.tables.table_modular')
		@elseif($materia->carrera->tipo == 'modular2')
			@include('asistencia.tables.table_modular_7030')
		@endif

	</div>

</div>
@endsection
@section('scripts')
<script src="{{ asset('js/asistencia/create.js') }}"></script>
@endsection
