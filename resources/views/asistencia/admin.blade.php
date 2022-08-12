@extends('layouts.app-prueba')
@section('content')
<div class="container">
	<h3 class="text-info">
		Administrar asistencias {{ $materia->nombre }}
		@if($cargo??'')
			<br/>
			<h5 class="text-dark ml-2 d-inline-block">Cargo: <i>{{$cargo->nombre}}</i></h5>
			<a href="{{route('proceso.listadoCargo', ['materia_id' => $materia->id, 'cargo_id'=> $cargo->id])}}"
			class="btn btn-sm d-inline-block"
			>
				<i class="fa fa-external-link-alt"></i> Ver calificaciones
			</a>
		@endif
	</h3>
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
