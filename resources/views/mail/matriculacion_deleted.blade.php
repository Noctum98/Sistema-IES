<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style type="text/css">
    	*{
    		font-family: Helvetica;
    	}
    	h1{
    		font-weight: 100;
    		color: #333 !important;
    	}
    	.conta{
    		width: 500px;
    		padding: 20px;
    	}
    	.img-mask{
    		padding: 30px;
    		background: #333;
    	}
    	.btn{
    		color: white !important;
    		border: none;
    		padding: 10px;
    		background: #208300;
    		text-decoration: none;
    		border-radius: 7px;
    		transition: 400ms;
    	}
    	.btn:hover{
    		background-color:#104000;
    	}
    </style>
</head>
<body>
    <div class="conta">
    <div class="img-mask">
    	<img src="http://iesvu.edu.ar/wp-content/uploads/2015/10/Logoanterior.png" style="width:150px">
    </div>
    
	<h1 class="h1 pt-4">
		Matriculación de : {{ $alumno->nombres.' '.$alumno->apellidos }}
	</h1>
	<hr>
	<div class="row">
		<div class="detalle-pre">
			<br>
			<p>Se ha eliminado tu matriculación de {{ $carrera->nombre." ".$carrera->sede->nombre }}</p>
			<p><strong>MOTIVOS:</strong></p>
			@if($errores)
				@foreach($errores as $error)
					<p>- Error en {{ $error }}</p>
				@endforeach
			@endif
			@if($motivo)
			<p>	{{ $motivo }}</p>
			@endif
		</div>
	</div>		
</div>
</body>
</html>
