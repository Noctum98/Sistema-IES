@extends('layouts.app-prueba')
@section('content')
<div class="container p-3">
	<h2 class="h1 text-info">
		Administrar alumnos
	</h2>
	<p>Agrega, edita o busca alumnos y su información</p>
	<hr>
	@if(@session('alumno_notIsset'))
	<div class="alert alert-warning">
		{{ @session('alumno_notIsset') }}
	</div>
	@endif
	<div class="col-md-8 row">
		<div class="col-md-5">
		<input type="hidden" id="materia_selected" name="materia_selected" value="{{ $materia_id ?? null }}">

			<form method="GET" action="{{ route('alumno.adminp') }}" id="buscador-alumnos" >
				<div class="row form-inline">
					<div class="input-group">
						{{-- <div class="input-group-append">--}}
						{{-- </div>--}}
						<input type="text" id="busqueda" name="busqueda" class="form-control" placeholder="Buscar alumno" aria-describedby="inputGroupPrepend2" value="{{ $busqueda && $busqueda != 1 ?? '' }}">
						<button class="input-group-text" id="inputGroupPrepend2" type="submit">
							<i class="fa fa-search text-info"></i>
						</button>
						<button type="button" class="input-group-text" data-bs-toggle="modal" data-bs-target="#filtrosAlumnos"><i class="fas fa-filter text-info"></i><div id="filtros_button"></div></button>
					</div>
				</div>
				@include('alumno.modals.filtros')

			</form>
		</div>
	</div>
	<div class="col-md-12">
		@if(!$busqueda)
		<table class="table mt-4 col-md-12">
			<thead class="thead-dark">
				<tr>
					<th scope="col">Nombre</th>
					<th scope="col">Resolución</th>
					<th scope="col">Sede</th>
					<th scope="col"><i class="fa fa-cog" style="font-size:20px;"></i></th>
				</tr>
			</thead>
			<tbody>
				@foreach ($sedes as $sede)
				@foreach($sede->carreras as $carrera)
				<tr>
					<td>{{ $carrera->nombre.' ('.ucwords($carrera->turno).')' }}</td>
					<td>{{ $carrera->resolucion }}</td>
					<td>{{ $carrera->sede->nombre }}</td>
					<td>
						<a href="{{ route('alumno.carrera',['carrera_id'=>$carrera->id]) }}" class="btn btn-sm btn-primary">
							Ver
						</a>
					</td>
				</tr>
				@endforeach
				@endforeach
			</tbody>
		</table>
		@elseif(!empty($alumnos))
		@if(count($alumnos) > 0)
		<br>
		<a id="descargar_busqueda" class="btn btn-sm btn-success"><i class="fas fa-download"></i>Descargar Alumnos</a>
		<table class="table mt-4">
			<thead class="thead-dark">
				<tr>
					<th scope="col">Nombre</th>
					<th scope="col">DNI</th>
					<th>Email</th>
					<th>Cohorte</th>
					<th scope="col"><i class="fa fa-cog" style="font-size:20px;"></i></th>
				</tr>
			</thead>
			<tbody>
				@foreach ($alumnos as $alumno)
				<tr>
					<td>{{ mb_strtoupper($alumno->apellidos).' '.ucwords($alumno->nombres) }}</td>
					<td>{{ $alumno->dni }}</td>
					<td>{{ $alumno->email }}</td>
					<td>{{ $alumno->cohorte ?? '-' }}</td>
					<td>
						<a href="{{ route('alumno.detalle',$alumno->id) }}" class="btn btn-sm btn-secondary">
							Ver datos
						</a>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		@else
		<br>
		<h5>No existen coincidencias con {{$busqueda}}</h5>
		@endif
		@endif

	</div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('js/user/carreras.js') }}"></script>
<script src="{{ asset('js/alumnos/filtros.js') }}"></script>

@endsection