@extends('layouts.app-prueba')
@section('content')
<div class="container">
	<h2 class="h1 text-info">
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
	@if(@session('error_fecha'))
	<div class="alert alert-danger">
		{{@session('error_fecha')}}
	</div>
	@endif

	<div id="accordion">
		@foreach($sede->carreras as $carrera)
		<div class="card">
			<div class="card-header" id="heading{{$carrera->id}}">
					<h6 style="cursor: pointer;" data-bs-toggle="collapse" data-bs-target="#collapse{{$carrera->id}}" aria-expanded="false" aria-controls="collapse{{$carrera->id}}" class="font-weight-bold text-secondary">
						{{$carrera->nombre}} -
						@if($carrera->nombre != 'Enfermería Profesional')
						Res: {{$carrera->resolucion}}
						@else
						Turno {{ucwords($carrera->turno)}}
						@endif
					</h6>
			</div>

			<div id="collapse{{$carrera->id}}" class="collapse" aria-labelledby="heading{{$carrera->id}}" data-bs-parent="#accordion">
				<div class="card-body">
					@if($carrera->estado != 1)
					<table class="table">
						<thead class="thead-dark">
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
							@include('includes.mesas.table_materias')
							@endif
							@endforeach

						</tbody>
					</table>
					@endif
					<table class="table">
						<thead class="thead-dark">
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
							@include('includes.mesas.table_materias')
							@endif
							@endforeach

						</tbody>
					</table>
					<table class="table">
						<thead class="thead-dark">
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
							@include('includes.mesas.table_materias')
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
