@extends('layouts.app')
@section('content')
	<div class="container">
		<h2 class="h1">
			Administrar asistencias {{ $materia->nombre }}
		</h2>
		<hr>
		<div class="col-md-8">
			<a href="{{ route('asis.fecha',['id'=>$materia->id]) }}" class="btn btn-primary">
				Tomar asistencia
			</a>
			<a href="{{ route('cerrar_asis',['id'=>$materia->id]) }}" class="btn btn-secondary">
				Cerrar planilla
			</a>
			<br>
			<br>
				<div id="accordion">
					@foreach($asistencias as $dia)
					  <div class="card">
					    <div class="card-header" id="heading{{$dia->id}}">
					      <h5 class="mb-0">
					        <h6 style="cursor: pointer;" data-toggle="collapse" data-target="#collapse{{$dia->id}}" aria-expanded="false" aria-controls="collapse{{$dia->id}}" class="fecha-titulo font-weight-bold">
					        	
					          {{$dia->fecha}}

					        </h6>
					      </h5>
					    </div>

					    <div id="collapse{{$dia->id}}" class="collapse" aria-labelledby="heading{{$dia->id}}" data-parent="#accordion">
					      <div class="card-body">
					        <table class="table">
							  <thead>
							    <th>Nombre y Apellido</th>
								<th>Estado</th>
							  </thead>
							  <tbody>
							  	@foreach($dia->asistencias as $asistencia)
							  	<tr>
							  		<td><strong>
							  			{{ $asistencia->alumno->nombres.' '.$asistencia->alumno->apellidos }}
							  		</strong></td>
							  		<td class="font-weight-bold {{$asistencia->estado == 'presente' ? 'text-success' : 'text-danger'}}">
							  			{{ ucwords($asistencia->estado) }}
							  		</td>
							  	</tr>
							  	@endforeach
							  </tbody>
							</table>
							<a href="" class="btn btn-sm btn-warning">Editar asistencias</a>
					      </div>
					    </div>
					@endforeach
			  </div>
		</div>
		
	</div>
@endsection