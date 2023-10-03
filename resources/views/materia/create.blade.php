@extends('layouts.app-prueba')
@section('content')
	<div class="container p-3">
		<h2 class="h1 text-info">
			Crear materia para {{ $carrera->nombre }}
		</h2>
		<p>Asigna materias a la carrera</p>
		<hr>
		<div class="col-md-4">
			@if(@session('message'))
			<div class="alert alert-success">
				{{ @session('message') }}
			</div>
			@endif
			<form method="POST" action="{{ route('crear_materia',['carrera_id'=>$carrera->id]) }}">
				@csrf
				<div class="form-group">
					<label for="nombre">Nombre:</label>
					<input type="text" id="nombre" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}" required />

					@error('nombre')
						<span class="invalid-feedback d-block" role="alert">
			                <strong>{{ $message }}</strong>
			            </span>
					@enderror
				</div>
				<div class="form-group">
					<label for="año">Año:</label>
					<input type="number" id="año" name="año" class="form-control @error('año') is-invalid @enderror" value="{{ old('año') }}" required />
					@error('año')
						<span class="invalid-feedback d-block" role="alert">
			                <strong>{{ $message }}</strong>
			            </span>
					@enderror
				</div>
				<div class="form-group">
					<label for="regimen">Régimen:</label>
					<select class="form-select" id="regimen" name="regimen">
						<option value="Anual">Anual</option>
						<option value="Cuatrimestral (1er)">Cuatrimestral (1er)</option>
						<option value="Cuatrimestral (2do)">Cuatrimestral (2do)</option>
					</select>
				</div>
				<div class="form-group">
					<label for="correlativa" name="correlativa">Correlatividad:</label>
					<select class="form-select" id="correlativa">
						<option value="">No es correlativa</option>
						@foreach($materias as $materia)
							<option value="{{ $materia->id }}">
								{{ $materia->nombre }}
							</option>
						@endforeach
					</select>
				</div>
				<div class="form-group">
					<input type="submit" class="btn btn-success" value="Guardar materia">
				</div>
			</form>
		</div>
	</div>
@endsection
