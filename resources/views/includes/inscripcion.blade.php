<form method="POST" action="{{ route('crear_preins',['carrera_id'=>$carrera->id]) }}" enctype="multipart/form-data">
	@csrf
	<div class="form-group">
		<label for="nombres">Nombres (como figura en el documento):</label>
		<input type="text" id="nombres" name="nombres" class="form-control @error('nombres') is-invalid @enderror" value="{{ old('nombres') }}" required />

		@error('nombres')
		<span class="invalid-feedback d-block" role="alert">
			<strong>{{ $message }}</strong>
		</span>
		@enderror
	</div>
	<div class="form-group">
		<label for="apellidos">Apellidos (como figura en el documento):</label>
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
		<label for="cuil">N° de CUIL (Sin guiones ni puntos):</label>
		<input type="number" id="cuil" name="cuil" class="form-control @error('cuil') is-invalid @enderror" value="{{ old('cuil') }}" required />

		@error('cuil')
		<span class="invalid-feedback d-block" role="alert">
			<strong>{{ $message }}</strong>
		</span>
		@enderror
	</div>
	<div class="form-group">
		<label for="fecha">Fecha de Nacimiento:</label>
		<input type="date" id="fecha" name="fecha" class="form-control @error('fecha') is-invalid @enderror" value="{{ old('fecha') }}" required />

		@error('fecha')
		<span class="invalid-feedback d-block" role="alert">
			<strong>{{ $message }}</strong>
		</span>
		@enderror
	</div>
	<div class="form-group">
		<label for="edad">Edad:</label>
		<input type="number" id="edad" name="edad" class="form-control @error('edad') is-invalid @enderror" value="{{ old('edad') }}" required />

		@error('edad')
		<span class="invalid-feedback d-block" role="alert">
			<strong>{{ $message }}</strong>
		</span>
		@enderror
	</div>
	<div class="form-group">
		<label for="email">Email:</label>
		<input type="text" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ $checked ? $checked->email : old('email') }}" readonly />

		@error('email')
		<span class="invalid-feedback d-block" role="alert">
			<strong>{{ $message }}</strong>
		</span>
		@enderror
	</div>
	<div class="form-group">
		<label for="nacionalidad">Nacionalidad:</label>
		<select class="form-select" name="nacionalidad" id="nacionalidad">
			<option value="argentina" {{ old('nacionalidad') == 'argentina' ? 'selected' : '' }}>Argentina</option>
			<option value="uruguaya" {{ old('nacionalidad') == 'uruguaya' ? 'selected' : '' }}>Uruguaya</option>
			<option value="chilena" {{ old('nacionalidad') == 'chilena' ? 'selected' : '' }}>Chilena</option>
			<option value="paraguaya" {{ old('nacionalidad') == 'paraguaya' ? 'selected' : '' }}>Paraguaya</option>
			<option value="brasilera" {{ old('nacionalidad') == 'brasilera' ? 'selected' : '' }}>Brasilera</option>
			<option value="boliviana" {{ old('nacionalidad') == 'boliviana' ? 'selected' : '' }}>Boliviana</option>
			<option value="colombiana" {{ old('nacionalidad') == 'colombiana' ? 'selected' : '' }}>Colombiana</option>
			<option value="peruana" {{ old('nacionalidad') == 'peruana' ? 'selected' : '' }}>Peruana</option>
			<option value="venezolana" {{ old('nacionalidad') == 'venezolana' ? 'selected' : '' }}>Venezolana</option>
			<option value="otra" {{ old('nacionalidad') == 'otra' ? 'selected' : '' }}>Otra</option>
		</select>
		@error('nacionalidad')
		<span class="invalid-feedback d-block" role="alert">
			<strong>{{ $message }}</strong>
		</span>
		@enderror
	</div>
	<div class="form-group">
		<label for="domicilio">Domicilio:</label>
		<input type="text" id="domicilio" name="domicilio" class="form-control @error('domicilio') is-invalid @enderror" value="{{ old('domicilio') }}" required />

		@error('domicilio')
		<span class="invalid-feedback d-block" role="alert">
			<strong>{{ $message }}</strong>
		</span>
		@enderror
	</div>
	<div class="form-group">
		<label for="residencia">Residencia:</label>
		<select class="form-select" name="residencia" id="residencia">
			<option value="capital" selected="selected">Capital</option>
			<option value="las heras" {{ old('residencia') == 'las heras' ? 'selected' : '' }}>Las Heras</option>
			<option value="godoy cruz" {{ old('residencia') == 'godoy cruz' ? 'selected' : '' }}>Godoy Cruz</option>
			<option value="guaymallén" {{ old('residencia') == 'guaymallén' ? 'selected' : '' }}>Guaymallén</option>
			<option value="lavalle" {{ old('residencia') == 'lavalle' ? 'selected' : '' }}>Lavalle</option>
			<option value="maipú" {{ old('residencia') == 'maipú' ? 'selected' : '' }}>Maipú</option>
			<option value="san martín" {{ old('residencia') == 'san martín' ? 'selected' : '' }}>San Martín</option>
			<option value="junín" {{ old('residencia') == 'junín' ? 'selected' : '' }}>Junín</option>
			<option value="rivadavia" {{ old('residencia') == 'rivadavia' ? 'selected' : '' }}>Rivadavia</option>
			<option value="santa rosa" {{ old('residencia') == 'santa rosa' ? 'selected' : '' }}>Santa Rosa</option>
			<option value="la paz" {{ old('residencia') == 'la paz' ? 'selected' : '' }}>La Paz</option>
			<option value="luján" {{ old('residencia') == 'luján' ? 'selected' : '' }}>Luján</option>
			<option value="tupungato" {{ old('residencia') == 'tupungato' ? 'selected' : '' }}>Tupungato</option>
			<option value="tunuyán" {{ old('residencia') == 'tunuyán' ? 'selected' : '' }}>Tunuyán</option>
			<option value="san carlos" {{ old('residencia') == 'san carlos' ? 'selected' : '' }}>San Carlos</option>
			<option value="san rafael" {{ old('residencia') == 'san rafael' ? 'selected' : '' }}>San Rafael</option>
			<option value="gral. alvear" {{ old('residencia') == 'gral. alvear' ? 'selected' : '' }}>Gral. Alvear</option>
			<option value="malargue" {{ old('residencia') == 'malargue' ? 'selected' : '' }}>Malargue</option>
			<option value="otra provincia" id="otra-p" {{ old('residencia') == 'otra provincia' ? 'selected' : '' }}>
				Otra provincia
			</option>
		</select>
		<div class="form-group" id="residencia-o" style="display:none;">
			<br>
			<label for="residencia">Indica la provincia:</label>
			<input type="text" class="form-control" id="residencia-ot">
		</div>
		@error('residencia')
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
	<div class="form-group">
		<label for="condicion_s">Situación de Escolaridad:</label>
		<select class="form-select" name="condicion_s" id="condicion_s">
			<option value="primario completo" {{ old('condicion_s') == 'primario completo' ? 'selected' : '' }}>Primario Completo</option>
			<option value="secundario completo" {{ old('condicion_s') == 'secundario completo' ? 'selected' : '' }}>Secundario Completo</option>
			<option value="secundario incompleto" {{ old('condicion_s') == 'secundario incompleto' ? 'selected' : '' }}>Secundario Incompleto</option>
			<option value="cursando actualmente secundario" {{ old('condicion_s') == 'cursando actualmente secundario' ? 'selected' : '' }}>Cursando actualmente el nivel secundario</option>
		</select>
		@error('condicion_s')
		<span class="invalid-feedback d-block" role="alert">
			<strong>{{ $message }}</strong>
		</span>
		@enderror
	</div>
	<div class="form-group">
		<label for="escolaridad">Título Secundario:</label>
		<div class="form-check">
			<input class="form-check-input" type="radio" value="si" name="escolaridad" id="escolaridad1" {{ old('escolaridad') == 'si' ? 'checked' : '' }} />
			<label class="form-check-label" for="escolaridad1">
				Si
			</label>
		</div>
		<div class="form-check">
			<input class="form-check-input" type="radio" value="no" name="escolaridad" id="escolaridad2" {{ old('escolaridad') == 'no' ? 'checked' : '' }}>
			<label class="form-check-label" for="escolaridad2">
				No
			</label>
		</div>
		@error('escolaridad')
		<span class="invalid-feedback d-block" role="alert">
			<strong>{{ $message }}</strong>
		</span>
		@enderror
	</div>
	<div class="form-group">
		<label for="escuela_s">Nombre de escuela donde egresó: (Número y Nombre):</label>
		<input type="text" id="escuela_s" name="escuela_s" class="form-control @error('escuela_s') is-invalid @enderror" value="{{ old('escuela_s') }}" required />

		@error('escuela_s')
		<span class="invalid-feedback d-block" role="alert">
			<strong>{{ $message }}</strong>
		</span>
		@enderror
	</div>
	<div class="form-group">
		<label for="materias_s">Adeuda materias:</label>
		<div class="form-check">
			<input class="form-check-input" type="radio" value="si" name="materias_s" id="materia_s1" {{ old('materias_s') == 'si' ? 'checked' : '' }} />
			<label class="form-check-label" for="materia_s1">
				Si
			</label>
		</div>
		<div class="form-check">
			<input class="form-check-input" type="radio" value="no" name="materias_s" id="materia_s2" {{ old('materias_s') == 'no' ? 'checked' : '' }}>
			<label class="form-check-label" for="materia_s2">
				No
			</label>
		</div>
		@error('materias_s')
		<span class="invalid-feedback d-block" role="alert">
			<strong>{{ $message }}</strong>
		</span>
		@enderror
	</div>
	<div class="form-group">
		<label for="cantidad_materias_s">Cuantas adeuda?:</label>
		<input type="number" id="cantidad_materias_s" name="cantidad_materias_s" class="form-control @error('cantidad_materias_s') is-invalid @enderror" value="{{ old('cantidad_materias_s') }}" disabled/>

		@error('cantidad_materias_s')
		<span class="invalid-feedback d-block" role="alert">
			<strong>{{ $message }}</strong>
		</span>
		@enderror
	</div>
	<div class="form-group">
		<label>Conexión a internet: </label>
		<div class="form-check">
			<input class="form-check-input" type="radio" value="si" name="conexion" id="conexion1" {{ old('conexion') == 'si' ? 'checked' : '' }} />
			<label class="form-check-label" for="conexion1">
				Si
			</label>
		</div>
		<div class="form-check">
			<input class="form-check-input" type="radio" value="no" name="conexion" id="conexion2" {{ old('conexion') == 'no' ? 'checked' : '' }}>
			<label class="form-check-label" for="conexion2">
				No
			</label>
		</div>
		@error('conexion')
		<span class="invalid-feedback d-block" role="alert">
			<strong>{{ $message }}</strong>
		</span>
		@enderror
	</div>
	<div class="form-group">
		<label>Trabajas actualmente: </label>
		<div class="form-check">
			<input class="form-check-input" type="radio" value="si" name="trabajo" id="trabajo1" {{ old('trabajo') == 'si' ? 'checked' : '' }} />
			<label class="form-check-label" for="trabajo1">
				Si
			</label>
		</div>
		<div class="form-check">
			<input class="form-check-input" type="radio" value="no" name="trabajo" id="trabajo2" {{ old('trabajo') == 'no' ? 'checked' : '' }}>
			<label class="form-check-label" for="trabajo2">
				No
			</label>
		</div>
		@error('trabajo')
		<span class="invalid-feedback d-block" role="alert">
			<strong>{{ $message }}</strong>
		</span>
		@enderror
	</div>

	<div class="form-group">
		<label>Alguna tuviste un trabajo relacionado a la carrera? </label>
		<div class="form-check">
			<input class="form-check-input" type="radio" value="si" name="trabajo_relacionado" id="trabajo_relacionado1" {{ old('trabajo_relacionado') == 'si' ? 'checked' : '' }} />
			<label class="form-check-label" for="trabajo_relacionado1">
				Si
			</label>
		</div>
		<div class="form-check">
			<input class="form-check-input" type="radio" value="no" name="trabajo_relacionado" id="trabajo_relacionado2" {{ old('trabajo_relacionado') == 'no' ? 'checked' : '' }}>
			<label class="form-check-label" for="trabajo_relacionado2">
				No
			</label>
		</div>
		@error('trabajo')
		<span class="invalid-feedback d-block" role="alert">
			<strong>{{ $message }}</strong>
		</span>
		@enderror
	</div>

	<br>
	<h4 class="text-secondary">Documentación a adjuntar</h4>
	<div class="alert alert-warning">
		Los siguientes campos solo admiten un archivo, en caso de tener que unir dos fotos se recomienda unirlas en un pdf utilizando la herramienta <a href="https://www.ilovepdf.com/" target="_blank">iLovePDF</a>.
	</div>
	<div class="alert alert-warning">
		El tamaño de los archivos no puede superar los 5MB.
	</div>
	<hr>

	<div class="form-group">
		<label for="dni_archivo_file">
			DNI Frente: (Debe ser legible y claro los datos que figura en el documento digital que adjunte):
		</label>
		<input type="file" id="dni_archivo_file" name="dni_archivo_file" class=" @error('dni_archivo_file') is-invalid @enderror" value="{{ old('dni_archivo_file') }}">

		@error('dni_archivo_file')
		<span class="invalid-feedback d-block" role="alert">
			<strong>{{ $message }}</strong>
		</span>
		@enderror
	</div>
	<div class="form-group">
		<label for="dni_archivo_2_file">
			DNI Dorso: (Debe ser legible y claro los datos que figura en el documento digital que adjunte):
		</label>
		<input type="file" id="dni_archivo_2_file" name="dni_archivo_2_file" class="@error('dni_archivo_2_file') is-invalid @enderror" value="{{ old('dni_archivo_2_file') }}">

		@error('dni_archivo_2_file')
		<span class="invalid-feedback d-block" role="alert">
			<strong>{{ $message }}</strong>
		</span>
		@enderror
	</div>
	<div class="form-group">
		<label for="comprobante_file">
			Comprobante de pago:
		</label>
		<input type="file" id="comprobante_file" name="comprobante_file" class=" @error('comprobante_file') is-invalid @enderror" value="{{ old('comprobante_file') }}">

		@error('comprobante_file')
		<span class="invalid-feedback d-block" role="alert">
			<strong>{{ $message }}</strong>
		</span>
		@enderror
	</div>
	<br>
	<h4 class="text-secondary">Trayecto de nivel medio</h4>
	<hr>
	<div class="form-group">
		<label for="certificado_archivo_file">
			Certificación de Nivel Secundario Frente (Si aún no has finalizado el Nivel Medio debes adjuntar constancia. Recuerda que debe ser legible y claro los datos que figura en el documento digital que adjuntes)
		</label>
		<input type="file" id="certificado_archivo_file" name="certificado_archivo_file" class=" @error('certificado_archivo_file') is-invalid @enderror" value="{{ old('certificado_archivo_file') }}">

		@error('certificado_archivo_file')
		<span class="invalid-feedback d-block" role="alert">
			<strong>{{ $message }}</strong>
		</span>
		@enderror
	</div>
	<div class="form-group">
		<label for="certificado_archivo_2_file">
			Certificación de Nivel Secundario Dorso
		</label>
		<input type="file" id="certificado_archivo_2_file" name="certificado_archivo_2_file" class=" @error('certificado_archivo_2_file') is-invalid @enderror" value="{{ old('certificado_archivo_2_file') }}">

		@error('certificado_archivo_2_file')
		<span class="invalid-feedback d-block" role="alert">
			<strong>{{ $message }}</strong>
		</span>
		@enderror
	</div>
	<div id="7mo" class="d-none">
		<br>
		<h4 class="text-secondary">Artículo 7mo</h4>
		<div class="alert alert-warning">
			Estás realizando tu preinscripción por Artículo 7, cuyos requisitos son:
			ser mayor de 25 años, tener secundario incompleto, certificar que trabajás o has
			trabajado en un empleo relacionado con la carrera elegida.
		</div>
		<div class="form-check">
			<input class="form-check-input" type="checkbox" name="articulo_septimo" id="articulo_septimo" value="1" {{ old('articulo_septimo') == 1 ? 'checked' : '' }}>
			<label class="form-check-label" for="articulo_septimo">
				Confirmo mi preinscripción por Artículo 7
			</label>
		</div>
		<hr>
		<div class="d-none" id="archivos_articulo_septimo">
			<div class="form-group">
				<label for="primario_file">
					Título de Nivel Primario:
				</label>
				<input type="file" id="primario_file" name="primario_file" class="@error('primario_file') is-invalid @enderror" value="{{ old('primario_file') }}">

				@error('primario_file')
				<span class="invalid-feedback d-block" role="alert">
					<strong>{{ $message }}</strong>
				</span>
				@enderror
			</div>
			<div class="form-group">
				<label for="ctrabajo_file">
					Certificado de Trabajo con firma y sello de quien lo emite
				</label>
				<input type="file" id="ctrabajo_file" name="ctrabajo_file" class="@error('ctrabajo_file') is-invalid @enderror" value="{{ old('ctrabajo_file') }}">

				@error('ctrabajo_file')
				<span class="invalid-feedback d-block" role="alert">
					<strong>{{ $message }}</strong>
				</span>
				@enderror
			</div>
			<div class="form-group">
				<label for="curriculum_file">
					Currículum Vitae (en formato PDF)
				</label>
				<input type="file" id="curriculum_file" name="curriculum_file" class="@error('curriculum_file') is-invalid @enderror" value="{{ old('curriculum_file') }}">

				@error('curriculum_file')
				<span class="invalid-feedback d-block" role="alert">
					<strong>{{ $message }}</strong>
				</span>
				@enderror
			</div>
			<div class="form-group">
				<label for="nota_file">
					Nota al Rector (en PDF)
				</label>
				<input type="file" id="nota_file" name="nota_file" class="@error('nota_file') is-invalid @enderror" value="{{ old('nota_file') }}">

				@error('nota_file')
				<span class="invalid-feedback d-block" role="alert">
					<strong>{{ $message }}</strong>
				</span>
				@enderror
			</div>
		</div>
	</div>

	<div class="form-group">
		<button type="submit" class="btn btn-success">Inscribirse</button>
	</div>
</form>