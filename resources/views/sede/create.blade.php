@extends('layouts.app-prueba')

@section('content')
	<div class="container">
		<h2 class="h1">
		Crear Sede
		</h2>
		<span>Crea sedes en caso de necesitarlas</span>
		<hr>
		@if(@session('message'))
			<div class="col-md-6 alert alert-success">
				{{@session('message')}}
			</div>
		@elseif(@session('error'))
			<div class="col-md-6 alert alert-success">
				{{@session('error')}}
			</div>
		@endif
		<form class="col-md-6" method="POST" action="{{ route('crear_sede') }}">
			 @csrf
			<div class="form-group">
				<label for="nombre">Nombre de la Sede</label>
				<input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}" placeholder="Sede Central" required />

				@error('nombre')
					<span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
				@enderror
			</div>
			<div class="form-group">
				<label for="ubicacion">Ubicación de la Sede</label>
				<input type="text" name="ubicacion" class="form-control @error('ubicacion') is-invalid @enderror" value="{{ old('ubicacion') }}" placeholder="Consulta/San Carlos" required />

				@error('ubicacion')
					<span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
				@enderror
			</div>
			<div class="form-group">
				<input type="submit" value="Guardar Sede" class="btn btn-success">
			</div>
			
		</form>
	</div>
	
@endsection