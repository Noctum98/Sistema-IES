@extends('layouts.app-prueba')
@section('content')
	<div class="container">
		<h2 class="h1 text-info">
			Asistencia cerrada
		</h2>
		<hr>
		<table class="table mt-4">
		  <thead class="thead-dark">
		    <tr>
		      <th scope="col">Alumno</th>
		      <th scope="col">Porcentaje</th>
		      <th scope="col">Estado</th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($procesos as $proceso)
			    <tr style="cursor:pointer;">
			      <td>{{ $proceso->alumno->nombres.' '.$proceso->alumno->apellidos }}</td>
			      <td>% {{ $proceso->final_asistencia }}</td>
			      <td>
			      	@if($proceso->final_asistencia >= 70)
			      		<span class="text-success font-weight-bold"> Asistencia regular </span>
			      	@else
			      		<span class="text-danger font-weight-bold"> Asistencia irregular </span>
			      	@endif
			      </td>
			    </tr>
		    @endforeach
		  </tbody>
		</table>
		<a href="{{url()->previous()}}" class="btn btn-warning">
			Volver
		</a>
	</div>
@endsection
