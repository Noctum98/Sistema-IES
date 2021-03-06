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

		.btn {
			color: white !important;
			border: none;
			padding: 10px;
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
			{{ucwords($instancia->nombre)}}
		</h1>
		<hr>
		<div class="row">
			<div class="detalle-pre">
				<br>
				<p>Te has bajado de la mesa de {{ $instancia->tipo == 0 ? $inscripcion->mesa->materia->nombre : $inscripcion->materia->nombre}}</p>
				<p>Para bajarte de alguna mesa, ve al siguiente enlace</p>
				<br>
				<p>Datos del estudiante:</p>
				<ul>
					<li>Sede: {{ $inscripcion->mesa->materia->carrera->sede->nombre }}</li>
					<li>Carrera: {{ $inscripcion->mesa->materia->carrera->nombre }}</li>
					<li>Nombres: {{$inscripcion->nombres}}</li>
					<li>Apellidos: {{$inscripcion->apellidos}}</li>
					<li>Correo: {{ $inscripcion->correo }}</li>
					<li>D.N.I: {{$inscripcion->dni}}</li>
					<li>Teléfono: {{$inscripcion->telefono}}</li>
					<li>Fecha:
						{{date_format(new DateTime($inscripcion->created_at),'d-m-Y H:i:s')}}
					</li>
				</ul>
				@if($instancia->tipo == 1)
				<a href="{{route('edit.mesa',['dni'=>$inscripcion->dni,'id'=>$instancia->id,'sede_id'=>$inscripcion->materia->carrera->sede->id])}}" class="btn">Mis inscripciones</a>
				@else
				<a href="{{route('edit.mesa',['dni'=>$inscripcion->dni,'id'=>$instancia->id,'sede_id'=>$inscripcion->mesa->materia->carrera->sede->id])}}" class="btn">Mis inscripciones</a>
				@endif
			</div>
		</div>
	</div>
</body>

</html>