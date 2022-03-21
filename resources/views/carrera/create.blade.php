@extends('layouts.app-prueba')
@section('content')
	<div class="container">
		<h2 class="h1">
			Crear carreras
		</h2>
		<p>Agrega una carrera a tu institución</p>
		<hr>
		<div class="col-md-5">
			<form method="POST" action="{{ route('crear_carrera') }}">
				@csrf
				<div class="form-group">
					<label for="nombre">Nombre de la carrera:</label>
					<input type="text" id="nombre" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}" required>

					@error('nombre')
						<span class="invalid-feedback d-block" role="alert">
			                <strong>{{ $message }}</strong>
			            </span>
					@enderror
				</div>
				<div class="form-group">
					<label for="sede">Sede:</label>
					<select id="sede" name="sede_id" class="form-control">
						@foreach($sedes as $sede)
							<option value="{{ $sede->id }}">{{ $sede->nombre }}</option>
						@endforeach
					</select>

					@error('cargo')
						<span class="invalid-feedback d-block" role="alert">
			                <strong>{{ $message }}</strong>
			            </span>
					@enderror
				</div>
				<div class="form-group">
					<label for="titulo">Nombre del título:</label>
					<input type="text" id="titulo" name="titulo" class="form-control @error('titulo') is-invalid @enderror" value="{{ old('titulo') }}" required>

					@error('titulo')
						<span class="invalid-feedback d-block" role="alert">
			                <strong>{{ $message }}</strong>
			            </span>
					@enderror
				</div>
				<div class="form-group">
					<label for="años">Años de duración:</label>
					<input type="number" id="años" name="años" class="form-control @error('años') is-invalid @enderror" value="{{ old('años') }}" required>

					@error('años')
						<span class="invalid-feedback d-block" role="alert">
			                <strong>{{ $message }}</strong>
			            </span>
					@enderror
				</div>
				<div class="form-group">
					<label for="resolucion">Resolución:</label>
					<input type="text" id="resolucion" name="resolucion" class="form-control @error('resolucion') is-invalid @enderror" value="{{ old('resolucion') }}">

					@error('resolucion')
						<span class="invalid-feedback d-block" role="alert">
			                <strong>{{ $message }}</strong>
			            </span>
					@enderror
				</div>
				<div class="form-group">
					<label for="modalidad">Modalidad:</label>
					<input type="text" id="modalidad" name="modalidad" class="form-control @error('modalidad') is-invalid @enderror" value="{{ old('modalidad') }}">

					@error('modalidad')
						<span class="invalid-feedback d-block" role="alert">
			                <strong>{{ $message }}</strong>
			            </span>
					@enderror
				</div>
				<div class="form-group">
					<label for="turno">Turno:</label>
					<select class="form-control" name="turno" id="turno">
						<option value="mañana">Mañana</option>
						<option value="tarde">Tarde</option>
						<option value="vespertino">Vespertino</option>
					</select>
				</div>
				<div class="form-group">
					<label for="vacunas">Vacunas:</label>
					<select class="form-control" name="vacunas" id="vacunas">
						<option value="todas">
							Todas
						</option>
						<option value="antitetánica">
							Antitetánica
						</option>
						<option value="ninguna">
							Ninguna
						</option>
					</select>
				</div>
				<div class="form-group">
					<input type="submit" value="Agregar carrera" class="btn btn-success">
				</div>
			</form>
		</div>
	</div>
@endsection