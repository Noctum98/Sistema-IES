@extends('layouts.app-prueba')
@section('content')
<div class="container">
	<h2 class="h1 text-info">
		Datos estadisticos
	</h2>
	<hr>
	<form action="" id="datos-form">
		<div class="form-group">
			<label for="sede_id">Unidades Academicas</label>
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
	<div>
		<canvas id="identidad_genero" class="d-none"></canvas>
	</div>



</div>
@endsection
@section('scripts')
<script src="{{ asset('js/estadistica/datos.js') }}"></script>
@endsection