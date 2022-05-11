@extends('layouts.app-prueba')
@section('content')
	<div class="container">
		<h2 class="h1 text-info">
			Preinscripciones de {{ $carrera->nombre.' ('.$carrera->sede->nombre.'-'.ucwords($carrera->turno).')' }}
		</h2>
		<hr>
		<a class="btn btn-success" href="{{route('pre.excel',['carrera_id'=>$carrera->id])}}">Descargar Excel</a>
		<a class="btn btn-secondary" href="{{route('pre.verificadas',['id'=>$carrera->id])}}">Ver verificadas</a>
		<a class="btn btn-danger" href="{{route('pre.sincorregir',['id'=>$carrera->id])}}">Ver sin corregir</a>
		<br>
		@if(count($preinscripciones) == 0)
		    <br>
			<p>No hay preinscripciones sin verificar para esta carrera.</p>
		@else
		<table class="table mt-4">
		  <thead class="thead-dark">
		    <tr>
		      <th scope="col">Nombre y Apellido</th>
		      <th scope="col">D.N.I</th>
		      <th scope="col">Email</th>
		      <th scope="col">Telefono</th>
		      <th scope="col">Acción</th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach ($preinscripciones as $preinscripcion)
		    <tr style="cursor:pointer;">
		      <td>{{ $preinscripcion->nombres.' '.$preinscripcion->apellidos }}</td>
		      <td>{{ $preinscripcion->dni }}</td>
		      <td>{{ $preinscripcion->email }}</td>
		      <td>{{ $preinscripcion->telefono }}</td>
		      <td>
		      	<a href="{{ route('pre.detalle',['id'=>$preinscripcion->id]) }}" class="btn-sm btn-primary">
		      		Ver datos
		      	</a>
		      </td>
		    </tr>
		    @endforeach
		  </tbody>
		</table>
		@endif
	</div>
@endsection
