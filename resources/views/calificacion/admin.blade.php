@extends('layouts.app-prueba')
@section('content')
<div class="container">
    <h2 class="h1 text-info">
        Calificaciónes: {{ $materia->nombre }}
    </h2>
    <hr>
    <button class="btn btn-warning">Crear Calificación</button>
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0 mt-1" method="GET" action="#" id="buscador">
		<div class="input-group mt-3">
			<input class="form-control ml-3" type="text" id="busqueda" placeholder="Buscar calificación" aria-label="Search for..." aria-describedby="btnNavbarSearch" />
			<button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
		</div>
	</form>
</div>
@endsection