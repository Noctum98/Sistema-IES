@extends('layouts.app-prueba')
@section('content')
	<div class="container p-3">
		<h2 class="h1 text-info">
			Editar materia {{ $materia->nombre }}
		</h2>
		<div class="col-md-4">
			@if(@session('message'))
			<div class="alert alert-success">
				{{ @session('message') }}
			</div>
			@endif
			<form method="POST" action="{{ route('editar_materia',['id'=>$materia->id]) }}">
				@csrf
				<div class="form-group">
					<label for="nombre">Nombre:</label>
					<input type="text" id="nombre" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ $materia->nombre }}" required />

					@error('nombre')
						<span class="invalid-feedback d-block" role="alert">
			                <strong>{{ $message }}</strong>
			            </span>
					@enderror
				</div>
				<div class="form-group">
					<label for="año">Año:</label>
					<input type="number" id="año" name="año" class="form-control @error('año') is-invalid @enderror" value="{{ $materia->año }}" required />
					@error('año')
						<span class="invalid-feedback d-block" role="alert">
			                <strong>{{ $message }}</strong>
			            </span>
					@enderror
				</div>
				<div class="form-group">
					<label for="regimen">Régimen:</label>
					<select class="form-select" id="regimen"  name="regimen">
						<option value="Anual" {{ $materia->regimen == 'Anual' ? 'selected="selected"' :'' }}>Anual</option>
						<option value="Cuatrimestral (1er)" {{ $materia->regimen == 'Cuatrimestral (1er)' ?  'selected="selected"' :'' }}>Cuatrimestral (1er)</option>
						<option value="Cuatrimestral (2do)" {{ $materia->regimen == 'Cuatrimestral (2do)' ?  'selected="selected"' :'' }}>Cuatrimestral (2do)</option>
					</select>
				</div>
				<div class="form-group">
					<label for="correlativa" name="correlativa">Correlatividad:</label>
					<select class="form-control" id="correlativa">
						<option value="">No es correlativa</option>
						@foreach($materias as $mater)
							@if($materia->correlativa == $mater->id)
								<option value="{{ $materia->id }}" selected="selected">
									{{ $mater->nombre }}
								</option>
							@else
								<option value="{{ $materia->id }}">
									{{ $mater->nombre }}
								</option>
							@endif

						@endforeach
					</select>
				</div>
				<div class="form-group">
					<label for="etapa_campo">Etapa de Campo</label>
					<select name="etapa_campo" id="etapa_campo" class="form-select">
						<option value="1" {{ $materia->etapa_campo ? 'selected' : '' }}>Habilitado</option>
						<option value="0" {{ !$materia->etapa_campo ? 'selected' : '' }}>Deshabilitado</option>
					</select>
				</div>
				<div class="form-group">
					<input type="submit" class="btn btn-success" value="Editar materia">
				</div>
			</form>
		</div>
	</div>
@endsection
