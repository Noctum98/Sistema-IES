@extends('layouts.app-prueba')
@section('content')
<div class="container">
    <h2 class="h1 text-info">Lista de Profesores</h2>
    <hr>
    {{ $lista->links() }}
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