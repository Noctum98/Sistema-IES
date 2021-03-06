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
		Preinscripcion: {{ $preinscripcion->nombres.' '.$preinscripcion->apellidos }}
	</h1>
	<hr>
	<div class="row">
		<div class="detalle-pre">
			<br>
			<p>Ha ocurrido un error en tu preinscripcion con los archivos:</p>
			<ul>
				@foreach($archivos as $archivo)
				    @if($archivo == 'd.n.i')
					<li>{{ucwords($archivo)}}</li>
					@else
					<li>{{$archivo}}</li>
					@endif
				@endforeach
			</ul>
			<p>Por favor pulsa en "Editar datos" y cambia los archivos mencionados.</p>
			<br>
			<a href="{{route('pre.editar',['timecheck'=>$preinscripcion->timecheck,'id'=>$preinscripcion->id])}}" class="btn">Editar mis datos</a>
		</div>
	</div>		
</div>
</body>
</html>
