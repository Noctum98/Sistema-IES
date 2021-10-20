@extends('layouts.app')
@section('content')
	<div class="container">
		<h2 class="h1">
			Crear Parcial
		</h2>
		<hr>
		<div class="col-md-6">
			<form method="POST" action="{{route('crear_parci',['id'=>$materia->id])}}"> 
				@csrf
				<div class="form-group">
					<label for="nombre">Parcial N°:</label>
					<input type="number" id="nombre" name="nombre" class="form-control @error('nombre') is-invalid @enderror" required>

					@error('nombre')
						<span class="invalid-feedback" role="alert">
				            <strong>{{ $message }}</strong>
				        </span>
					@enderror
				</div>
				<div class="form-group">
					<label for="fecha">Fecha en que se subió el trabajo:</label>
					<input type="date" id="fecha" name="fecha" class="form-control @error('fecha') is-invalid @enderror" value="{{ old('fecha') }}" required>

					@error('fecha')
						<span class="invalid-feedback" role="alert">
				            <strong>{{ $message }}</strong>
				        </span>
					@enderror
				</div>
				<input type="submit" value="Crear Parcial" class="btn btn-success">
			</form>
		</div>
	</div>
@endsection