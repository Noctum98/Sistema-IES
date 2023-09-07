@extends('layouts.app-prueba')
@section('content')
<div class="container p-3">
	<div class="col-md-12 d-flex flex-column align-items-center">
		<div class="col-md-7">
			<h2 class="h1 text-info">
				Preinscripción en {{ $preinscripcion->carrera->nombre }}
				<small>{{$preinscripcion->carrera->turno}}</small>.
			</h2>
			<hr>
			<p>
				<a href="{{route('pre.eliminar',['timecheck'=>$preinscripcion->timecheck,'id'=>$preinscripcion->id])}}" class="text-danger font-weight-bold">Eliminar mi preinscripción</a>
			</p>
			<div class="col-md-10">
				<form method="POST" action="{{route('editar_preins',['id'=>$preinscripcion->id])}}" enctype="multipart/form-data">
					@csrf
					<div class="form-group">
						<label for="nombres">Nombres (como figura en el documento):</label>
						<input type="text" id="nombres" name="nombres" class="form-control @error('nombres') is-invalid @enderror" value="{{$preinscripcion->nombres}}" required />

						@error('nombres')
						<span class="invalid-feedback d-block" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>
					<div class="form-group">
						<label for="apellidos">Apellidos (como figura en el documento):</label>
						<input type="text" id="apellidos" name="apellidos" class="form-control @error('apellidos') is-invalid @enderror" value="{{$preinscripcion->apellidos}}" required />

						@error('apellidos')
						<span class="invalid-feedback d-block" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>
					<div class="form-group">
						<label for="nacionalidad">Nacionalidad:</label>
						<select class="form-control" name="nacionalidad" id="nacionalidad">
							<option value="argentina" {{$preinscripcion->nacionalidad == 'argentina' ? 'selected="selected"' : ''}}>
								Argentina
							</option>
							<option value="uruguaya" {{$preinscripcion->nacionalidad == 'uruguaya' ? 'selected="selected"' : ''}}>
								Uruguaya
							</option>
							<option value="chilena" {{$preinscripcion->nacionalidad == 'chilena' ? 'selected="selected"' : ''}}>
								Chilena
							</option>
							<option value="paraguaya" {{$preinscripcion->nacionalidad == 'paraguaya' ? 'selected="selected"' : ''}}>
								Paraguaya
							</option>
							<option value="brasilera" {{$preinscripcion->nacionalidad == 'brasilera' ? 'selected="selected"' : ''}}>
								Brasilera
							</option>
							<option value="boliviana" {{$preinscripcion->nacionalidad == 'boliviana' ? 'selected="selected"' : ''}}>
								Boliviana
							</option>
							<option value="colombiana" {{$preinscripcion->nacionalidad == 'colombiana' ? 'selected="selected"' : ''}}>
								Colombiana
							</option>
							<option value="peruana" {{$preinscripcion->nacionalidad == 'peruana' ? 'selected="selected"' : ''}}>
								Peruana
							</option>
							<option value="venezolana" {{$preinscripcion->nacionalidad == 'venezolana' ? 'selected="selected"' : ''}}>
								Venezolana
							</option>
							<option value="otra" {{$preinscripcion->nacionalidad == 'otra' ? 'selected="selected"' : ''}}>
								Otra
							</option>
						</select>
					</div>
					<div class="form-group">
					<label for="dni">D.N.I (Sin puntos<span id="label_dni"></span>):</label>
						<input type="number" id="dni" name="dni" class="form-control @error('dni') is-invalid @enderror" value="{{$preinscripcion->dni}}" required />

						@error('dni')
						<span class="invalid-feedback d-block" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>
					<div class="form-group">
						<label for="cuil">N° de CUIL (Sin guiones ni puntos):</label>
						<input type="number" id="cuil" name="cuil" class="form-control @error('cuil') is-invalid @enderror" value="{{ $preinscripcion->cuil }}" required />

						@error('cuil')
						<span class="invalid-feedback d-block" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>
					<div class="form-group">
						<div class="form-group">
							<label for="fecha">Fecha de Nacimiento:</label>
							<input type="date" id="fecha" name="fecha" class="form-control @error('fecha') is-invalid @enderror" value="{{ $preinscripcion->fecha }}" required />

							@error('fecha')
							<span class="invalid-feedback d-block" role="alert">
								<strong>{{ $message }}</strong>
							</span>
							@enderror
						</div>
						<label for="edad">Edad:</label>
						<input type="number" id="edad" name="edad" class="form-control @error('edad') is-invalid @enderror" value="{{$preinscripcion->edad}}" required />

						@error('edad')
						<span class="invalid-feedback d-block" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>
					<div class="form-group">
						<label for="email">Email:</label>
						<input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{$preinscripcion->email}}" email required readonly />

						@error('email')
						<span class="invalid-feedback d-block" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>
					
					<div class="form-group">
						<label for="domicilio">Domicilio:</label>
						<input type="text" id="domicilio" name="domicilio" class="form-control @error('domicilio') is-invalid @enderror" value="{{$preinscripcion->domicilio}}" required />

						@error('domicilio')
						<span class="invalid-feedback d-block" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>
					<div class="form-group">
						<label for="residencia">Residencia:</label>
						<select class="form-control" name="residencia" id="residencia">
							<option value="capital" {{$preinscripcion->residencia == 'capital' ? 'selected="selected"' : ''}}>
								Capital
							</option>
							<option value="las heras" {{$preinscripcion->residencia == 'las heras' ? 'selected="selected"' : ''}}>
								Las Heras
							</option>
							<option value="godoy cruz" {{$preinscripcion->residencia == 'godoy cruz' ? 'selected="selected"' : ''}}>
								Godoy Cruz
							</option>
							<option value="guaymallén" {{$preinscripcion->residencia == 'guaymallén' ? 'selected="selected"' : ''}}>
								Guaymallén
							</option>
							<option value="lavalle" {{$preinscripcion->residencia == 'lavalle' ? 'selected="selected"' : ''}}>
								Lavalle
							</option>
							<option value="maipú" {{$preinscripcion->residencia == 'maipú' ? 'selected="selected"' : ''}}>
								Maipú
							</option>
							<option value="san martín" {{$preinscripcion->residencia == 'san martín' ? 'selected="selected"' : ''}}>
								San Martín
							</option>
							<option value="junín" {{$preinscripcion->residencia == 'junín' ? 'selected="selected"' : ''}}>
								Junín
							</option>
							<option value="rivadavia" {{$preinscripcion->residencia == 'rivadavia' ? 'selected="selected"' : ''}}>
								Rivadavia
							</option>
							<option value="santa rosa" {{$preinscripcion->residencia == 'santa rosa' ? 'selected="selected"' : ''}}>
								Santa Rosa
							</option>
							<option value="la paz" {{$preinscripcion->residencia == 'la paz' ? 'selected="selected"' : ''}}>
								La Paz
							</option>
							<option value="luján" {{$preinscripcion->residencia == 'luján' ? 'selected="selected"' : ''}}>
								Luján
							</option>
							<option value="tupungato" {{$preinscripcion->residencia == 'tupungato' ? 'selected="selected"' : ''}}>
								Tupungato
							</option>
							<option value="tunuyán" {{$preinscripcion->residencia == 'tunuyán' ? 'selected="selected"' : ''}}>
								Tunuyán
							</option>
							<option value="san carlos" {{$preinscripcion->residencia == 'san carlos' ? 'selected="selected"' : ''}}>
								San Carlos
							</option>
							<option value="san rafael" {{$preinscripcion->residencia == 'san rafael' ? 'selected="selected"' : ''}}>
								San Rafael
							</option>
							<option value="gral. alvear" {{$preinscripcion->residencia == 'gral. alvear' ? 'selected="selected"' : ''}}>
								Gral. Alvear
							</option>
							<option value="malargue" {{$preinscripcion->residencia == 'malargue' ? 'selected="selected"' : ''}}>
								Malargüe
							</option>
							<option value="otra provincia">Otra provincia</option>
						</select>
						<div class="form-group" id="residencia-o" style="display:none;">
							<br>
							<label for="residencia-ot">Indica la provincia:</label>
							<input type="text" id="residencia-ot" name="residencia" class="form-control" value="{{$preinscripcion->residencia}}">
						</div>
					</div>
					<div class="form-group">
						<label for="telefono">Teléfono:</label>
						<input type="number" id="telefono" name="telefono" class="form-control @error('telefono') is-invalid @enderror" value="{{$preinscripcion->telefono}}" required />

						@error('telefono')
						<span class="invalid-feedback d-block" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>
					<div class="form-group">
						<label for="condicion_s">Situación de Escolaridad:</label>
						<select class="form-control" name="condicion_s" id="condicion_s">
							<option value="primario completo" {{$preinscripcion->condicion_s == 'primario completo' ? 'selected="selected"' : ''}}>
								Primario Completo
							</option>
							<option value="secundario completo" {{$preinscripcion->condicion_s == 'secundario completo' ? 'selected="selected"' : ''}}>
								Secundario Completo
							</option>
							<option value="secundario incompleto" {{$preinscripcion->condicion_s == 'secundario incompleto' ? 'selected="selected"' : ''}}>
								Secundario Incompleto
							</option>
							<option value="cursando actualmente secundario" {{$preinscripcion->condicion_s == 'cursando actualmente secundario' ? 'selected="selected"' : ''}}>
								Cursando actualmente el nivel secundario
							</option>
						</select>
					</div>
					<div class="form-group">
						<label for="escolaridad">Título Secundario:</label>
						<div class="form-check">
							<input class="form-check-input" type="radio" value="si" name="escolaridad" id="escolaridad1" {{$preinscripcion->escolaridad == 'si' ? 'checked' : ''}}>
							<label class="form-check-label" for="escolaridad1">
								Si
							</label>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="radio" value="no" name="escolaridad" id="escolaridad2" {{$preinscripcion->escolaridad == 'no' ? 'checked' : ''}}>
							<label class="form-check-label" for="escolaridad2">
								No
							</label>
						</div>
					</div>
					<div class="form-group">
						<label for="escuela_s">Nombre de escuela donde egresó: (Número y Nombre):</label>
						<input type="text" id="escuela_s" name="escuela_s" class="form-control @error('escuela_s') is-invalid @enderror" value="{{ $preinscripcion->escuela_s }}" required />

						@error('escuela_s')
						<span class="invalid-feedback d-block" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>
					<div class="form-group">
						<label for="materia_s">Adeuda materias:</label>
						<div class="form-check">
							<input class="form-check-input" type="radio" value="si" name="materia_s" id="materia_s1" {{$preinscripcion->materias_s == 'si' ? 'checked' : ''}}>
							<label class="form-check-label" for="materia_s1">
								Si
							</label>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="radio" value="no" name="materia_s" id="materia_s2" {{$preinscripcion->materias_s == 'no' ? 'checked' : ''}}>
							<label class="form-check-label" for="materia_s2">
								No
							</label>
						</div>
					</div>
					<div class="form-group">
						<label>Conexión a internet: </label>
						<div class="form-check">
							<input class="form-check-input" type="radio" value="si" name="conexion" id="conexion1" {{$preinscripcion->conexion == 'si' ? 'checked' : ''}}>
							<label class="form-check-label" for="conexion1">
								Si
							</label>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="radio" value="no" name="conexion" id="conexion2" {{$preinscripcion->conexion == 'no' ? 'checked' : ''}}>
							<label class="form-check-label" for="conexion2">
								No
							</label>
						</div>
					</div>
					<div class="form-group">
						<label>Trabajas actualmente: </label>
						<div class="form-check">
							<input class="form-check-input" type="radio" value="si" name="trabajo" id="trabajo1" {{$preinscripcion->trabajo == 'si' ? 'checked' : ''}}>
							<label class="form-check-label" for="trabajo1">
								Si
							</label>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="radio" value="no" name="trabajo" id="trabajo2" {{$preinscripcion->trabajo == 'no' ? 'checked' : ''}}>
							<label class="form-check-label" for="trabajo2">
								No
							</label>
						</div>
					</div>
					<div class="form-group">
						<label>Alguna vez tuviste un trabajo relacionado a la carrera? </label>
						<div class="form-check">
							<input class="form-check-input" type="radio" value="si" name="trabajo_relacionado" id="trabajo_relacionado1" {{ old('trabajo_relacionado') == 'si' ? 'checked' : '' }} />
							<label class="form-check-label" for="trabajo_relacionado1">
								Si
							</label>
						</div>
                        <div class="form-group">
						<label>Alguna vez tuviste un trabajo relacionado a la carrera? </label>
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
						<hr>
						<div class="form-group">
							<label for="dni_archivo_file">
								DNI:
								@if($preinscripcion->dni_archivo)
									<b>(Ya hay un archivo subido, si sube otro, el anterior se eliminará)</b>
								@endif
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
					<hr>
					<div class="form-group">
						<label for="dni_archivo_file">
							DNI:
							@if($preinscripcion->dni_archivo)
							<b>(Ya hay un archivo subido, si sube otro, el anterior se eliminará)</b>
							@endif
						</label>
						<br>
						<input type="file" id="dni_archivo_file" name="dni_archivo_file" class=" @error('dni_archivo_file') is-invalid @enderror" value="{{ old('dni_archivo_file') }}">

						@error('dni_archivo_file')
						<span class="invalid-feedback d-block" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>
					<div class="form-group">
						<label for="dni_archivo_2_file">
							DNI Dorso:
							@if($preinscripcion->dni_archivo_2)
							<b>(Ya hay un archivo subido, si sube otro, el anterior se eliminará)</b>
							@endif
						</label>
						<br>
						<input type="file" id="dni_archivo_2_file" name="dni_archivo_2_file" class=" @error('dni_archivo_2_file') is-invalid @enderror" value="{{ old('dni_archivo_2_file') }}">

						@error('dni_archivo_2_file')
						<span class="invalid-feedback d-block" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>
					<div class="form-group">
						<label for="comprobante_file">
							Comprobante de pago:
							@if($preinscripcion->comprobante)
							<b>(Ya hay un archivo subido, si sube otro, el anterior se eliminará)</b>
							@endif
						</label>
						<br>
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
							Certificación de Nivel Secundario:
							@if($preinscripcion->certificado_archivo)
							<b>(Ya hay un archivo subido, si sube otro, el anterior se eliminará)</b>
							@endif
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
							Certificación de Nivel Secundario Dorso:
							@if($preinscripcion->certificado_archivo_2)
							<b>(Ya hay un archivo subido, si sube otro, el anterior se eliminará)</b>
							@endif
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
						<hr>
						<div class="form-group">
							<label for="primario_file">
								Título de Nivel Primario:
								@if($preinscripcion->primario)
								<b>(Ya hay un archivo subido, si sube otro, el anterior se eliminará)</b>
								@endif
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
								@if($preinscripcion->ctrabajo)
								<b>(Ya hay un archivo subido, si sube otro, el anterior se eliminará)</b>
								@endif
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
								@if($preinscripcion->curriculum)
								<b>(Ya hay un archivo subido, si sube otro, el anterior se eliminará)</b>
								@endif
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
								Nota a la Rectora (en PDF)
								@if($preinscripcion->nota)
								<b>(Ya hay un archivo subido, si sube otro, el anterior se eliminará)</b>
								@endif
							</label>
							<input type="file" id="nota_file" name="nota_file" class="@error('nota_file') is-invalid @enderror" value="{{ old('nota_file') }}">

							@error('nota_file')
							<span class="invalid-feedback d-block" role="alert">
								<strong>{{ $message }}</strong>
							</span>
							@enderror
						</div>
					</div>
					<input type="submit" value="Actualizar datos" class="btn btn-success" id="loading">
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('js/preinscripcion/preinscripcion.js') }}"></script>
@endsection
