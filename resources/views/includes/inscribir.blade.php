<form  method="POST" action="{{ route('crear_alumno',['carrera_id'=>$carrera->id]) }}">
	@csrf
	<div class="form-group">
		<label for="año">Año:</label>
		<select name="año" id="año" class="form-control">
			<option value=1>1er año</option>
			<option value=2>2do año</option>
			<option value=3>3er año</option>
		</select>

		@error('año')
			<span class="invalid-feedback" role="alert">
			    <strong>{{ $message }}</strong>
			</span>
		@enderror
	</div>
	<div class="form-group">
		<label for="nombres">Nombres (como figura en el documento):</label>
		<input type="text" id="nombres" name="nombres" class="form-control @error('nombres') is-invalid @enderror" value="{{ old('nombres') }}" required>

		@error('nombres')
			<span class="invalid-feedback" role="alert">
			    <strong>{{ $message }}</strong>
			</span>
		@enderror
	</div>
	<div class="form-group">
		<label for="apellidos">Apellidos (como figura en el documento):</label>
		<input type="text" id="apellidos" name="apellidos" class="form-control @error('apellidos') is-invalid @enderror" value="{{ old('apellidos') }}" required>

		@error('apellidos')
			<span class="invalid-feedback" role="alert">
			    <strong>{{ $message }}</strong>
			</span>
		@enderror
	</div>
	<div class="form-group">
		<label for="fecha">Fecha de Nacimiento:</label>
		<input type="date" id="fecha" name="fecha" class="form-control @error('fecha') is-invalid @enderror" value="{{ old('fecha') }}" required>

		@error('fecha')
			<span class="invalid-feedback" role="alert">
			    <strong>{{ $message }}</strong>
			</span>
		@enderror
	</div>
	<div class="form-group">
		<label for="dni">D.N.I (Sin puntos):</label>
		<input type="number" id="dni" name="dni" class="form-control @error('dni') is-invalid @enderror" value="{{ old('dni') }}" required>

		@error('dni')
			<span class="invalid-feedback" role="alert">
			    <strong>{{ $message }}</strong>
			</span>
		@enderror
	</div>
	<div class="form-group">
		<label for="telefono">Teléfono:</label>
		<input type="number" id="telefono" name="telefono" class="form-control @error('telefono') is-invalid @enderror" value="{{ old('telefono') }}" required>

		@error('telefono')
			<span class="invalid-feedback" role="alert">
			    <strong>{{ $message }}</strong>
			</span>
		@enderror
	</div>
	<div class="form-group">
		<label for="email">Email:</label>
		<input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" email required>

		@error('email')
			<span class="invalid-feedback" role="alert">
			    <strong>{{ $message }}</strong>
			</span>
		@enderror
	</div>
	<input type="submit" value="Inscribirse" id="loading" class="btn btn-success">
</form>