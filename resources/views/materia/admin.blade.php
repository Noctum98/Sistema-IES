@extends('layouts.app-prueba')
@section('content')
	<div class="container p-3">
		<h2 class="h1">
			Plan de estudios de {{ $carrera->nombre }}
		</h2>
		<p>Revisa y administra el plan de estudios</p>
		<hr>
		<a href="{{ route('materia.crear',['carrera_id'=>$carrera->id]) }}" class="btn btn-success mb-4">
			Agregar materia
		</a>
		<div class="col-md-8">
		    @if($carrera->estado != 1)
			<h3>Primer Año</h3>
			<table class="table table-hover mt-4">
				  <thead class="thead-dark">
				    <tr>
				      <th scope="col">Materia</th>
				      <th scope="col">Correlativa</th>
				      <th scope="col">Accion</th>
				    </tr>
				  </thead>
				  <tbody>
				  	@foreach($materias as $materia)
						@if($materia->año == 1)
						<tr style="cursor:pointer;">
					      <td>{{ $materia->nombre }}</td>
					      <td>{{$materia->correlativa ? 'Si' : 'No'}}</td>
					      <td>
					      	<a href="{{ route('materia.editar',['id'=>$materia->id]) }}" class="btn-sm btn-warning">Editar</a>
					      </td>
					    </tr>
						@endif
					@endforeach
				  </tbody>
				</table>
				<hr>
				@endif
				<h3>Segundo Año</h3>
				<table class="table table-hover mt-4">
				  <thead class="thead-dark">
				    <tr>
				      <th scope="col">Materia</th>
				      <th scope="col">Correlativa</th>
					  <th scope="col">Accion</th>
				    </tr>
				  </thead>
				  <tbody>
				  	@foreach($materias as $materia)
						@if($materia->año == 2)
						<tr style="cursor:pointer;">
					      <td>{{ $materia->nombre }}</td>
					      <td>{{$materia->correlativa ? 'Si' : 'No'}}</td>
					      <td>
					      	<a href="{{ route('materia.editar',['id'=>$materia->id]) }}" class="btn-sm btn-warning">Editar</a>
					      </td>
					    </tr>
						@endif
					@endforeach
				  </tbody>
				</table>
				<hr>
				<h3>Tercer Año</h3>
				<table class="table table-hover mt-4">
				  <thead class="thead-dark">
				    <tr>
				      <th scope="col">Materia</th>
				      <th scope="col">Correlativa</th>
				      <th scope="col">Accion</th>
				    </tr>
				  </thead>
				  <tbody>
				  	@foreach($materias as $materia)
						@if($materia->año == 3)
						<tr style="cursor:pointer;">
					      <td>{{ $materia->nombre }}</td>
					      <td>{{$materia->correlativa ? 'Si' : 'No'}}</td>
					      <td>
					      	<a href="{{ route('materia.editar',['id'=>$materia->id]) }}" class="btn-sm btn-warning">Editar</a>
					      </td>
					    </tr>
						@endif
					@endforeach
				  </tbody>
				</table>
		</div>
		
	</div>
@endsection