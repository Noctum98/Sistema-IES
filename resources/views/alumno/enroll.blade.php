@extends('layouts.app-prueba')
@section('content')
	<div class="container">
		<h2 class="h1 text-info">
			Inscribir a {{ $alumno->nombres.' '.$alumno->apellidos }}
		</h2>
		<hr>
		<div class="col-md-8">
			@if(@session('message'))
				<div class="alert alert-success">
					{{ @session('message') }}
				</div>
			@endif
			<h3 class="text-secondary">Materias Inscritas</h3>
			@if(count($procesos)> 0)
			<table class="table mt-4">
				  <thead class="thead-dark">
				    <tr>
				      <th scope="col">Nombre</th>
				      <th scope="col">Año</th>
				      <th scope="col">Estado</th>
				      <th scope="col">Acción</th>
				    </tr>
				  </thead>
				  <tbody>
				  	@foreach ($procesos as $proceso)
				    <tr style="cursor:pointer;">
				      <td>{{ $proceso->materia->nombre }}</td>
				      <td>{{ $proceso->materia->año }}</td>
				      @if($proceso->estado == 'en curso' )
					      <td class="text-info">
					      	{{ ucwords($proceso->estado) }}
					      </td>
				      @elseif($proceso->estado == 'regular')
					      <td class="text-success">
					      	{{ ucwords($proceso->estado) }}
					      </td>
					   @else
					   	  <td class="text-danger">
					      	{{ ucwords($proceso->estado) }}
					      </td>
				      @endif
				      <td>
				      	<a href="{{ route('proceso.detalle',['id'=>$proceso->id]) }}" class="btn-sm btn-primary">Ver proceso</a>
				      </td>
				    </tr>
				    @endforeach
				</tbody>
			</table>
			@else
			<p>{{ $alumno->nombres }} no esta inscripto a ninguna materia.</p>
			@endif
			<h3 class="text-secondary">Inscribir a:</h3>
			@if(count($materias)>0)
			<table class="table mt-4">
			  <thead class="thead-dark">
			    <tr>
			      <th scope="col">Nombre</th>
			      <th scope="col">Año</th>
			      <th scope="col">Acción</th>
			    </tr>
			  </thead>
			  <tbody>
			  	@foreach ($materias as $materia)
			    <tr style="cursor:pointer;">
			      <td>{{ $materia['nombre'] }}</td>
			      <td>{{ $materia['año'] }}</td>
			      <td>
			      	<a href="{{route('inscribir_proceso',['alumno_id'=>$alumno->id,'materia_id'=>$materia['id']])}}" class="btn-sm btn-primary">
				      		Inscribir
				    </a>
			      </td>
			    </tr>
			    @endforeach
			</tbody>
		</table>
		@else
		<p>No hay materias disponibles para {{ $alumno->nombres }}.</p>
		@endif
		</div>
	</div>
@endsection
