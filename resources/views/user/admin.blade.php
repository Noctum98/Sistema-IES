@extends('layouts.app')
@section('content')
	<div class="container">
		<h2 class="h1">
			Administrar usuarios
		</h2>
		<div class="col-md-12">
			@if(@session('error_rol'))
				<div class="alert alert-danger">
					{{ @session('error_rol') }}
				</div>
			@elseif(@session('message'))
				<div class="alert alert-success">
					{{ @session('message') }}
				</div>
			@endif
			<table class="table mt-4">
			  <thead class="thead-dark">
			    <tr>
			      <th scope="col">#</th>
			      <th scope="col">Nombre</th>
			      <th scope="col">Rol</th>
			      <th scope="col">Sede</th>
			      <th scope="col">Acción</th>
			    </tr>
			  </thead>
			  <tbody>
			  	@foreach ($users as $user)
			    <tr>
			      <th scope="row">{{ $user->id }}</th>
			      <td>{{ $user->nombre.' '.$user->apellido }}</td>
			      <td>{{ $user->rol == 'rol_admin' ? 'Administrador' : 'Usuario' }}</td>
			      <td>{{ $user->sede_id ? $user->sede->nombre : 'Ninguna'}}</td>
			      <td>
			      	@if($user->rol == 'rol_admin')
				      	<a href="{{ route('rol_usuario',['id'=>$user->id,'rol'=>'rol_user']) }}" class="btn-sm btn-primary">
				      		Cambiar a Usuario
				      	</a>
				    @else
				      	<a href="{{ route('rol_usuario',['id'=>$user->id,'rol'=>'rol_admin']) }}" class="btn-sm btn-warning">
				      		Cambiar a Administrador
				      	</a>
				    @endif
				    @if($user->rol != 'rol_admin')
				    <a type="button" class="ml-2 btn-sm btn-secondary" data-toggle="modal" data-target="#exampleModal{{$user->id}}">
					  Cambiar de sede
					</a>
					@endif
					<div class="modal fade" id="exampleModal{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog" role="document">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title" id="exampleModalLabel">
					        	Cambiar sede de {{$user->nombre}}
					        </h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      <div class="modal-body">
					      	<form action="{{route('sede_usuario',['id'=>$user->id])}}" method="POST">
					      		@csrf
					      		@foreach($sedes as $sede)
						        <div class="form-check">
								  <input class="form-check-input" type="radio" name="sede" id="exampleRadios{{$sede->id}}" value="{{$sede->id}}">
								  <label class="form-check-label" for="exampleRadios{{$sede->id}}">
								    {{$sede->nombre}}
								  </label>
								</div>
						        @endforeach
						      </div>
						      <div class="modal-footer">
						        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
						        <input type="submit"class="btn btn-primary" value="Guardar cambios">
						      </div>
						    </form>
						</div>
					      	
					  </div>
					</div>
			      </td>
			    </tr>
			    @endforeach
			  </tbody>
			</table>
			
		</div>
	</div>
@endsection