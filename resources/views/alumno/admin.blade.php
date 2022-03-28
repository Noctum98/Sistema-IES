@extends('layouts.app-prueba')
@section('content')
	<div class="container p-3">
		<h2 class="h1">
			Administrar alumnos
		</h2>
		<p>Agrega, edita o busca alumnos y su información</p>
		<hr>
		<div class="col-md-6 row">
			<div class="col-md-6 mr-2">
				<form method="GET" action="#" id="buscador-alumnos">
					<div class="row pr-2">
						<input type="text" id="busqueda" class="form-control" placeholder="Buscar alumno">
					</div>
				</form>
			</div>
		</div>
		<div class="col-md-12">
			@if(!empty($sedes))
				<table class="table mt-4 col-md-12">
				  <thead class="thead-dark">
				    <tr>
				      <th scope="col">Nombre</th>
				      <th scope="col">Resolución</th>
				      <th scope="col">Sede</th>
				      <th scope="col">Acción</th>
				    </tr>
				  </thead>
				  <tbody>
				  	@foreach ($sedes as $sede)
						@foreach($sede->carreras as $carrera)
							<tr>
							<td>{{ $carrera->nombre }}</td>
							<td>{{ $carrera->resolucion }}</td>
							<td>{{ $carrera->sede->nombre }}</td>
							<td>
								<a href="{{ route('alumno.carrera',['carrera_id'=>$carrera->id]) }}" class="btn-sm btn-primary">
									Ver alumnos
								</a>
							</td>
							</tr>
						@endforeach
				    @endforeach
				  </tbody>
				</table>
			@elseif(!empty($alumnos))
				@if(count($alumnos) > 0)
				<table class="table mt-4">
				  <thead class="thead-dark">
				    <tr>
				      <th scope="col">Nombre</th>
				      <th scope="col">DNI</th>
				      <th scope="col">Acción</th>
				    </tr>
				  </thead>
				  <tbody>
				  	@foreach ($alumnos as $alumno)
				    <tr>
				      <td>{{ $alumno->nombres.' '.$alumno->apellidos }}</td>
				      <td>{{ $alumno->dni }}</td>
				      <td>
				      	<a href="{{ route('alumno.detalle',['id'=>$alumno->id]) }}" class="btn btn-sm btn-primary">
				      		Ver datos
				      	</a>
				      </td>
				    </tr>
				    @endforeach
				  </tbody>
				</table>
				@else
					<h5>No existen coincidencias con {{$busqueda}}</h5>
				@endif
			@endif
			
		</div>
	</div>
@endsection