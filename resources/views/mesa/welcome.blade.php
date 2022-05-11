@extends('layouts.app-prueba')
@section('content')
	<div class="container">
		<h2 class="h1 text-info">
			Bienvenido a la {{$instancia->nombre}}
		</h2>
		<p>Ingresa tus datos para continuar.</p>
		<hr>
		<form method="POST" action="{{route('mesas.materias')}}" class="col-md-5">
            @csrf
			<div class="form-group">
				<label for="sede">Sede en la que estudia:</label>
				<select name="sede" class="form-select">
					@foreach($sedes as $sede)
					<option value="{{$sede->id}}">{{$sede->nombre}}</option>
					@endforeach
				</select>

				@error('nombres')
					<span class="invalid-feedback d-block" role="alert">
					    <strong>{{ $message }}</strong>
					</span>
				@enderror
			</div>
			<div class="form-group">
				<label for="nombres">Nombres:</label>
				<input type="text" id="nombres" name="nombres" class="form-control @error('nombres') is-invalid @enderror" value="{{ old('nombres') }}" required />

				@error('nombres')
					<span class="invalid-feedback d-block" role="alert">
					    <strong>{{ $message }}</strong>
					</span>
				@enderror
			</div>
			<div class="form-group">
				<label for="apellidos">Apellidos:</label>
				<input type="text" id="apellidos" name="apellidos" class="form-control @error('apellidos') is-invalid @enderror" value="{{ old('apellidos') }}" required />

				@error('apellidos')
					<span class="invalid-feedback d-block" role="alert">
					    <strong>{{ $message }}</strong>
					</span>
				@enderror
			</div>
			<div class="form-group">
				<label for="dni">D.N.I (Sin puntos):</label>
				<input type="number" id="dni" name="dni" class="form-control @error('dni') is-invalid @enderror" value="{{ old('dni') }}" required />

				@error('dni')
					<span class="invalid-feedback d-block" role="alert">
					    <strong>{{ $message }}</strong>
					</span>
				@enderror
			</div>
			<div class="form-group">
				<label for="email">Email:</label>
				<input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" oncopy="return false" email required />

				@error('email')
					<span class="invalid-feedback d-block" role="alert">
					    <strong>{{ $message }}</strong>
					</span>
				@enderror
			</div>
			<div class="form-group">
				<label for="telefono">Teléfono:</label>
				<input type="number" id="telefono" name="telefono" class="form-control @error('telefono') is-invalid @enderror" value="{{ old('telefono') }}" required />

				@error('telefono')
					<span class="invalid-feedback d-block" role="alert">
					    <strong>{{ $message }}</strong>
					</span>
				@enderror
			</div>
			<input type="submit" value="Continuar" class="btn btn-primary">
		</form>
	</div>
@endsection
