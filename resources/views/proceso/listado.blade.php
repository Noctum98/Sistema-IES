@extends('layouts.app-prueba')
@section('content')
	<div class="container">
		<h2 class="h1 text-info">
			Notas de Proceso de {{ $materia->nombre }} @if($comision)<br/><small>{{$comision->nombre}}</small>@endif
		</h2>
		<hr>
		@if(count($procesos) > 0)
			<div class="table-responsive">

				<table class="table mt-4">
					<thead class="thead-dark">
					<tr>
						<td>
							Alumno
						</td>
						<td>
							Estado
						</td>
						<td>
							Notas
						</td>
						<td>
							Cierre
						</td>
					</tr>
					</thead>
					<tbody>
					@foreach($procesos as $proceso)
						<tr>
							<td>
								{{$proceso->alumno->apellidos}}, {{$proceso->alumno->nombres}}
							</td>
							<td>
								{{$proceso->procesosCalificaciones()}}
							</td>
							<td>
								{{$proceso->estado}}
							</td>
							<td>
								{{$proceso->cierre}}
							</td>

						</tr>
					@endforeach
					</tbody>
		@else
			'No se encontraron procesos'
		@endif
{{--		<div class="col-md-4 m-0 p-0 proceso-detalle">--}}
{{--			<ul>--}}
{{--				<li><strong>Materia:</strong> {{ $proceso->materia->nombre }}</li>--}}
{{--				<li><strong>Estado:</strong> {{ ucwords($proceso->estado) }}</li>--}}
{{--				<li><strong>Nota final de parciales:</strong>--}}
{{--				 {{ $proceso->final_parciales ? $proceso->final_parciales : 'Sin asignar'}}--}}
{{--				</li>--}}
{{--				<li><strong>Nota final de TP:</strong>--}}
{{--					{{ $proceso->final_trabajos ? $proceso->final_trabajos : 'Sin asignar'}}--}}
{{--				</li>--}}
{{--				<li><strong>Asistencia final:</strong>--}}
{{--					{{ $proceso->final_asistencia ? $proceso->final_asistencia : 'Sin asignar'}}--}}
{{--				</li>--}}
{{--			</ul>--}}
{{--		</div>--}}
	</div>
@endsection
