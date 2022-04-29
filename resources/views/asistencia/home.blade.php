@extends('layouts.app-prueba')
@section('content')
	<div class="container">
		<h2 class="h1">
			Elige la materia para ver la planilla
		</h2>
		<hr>
		
		@foreach($materias as $materia)
		<h3 class="mb-3 mt-3">
		</h3>
		<a type="button" href="{{ route($ruta,['id'=>$materia->id]) }}" class="list-group-item list-group-item-action border-top mt-2 text-success" >
			<strong>
				{{ $materia->carrera->sede->nombre.': '.$materia->carrera->nombre.' - '.$materia->nombre.' ( '.ucwords($materia->carrera->turno).' | Res: '.$materia->carrera->resolucion.' )' }}
			</strong>
		</a>
		@endforeach
		<!---
		
		---->
	</div>
@endsection