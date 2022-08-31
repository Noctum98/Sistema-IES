@extends('layouts.app-prueba')
@section('content')
	<div class="container p-3">
		<div class="col-md-12 d-flex flex-column align-items-center">
			<div class="col-md-7">
			    @if($carrera)
				<h2 class="h1 text-info">
					Preinscripción en {{ $carrera->nombre.' ('.$carrera->sede->nombre.' - Turno '.ucwords($carrera->turno).')' }}
				</h2>
				<hr>
				@if(@session('error_carrera'))
					<div class="alert alert-danger">
						{{@session('error_carrera')}}
					</div>
				@endif
				<div class="col-md-10">
					@if($checked)
						@include('includes.inscripcion')
					@else
						<form action="{{ route('pre.sendEmail',$carrera->id) }}" method="POST">
							<div class="form-group">
							<label for="email">Ingrese su email</label>
							<input type="email" name="email" id="email" class="form-control" required>
							</div>
							<input type="submit" value="Enviar Correo" class="btn btn-success">	
						</form>
					@endif
				</div>
				@else
				<h2 class="h1 text-info">{{$error}}</h2>
				@endif
			</div>
		</div>
	</div>
@endsection
