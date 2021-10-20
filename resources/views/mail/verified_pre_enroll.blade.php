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
		PreinscripciÃ³n: {{ $preinscripcion->nombres.' '.$preinscripcion->apellidos }}
	</h1>
	<hr>
	<div class="row">
		<div class="detalle-pre">
			<br>
			<p>
				Tu preinscripci¨®n esta completa, podr¨¢s ingresar al Aula Virtual de Ingreso en <a href=" https://www.entornovirtual.mendoza.edu.ar/course/view.php?id=2059">este enlace</a> dentro de 72hs.</a>.
			</p>
			<p>Su ususario y clave ser¨¢n su dni sin puntos.</p>
			<br>
		</div>
	</div>		
</div>
</body>
</html>
