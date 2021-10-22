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
	<div id="accordion">
		@foreach($sede->carreras as $carrera)
		<div class="card">
			<div class="card-header" id="heading{{$carrera->id}}">
				<h5 class="mb-0">
					<h6 style="cursor: pointer;" data-toggle="collapse" data-target="#collapse{{$carrera->id}}" aria-expanded="false" aria-controls="collapse{{$carrera->id}}" class="font-weight-bold">

						{{$carrera->nombre}}

					</h6>
				</h5>
			</div>

			<div id="collapse{{$carrera->id}}" class="collapse" aria-labelledby="heading{{$carrera->id}}" data-parent="#accordion">
				<div class="card-body">
					@if($carrera->estado != 1)
					<table class="table">
						<thead>
							<tr>
								<th scope="col">Primer Año</th>
								@if($instancia->tipo == 0)
								<th scope="col">Cierre</th>
								@endif
								<th scope="col">Acción</th>
							</tr>
						</thead>
						<tbody>
							@foreach($carrera->materias as $materia)
							@if($materia->año == 1)
							<tr>
								<td>
									{{ $materia->nombre }} <b>({{count($materia->mesa_inscriptos)}})</b>
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
								@endif
								@endif
								<td>
									<a href="{{route('mesa.descargar',['id'=>$materia->id])}}" class="btn-sm btn-success">Descargar excel</a>
									@if($instancia->tipo == 0)
									@if(($materia->mesas && count($materia->mesas)==0) || !$materia->mesas)
									<a href="{{route('mesa.descargar',['id'=>$materia->id])}}" class="btn-sm btn-warning" data-toggle="modal" data-target="#exampleModal{{$materia->id}}">Configurar mesa</a>
									@elseif($materia->mesas && count($materia->mesas)>0)
									@foreach($materia->mesas as $mesa)
									@if($mesa->instancia_id == $instancia->id && !$mesa->fecha)
									<a href="{{route('mesa.descargar',['id'=>$materia->id])}}" class="btn-sm btn-warning" data-toggle="modal" data-target="#exampleModal{{$materia->id}}">Configurar mesa</a>
									@endif
									@endforeach
									@endif
									<div class="modal fade" id="exampleModal{{$materia->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="exampleModalLabel">
														Mesa de {{$materia->nombre}}
													</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
													<form method="POST" action="{{route('crear_mesa',['id'=>$materia->id])}}">
														@csrf
														<div class="form-group">
															<label for="fecha">Fecha y Hora de cierre:</label>
															<input type="datetime-local" name="fecha" class="form-control" required>
															<input type="submit" value="Configurar" class="btn btn-sm btn-success mt-2">
														</div>
													</form>
												</div>
											</div>
										</div>
									</div>
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
								<th scope="col">Cierre</th>
								@endif
								<th scope="col">Acción</th>
							</tr>
						</thead>
						<tbody>
							@foreach($carrera->materias as $materia)
							@if($materia->año == 2)
							<tr>
								<td>{{ $materia->nombre }} <b>({{count($materia->mesa_inscriptos)}})</b></td>
								@if($instancia->tipo == 0)
								<td>
									@if($materia->mesas)
									@if(count($materia->mesas) == 0)
									<strong>
										Sin configurar
									</strong>
									@else
									@foreach($materia->mesas as $mesa)
									@if($mesa->instancia_id == $instancia->id && $mesa->fecha)
									<strong>
										{{date_format(new DateTime($mesa->fecha), 'Y-m-d H:i:s')}}
									</strong>
									@elseif($mesa->instancia_id == $instancia->id && !$mesa->fecha)
									<strong>
										Sin configurar
									</strong>
									@endif
									@endforeach
									@endif
									@endif
								</td>
								@endif
								<td>
									<a href="{{route('mesa.descargar',['id'=>$materia->id])}}" class="btn-sm btn-success">Descargar excel</a>
									@if($instancia->tipo == 0)
									@if($materia->mesas)
									@if(count($materia->mesas)==0)
									<a href="{{route('mesa.descargar',['id'=>$materia->id])}}" class="btn-sm btn-warning" data-toggle="modal" data-target="#exampleModal{{$materia->id}}">Configurar mesa</a>
									@else
									@foreach($materia->mesas as $mesa)
									@if($mesa->instancia_id == $instancia->id && !$mesa->fecha)
									<a href="{{route('mesa.descargar',['id'=>$materia->id])}}" class="btn-sm btn-warning" data-toggle="modal" data-target="#exampleModal{{$materia->id}}">Configurar mesa</a>
									@endif
									@endforeach
									@endif
									@endif
									<div class="modal fade" id="exampleModal{{$materia->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="exampleModalLabel">
														Mesa de {{$materia->nombre}}
													</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
													<form method="POST" action="{{route('crear_mesa',['id'=>$materia->id])}}">
														@csrf
														<div class="form-group">
															<label for="fecha">Fecha y Hora de cierre:</label>
															<input type="datetime-local" name="fecha" class="form-control" required>
															<input type="submit" value="Configurar" class="btn btn-sm btn-success mt-2">
														</div>
													</form>
												</div>
											</div>
										</div>
									</div>
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
								<th scope="col">Cierre</th>
								@endif
								<th scope="col">Acción</th>
							</tr>
						</thead>
						<tbody>
							@foreach($carrera->materias as $materia)
							@if($materia->año == 3)
							<tr>
								<td>{{ $materia->nombre }} <b>({{count($materia->mesa_inscriptos)}})</b></td>
								@if($instancia->tipo == 0)
								@if($materia->mesas)
								<td>
									@if(count($materia->mesas) == 0)
									<strong>
										Sin configurar
									</strong>
									@else
									@foreach($materia->mesas as $mesa)
									@if($mesa->instancia_id == $instancia->id && $mesa->fecha)
									<strong>
										{{date_format(new DateTime($mesa->fecha), 'Y-m-d H:i:s')}}
									</strong>
									@elseif($mesa->instancia_id == $instancia->id && !$mesa->fecha)
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
									<a href="{{route('mesa.descargar',['id'=>$materia->id])}}" class="btn-sm btn-success">Descargar excel</a>
									@if($instancia->tipo == 0)
									@if($materia->mesas)
									@if(count($materia->mesas)==0)
									<a href="{{route('mesa.descargar',['id'=>$materia->id])}}" class="btn-sm btn-warning" data-toggle="modal" data-target="#exampleModal{{$materia->id}}">Configurar mesa</a>
									@else
									@foreach($materia->mesas as $mesa)
									@if($mesa->instancia_id == $instancia->id && !$mesa->fecha)
									<a href="{{route('mesa.descargar',['id'=>$materia->id])}}" class="btn-sm btn-warning" data-toggle="modal" data-target="#exampleModal{{$materia->id}}">Configurar mesa</a>
									@endif
									@endforeach
									@endif
									@endif
									<div class="modal fade" id="exampleModal{{$materia->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="exampleModalLabel">
														Mesa de {{$materia->nombre}}
													</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
													<form method="POST" action="{{route('crear_mesa',['id'=>$materia->id])}}">
														@csrf
														<div class="form-group">
															<label for="fecha">Fecha y Hora de cierre:</label>
															<input type="datetime-local" name="fecha" class="form-control" required>
															<input type="submit" value="Configurar" class="btn btn-sm btn-success mt-2">
														</div>
													</form>
												</div>
											</div>
										</div>
									</div>
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