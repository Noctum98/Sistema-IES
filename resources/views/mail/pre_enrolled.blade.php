<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<style type="text/css">
		* {
			font-family: Helvetica;
		}

		h1 {
			font-weight: 100;
			color: #333 !important;
		}

		.conta {
			width: 500px;
			padding: 20px;
		}

		.img-mask {
			padding: 30px;
			background: #333;
		}

		li {
			color: #333 !important;
			list-style: none;
			padding-top: 10px;
			padding-bottom: 10px;
		}

		.btn {
			color: white !important;
			border: none;
			padding: 10px;
			margin-left: 43px;
			background: #0d6efd;
			text-decoration: none;
			border-radius: 7px;
			transition: 400ms;
		}

		.btn:hover {
			background-color: #013b90;
		}
	</style>
</head>

<body>
	<div class="conta">
		<div class="img-mask">
			<img src="http://iesvu.edu.ar/wp-content/uploads/2015/10/Logoanterior.png" style="width:150px">
		</div>

		<h1 class="h1 pt-4">
			{{$titulo}}
		</h1>
		<hr>
		<div class="row">
			<div class="detalle-pre">
				@if($preinscripcion->articulo_septimo)
				<p><b>
						Estás realizando tu preinscripción por Artículo 7mo, cuyos requisitos son:
						ser mayor de 25 años, tener secundario incompleto, certificar que trabajás o has
						trabajado en un empleo relacionado con la carrera elegida. Es requisito obligatorio presentar la
						documentación Título de Nivel Primario, Certificado de Trabajo con firma y sello de quien lo emite,
						Currículum Vitae, Nota al Rector, caso contrario no podrá ingresar a la carrera. La fecha limite es el 30 de septiembre.
					</b></p>

					<a href="{{ route('pre.files',['id'=>$preinscripcion->id,'timecheck'=>$preinscripcion->timecheck]) }}" class="btn">
						Subir archivos de Artículo Séptimo aquí
					</a>

				@endif
				<br><br>
				<ul>
					<li><b>Carrera:</b> {{ $preinscripcion->carrera->nombre }}</li>
					<li><b>Turno:</b> {{ ucwords($preinscripcion->carrera->turno) }}</li>
					<li><b>Sede:</b> {{ ucwords($preinscripcion->carrera->sede->nombre) }}</li>
					<li><b>D.N.I:</b> {{$preinscripcion->dni}}</li>
					<li><b>CUIL:</b> {{$preinscripcion->cuil}}</li>
					<li><b>Edad:</b> {{$preinscripcion->edad}} años</li>
					<li><b>Email:</b> {{$preinscripcion->email}}</li>
					<li><b>Domicilio:</b> {{$preinscripcion->domicilio}}</li>
					<li><b>Nacionalidad:</b> {{ucwords($preinscripcion->nacionalidad)}}</li>
					<li><b>Residencia:</b> {{ ucwords($preinscripcion->residencia) }}</li>
					<li><b>Teléfono:</b> {{$preinscripcion->telefono}}</li>
					<li><b>Escuela Secundaria:</b> {{ucwords($preinscripcion->escuela_s)}}</li>
					<li><b>Título Secundario:</b>
						<span class="{{ $preinscripcion->escolaridad == 'si' ? 'text-success' : 'text-danger' }}">
							{{ucwords($preinscripcion->escolaridad)}}
						</span>
					</li>
					<li><b>Debe materias del secundario:</b>
						<span class="{{ $preinscripcion->materias_s == 'si' ? 'text-success' : 'text-danger' }}">
							{{ucwords($preinscripcion->materias_s)}}
						</span>
					</li>
					<li><b>Trabaja actualmente:</b>
						<span class="{{ $preinscripcion->trabajo == 'si' ? 'text-success' : 'text-danger' }}">
							{{ucwords($preinscripcion->trabajo)}}
						</span>
					</li>
				</ul>


				<a href="{{route('pre.editar',['timecheck'=>$preinscripcion->timecheck,'id'=>$preinscripcion->id])}}" class="btn">Editar mis datos</a>
			</div>
		</div>
	</div>
</body>

</html>