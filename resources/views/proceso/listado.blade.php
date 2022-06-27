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
						@if(count($calificaciones) > 0)
							@foreach($calificaciones as $calificacion)
								<td>{{$calificacion->nombre}}</td>
							@endforeach
						@else
							<td>
								Notas
							</td>
						@endif
						<td>
							Estado
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
							@if($proceso->procesosCalificaciones())
								@foreach($proceso->procesosCalificaciones() as $calificacion)
							<td>
								{{$calificacion->porcentaje}}
							</td>
								@endforeach
							@endif
							<td>
								<select class="custom-select select-estado" name="estado-{{$proceso->id}}" id="{{$proceso->id}}">
									<option value="">Seleccione estado</option>
									@foreach($estados as $estado)
										@if($estado->id == $proceso->$estado)
											<option value="{{$estado->id}}" selected>{{$estado->nombre}}</option>
										@else
											<option value="{{$estado->id}}" >{{$estado->nombre}}</option>
										@endif
									@endforeach
								</select>
								{{$proceso->estado}}
							</td>
							<td>
								<input type="checkbox" class=" " value="{{$proceso->cierre}}" id="{{$proceso->id}}"
										{{$proceso->cierre == 'activa' ? 'checked':'checked'}}>
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
			@section('scripts')
				<script src="{{ asset('js/proceso/cambia_estado.js') }}"></script>
@endsection