@extends('layouts.app-prueba')

@section('content')
	<div class="container">
		<h1>Seccion de Sedes</h1>
		<hr>
		@if(Session::has('admin'))
			<div class="row">
				<a href="{{ route('sedes.crear') }}" class="btn btn-success col-md-2">
					Administrar Sedes
				</a>
			</div>
		@endif
		@if(@session('sede_deleted'))
			<div class="mt-3 alert alert-danger">
				{{ @session('sede_deleted') }}
			</div>
		@endif
		<table class="table table-hover mt-4">
		  <thead class="thead-dark">
		    <tr>
		      <th scope="col">Nombre</th>
		      <th scope="col">Ubicación</th>
		      <th scope="col">Acción</th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach ($sedes as $sede)
		    <tr style="cursor:pointer;">
		      <td>{{ $sede->nombre }}</td>
		      <td>{{ $sede->ubicacion }}</td>
		      <td>
		      	<a href="{{ route('eliminar_sede',['id'=>$sede->id]) }}" class="mr-2 btn-sm btn-danger">
		      		Eliminar
		      	</a>
		      	<a href="{{ route('sedes.editar',['id'=>$sede->id]) }}" class="btn-sm btn-warning">
		      		Editar
		      	</a>
		      </td>
		    </tr>
		    @endforeach
		  </tbody>
		</table>
	</div>
@endsection