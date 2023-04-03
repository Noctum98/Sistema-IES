@extends('layouts.app-prueba')
@section('content')
<div class="container p-3">
	<a href="{{url()->previous()}}" ><button class="btn btn-outline-info mb-2"><i class="fas fa-angle-left"></i> Volver</button> </a>
	<h2 class="h1 text-info">
		Listado materias
	</h2>
	<hr>
	@if(Session::has('admin') || Session::has('coordinador') || Session::has('seccionAlumnos'))
	<a href="{{ route('carrera.admin') }}" class="btn btn-success mb-4">
		Crear materia
	</a>
	@endif





	@if(@session('error_procesos'))
	{{ @session('error_procesos') }}
	@endif
	<div class="col-md-8">


		<table class="table table-hover mt-4">
			<thead class="thead-dark">
				<tr>
					<th scope="col">Materia</th>
					<th scope="col">Año</th>
					<th scope="col">Carrera</th>
					<th scope="col">Sede</th>
					<th scope="col" class="text-center"> <i class="fa fa-cog" style="font-size:20px;"></i>
					</th>
				</tr>
			</thead>
			<tbody>
				@foreach($materias as $materia)

				<tr style="cursor:pointer;">
					<td>{{ $materia->nombre }}</td>
					<td>{{ $materia->año }}</td>
					<td>
					{{ $materia->carrera->nombre }}
						@if(Auth::user()->hasRole('admin'))
							<a href="{{ route('carrera.editar',['id'=>$materia->carrera->id]) }}" class="mr-2 col-md-12 btn btn-sm btn-warning">
								Editar
							</a>
						@endif
					</td>
					<td>
					{{ $materia->carrera->sede->nombre }}
					</td>
					<td>
						@if(Auth::user()->hasRole('admin'))
						<a href="{{ route('materia.editar',['id'=>$materia->id]) }}" class="btn btn-sm btn-warning">Editar</a>
						@endif
						<a href="{{ route('calificacion.admin',['materia_id'=>$materia->id]) }}" class="btn btn-sm btn-secondary">Ver calificaciones</a>
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

				@endforeach
			</tbody>
		</table>
		<div class="d-flex justify-content-center" style="font-size: 0.8em">
			{{ $materias->links() }}
		</div>

	<a href="{{url()->previous()}}" ><button class="btn btn-outline-info mb-2"><i class="fas fa-angle-left"></i> Volver</button> </a>
</div>

@endsection