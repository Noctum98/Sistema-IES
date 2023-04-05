@extends('layouts.app-prueba')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-8">
			<h4 class="text-primary">
				Alumnos de {{ $carrera->nombre }}<br />
				<small class="text-dark" style="font-size: .8em">Turno: {{ucwords($carrera->turno)}} - Resolución Nro.: {{$carrera->resolucion}} - Ciclo Lectivo: {{$ciclo_lectivo}} </small>
			</h4>
		</div>
		<div class="col-4">
			<div class="dropdown">
				<button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdown1" data-bs-toggle="dropdown">
					Ciclo lectivo
				</button>
				<ul class="dropdown-menu">
					@for ($i = $changeCicloLectivo[1]; $i >= $changeCicloLectivo[0]; $i--)
					<li>
						<a class="dropdown-item @if($i == $ciclo_lectivo) active @endif " href="{{ route('alumno.carrera',['carrera_id'=>$carrera->id, 'ciclo_lectivo' => $i]) }}">
							{{$i}}
						</a>

					</li>
					@endfor
				</ul>
			</div>
		</div>

	</div>

	<p>
		Selecciona el año para mostrar los alumnos de cada uno
	</p>
	<hr>
	<div class="col-md-11">
		@if(@session('alumno_deleted'))
		<div class="alert alert-warning">
			{{ @session('alumno_deleted') }}
		</div>
		@endif
		<div class="col-md-12 row mb-3">
			<div class="col-md-4">
				<!---
                    <form method="GET" action="#" id="buscador-alumnos" class="form-inline">
                        <div class="row">
                            <div class="input-group">
{{--                                <div class="input-group-append">--}}
{{--                                </div>--}}
                                <input type="text" id="busqueda" class="form-control" placeholder="Buscar alumno"
                                       aria-describedby="inputGroupPrepend2"
                                >
                                <button class="input-group-text" id="inputGroupPrepend2" type="submit">
                                    <i class="fa fa-search text-info"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
				<div class="col-md-3">

				</div>
				-->
				<a href="{{ route('excel.alumnosDatos',['carrera_id'=>$carrera->id,'ciclo_lectivo'=>$ciclo_lectivo]) }}" class="d-block btn btn-secondary mb-2"><i class="fas fa-download"></i> Descargar Datos</a>

			</div>
			<div id="accordion">
				<div class="card">
					<div class="card-header" id="headingOne">
						<h5 class="text-secondary" style="cursor: pointer;" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-bs-expanded="true" aria-bs-controls="collapseOne">
							Primer Año
						</h5>
					</div>

					<div id="collapseOne" class="collapse show" aria-bs-labelledby="headingOne" data-bs-parent="#accordion">
						<div class="card-body">
							<a href="{{ route('excel.alumnosAño',['carrera_id'=>$carrera->id,'year'=>1,'ciclo_lectivo'=>$ciclo_lectivo]) }}" class="btn btn-sm btn-success mb-2"><i class="fas fa-download"></i> Descargar Alumnos</a>
							<table class="table">
								<thead>
									<tr>
										<th scope="col">Apellidos y Nombres</th>
										<th scope="col">DNI</th>
										@if($ciclo_lectivo == date('Y'))
										<th scope="col" class="text-center">Verificado</th>
										@endif
										<th scope="col" class="text-center"><i class="fa fa-cogs"></i> </th>
									</tr>
								</thead>
								<tbody>
									@foreach($carrera->obtenerAlumnosCicloLectivo($ciclo_lectivo) as $alumno)
									@if($alumno->procesoCarrera($carrera->id,$alumno->alumno_id, $ciclo_lectivo)->año == 1)
									<tr>
										<td>{{$alumno->apellidos.' '.$alumno->nombres}}</td>
										<td>{{ $alumno->dni }}</td>
										@if($ciclo_lectivo == date('Y'))

										<td class="text-center">
											@if($alumno->aprobado)
											<i class='fas fa-user-check' style='font-size:14px;color:green'></i>
											@else
											<i class='fas fa-user-times' style='font-size:14px;color:red'></i>
											@endif
										</td>
										@endif
										<td class="text-center">
											<a href="{{ route('alumno.detalle',['id'=>$alumno->alumno_id, 'ciclo_lectivo' => $ciclo_lectivo]) }}" class="btn btn-sm btn-secondary mr-1">
												Ver datos
											</a>
										</td>
									</tr>
									@endif
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="card">
					<div class="card-header" id="headingTwo">
						<h5 class="mb-0">
							<h5 style="cursor:pointer;" class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-bs-expanded="false" aria-bs-controls="collapseTwo">
								Segundo Año
							</h5>
						</h5>
					</div>
					<div id="collapseTwo" class="collapse" aria-bs-labelledby="headingTwo" data-bs-parent="#accordion">
						<div class="card-body">
							<a href="{{ route('excel.alumnosAño',['carrera_id'=>$carrera->id,'year'=>2,'ciclo_lectivo'=>$ciclo_lectivo]) }}" class="btn btn-sm btn-success mb-2"><i class="fas fa-download"></i> Descargar Alumnos</a>
							<table class="table">
								<thead>
									<tr>
										<th scope="col">Apellidos y Nombres</th>
										<th scope="col">DNI</th>
										@if($ciclo_lectivo == date('Y'))
										<th scope="col" class="text-center">Verificado</th>
										@endif
										<th scope="col">Accion</th>
									</tr>
								</thead>
								<tbody>
									@foreach($carrera->obtenerAlumnosCicloLectivo($ciclo_lectivo) as $alumno)
									@if($alumno->procesoCarrera($carrera->id,$alumno->alumno_id, $ciclo_lectivo)->año == 2)
									<tr>
										<td>{{$alumno->apellidos.' '.$alumno->nombres}}</td>
										<td>{{ $alumno->dni }}</td>
										@if($ciclo_lectivo == date('Y'))

										<td>
											@if($alumno->aprobado)
											<i class='fas fa-user-check' style='font-size:24px;color:green'></i>
											@else
											<i class='fas fa-user-times' style='font-size:24px;color:red'></i>
											@endif
										</td>
										@endif
										<td>
											<a href="{{ route('alumno.detalle',['id'=>$alumno->alumno_id, 'ciclo_lectivo' => $ciclo_lectivo]) }}" class="btn btn-sm btn-secondary">
												Ver datos
											</a>
										</td>
									</tr>
									@endif
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="card">
					<div class="card-header" id="headingThree">
						<h5 class="mb-0">
							<h5 style="cursor:pointer" class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-bs-expanded="false" aria-bs-controls="collapseThree">
								Tercer Año
							</h5>
						</h5>
					</div>
					<div id="collapseThree" class="collapse" aria-bs-labelledby="headingThree" data-bs-parent="#accordion">
						<div class="card-body">
							<a href="{{ route('excel.alumnosAño',['carrera_id'=>$carrera->id,'year'=>3,'ciclo_lectivo'=>$ciclo_lectivo]) }}" class="btn btn-sm btn-success mb-2"><i class="fas fa-download"></i> Descargar Alumnos</a>
							<table class="table">
								<thead>
									<tr>
										<th scope="col">Apellidos y Nombres</th>
										<th scope="col">DNI</th>
										@if($ciclo_lectivo == date('Y'))
										<th scope="col" class="text-center">Verificado</th>
										@endif
										<th scope="col">Accion</th>
									</tr>
								</thead>
								<tbody>
									@foreach($carrera->obtenerAlumnosCicloLectivo($ciclo_lectivo) as $alumno)
									@if($alumno->procesoCarrera($carrera->id,$alumno->alumno_id, $ciclo_lectivo)->año == 3)
									<tr>
										<td>{{$alumno->apellidos.' '.$alumno->nombres}}</td>
										<td>{{ $alumno->dni }}</td>
										@if($ciclo_lectivo == date('Y'))
										<td>
											@if($alumno->aprobado)
											<i class='fas fa-user-check' style='font-size:24px;color:green'></i>
											@else
											<i class='fas fa-user-times' style='font-size:24px;color:red'></i>
											@endif
										</td>
										@endif
										<td>
											<a href="{{ route('alumno.detalle',['id'=>$alumno->alumno_id, 'ciclo_lectivo' => $ciclo_lectivo]) }}" class="btn btn-sm btn-secondary">
												Ver datos
											</a>
										</td>
									</tr>
									@endif
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	@endsection('content')