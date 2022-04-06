@extends('layouts.app-prueba')
@section('content')
<div class="container">
	<h2 class="h1">
		Administrar usuarios
	</h2>
	<hr>
	<div class="col-md-12">
		@if(@session('carrera_success'))
		<div class="alert alert-success">
			{{ @session('carrera_success') }}
		</div>
		@endif
		@if(@session('error_sede'))
		<div class="alert alert-warning">
			{{ @session('error_sede') }}
		</div>
		@endif
		@if(@session('error_rol'))
		<div class="alert alert-danger">
			{{ @session('error_rol') }}
		</div>
		@elseif(@session('message'))
		<div class="alert alert-success">
			{{ @session('message') }}
		</div>
		@endif
		<a href="{{ route('roles.index') }}" class="btn btn-warning">Administrar Roles</a>
		<table class="table mt-4">
			<thead class="thead-dark">
				<tr>
					<th scope="col">#</th>
					<th scope="col">Nombre</th>
					<th scope="col">Acción</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($users as $user)
				<tr>
					<th scope="row">{{ $user->id }}</th>
					<td><a href="{{ route('usuarios.detalle',$user->id) }}">{{ $user->nombre.' '.$user->apellido }}</a></td>
					<td>

						<button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#rolesModal{{$user->id}}">
							Asignar Roles
						</button>
						<button type="button" class="ml-2 btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#exampleModal{{$user->id}}">
							Asignar Sedes
						</button>
						<button type="button" class="ml-2 btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#materiasModal{{$user->id}}">
							Asignar Carreras/Materias
						</button>
						@include('user.modals.admin_sedes')
						@include('user.modals.admin_roles')
						@include('user.modals.admin_carreras_materias')
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/user/carreras.js') }}"></script>
@endsection