@extends('layouts.app-prueba')
@section('content')
<div class="container p-3">
	<a href="{{route('carrera.admin')}}" ><button class="btn btn-outline-info mb-2"><i class="fas fa-angle-left"></i> Volver</button> </a>
	<h2 class="h1 text-info">
		Plan de estudios de {{ $carrera->nombre }}
	</h2>
	<hr>
	@if(Session::has('admin') || Session::has('coordinador') || Session::has('seccionAlumnos'))
	<a href="{{ route('materia.crear',['carrera_id'=>$carrera->id]) }}" class="btn btn-success mb-4">
		Agregar materia
	</a>
	<a href="{{ route('comisiones.ver',$carrera->id) }}" class="btn btn-warning mb-4">
		Ver comisiones
	</a>
		<button class="btn btn-info mb-4"
		   data-bs-toggle="modal" data-bs-target="#crearComision"
		>
		Crear comisión
	</button>
	@endif





	@if(@session('error_procesos'))
	{{ @session('error_procesos') }}
	@endif
	<div class="col-md-8">
		@if($carrera->estado != 1)
		<h3 class="text-secondary">Primer Año</h3>
		<table class="table table-hover mt-4">
			<thead class="thead-dark">
				<tr>
					<th scope="col">Materia</th>
					<th scope="col" class="text-center"> <i class="fa fa-cog" style="font-size:20px;"></i>
					</th>
				</tr>
			</thead>
			<tbody>
				@foreach($materias as $materia)
				@if($materia->año == 1)
				<tr style="cursor:pointer;">
					<td>{{ $materia->nombre }}</td>
					<td>
						@if(Auth::user()->hasRole('admin'))
						<a href="{{ route('materia.editar',['id'=>$materia->id]) }}" class="btn btn-sm btn-warning">Editar</a>
						@endif
						<a href="{{ route('calificacion.admin',['materia_id'=>$materia->id,'ciclo_lectivo'=>date('Y')]) }}" class="btn btn-sm btn-secondary">Ver calificaciones</a>
						<!-----<a href="{{ route('descargar_planilla',$materia->id) }}" class="btn btn-sm btn-success"><i class="fas fa-download"></i> Descargar Alumnos</a>--->
							<sup class="badge badge-info" title="Total Comisiones">
								{{$materia->getTotalAttribute()}}
								@if($materia->getTotalAttribute() > 0)

										<a href="{{ route('comisiones.ver',$carrera->id)}}/?año={{$materia->año}}" >
											<i class="fa fa-eye"></i>
										</a>

								@endif
							</sup>
					</td>
				</tr>
				@endif
				@endforeach
			</tbody>
		</table>
		<hr>
		@endif
		<h3 class="text-secondary">Segundo Año</h3>
		<table class="table table-hover mt-4">
			<thead class="thead-dark">
				<tr>
					<th scope="col">Materia</th>
					<th scope="col"> <i class="fa fa-cog" style="font-size:20px;"></i>
					</th>
				</tr>
			</thead>
			<tbody>
				@foreach($materias as $materia)
				@if($materia->año == 2)
				<tr style="cursor:pointer;">
					<td>{{ $materia->nombre }}</td>
					<td>
						@if(Auth::user()->hasRole('admin'))
						<a href="{{ route('materia.editar',['id'=>$materia->id]) }}" class="btn btn-sm btn-warning">Editar</a>
						@endif
						<a href="{{ route('calificacion.admin',['materia_id'=>$materia->id,'ciclo_lectivo'=>date('Y')]) }}" class="btn btn-sm btn-secondary">Ver calificaciones</a>
						<!-----<a href="{{ route('descargar_planilla',$materia->id) }}" class="btn btn-sm btn-success"><i class="fas fa-download"></i> Descargar Alumnos</a>-->
							<sup class="badge badge-info" title="Total Comisiones">
								{{$materia->getTotalAttribute()}}
								@if($materia->getTotalAttribute() > 0)
										<a href="{{ route('comisiones.ver',$carrera->id)}}/?año={{$materia->año}}" >
											<i class="fa fa-eye"></i>
										</a>
								@endif
							</sup>
					</td>
				</tr>
				@endif
				@endforeach
			</tbody>
		</table>
		<hr>
		<h3 class="text-secondary">Tercer Año</h3>
		<table class="table table-hover mt-4">
			<thead class="thead-dark">
				<tr>
					<th scope="col">Materia</th>
					<th scope="col"> <i class="fa fa-cog" style="font-size:20px;"></i>
					</th>
				</tr>
			</thead>
			<tbody>
				@foreach($materias as $materia)
				@if($materia->año == 3)
				<tr style="cursor:pointer;">
					<td>{{ $materia->nombre }}</td>
					<td>
						@if(Auth::user()->hasRole('admin'))
						<a href="{{ route('materia.editar',['id'=>$materia->id]) }}" class="btn btn-sm btn-warning">Editar</a>
						@endif
						<a href="{{ route('calificacion.admin',['materia_id'=>$materia->id,'ciclo_lectivo'=>date('Y')]) }}" class="btn btn-sm btn-secondary">Ver calificaciones</a>
						<!-----<a href="{{ route('descargar_planilla',$materia->id) }}" class="btn btn-sm btn-success"><i class="fas fa-download"></i> Descargar Alumnos</a>-->

							<sup class="badge badge-info" title="Total Comisiones">
								{{$materia->getTotalAttribute()}}
								</sup>
								@if($materia->getTotalAttribute() > 0)

										<a href="{{ route('comisiones.ver',$carrera->id)}}/?año={{$materia->año}}" >
											<i class="fa fa-eye"></i>
										</a>

								@endif


					</td>
				</tr>
				@endif
				@endforeach
			</tbody>
		</table>
	</div>
	<a href="{{url()->previous()}}" ><button class="btn btn-outline-info mb-2"><i class="fas fa-angle-left"></i> Volver</button> </a>
</div>
@include('comision.modals.crear_comision')
@endsection