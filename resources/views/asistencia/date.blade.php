@extends('layouts.app-prueba')
@section('content')
	<div class="container">
		<h2 class="h1 text-info">
			Primero elige la fecha
		</h2>
		<hr>
		<div class="col-md-6">
			<form method="POST" action="{{ route('crear_asis',['id'=>$materia->id]) }}">
				@csrf
				<div class="form-group">
					<label for="fecha">Fecha:</label>
					<input type="date" id="fecha" name="fecha" class="form-control @error('fecha') is-invalid @enderror" value="{{ old('fecha') }}" required />

					@error('fecha')
						<span class="invalid-feedback d-block" role="alert">
			                <strong>{{ $message }}</strong>
			            </span>
					@enderror
				</div>
				<div class="form-group">
					<label for="presencialidad">Presencialidad:</label>
					<select id="presencialidad" name="presencialidad" class="form-control">
						<option value="presencial">Presencial</option>
						<option value="sincronico">Sincronico</option>
						<option value="asincronico">Asincronica</option>
					</select>

					@error('fecha')
						<span class="invalid-feedback d-block" role="alert">
			                <strong>{{ $message }}</strong>
			            </span>
					@enderror
				</div>
				<input type="submit" value="Siguiente ->" class="btn btn-success">
			</form>
		</div>
	</div>
@endsection
