@extends('layouts.app-prueba')
@section('content')
<div class="container">
	<h2 class="h1 text-info">
		Datos estadísticos
	</h2>
	<hr>
	<form action="" id="datos-form">
		<div class="form-group">
			<label for="sede_id">Unidades Académicas</label>
			<select name="sede_id" id="sede_id" class="form-select">
				@foreach($sedes as $sede)
				<option value="{{ $sede->id }}" {{ isset($sede_id) && $sede->id == $sede_id ? 'selected':'' }}>{{ $sede->nombre }}</option>
				@endforeach
			</select>
		</div>
		<div class="form-group">
			<label for="carrera_id">Carreras</label>
			<select name="carrera_id" id="carrera_id" class="form-select">
				<option value="">Ninguna</option>
				@foreach($carreras as $carrera)
				<option value="{{ $carrera->id }}" {{ isset($carrera_id) && $carrera->id == $carrera_id ? 'selected':'' }}>{{ $carrera->nombre.' ('.$carrera->turno.') - '.$carrera->sede->nombre }}</option>
				@endforeach
			</select>

		</div>
		<div class="form-group">
			<label for="localidad">Año</label>
			<input type="text" class="form-control" id="año" name="año" value="{{ isset($año) ? $año : '' }}">
		</div>

		<input type="submit" value="Buscar" class="btn btn-success">
	</form>

	<div id="graficos" class="d-none">
		@foreach($questions as $i => $question)
		<div class="card mt-3">
			<div class="card-header p-3 bg-info text-center">
				{{$i}}
			</div>
			<div class="card-body">
				<canvas id="{{$question}}"></canvas>
			</div>
		</div>
		@endforeach
	</div>



</div>
@endsection
@section('scripts')
<script src="{{ asset('js/estadistica/datos.js') }}"></script>
@endsection