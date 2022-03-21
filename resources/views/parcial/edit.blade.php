@extends('layouts.app-prueba')
@section('content')
	<div class="container">
		<h2 class="h1">
			Notas {{ $parcial->nombre }}
		</h2>
		<hr>
		<table class="table mt-4">
		  <thead class="thead-dark">
		    <tr>
		      <th scope="col">Nombre</th>
		      <th scope="col">Nota</th>
		      <th scope="col">Porcentaje</th>
		      <th scope="col">Acción</th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach ($parcial->parciales as $parci)
		    <tr style="cursor:pointer;">
		      <td>{{ $parci->alumno->nombres.' '.$parci->alumno->apellidos }}</td>
		      <td class="{{ $parci->nota >= 6 ? ('text-success') : ($parci->nota > 0 && $parci->nota < 6 ? ('text-danger'): ('')) }}">
		      	{{ $parci->nota ? $parci->nota : 'Sin asignar' }}
		      </td>
		      <td style="width:150px">
		      	<input type="number" name="nota" id="{{$parci->alumno->id.'/'.$parcial->id.'/nota/parcial/'}}" value="{{ $parci->porcentaje_nota }}" class="nota form-control">
		      </td>
		      <td>
		      	<button class="mr-2 btn btn-primary asig-nota" id="{{$loop->index}}">
		      		Cambiar nota
		      	</button>
		      </td>
		    </tr>
		    @endforeach
		  </tbody>
		</table>
		<a href="{{ route('parci.admin',['id'=>$parcial->materia_id]) }}" class="btn btn-secondary">
			Guardar Planilla
		</a>
	</div>
	</div>
@endsection