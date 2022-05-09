@extends('layouts.app-prueba')
@section('content')
	<div class="container">
		<h2 class="h1">
			Elige la mesa que deseas rendir
		</h2>
		<hr>

		@foreach($instancias as $instancia)

		<a type="button" href="{{ route('mesa.mate',$instancia->id) }}" class="list-group-item list-group-item-action border-top mt-2 text-primary p-3" >
			<strong>
                {{ $instancia->nombre }}
			</strong>
		</a>
        @endforeach
		<!---

		---->
	</div>
@endsection
