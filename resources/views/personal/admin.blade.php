@extends('layouts.app-prueba')
@section('content')
	<div class="container">
		<h2 class="h1">
			Administrar Personal
		</h2>
		<a href="{{ route('personal.crear') }}" class="btn btn-success">
			Agregar personal
		</a>
		<div class="col-md-8">
			<table class="table mt-4">
			  <thead class="thead-dark">
			    <tr>
			      <th scope="col">Nombre</th>
			      <th scope="col">Sede</th>
			      <th scope="col">Cargo</th>
			      <th scope="col">Acción</th>
			    </tr>
			  </thead>
			  <tbody>
			  	@foreach ($personal as $persona)
			    <tr>
			      <td>{{ $persona->nombres.' '.$persona->apellidos }}</td>
			      <td>{{ $persona->sede->nombre }}</td>
			      <td>{{ ucwords($persona->cargo) }}</td>
			      <td>
			      	<a href="{{ route('personal.ficha',['id'=>$persona->id]) }}" class="btn-sm btn-warning">
			      		Ver ficha
			      	</a>
			      </td>
			    </tr>
			    @endforeach
			  </tbody>
			</table>
		</div>

	</div>
@endsection