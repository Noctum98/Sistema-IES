@extends('layouts.app-prueba')
@section('content')
	<div class="container">
		<h2 class="h1">
		{{ $trabajo->nombre }}
		</h2>
		<hr>
		<table class="table mt-4">
		  <thead class="thead-dark">
		    <tr>
		      <th scope="col">Nombre</th>
		      <th scope="col">Porcentaje</th>
		      <th scope="col">Acción</th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach ($procesos as $proceso)
		    <tr style="cursor:pointer;">
		      <td>{{ $proceso->alumno->nombres.' '.$proceso->alumno->apellidos }}</td>
		      <td style="width:150px">
		      	<input type="number" name="nota" id="{{$proceso->alumno->id.'/'.$trabajo->id.'/nota/trabajo/'}}" class="nota form-control">
		      </td>
		      <td>
		      	<button class="mr-2 btn btn-primary asig-nota" id="{{$loop->index}}">
		      		Nota
		      	</button>
		      </td>
		    </tr>
		    @endforeach
		  </tbody>
		</table>
		<a href="{{ route('trab.admin',['id'=>$trabajo->materia_id]) }}" class="btn btn-secondary">
			Guardar Planilla
		</a>
	</div>
@endsection