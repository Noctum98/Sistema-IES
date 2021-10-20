@extends('layouts.app')
@section('content')
	<div class="container ">
		<h2 class="h1">
			Elige la carrera 
		</h2>
		<p>Elige la carrera en donde agregar los alumnos</p>
		<hr>
		<table class="table mt-4">
		  <thead class="thead-dark">
		    <tr>
		      <th scope="col">Nombre</th>
		      <th scope="col">Resolución</th>
		      <th scope="col">Sede</th>
		      <th scope="col">Acción</th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach ($carreras as $carrera)
		    <tr>
		      <td>{{ $carrera->nombre }}</td>
		      <td>{{ $carrera->resolucion }}</td>
		      <td>{{ $carrera->sede->nombre }}</td>
		      <td>
		      	<a href="{{ route('alumno.crear',['id'=>$carrera->id]) }}" class="btn-sm btn-primary">
		      		Elegir
		      	</a>
		      </td>
		    </tr>
		    @endforeach
		  </tbody>
		</table>
	</div>
@endsection