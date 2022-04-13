@extends('layouts.app-prueba')
@section('content')
<div class="container">
	<h2 class="h1">
		Administrar asistencias {{ $materia->nombre }}
	</h2>
	<hr>
	<div class="col-md-12">

		<br>
		<br>
		<div id="accordion">


			<table class="table">
				<thead class="thead-dark">
					<th>Nombre y Apellido</th>
					<th>Porcentaje</th>
					<th>Cargar</th>
				</thead>
				<tbody>
					@foreach($procesos as $proceso)
					<tr>
						<td>
							{{ $proceso->alumno->nombres.' '.$proceso->alumno->apellidos }}
						</td>
						<td class="font-weight-bold">
							<form action="" class="col-md-3 m0 p-0 asis-alumnos" id="{{ $proceso->id }}" method="POST">
								<input type="number" class="form-control" id="asis-procentaje-{{ $proceso->id }}" required>
						</td>
						<td>
							<button class="btn btn-sm btn-outline-success">Cargar</button>
						</form>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>

</div>
@endsection
@section('scripts')
<script src="{{ asset('js/asistencia/create.js') }}"></script>
@endsection