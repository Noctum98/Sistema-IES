@extends('layouts.app')
@section('content')
	<div class="container">
		<h2 class="h1">
			Ficha de {{ $personal->nombres.' '.$personal->apellidos }}
		</h2>
		<hr>
		<div class="col-md-8">
			<div class="d-flex flex-column">
				@include('includes.personal')
				<div class="ml-3 col-md-5 row">
					<a href="{{ route('personal.editar',['id'=>$personal->id]) }}" class="mr-2 btn-sm btn-warning">
						Editar ficha
					</a>
					<a href="{{ route('descargar_ficha',['id'=>$personal->id]) }}" class="btn-sm btn-danger">
						Descargar ficha
					</a>
				</div>
				
			</div>
			
			
		</div>
	</div>
@endsection