@extends('layouts.app-prueba')

	<link href="{{ asset('vendors/select2/css/select2.min.css') }}" rel="stylesheet">

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
		@if(count($carreras) > 0)
		@foreach($carreras as $carrera)
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
				<a href="{{ route('mesa.tribunal',['id'=>$carrera->id,'instancia_id'=>$instancia->id]) }}" class="btn btn-sm btn-success mb-3">Descargar tribunal</a>

					@if($carrera->estado != 1)
					<table class="table">
						<thead class="thead-dark">
							<tr>
								<th scope="col">Primer Año</th>
								<th scope="col">Fecha Primer llamado</th>
								<th scope="col">Fecha Segundo llamado</th>
								<th scope="col"><i class="fa fa-cog" style="font-size:20px;"></i></th>
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
								
								<th scope="col">Fecha Primer llamado</th>
								<th scope="col">Fecha Segundo llamado</th>
								
								<th scope="col"><i class="fa fa-cog" style="font-size:20px;"></i></th>
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
								
								<th scope="col">Fecha Primer llamado</th>
								<th scope="col">Fecha Segundo llamado</th>
								
								<th scope="col"><i class="fa fa-cog" style="font-size:20px;"></i></th>
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
			@else
			<h3>No tienes carreras asignadas.</h3>
			@endif
		</div>
	</div>
	@endsection
	@section('scripts')
		<script src="{{ asset('js/mesas/configuracion.js') }}"></script>
		<script src="{{asset('vendors/select2/js/select2.min.js')}}"></script>
		<script>
			$('.js-data-example-ajax').select2({

				ajax: {
					url: 'carrera/verProfesores/'+$(this).attr('id'),
					dataType: 'json'
					// Additional AJAX parameters go here; see the end of this chapter for the full code of this example
				}
			});
		</script>

	@endsection
