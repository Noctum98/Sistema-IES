@extends('layouts.app')
@section('content')
	<div class="container">
		<h2 class="h1">
			Administrar carreras
		</h2>
		<hr>
		<a href="{{ route('carrera.crear') }}" class="btn btn-success">
			Crear carrera
		</a>
		
		<table class="table table-hover mt-4">
		  <thead class="thead-dark">
		    <tr>
		      <th scope="col">ID</th>
		      <th scope="col">Nombre</th>
		      <th scope="col">Estado</th>
		      <th scope="col">Ubicación</th>
		      <th scope="col">Acción</th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach ($carreras as $carrera)
		    <tr style="cursor:pointer;">
		      <td><b>{{ $carrera->id }}</b></td>
		      <td>{{ $carrera->nombre }}</td>
		      <td>
		          @if($carrera->estado == 1)
		          <span class="text-danger font-weight-bold">En cierre</span>
		          @elseif($carrera->estado == 0)
		          <span class="text-success font-weight-bold">En curso</span>
		          @else
		          <span class="text-primary font-weight-bold">Ninguna</span>
		          @endif
		      </td>
		      <td>{{ $carrera->sede->nombre }}</td>
		      <td>
		      	<a href="{{ route('carrera.editar',['id'=>$carrera->id]) }}" class="mr-2 btn-sm btn-warning">
		      		Editar
		      	</a>
		      	<a href="{{ route('materia.admin',['carrera_id'=>$carrera->id]) }}" class="btn-sm btn-primary">
		      		Ver plan de estudios
		      	</a>
		      </td>
		    </tr>
		    @endforeach
		  </tbody>
		</table>
		

	</div>
@endsection