@extends('layouts.app-prueba')
@section('content')
	<div class="container">
		<h2 class="h1 text-info">
			Editar {{ $trabajo->nombre }}
		</h2>
		<hr>
		<table class="table mt-4">
		  <thead class="thead-dark">
		    <tr>
		      <th scope="col">Nombre</th>
		      <th scope="col">Porcentaje</th>
		      <th scope="col">Nota</th>
		      <th scope="col"><i class="fa fa-cog" style="font-size:20px;"></i></th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach ($trabajo->trabajos as $trab)
		    <tr style="cursor:pointer;">
		      <td>{{ $trab->alumno->nombres.' '.$trab->alumno->apellidos }}</td>
		      <td style="width:150px">
		      	<input type="number" max="100" value="{{$trab->porcentaje}}" name="nota" id="{{$trab->alumno->id.'/'.$trabajo->id.'/alumno/trab/'}}" class="nota form-control">
		      </td>
		      <td class="{{$trab->nota >= 6 ? 'text-success' : 'text-danger'}} nueva-nota">
		      	{{$trab->nota}}
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
