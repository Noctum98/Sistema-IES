@extends('layouts.app-prueba')
@section('content')
<div class="container">
	<h2 class="h1 text-info">
		Preinscripciones: Elegir la carrera
	</h2>
	<hr>
	@if(Session::has('admin') || Session::has('regente') || Session::has('areaSocial'))
	<div class="col-md-12">
		<a href="{{route('pre.excelv')}}" class="m-1 btn btn-success" class="">
			<i class="fas fa-download"></i>
			Descargar verificadas
		</a>
		<a href="{{route('pre.articulo')}}" class="m-1 btn btn-secondary">Articulo 7mo</a>
		<a href="{{ route('pre.eliminadas') }}" class="m-1 btn btn-danger">Eliminadas</a>
	</div>
	@endif
	<form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0" method="GET" action="#" id="buscador">
		<div class="input-group mt-3">
			<input class="form-control ml-3" type="text" id="busqueda" placeholder="Buscar preinscripcion" aria-label="Search for..." aria-describedby="btnNavbarSearch" />
			<button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
		</div>
	</form>


	@if(!empty($carreras))
	<div class="table-responsive">
		<table class="table mt-4">
			<thead class="thead-dark">
				<tr>
					<th scope="col">Nombre</th>
					<th scope="col">Resolución</th>
					<th scope="col">Turno</th>
					<th scope="col">Ubicación</th>
					<th scope="col">Preins. Disponible</th>
					<th scope="col"><i class="fa fa-cog" style="font-size:20px;"></i></th>
				</tr>
			</thead>
			<tbody>
				@foreach ($carreras as $carrera)
				<tr style="cursor:pointer;">
					<td>{{ $carrera->nombre }}</td>
					<td>{{ $carrera->resolucion }}</td>
					<td><b>{{ ucwords($carrera->turno) }}<b></td>
					<td>{{ $carrera->sede->nombre }}</td>
					<td>
						@if($carrera->preinscripcion_habilitada)
						<i class='fas fa-check' style='font-size:14px;color:green'></i>
						@else
						<i class='fas fa-times' style='font-size:14px;color:red'></i>
						@endif
					</td>
					<td>
						<a href="{{ route('pre.all',['id'=>$carrera->id]) }}" class="btn btn-sm btn-primary">
							Ver respuestas
						</a>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		@else

		@if(count($preinscripciones) > 0)
		<table class="table mt-4">
			<thead class="thead-dark">
				<tr>
					<th scope="col">Nombre y Apellido</th>
					<th scope="col">D.N.I</th>
					<th scope="col">Email</th>
					<th scope="col">Telefono</th>
					<th scope="col">Estado</th>
					<th scope="col"><i class="fa fa-cog" style="font-size:20px;"></i></th>
				</tr>
			</thead>

			<tbody>

				@foreach ($preinscripciones as $preinscripcion)
				<tr style="cursor:pointer;">
					<td>{{ $preinscripcion->nombres.' '.$preinscripcion->apellidos }}</td>
					<td>{{ $preinscripcion->dni }}</td>
					<td>{{ $preinscripcion->email }}</td>
					<td>{{ $preinscripcion->telefono }}</td>
					<td class="{{$preinscripcion->estado == 'por corregir' ? 'text-danger': 'text-success'}}">{{ ucwords($preinscripcion->estado) }}</td>
					<td>
						<a href="{{ route('pre.detalle',['id'=>$preinscripcion->id]) }}" class="btn-sm btn-primary">
							Ver datos
						</a>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		@endif
		@if(count($preinscripciones) == 0)
		<p></p>
		<p>No existen coincidencias</p>
		@endif
	</div>

	
	@endif
</div>
@endsection