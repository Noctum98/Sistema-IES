@extends('layouts.app-prueba')
@section('content')
	<div class="container">
		<h2 class="h1">
			Elige la mesa que deseas rendir
		</h2>
		<hr>

		@if(count($instancias) > 0)
		@foreach($instancias as $instancia)

		<a type="button" href="{{ route('mesa.mate',$instancia->id) }}" class="list-group-item list-group-item-action border-top mt-2 text-primary p-3" >
			<strong>
                {{ $instancia->nombre }}
			</strong>
		</a>
		@endforeach
		@else
			<h3>No hay mesas abiertas</h3>
		@endif
		<!---

		---->
	</div>
@endsection
