<form method="POST" action="{{ route('crear_preins',['carrera_id'=>$carrera->id]) }}" enctype="multipart/form-data">
	@csrf
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
		<label for="dni">D.N.I (Sin puntos):</label>
		<input type="number" id="dni" name="dni" class="form-control @error('dni') is-invalid @enderror" value="{{ old('dni') }}" required>

		@error('dni')
			<span class="invalid-feedback" role="alert">
			    <strong>{{ $message }}</strong>
			</span>
		@enderror
	</div>
	<div class="form-group">
		<label for="cuil">N° de CUIL (Sin guiones ni puntos):</label>
		<input type="number" id="cuil" name="cuil" class="form-control @error('cuil') is-invalid @enderror" value="{{ old('cuil') }}" required>

		@error('cuil')
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
		<label for="edad">Edad:</label>
		<input type="number" id="edad" name="edad" class="form-control @error('edad') is-invalid @enderror" value="{{ old('edad') }}" required>

		@error('edad')
			<span class="invalid-feedback" role="alert">
			    <strong>{{ $message }}</strong>
			</span>
		@enderror
	</div>
	<div class="form-group">
		<label for="email">Email:</label>
		<input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" oncopy="return false" email required>

		@error('email')
			<span class="invalid-feedback" role="alert">
			    <strong>{{ $message }}</strong>
			</span>
		@enderror
	</div>
	<div class="form-group">
        <label for="email-confirm">{{ __('Confirmar Email') }}:</label>

        <div>
            <input id="email-confirm" type="email" class="form-control" name="email_confirmation" required autocomplete="new-email" onpaste="return false" value="{{ old('email_confirmation') }}">
        </div>
    </div>
	<div class="form-group">
		<label for="nacionalidad">Nacionalidad:</label>
		<select class="form-control" name="nacionalidad" id="nacionalidad">
			<option value="argentina" selected="selected">Argentina</option>
			<option value="uruguaya">Uruguaya</option>
			<option value="chilena">Chilena</option>
			<option value="paraguaya">Paraguaya</option>
			<option value="brasilera">Brasilera</option>
			<option value="boliviana">Boliviana</option>
			<option value="colombiana">Colombiana</option>
			<option value="peruana">Peruana</option>
			<option value="venezolana">Venezolana</option>
			<option value="otra">Otra</option>
		</select>
		@error('nacionalidad')
			<span class="invalid-feedback" role="alert">
			    <strong>{{ $message }}</strong>
			</span>
		@enderror
	</div>
	<div class="form-group">
		<label for="domicilio">Domicilio:</label>
		<input type="text" id="domicilio" name="domicilio" class="form-control @error('domicilio') is-invalid @enderror" value="{{ old('domicilio') }}" required>

		@error('domicilio')
			<span class="invalid-feedback" role="alert">
			    <strong>{{ $message }}</strong>
			</span>
		@enderror
	</div>
	<div class="form-group">
		<label for="residencia">Residencia:</label>
		<select class="form-control" name="residencia" id="residencia">
			<option value="capital" selected="selected">Capital</option>
			<option value="las heras">Las Heras</option>
			<option value="godoy cruz">Godoy Cruz</option>
			<option value="guaymallén">Guaymallén</option>
			<option value="lavalle">Lavalle</option>
			<option value="maipú">Maipú</option>
			<option value="san martín">San Martín</option>
			<option value="junín">Junín</option>
			<option value="rivadavia">Rivadavia</option>
			<option value="santa rosa">Santa Rosa</option>
			<option value="la paz">La Paz</option>
			<option value="luján">Luján</option>
			<option value="tupungato">Tupungato</option>
			<option value="tunuyán">Tunuyán</option>
			<option value="san carlos">San Carlos</option>
			<option value="san rafael">San Rafael</option>
			<option value="gral. alvear">Gral. Alvear</option>
			<option value="malargue">Malargue</option>
			<option value="otra provincia" id="otra-p">
				Otra provincia
			</option>
		</select>
		<div class="form-group" id="residencia-o" style="display:none;">
			<br>
			<label for="residencia">Indica la provincia:</label>
			<input type="text" class="form-control" id="residencia-ot">
		</div>
		@error('residencia')
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
		<label for="condicion_s">Situación de Escolaridad:</label>
		<select class="form-control" name="condicion_s" id="condicion_s" >
			<option value="primario completo">Primario Completo</option>
			<option value="secundario completo">Secundario Completo</option>
			<option value="secundario incompleto">Secundario Incompleto</option>
			<option value="cursando actualmente secundario">Cursando actualmente el nivel secundario</option>
		</select>
		@error('condicion_s')
			<span class="invalid-feedback" role="alert">
			    <strong>{{ $message }}</strong>
			</span>
		@enderror
		<span class="text-danger">
			*IMPORTANTE: Si tienes secundario incompleto y eres mayor de 25 años, clickea sobre 
			la siguiente casilla para inscribirte por articulo 7mo.
		</span>
		<div class="form-check">
		  <input class="form-check-input" type="checkbox" value="" id="articulo7mo">
		  <label class="form-check-label" for="articulo7mo">
		    Inscripción Articulo 7mo
		  </label>
		</div>
	</div>
	<div class="form-group">
		<label for="escolaridad">Título Secundario:</label>
		<div class="form-check">
	  		<input class="form-check-input" type="radio" value="si" name="escolaridad" id="escolaridad1" required>
	  		<label class="form-check-label" for="escolaridad1">
	    		Si
	  		</label>
		</div>
		<div class="form-check">
		    <input class="form-check-input" type="radio" value="no" name="escolaridad" id="escolaridad2">
		    <label class="form-check-label" for="escolaridad2">
		    	No
		    </label>
		</div>
		@error('escolaridad')
			<span class="invalid-feedback" role="alert">
			    <strong>{{ $message }}</strong>
			</span>
		@enderror
	</div>
	<div class="form-group">
		<label for="escuela_s">Nombre de escuela donde egresó: (Número y Nombre):</label>
		<input type="text" id="escuela_s" name="escuela_s" class="form-control @error('escuela_s') is-invalid @enderror" value="{{ old('escuela_s') }}" required>

		@error('escuela_s')
			<span class="invalid-feedback" role="alert">
			    <strong>{{ $message }}</strong>
			</span>
		@enderror
	</div>
	<div class="form-group">
		<label for="materia_s">Adeuda materias:</label>
		<div class="form-check">
	  		<input class="form-check-input" type="radio" value="si" name="materia_s" id="materia_s1" required>
	  		<label class="form-check-label" for="materia_s1">
	    		Si
	  		</label>
		</div>
		<div class="form-check">
		    <input class="form-check-input" type="radio" value="no" name="materia_s" id="materia_s2" >
		    <label class="form-check-label" for="materia_s2">
		    	No
		    </label>
		</div>
		@error('materia_s')
			<span class="invalid-feedback" role="alert">
			    <strong>{{ $message }}</strong>
			</span>
		@enderror
	</div>
	<div class="form-group">
		<label>Conexión a internet: </label>
		<div class="form-check">
	  		<input class="form-check-input" type="radio" value="si" name="conexion" id="conexion1" required>
	  		<label class="form-check-label" for="conexion1">
	    		Si
	  		</label>
		</div>
		<div class="form-check">
		    <input class="form-check-input" type="radio" value="no" name="conexion" id="conexion2">
		    <label class="form-check-label" for="conexion2">
		    	No
		    </label>
		</div>
		@error('conexion')
			<span class="invalid-feedback" role="alert">
			    <strong>{{ $message }}</strong>
			</span>
		@enderror
	</div>
	<div class="form-group">
		<label>Trabajas actualmente: </label>
		<div class="form-check">
	  		<input class="form-check-input" type="radio" value="si" name="trabajo" id="trabajo1" required>
	  		<label class="form-check-label" for="trabajo1">
	    		Si
	  		</label>
		</div>
		<div class="form-check">
		    <input class="form-check-input" type="radio" value="no" name="trabajo" id="trabajo2">
		    <label class="form-check-label" for="trabajo2">
		    	No
		    </label>
		</div>
		@error('trabajo')
			<span class="invalid-feedback" role="alert">
			    <strong>{{ $message }}</strong>
			</span>
		@enderror
	</div>
	<br>
	<h4>Documentación a adjuntar</h4>
	<div class="alert alert-warning">
	    Los siguientes campos solo admiten un archivo, en caso de tener que unir dos fotos se recomienda unirlas en un pdf utilizando la herramienta <a href="https://www.ilovepdf.com/" target="_blank">iLovePDF</a>.
	</div>
	<hr>

	<div class="form-group">
		<label for="dni_archivo">
			DNI Frente: (Debe ser legible y claro los datos que figura en el documento digital que adjunte):
		</label>
		<input type="file" id="dni_archivo" name="dni_archivo" class=" @error('dni_archivo') is-invalid @enderror" value="{{ old('dni_archivo') }}" >

		@error('dni_archivo')
			<span class="invalid-feedback" role="alert">
			    <strong>{{ $message }}</strong>
			</span>
		@enderror
	</div>
	<div class="form-group">
		<label for="dni_archivo_2">
			DNI Dorso: (Debe ser legible y claro los datos que figura en el documento digital que adjunte):
		</label>
		<input type="file" id="dni_archivo_2" name="dni_archivo_2" class=" @error('dni_archivo_2') is-invalid @enderror" value="{{ old('dni_archivo_2') }}" >

		@error('dni_archivo_2')
			<span class="invalid-feedback" role="alert">
			    <strong>{{ $message }}</strong>
			</span>
		@enderror
	</div>
	<div class="form-group">
		<label for="comprobante">
			Comprobante de pago:
		</label>
		<input type="file" id="comprobante" name="comprobante" class=" @error('comprobante') is-invalid @enderror" value="{{ old('comprobante') }}" >

		@error('comprobante')
			<span class="invalid-feedback" role="alert">
			    <strong>{{ $message }}</strong>
			</span>
		@enderror
	</div>
	<br>
	<h4>Trayecto de nivel medio</h4>
	<hr>
	<div class="form-group">
		<label for="certificado_archivo">
			Certificación de Nivel Secundario Frente (Si aún no has finalizado el Nivel Medio debes adjuntar constancia. Recuerda que debe ser legible y claro los datos que figura en el documento digital que adjuntes)
		</label>
		<input type="file" id="certificado_archivo" name="certificado_archivo" class=" @error('certificado_archivo') is-invalid @enderror" value="{{ old('certificado_archivo') }}" >

		@error('certificado_archivo')
			<span class="invalid-feedback" role="alert">
			    <strong>{{ $message }}</strong>
			</span>
		@enderror
	</div>
	<div class="form-group">
		<label for="certificado_archivo_2">
			Certificación de Nivel Secundario Dorso 
		</label>
		<input type="file" id="certificado_archivo_2" name="certificado_archivo_2" class=" @error('certificado_archivo_2') is-invalid @enderror" value="{{ old('certificado_archivo_2') }}" >

		@error('certificado_archivo_2')
			<span class="invalid-feedback" role="alert">
			    <strong>{{ $message }}</strong>
			</span>
		@enderror
	</div>
	<div id="7mo" style="display: none;">
		<br>
		<h4>Artículo 7mo</h4>
		<hr>
		<div class="form-group">
			<label for="primario">
				Título de Nivel Primario (Adjunta aquí el título  o certificación de finalización del mismo. Recuerda que debe ser legible y claro los datos que figura en el documento digital que adjuntes) 
			</label>
			<input type="file" id="primario" name="primario" class="@error('primario') is-invalid @enderror" value="{{ old('primario') }}" >

			@error('primario')
				<span class="invalid-feedback" role="alert">
				    <strong>{{ $message }}</strong>
				</span>
			@enderror
		</div>
		<div class="form-group">
			<label for="ctrabajo">
				Certificado de Trabajo con firma y sello de quien lo emite  (Debe ser legible y claro los datos que figuran en el documento digital que adjunte. Se puede adjuntar una foto, un escaneo color)  
			</label>
			<input type="file" id="ctrabajo" name="ctrabajo" class="@error('ctrabajo') is-invalid @enderror" value="{{ old('ctrabajo') }}" >

			@error('ctrabajo')
				<span class="invalid-feedback" role="alert">
				    <strong>{{ $message }}</strong>
				</span>
			@enderror
		</div>
		<div class="form-group">
			<label for="curriculum">
				Currículum  Vitae (en formato  PDF)  
			</label>
			<input type="file" id="curriculum" name="curriculum" class="@error('curriculum') is-invalid @enderror" value="{{ old('curriculum') }}" >

			@error('curriculum')
				<span class="invalid-feedback" role="alert">
				    <strong>{{ $message }}</strong>
				</span>
			@enderror
		</div>
		<div class="form-group">
			<label for="nota">
				Nota al Rector (en  PDF)   
			</label>
			<input type="file" id="nota" name="nota" class="@error('nota') is-invalid @enderror" value="{{ old('nota') }}" >

			@error('nota')
				<span class="invalid-feedback" role="alert">
				    <strong>{{ $message }}</strong>
				</span>
			@enderror
		</div>
	</div>
	<div class="form-group">
		<input type="submit" value="Inscribirse" class="btn btn-success" id="loading">
	</div>

</form>