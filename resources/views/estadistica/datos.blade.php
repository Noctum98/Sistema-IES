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
		<div class="localidad">
			<label for="localidad">Localidad</label>
			<input type="text" class="form-control" id="localidad" name="localidad" value="{{ isset($localidad) ? $localidad : '' }}">
		</div>
		<div class="form-group">
			<label for="edad">Edad</label>
			<input type="number" name="edad" id="edad" class="form-control" value="{{ isset($edad) ? $edad : '' }}">
		</div>
		<input type="submit" value="Buscar">
	</form>

	@if(isset($status) && $status == 1)
	<table class="table mt-4">
		<thead class="thead-dark">
			<tr>
				<th scope="col">Dato</th>
				<th scope="col">Cantidad</th>
			</tr>
		</thead>
		<tbody>
			@if($edad)
			<tr>
				<td>Edad: {{$edad}} </td>
				<td>{{$edades}}</td>
			</tr>
			@endif
			<tr>
				<td>Discapacidad Visual: </td>
				<td>{{ $discapacidad_visual }}</td>
			</tr>

			<tr>
				<td>Discapacidad Motriz:</td>
				<td>{{ $discapacidad_motriz }}</td>
			</tr>

			<tr>
				<td>Discapacidad Mental:</td>
				<td>{{ $discapacidad_mental }}</td>
			</tr>

			<tr>
				<td>Discapacidad Intelectual:</td>
				<td>{{ $discapacidad_intelectual }}</td>
			</tr>

			<tr>
				<td>Discapacidad Auditiva:</td>
				<td>{{ $discapacidad_auditiva }}</td>
			</tr>

			<tr>
				<td>Población Indigena</td>
				<td>{{$poblacion_indigena}}</td>
			</tr>

			<tr>
				<td>Privado de libertad:</td>
				<td>{{$privacidad}}</td>
			</tr>

			@if($localidad)
			<tr>
				<td>Localidad: {{ $localidad }}</td>
				<td>{{$localidad_cantidad}}</td>
			</tr>
			@endif

			<tr>
				<td>Fuera de Mendoza</td>
				<td>{{$fuera_mendoza}}</td>
			</tr>
		</tbody>
	</table>
	@endif
</div>
@endsection
@section('scripts')
<script src="{{ asset('js/estadistica/datos.js') }}"></script>
@endsection