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
    		background: #0d6efd;
    		text-decoration: none;
    		border-radius: 7px;
    		transition: 400ms;
    	}
    	.btn:hover{
    		background-color:#013b90;
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
			<br>
			<p>
				{{$pie}}
			</p>
			<p>{{$subtitulo}}</p>
			<p>Ciclo de Actualización de Saberes Previos inicia en octubre de 2023 para las siguientes carreras:</p>
			<li>Enfermería Profesional</li>
			<li>Tec. Sup. en Laboratorio de Análisis Clínicos </li>
			<li>Tec. Sup. en Enología e Industrias de los Alimentos</li>
			<li>Tec. Sup. en Gastronomía</li>
			<p>Las demás carreras inicia en febrero de 2024.</p>
			<br>
		</div>
	</div>		
</div>
</body>
</html>
