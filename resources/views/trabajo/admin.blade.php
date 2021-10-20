@extends('layouts.app')
@section('content')
	<div class="container">
		<h2 class="h1">
			Trabajos Prácticos de {{ $materia->nombre }}
		</h2>
		<hr>
		<div class="col-md-8">
			<a href="{{ route('trab.crear',['id'=>$materia->id]) }}" class="btn btn-primary">
				Crear Trabajo Práctico
			</a>
			<br>
			<br>
			<div id="accordion">
					@foreach($trabajos as $trab)
					  <div class="card">
					    <div class="card-header" id="heading{{$trab->id}}">
					      <h5 class="mb-0">
					        <h6 style="cursor: pointer;" data-toggle="collapse" data-target="#collapse{{$trab->id}}" aria-expanded="false" aria-controls="collapse{{$trab->id}}" class="font-weight-bold">
					        	
					          {{$trab->nombre}}

					        </h6>
					      </h5>
					    </div>

					    <div id="collapse{{$trab->id}}" class="collapse" aria-labelledby="heading{{$trab->id}}" data-parent="#accordion">
					      <div class="card-body">
					        <table class="table">
							  <thead>
							    <th scope="col">Nombre</th>
							    <th scope="col">Fecha</th>
							    <th scope="col">Porcentaje</th>
							    <th scope="col">Nota</th>
							  </thead>
							  <tbody>
							  	@foreach($trab->trabajos as $trabajo)
							  	<tr>
							  		<td><strong>
							  			{{ $trabajo->alumno->nombres.' '.$trabajo->alumno->apellidos }}
							  		</strong></td>
							  		<td class="fecha-titulo">{{$trab->fecha}}</td>
							  		<td>{{$trabajo->porcentaje}} %</td>
							  		<td class="font-weight-bold {{$trabajo->nota >= 6 ? 'text-success' : 'text-danger'}}">
							  			{{ ucwords($trabajo->nota) }}
							  		</td>
							  	</tr>
							  	@endforeach
							  </tbody>
							</table>
							<a href="{{route('trab.editar',['id'=>$trab->id])}}" class="btn-sm btn-warning">
							Editar Notas
							</a>
					    </div>
					</div>
				@endforeach
			</div>
		</div>
	</div>
@endsection