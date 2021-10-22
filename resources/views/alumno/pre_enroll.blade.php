@extends('layouts.app')
@section('content')
	<div class="container p-3">
		<div class="col-md-12 d-flex flex-column align-items-center">
			<div class="col-md-7">
			    @if($carrera)
				<h2 class="h1">
					Preinscripción en {{ $carrera->nombre.' ('.$carrera->sede->nombre.' - Turno '.ucwords($carrera->turno).')' }} 
				</h2>
				<hr>
				@if(@session('error_carrera'))
					<div class="alert alert-danger">
						{{@session('error_carrera')}}
					</div>	
				@endif
				<div class="col-md-10">
					@include('includes.inscripcion')
				</div>
				@else
				<h2 class="h1">{{$error}}</h2>
				@endif
			</div>	
		</div>
	</div>
@endsection