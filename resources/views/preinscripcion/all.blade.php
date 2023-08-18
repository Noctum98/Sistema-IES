@extends('layouts.app-prueba')
@section('content')
<div class="container">
	<h2 class="h1 text-info">
		Preinscripciones de {{ $carrera->nombre.' ('.$carrera->sede->nombre.'-'.ucwords($carrera->turno).')' }}
	</h2>
	<hr>
	@if(Session::has('admin') || Session::has('regente') || Session::has('areaSocial'))
	<a class="btn btn-success col-sm-12 col-md-2" href="{{route('pre.excel',['carrera_id'=>$carrera->id])}}"><i class="fas fa-download"></i> Descargar Excel</a>
	<a class="btn btn-secondary col-sm-12 col-md-2" href="{{route('pre.verificadas',['id'=>$carrera->id])}}">Ver verificadas</a>
	<a class="btn btn-danger col-sm-12 col-md-2" href="{{route('pre.sincorregir',['id'=>$carrera->id])}}">Ver sin corregir</a>
	<br>
	@endif
	@if(count($preinscripciones) == 0)
	<br>
	<p>No hay preinscripciones sin verificar para esta carrera.</p>
	@else
	<div class="table-responsive">
		<table class="table mt-4">
			<thead class="thead-dark">
				<tr>
					<th scope="col">#</th>
					<th scope="col">Apellido y Nombre</th>
					<th scope="col">D.N.I</th>
					<th scope="col">Email</th>
					<th scope="col">Telefono</th>
					<th scope="col"><i class="fa fa-cog" style="font-size:20px;"></i></th>
				</tr>
			</thead>
			<tbody>
				@foreach ($preinscripciones as $key => $preinscripcion)
				<tr style="cursor:pointer;">
					<td>{{ $key + 1 }}</td>
					<td>{{ mb_strtoupper($preinscripcion->apellidos).' '.ucwords($preinscripcion->nombres) }}</td>
					<td>{{ $preinscripcion->dni }}</td>
					<td>{{ $preinscripcion->email }}</td>
					<td>{{ $preinscripcion->telefono }}</td>
					<td>
						<a href="{{ route('pre.detalle',['id'=>$preinscripcion->id]) }}" class="btn btn-sm btn-primary">
							Ver datos
						</a>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	@endif
</div>
@endsection