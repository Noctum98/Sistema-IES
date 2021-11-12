@extends('layouts.app')
@section('content')
<div class="container">
	<h2 class="h1">
		{{$sede->nombre}}
	</h2>
	<hr>
	@if(@session('message'))
	<div class="alert alert-success">
		{{@session('message')}}
	</div>
	@endif
	@if(@session('message_edit'))
	<div class="alert alert-primary">
		{{@session('message_edit')}}
	</div>
	@endif
	<div id="accordion">
		@foreach($sede->carreras as $carrera)
		<div class="card">
			<div class="card-header" id="heading{{$carrera->id}}">
				<h5 class="mb-0">
					<h6 style="cursor: pointer;" data-toggle="collapse" data-target="#collapse{{$carrera->id}}" aria-expanded="false" aria-controls="collapse{{$carrera->id}}" class="font-weight-bold">

						{{$carrera->nombre}} - 
						@if($carrera->nombre != 'Enfermería Profesional')
							Res: {{$carrera->resolucion}}
						@else
							Turno {{ucwords($carrera->turno)}}
						@endif

					</h6>
				</h5>
			</div>

			<div id="collapse{{$carrera->id}}" class="collapse" aria-labelledby="heading{{$carrera->id}}" data-parent="#accordion">
				<div class="card-body">
					<a href="{{ route('mesa.tribunal',['id'=>$carrera->id]) }}" class="btn btn-secondary mb-3">
						Descargar grilla de mesas
					</a>
					@if($carrera->estado != 1)
					<table class="table">
						<thead>
							<tr>
								<th scope="col">Primer Año</th>
								@if($instancia->tipo == 0)
								<th scope="col">Fecha Primer llamado</th>
								<th scope="col">Fecha Segundo llamado</th>
								@endif
								<th scope="col">Acción</th>
							</tr>
						</thead>
						<tbody>
							@foreach($carrera->materias as $materia)
							@if($materia->año == 1)
							<tr>
								<td>
									{{ $materia->nombre }}
									@if($instancia->tipo == 0)
									@foreach($materia->mesas as $mesa)
									<b>({{count($mesa->mesa_inscriptos)}})</b>
									@endforeach
									@else
									<b>({{count($materia->mesa_inscriptos)}})</b>
									@endif

								</td>
								@if($instancia->tipo == 0)
								@if($materia->mesas)
								<td>
									@if(count($materia->mesas) == 0)
									<strong>
										Sin configurar
									</strong>
									@elseif(count($materia->mesas) > 0)
									@foreach($materia->mesas as $mesa)
									@if($mesa->instancia_id == $instancia->id && $mesa->fecha)
									<strong>
										{{date_format(new DateTime($mesa->fecha), 'd-m-Y H:i:s')}}
									</strong>
									@elseif($mesa->instancia_id == $instancia->id && !$mesa->fecha)
									<strong>
										Sin configurar
									</strong>
									@else
									<strong>
										Sin configurar
									</strong>
									@endif
									@endforeach
								@endif
								</td>
								<td>
									@if(count($materia->mesas) == 0)
									<strong>
										Sin configurar
									</strong>
									@elseif(count($materia->mesas) > 0)
									@foreach($materia->mesas as $mesa)
									@if($mesa->instancia_id == $instancia->id && $mesa->fecha_segundo)
									<strong>
										{{date_format(new DateTime($mesa->fecha_segundo), 'd-m-Y H:i:s')}}
									</strong>
									@elseif($mesa->instancia_id == $instancia->id && !$mesa->fecha_segundo)
									<strong>
										Sin configurar
									</strong>
									@else
									<strong>
										Sin configurar
									</strong>
									@endif
									@endforeach
									@endif
								</td>
								@endif
								@endif
								<td>
									@if($instancia->tipo == 0)
									@foreach($materia->mesas as $mesa)
									<a href="{{route('mesa.descargar',['id'=>$mesa->id])}}" class="btn-sm btn-success">Descargar excel</a>
									<a href="#" class="btn-sm btn-primary" data-toggle="modal" data-target="#editModal{{$materia->id}}">Editar mesa</a>
									@endforeach

									@if(($materia->mesas && count($materia->mesas)==0) || !$materia->mesas)
									<a href="{{route('mesa.descargar',['id'=>$materia->id])}}" class="btn-sm btn-warning" data-toggle="modal" data-target="#exampleModal{{$materia->id}}">Configurar mesa</a>
									@elseif($materia->mesas && count($materia->mesas)>0)
									@foreach($materia->mesas as $mesa)
									@if($mesa->instancia_id == $instancia->id && !$mesa->fecha)
									<a href="{{route('mesa.descargar',['id'=>$materia->id])}}" class="btn-sm btn-warning" data-toggle="modal" data-target="#exampleModal{{$materia->id}}">Configurar mesa</a>
									@endif
									@endforeach
									@else
									<a href="{{route('mesa.descargar',['id'=>$materia->id])}}" class="btn-sm btn-success">Descargar excel</a>
									@endif
									@include('includes.mesas.config_mesa')
									@include('includes.mesas.edit_mesa')
									@else
									<a href="{{route('mesa.descargar',['id'=>$materia->id])}}" class="btn-sm btn-success">Descargar excel</a>
									@endif
								</td>
							</tr>
							@endif
							@endforeach

						</tbody>
					</table>
					@endif
					<table class="table">
						<thead>
							<tr>
								<th scope="col">Segundo Año</th>
								@if($instancia->tipo == 0)
								<th scope="col">Fecha Primer llamado</th>
								<th scope="col">Fecha Segundo llamado</th>
								@endif
								<th scope="col">Acción</th>
							</tr>
						</thead>
						<tbody>
							@foreach($carrera->materias as $materia)
							@if($materia->año == 2)
							<tr>
								<td>
									{{ $materia->nombre }}
									@if($instancia->tipo == 0)
									@foreach($materia->mesas as $mesa)
									<b>({{count($mesa->mesa_inscriptos)}})</b>
									@endforeach
									@else
									<b>({{count($materia->mesa_inscriptos)}})</b>
									@endif

								</td>
								@if($instancia->tipo == 0)
								@if($materia->mesas)
								<td>
									@if(count($materia->mesas) == 0)
									<strong>
										Sin configurar
									</strong>
									@elseif(count($materia->mesas) > 0)
									@foreach($materia->mesas as $mesa)
									@if($mesa->instancia_id == $instancia->id && $mesa->fecha)
									<strong>
										{{date_format(new DateTime($mesa->fecha), 'd-m-Y H:i:s')}}
									</strong>
									@elseif($mesa->instancia_id == $instancia->id && !$mesa->fecha)
									<strong>
										Sin configurar
									</strong>
									@else
									<strong>
										Sin configurar
									</strong>
									@endif
									@endforeach
								@endif
								</td>
								<td>
									@if(count($materia->mesas) == 0)
									<strong>
										Sin configurar
									</strong>
									@elseif(count($materia->mesas) > 0)
									@foreach($materia->mesas as $mesa)
									@if($mesa->instancia_id == $instancia->id && $mesa->fecha_segundo)
									<strong>
										{{date_format(new DateTime($mesa->fecha_segundo), 'd-m-Y H:i:s')}}
									</strong>
									@elseif($mesa->instancia_id == $instancia->id && !$mesa->fecha_segundo)
									<strong>
										Sin configurar
									</strong>
									@else
									<strong>
										Sin configurar
									</strong>
									@endif
									@endforeach
									@endif
								</td>
								@endif
								@endif
								<td>
								@if($instancia->tipo == 0)
									@foreach($materia->mesas as $mesa)
									<a href="{{route('mesa.descargar',['id'=>$mesa->id])}}" class="btn-sm btn-success">Descargar excel</a>
									@endforeach

									@if(($materia->mesas && count($materia->mesas)==0) || !$materia->mesas)
									<a href="{{route('mesa.descargar',['id'=>$materia->id])}}" class="btn-sm btn-warning" data-toggle="modal" data-target="#exampleModal{{$materia->id}}">Configurar mesa</a>
									@elseif($materia->mesas && count($materia->mesas)>0)
									@foreach($materia->mesas as $mesa)
									@if($mesa->instancia_id == $instancia->id && !$mesa->fecha)
									<a href="{{route('mesa.descargar',['id'=>$materia->id])}}" class="btn-sm btn-warning" data-toggle="modal" data-target="#exampleModal{{$materia->id}}">Configurar mesa</a>
									@endif
									@endforeach
									@else
									<a href="{{route('mesa.descargar',['id'=>$materia->id])}}" class="btn-sm btn-success">Descargar excel</a>
									@endif
									@include('includes.mesas.config_mesa')
									@include('includes.mesas.edit_mesa')
								@else
									<a href="{{route('mesa.descargar',['id'=>$materia->id])}}" class="btn-sm btn-success">Descargar excel</a>
								@endif
								</td>
							</tr>
							@endif
							@endforeach

						</tbody>
					</table>
					<table class="table">
						<thead>
							<tr>
								<th scope="col">Tercer Año</th>
								@if($instancia->tipo == 0)
								<th scope="col">Fecha Primer llamado</th>
								<th scope="col">Fecha Segundo llamado</th>
								@endif
								<th scope="col">Acción</th>
							</tr>
						</thead>
						<tbody>
							@foreach($carrera->materias as $materia)
							@if($materia->año == 3)
							<tr>
								<td>
									{{ $materia->nombre }}
									@if($instancia->tipo == 0)
									@foreach($materia->mesas as $mesa)
									<b>({{count($mesa->mesa_inscriptos)}})</b>
									@endforeach
									@else
									<b>({{count($materia->mesa_inscriptos)}})</b>
									@endif

								</td>
								@if($instancia->tipo == 0)
								@if($materia->mesas)
								<td>
									@if(count($materia->mesas) == 0)
									<strong>
										Sin configurar
									</strong>
									@elseif(count($materia->mesas) > 0)
									@foreach($materia->mesas as $mesa)
									@if($mesa->instancia_id == $instancia->id && $mesa->fecha)
									<strong>
										{{date_format(new DateTime($mesa->fecha), 'd-m-Y H:i:s')}}
									</strong>
									@elseif($mesa->instancia_id == $instancia->id && !$mesa->fecha)
									<strong>
										Sin configurar
									</strong>
									@else
									<strong>
										Sin configurar
									</strong>
									@endif
									@endforeach
								@endif
								</td>
								<td>
									@if(count($materia->mesas) == 0)
									<strong>
										Sin configurar
									</strong>
									@elseif(count($materia->mesas) > 0)
									@foreach($materia->mesas as $mesa)
									@if($mesa->instancia_id == $instancia->id && $mesa->fecha_segundo)
									<strong>
										{{date_format(new DateTime($mesa->fecha_segundo), 'd-m-Y H:i:s')}}
									</strong>
									@elseif($mesa->instancia_id == $instancia->id && !$mesa->fecha_segundo)
									<strong>
										Sin configurar
									</strong>
									@else
									<strong>
										Sin configurar
									</strong>
									@endif
									@endforeach
									@endif
								</td>
								@endif
								@endif
								<td>
								@if($instancia->tipo == 0)
									@foreach($materia->mesas as $mesa)
									<a href="{{route('mesa.descargar',['id'=>$mesa->id])}}" class="btn-sm btn-success">Descargar excel</a>
									@endforeach

									@if(($materia->mesas && count($materia->mesas)==0) || !$materia->mesas)
									<a href="{{route('mesa.descargar',['id'=>$materia->id])}}" class="btn-sm btn-warning" data-toggle="modal" data-target="#exampleModal{{$materia->id}}">Configurar mesa</a>
									@elseif($materia->mesas && count($materia->mesas)>0)
									@foreach($materia->mesas as $mesa)
									@if($mesa->instancia_id == $instancia->id && !$mesa->fecha)
									<a href="{{route('mesa.descargar',['id'=>$materia->id])}}" class="btn-sm btn-warning" data-toggle="modal" data-target="#exampleModal{{$materia->id}}">Configurar mesa</a>
									@endif
									@endforeach
									@else
									<a href="{{route('mesa.descargar',['id'=>$materia->id])}}" class="btn-sm btn-success">Descargar excel</a>
									@endif
									@include('includes.mesas.config_mesa')
									@include('includes.mesas.edit_mesa')
									@else
									<a href="{{route('mesa.descargar',['id'=>$materia->id])}}" class="btn-sm btn-success">Descargar excel</a>
								@endif
								</td>
							</tr>
							@endif
							@endforeach

						</tbody>
					</table>
				</div>
			</div>
			@endforeach
		</div>
	</div>
	@endsection