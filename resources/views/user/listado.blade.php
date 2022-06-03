@extends('layouts.app-prueba')
@section('content')
<div class="container">
    <h2 class="h1 text-info">Listado: {{ ucwords($rolListado->descripcion) }}</h2>
    <hr>
    {{ $lista->links() }}
	<form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0" method="GET" action="#" id="buscadorProfesores">
		<div class="input-group mt-3">
			<input class="form-control" type="text" id="busquedaProfesor" placeholder="Buscar personal" aria-label="Search for..." aria-describedby="btnNavbarSearch" />
			<button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
		</div>
	</form>
	<a href="{{ route('register') }}" class="btn btn-warning">Crear usuarios</a>

    <table class="table mt-4">
			<thead class="thead-dark">
				<tr>
					<th scope="col">#</th>
					<th scope="col">Nombre</th>
                    <th scope="col"><i class="fa fa-cog" style="font-size:20px;"></i></th>
				</tr>
			</thead>
			<tbody>
				@foreach ($lista as $user)
				<tr>
					<th scope="row">{{ $user->id }}</th>
					<td>{{ $user->nombre.' '.$user->apellido }}</td>
                    <td><a href="{{ route('usuarios.detalle',$user->id) }}" class="btn btn-sm btn-primary">Ver Datos</a></td>
				</tr>
				@endforeach
			</tbody>
		</table>
</div>
@endsection
@section('scripts')
<script src="{{ asset('js/listados/listado.js') }}"></script>
@endsection