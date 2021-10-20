@extends('layouts.app')
@section('content')
	<div class="container">
		<h2 class="h1">
			Proceso de {{ $proceso->alumno->nombres }}
		</h2>
		<hr>
		<div class="col-md-4 m-0 p-0 proceso-detalle">
			<ul>
				<li><strong>Materia:</strong> {{ $proceso->materia->nombre }}</li>
				<li><strong>Estado:</strong> {{ ucwords($proceso->estado) }}</li>
				<li><strong>Nota final de parciales:</strong>
				 {{ $proceso->final_parciales ? $proceso->final_parciales : 'Sin asignar'}}
				</li>
				<li><strong>Nota final de TP:</strong>
					{{ $proceso->final_trabajos ? $proceso->final_trabajos : 'Sin asignar'}}
				</li>
				<li><strong>Asistencia final:</strong>
					{{ $proceso->final_asistencia ? $proceso->final_asistencia : 'Sin asignar'}}
				</li>
			</ul>
		</div>
	</div>
@endsection