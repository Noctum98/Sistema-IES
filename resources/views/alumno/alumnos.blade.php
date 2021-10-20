@extends('layouts.app')
@section('content')
	<div class="container">
		<h2 class="h1">
			Alumnos de {{ $carrera->nombre }}
		</h2>
		<p>
			Selecciona el año para mostrar los alumnos de cada uno
		</p>
		<hr>
			<div class="col-md-11">
			<div id="accordion">
			  <div class="card">
			    <div class="card-header" id="headingOne">
			      <h5 class="mb-0">
			        <h2 style="cursor: pointer;" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
			          Primer Año
			        </h2>
			      </h5>
			    </div>

			    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
			      <div class="card-body">
			        <table class="table">
					  <thead>
					    <tr>
					      <th scope="col">Nombre y Apellido</th>
					      <th scope="col">DNI</th>
					      <th scope="col">Accion</th>
					    </tr>
					  </thead>
					  <tbody>
					  	@foreach($alumnos as $alumno)
					  		@if($alumno->año == 1 || $alumno->año == '1')
						    <tr>
						      <td>{{$alumno->nombres.' '.$alumno->apellidos}}</td>
						      <td>{{ $alumno->dni }}</td>
						      <td>
						      	<a href="{{ route('alumno.detalle',['id'=>$alumno->id]) }}" class="btn-sm btn-secondary mr-1">
						      		Ver datos de alumno
						      	</a>
						      	<a href="{{ route('proceso.inscribir',['id'=>$alumno->id]) }}" class="btn-sm btn-primary">
						      		Inscribir en materias
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
			        <h2 style="cursor:pointer;" class="collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
			          Segundo Año
			        </h2>
			      </h5>
			    </div>
			    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
			      <div class="card-body">
			        <table class="table">
					  <thead>
					    <tr>
					      <th scope="col">Nombre y Apellido</th>
					      <th scope="col">DNI</th>
					      <th scope="col">Accion</th>
					    </tr>
					  </thead>
					  <tbody>
					  	@foreach($alumnos as $alumno)
					  		@if($alumno->año == 2 || $alumno->año == '2')
						    <tr>
						      <td>{{$alumno->nombres.' '.$alumno->apellidos}}</td>
						      <td>{{ $alumno->dni }}</td>
						      <td>
						      	<a href="{{ route('alumno.detalle',['id'=>$alumno->id]) }}" class="btn-sm btn-secondary">
						      		Ver datos de alumno
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
			        <h2 style="cursor:pointer" class="collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
			          Tercer Año
			        </h2>
			      </h5>
			    </div>
			    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
			      <div class="card-body">
			        <table class="table">
					  <thead>
					    <tr>
					      <th scope="col">Nombre y Apellido</th>
					      <th scope="col">DNI</th>
					      <th scope="col">Accion</th>
					    </tr>
					  </thead>
					  <tbody>
					  	@foreach($alumnos as $alumno)
					  		@if($alumno->año == 3 || $alumno->año == '3')
						    <tr>
						      <td>{{$alumno->nombres.' '.$alumno->apellidos}}</td>
						      <td>{{ $alumno->dni }}</td>
						      <td>
						      	<a href="{{ route('alumno.detalle',['id'=>$alumno->id]) }}" class="btn-sm btn-secondary">
						      		Ver datos de alumno
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