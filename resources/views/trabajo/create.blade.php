@extends('layouts.app-prueba')
@section('content')
	<div class="container">
		<h2 class="h1">
			Crear Trabájo Práctico
		</h2>
		<hr>
		<div class="col-md-6">
			<form method="POST" action="{{ route('crear_trab',['id'=>$materia->id]) }}"> 
				@csrf
				<div class="form-group">
					<label for="nombre">Nombre del trabajo:</label>
					<input type="text" id="nombre" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="Trabajo Práctico N° " required>

					@error('nombre')
						<span class="invalid-feedback d-block" role="alert">
				            <strong>{{ $message }}</strong>
				        </span>
					@enderror
				</div>
				<div class="form-group">
					<label for="fecha">Fecha en que se subió el trabajo:</label>
					<input type="date" id="fecha" name="fecha" class="form-control @error('fecha') is-invalid @enderror" value="{{ old('fecha') }}" required>

					@error('fecha')
						<span class="invalid-feedback d-block" role="alert">
				            <strong>{{ $message }}</strong>
				        </span>
					@enderror
				</div>
				<input type="submit" value="Asignar notas ->" class="btn btn-success">
			</form>
		</div>
	</div>
@endsection