
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
            Has recibido una respuesta del ticket: {{ $ticket->id }}
		</h1>
		<hr>
		<div class="row">
			<div class="detalle-pre" style="text-align: center;">
				<br>
				<p>Respondido por: {{ ucwords($ticket->responsable->user->nombre).' '.ucwords($ticket->responsable->user->apellido) }}</p>
				<a class="btn" href="{{ route('tickets.ticket.show',$ticket->id) }}" target="__blank">IR AL TICKET</a>
			</div>
		</div>
	</div>
</body>
