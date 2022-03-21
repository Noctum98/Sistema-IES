@extends('layouts.app-prueba')
@section('content')
	<div class="container">
		<h2 class="h1">
			Administrar instancias de mesas
		</h2>
		<hr>
		@if(Auth::user()->rol == 'rol_admin')
		<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
		  Crear Instancia
		</button>
		@endif
		@if(@session('mensaje'))
		<div class="alert alert-success mt-3">
			{{@session('mensaje')}}
		</div>
		@endif
		<!-- Modal Crear-->
		@include('mesa.modals.crear_instancia')
		@if(count($instancias) != 0)
		<table class="table mt-4">
		  <thead class="thead-dark">
		    <tr>
		      <th scope="col">Nombre</th>
		      <th scope="col">Tipo</th>
		      <th scope="col">Acción</th>
		      <th scope="col">Inactiva/Activa</th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach ($instancias as $instancia)
		    <tr style="cursor:pointer;">
		      <td><b>{{ $instancia->nombre }}</b></td>
		      <td><b>{{ $instancia->tipo == 0 ? 'Común' : 'Especial' }}</b></td>
		      <td>
		      	<button type="button" class="btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#modal{{$instancia->id}}">
				  Ver Inscripciones
				</button>
				@if(Auth::user()->rol == 'rol_admin')
				<button type="button" class="btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#edit{{$instancia->id}}">
				  Editar Mesa
				</button>
				@if($instancia->tipo == 0)
					<button type="button" class="btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete{{$instancia->id}}">
					Borrar datos
					</button>
				@else
					<a href="{{route('borrar_datos',['id'=>$instancia->id])}}" type="button" class="btn-sm btn-danger" >
					Borrar datos
					</a>
				@endif
				
				@endif
		      </td>
		      <td>
		      	<div class="custom-control custom-switch">
				  <input type="checkbox" class="custom-control-input switchinsta" value="{{$instancia->estado}}" id="{{$instancia->id}}" 
				  {{$instancia->estado == 'activa' ? 'checked':''}}>
				  <label class="custom-control-label" for="{{$instancia->id}}"></label>
				</div>
		      </td>
		    </tr>
		    <!--Modal Ver-->
			@include('mesa.modals.ver_inscripciones')
			<!--Modal Editar-->
			@include('mesa.modals.editar_instancia')
			<!--Modal Borrar-->
			@include('mesa.modals.borrar_instancia')
		    @endforeach
		  </tbody>
		</table>
		@else
		<p>No existen instancias creadas</p>
		@endif
	</div>
@endsection