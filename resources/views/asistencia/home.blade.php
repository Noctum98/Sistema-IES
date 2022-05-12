@extends('layouts.app-prueba')
@section('content')
<div class="container">
	<h2 class="h1 text-info">
		Elige la materia para ver la planilla
	</h2>
	<hr>
	@if(count($materias) > 0)
	<h4>Materias</h4>
	@foreach($materias as $materia)
	<a type="button" href="{{ route($ruta,['id'=>$materia->id]) }}" class="list-group-item list-group-item-action border-top mt-2 text-success">
		<strong>
			{{ $materia->carrera->sede->nombre.': '.$materia->carrera->nombre.' - '.$materia->nombre.' ( '.ucwords($materia->carrera->turno).' | Res: '.$materia->carrera->resolucion.' )' }}
		</strong>
	</a>
	@endforeach
	@endif
	@if(count($cargos) > 0)
	@foreach($cargos as $cargo)
	<h4 class="text-secondary">Cargos</h4>
	@foreach($cargo->materias as $materia)
	<a type="button" href="{{ route($ruta,['id'=>$materia->id,'cargo_id'=>$cargo->id]) }}" class="list-group-item list-group-item-action border-top mt-2 text-success">
		<strong>
			{{ $materia->carrera->sede->nombre.': '.$materia->carrera->nombre.' - '.$materia->nombre.' ( '.ucwords($materia->carrera->turno).' | Res: '.$materia->carrera->resolucion.' )' }}
		</strong>
	</a>
	@endforeach

	@endforeach
	@endif
</div>
@endsection