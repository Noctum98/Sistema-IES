@extends('layouts.app-prueba')
@section('content')
<div class="container">
	<h2 class="h1 text-info">
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
			@if(@session('error_baja'))
			<div class="alert alert-danger">
				{{@session('error_baja')}}
			</div>
			@endif

			@if(isset($carreras))
			@foreach($carreras as $carrera)
			<a type="button" href="#" class="list-group-item list-group-item-action mt-3" data-bs-toggle="modal" data-bs-target="#exampleModal{{$carrera->id}}">
				{{$carrera->nombre.' - Res: '.$carrera->resolucion}} {{ $carrera->nombre == 'Enfermería Profesional' ? '('.ucwords($carrera->turno).')': '' }}
			</a>
			<div class="modal fade" id="exampleModal{{$carrera->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title text-secondary" id="exampleModalLabel">{{$carrera->nombre}}</h5>
							<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<h6 class="text-secondary">Recuerda la inscripción de la mesa estará abierta hasta 48hs antes de la fecha y hora de la misma.</h6>
							<form method="POST" action="{{route('insc_mesa',['instancia_id'=>$instancia->id])}}">
								@csrf
								<table class="table mt-4">
									<thead class="thead-white">
										<tr>
											<th scope="col">Nombre</th>
											@if($instancia->tipo == 0)
											<th scope="col">Fecha y hora</th>
											<th scope="col">Inscripción</th>
											<th scope="col">LLamado</th>
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

													@if(time() < $mesa->cierre || (time() > strtotime($mesa->fecha) && time() < $mesa->cierre_segundo))
															<input class="form-check-input" name="{{$mesa->materia->nombre}}" type="checkbox" value="{{$mesa->id}}" id="{{$materia->id}}">
															<label class="form-check-label {{$materia->año == 1 ? 'text-success' : ''}} {{$materia->año == 2 ? 'text-primary' : ''}}" for="{{$materia->id}}">
																{{$materia->nombre}}
															</label>
															@elseif(time() > $mesa->cierre || (time() <= strtotime($mesa->fecha) || time() > $mesa->cierre_segundo))
																<label class="form-check-label text-secondary" for="{{$materia->id}}">
																	{{$materia->nombre}}
																</label>
																@endif
												</div>

											</td>
											<td>
												@if(time() <= strtotime($mesa->fecha))
													<span class="font-weight-bold">
														{{date_format(new DateTime($mesa->fecha), 'd-m-Y H:i:s')}}
													</span>
													@else
													<span class="font-weight-bold">
														{{date_format(new DateTime($mesa->fecha_segundo), 'd-m-Y H:i:s')}}
													</span>
													@endif
											</td>
											<td>
												@if(time() < $mesa->cierre || (time() > strtotime($mesa->fecha) && time() < $mesa->cierre_segundo))
														<span class="text-success font-weight-bold">
															Abierta
														</span>
														@else
														<span class="text-secondary font-weight-bold">
															Cerrada
														</span>
														@endif

											</td>
											<td>
												@if(time() <= strtotime($mesa->fecha) || !$mesa->fecha_segundo)
													<span class="font-weight-bold">1ero</span>
													@elseif(time() > strtotime($mesa->fecha) && $mesa->fecha_segundo)
													<span class="font-weight-bold">2do</span>
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
								<input type="submit" value="Inscribirse" class="btn btn-primary" id="loading">
							</form>
						</div>
					</div>
				</div>
			</div>
			@endforeach
			@else
			<h4 class="text-secondary">Ya no puedes inscribirte a ninguna materia.</h4>
			@endif
		</div>
		<div class="col-md-4 mt-3">
			<h4 class="text-secondary">Materias inscriptas</h4>
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
							$inscripcion['mesa']['materia']['nombre']
						}}
						-
						@if($instancia->tipo == 1)
						@if($inscripcion->estado_baja)
							<span class="text-secondary">Dada de baja</span>
						@else

						<a href="{{route('mesa.baja',['id'=>$inscripcion->id,'instancia_id'=>$instancia->id])}}" class="text-danger">Bajarme</a>
						@endif
						@else
						@if(!$inscripcion['segundo_llamado'])
						<span class="font-weight-bold">1er llamado </span>
						@else
						<span class="font-weight-bold">2do llamado </span>
						@endif
						@if(time() < $inscripcion['mesa']['cierre'] || (time()> strtotime($inscripcion['mesa']['fecha']) && time() < $inscripcion['mesa']['cierre_segundo']))
						 - <a href="{{route('mesa.baja',['id'=>$inscripcion['id']])}}" class="text-danger">Bajarme</a>
						@endif
						@endif
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
