@extends('layouts.app')
@section('content')
<div class="container">
	<h2 class="h1">
		Elige que materia rendir
	</h2>
	<p>Selecciona la carrera, luego las materias</p>
	<hr>

	<div class="row">
		<div class="list-group col-md-8 border-right">
			@if(@session('error_mesa'))
			<div class="alert alert-danger">
				{{@session('error_mesa')}}
			</div>
			@endif
			@if(@session('inscripcion_success'))
			<div class="alert alert-success">
				{{@session('inscripcion_success')}}
			</div>
			@endif
			@if(@session('error_materia'))
			<div class="alert alert-danger">
				{{@session('error_materia')}}
			</div>
			@endif

			@if(isset($carreras))
			@foreach($carreras as $carrera)
			<a type="button" href="#" class="list-group-item list-group-item-action mt-3" data-toggle="modal" data-target="#exampleModal{{$carrera->id}}">
				{{$carrera->nombre}} {{ $carrera->nombre == 'Enfermería Profesional' ? '('.ucwords($carrera->turno).')': '' }}
			</a>
			<div class="modal fade" id="exampleModal{{$carrera->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">{{$carrera->nombre}}</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<h6>Recuerda la inscripción de la mesa estará abierta hasta 48hs antes de la fecha.</h6>
							<form method="POST" action="{{route('insc_mesa')}}">
								@csrf
								<table class="table mt-4">
									<thead class="thead-white">
										<tr>
											<th scope="col">Nombre</th>
											@if($instancia->tipo == 0)
											<th scope="col">Fecha y hora</th>
											<th scope="col">Inscripción</th>
											@endif
											<th scope="col">Año</th>
										</tr>
									</thead>
									<tbody>
										@foreach($carrera->materias as $materia)
										@if($instancia->tipo == 0)
										@if($materia->mesas)
										@foreach($materia->mesas as $mesa)
										@if($mesa->instancia_id == $instancia->id)

										<tr>
											<td>
												<div class="form-check">
													@if($mesa->cierre > time())
													<input class="form-check-input" name="{{$mesa->materia->nombre}}" type="checkbox" value="{{$mesa->id}}" id="{{$materia->id}}">
													<label class="form-check-label {{$materia->año == 1 ? 'text-success' : ''}} {{$materia->año == 2 ? 'text-primary' : ''}}" for="{{$materia->id}}">
														{{$materia->nombre}}
													</label>
													@else
													<label class="form-check-label text-secondary" for="{{$materia->id}}">
														{{$materia->nombre}}
													</label>

													@endif
												</div>

											</td>
											<td>
												<span class="font-weight-bold">
													{{$mesa->fecha}}
												</span>
											</td>
											<td>
												@if($mesa->cierre > time())
												<span class="text-success font-weight-bold">
													Abierta
												</span>
												@else
												<span class="text-secondary font-weight-bold">
													Cerrada
												</span>
												@endif
											</td>
											<td class="{{$materia->año == 1 ? 'text-success' : ''}} {{$materia->año == 2 ? 'text-primary' : ''}} {{$materia->año == 3 ? 'text-secondary' : ''}}">
												{{$materia->año}} °
											</td>
										</tr>
										@endif
										@endforeach
										@endif
										@else
										<tr>
											<td>
												<div class="form-check">
													<input class="form-check-input" name="{{$materia->nombre}}" type="checkbox" value="{{$materia->id}}" id="{{$materia->id}}">
													<label class="form-check-label {{$materia->año == 1 ? 'text-success' : ''}} {{$materia->año == 2 ? 'text-primary' : ''}}  for=" {{$materia->id}}">
														{{$materia->nombre}}
													</label>
												</div>
											</td>
											<td class="{{$materia->año == 1 ? 'text-success' : ''}} {{$materia->año == 2 ? 'text-primary' : ''}}">
												{{$materia->año}} °
											</td>

										</tr>
										@endif
										@endforeach
									</tbody>
								</table>
								<input type="submit" value="Inscribirse" class="btn btn-primary">
							</form>
						</div>
					</div>
				</div>
			</div>
			@endforeach
			@else
			<h4>Ya no puedes inscribirte a ninguna materia.</h4>
			@endif
		</div>
		<div class="col-md-4 mt-3">
			<h4>Materias inscriptas</h3>
				@if(@session('bajar_exitosa'))
				<div class="alert alert-warning">
					{{@session('bajar_exitosa')}}
				</div>
				@endif
				@if(count($inscripciones)>0)
				<ul class="list-group list-group-flush">
					@foreach($inscripciones as $inscripcion)
					<li class="list-group-item">
						{{
							$instancia->tipo != 0 ?
							$inscripcion->materia->nombre :
							$inscripcion->mesa->materia->nombre
						}}
						- <a href="{{route('mesa.baja',['id'=>$inscripcion->id])}}" class="text-danger">Bajarme</a>
					</li>
					@endforeach
				</ul>
				@else
				<p>No te encuentras inscripto en ninguna materia </p>
				@endif
		</div>
	</div>
</div>
@endsection