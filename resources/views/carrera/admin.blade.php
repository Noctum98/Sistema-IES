@extends('layouts.app-prueba')
@section('content')
<div class="container">
	<h2 class="h1 text-info">
		Administrar carreras
	</h2>
	<hr>
	@if(Auth::user()->hasRole('admin'))
	<a href="{{ route('carrera.crear') }}" class="btn btn-success">
		Crear carrera
	</a>
	@endif


	<div class="table-responsive">
		<table class="table mt-4">
			<thead class="thead-dark">
				<tr>
					<th scope="col">ID</th>
					<th scope="col">Nombre</th>
					<th>Resolución</th>
					@if(Session::has('admin'))
					<th scope="col">Estado</th>
					@endif
					<th scope="col">Ubicación</th>
					<th scope="col"><i class="fa fa-cog" style="font-size:20px;"></i></th>
				</tr>
			</thead>
			<tbody>
				
				@foreach($carreras as $carrera)
				<tr style="cursor:pointer;">
					<td><b>{{ $carrera->id }}</b></td>
					<td>{{ $carrera->nombre }}</td>
					<td>{{ $carrera->resolucion }}</td>
					@if(Auth::user()->hasRole('admin'))
					<td>
						@if($carrera->estado == 1)
						<span class="text-danger font-weight-bold">En cierre</span>
						@elseif($carrera->estado == 0)
						<span class="text-success font-weight-bold">En curso</span>
						@else
						<span class="text-primary font-weight-bold">Ninguna</span>
						@endif
					</td>
					@endif
					<td>{{ $carrera->sede->nombre }}</td>
					<td>
						@if(Session::has('admin') || Session::has('coordinador') || Session::has('regente'))
						<a href="{{ route('carrera.editar',['id'=>$carrera->id]) }}" class="mr-2 col-md-12 btn btn-sm btn-warning">
							Editar
						</a>
						@endif
						<a href="{{ route('materia.admin',['carrera_id'=>$carrera->id]) }}" class="mt-2 col-md-12 btn btn-sm btn-primary">
							Ver plan de estudios
						</a>
					</td>
				</tr>
				@endforeach
				
			</tbody>
		</table>
	</div>

</div>
@endsection
