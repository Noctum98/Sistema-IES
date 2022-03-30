@extends('layouts.app-prueba')
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
			@if(@session('alumno_deleted'))
				<div class="alert alert-warning">
					{{ @session('alumno_deleted') }}
				</div>
			@endif
			<div id="accordion">
			  <div class="card">
			    <div class="card-header" id="headingOne">
			      <h5 class="mb-0">
			        <h5 style="cursor: pointer;" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-bs-expanded="true" aria-bs-controls="collapseOne">
			          Primer Año
			        </h5>
			      </h5>
			    </div>

			    <div id="collapseOne" class="collapse show" aria-bs-labelledby="headingOne" data-bs-parent="#accordion">
			      <div class="card-body">
					<a href="{{ route('excel.alumnosAño',['carrera_id'=>$carrera->id,'year'=>1]) }}" class="btn btn-sm btn-success mb-2">Descargar Alumnos</a>
			        <table class="table">
					  <thead>
					    <tr>
					      <th scope="col">Nombre y Apellido</th>
					      <th scope="col">DNI</th>
					      <th scope="col">Accion</th>
					    </tr>
					  </thead>
					  <tbody>
					  	@foreach($carrera->alumnos as $alumno)
					  		@if($alumno->año == 1 || $alumno->año == '1')
						    <tr>
						      <td>{{$alumno->nombres.' '.$alumno->apellidos}}</td>
						      <td>{{ $alumno->dni }}</td>
						      <td>
						      	<a href="{{ route('alumno.detalle',['id'=>$alumno->id]) }}" class="btn btn-sm btn-secondary mr-1">
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
				  <a href="{{ route('excel.alumnosAño',['carrera_id'=>$carrera->id,'year'=>2]) }}" class="btn btn-sm btn-success mb-2">Descargar Alumnos</a>
			        <table class="table">
					  <thead>
					    <tr>
					      <th scope="col">Nombre y Apellido</th>
					      <th scope="col">DNI</th>
					      <th scope="col">Accion</th>
					    </tr>
					  </thead>
					  <tbody>
					  	@foreach($carrera->alumnos as $alumno)
					  		@if($alumno->año == 2 || $alumno->año == '2')
						    <tr>
						      <td>{{$alumno->nombres.' '.$alumno->apellidos}}</td>
						      <td>{{ $alumno->dni }}</td>
						      <td>
						      	<a href="{{ route('alumno.detalle',['id'=>$alumno->id]) }}" class="btn btn-sm btn-secondary">
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
				  <a href="{{ route('excel.alumnosAño',['carrera_id'=>$carrera->id,'year'=>3]) }}" class="btn btn-sm btn-success mb-2">Descargar Alumnos</a>
			        <table class="table">
					  <thead>
					    <tr>
					      <th scope="col">Nombre y Apellido</th>
					      <th scope="col">DNI</th>
					      <th scope="col">Accion</th>
					    </tr>
					  </thead>
					  <tbody>
					  	@foreach($carrera->alumnos as $alumno)
					  		@if($alumno->año == 3 || $alumno->año == '3')
						    <tr>
						      <td>{{$alumno->nombres.' '.$alumno->apellidos}}</td>
						      <td>{{ $alumno->dni }}</td>
						      <td>
						      	<a href="{{ route('alumno.detalle',['id'=>$alumno->id]) }}" class="btn btn-sm btn-secondary">
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