@extends('layouts.app-prueba')
@section('content')
<div class="container">
	<h2 class="h1 text-info">
		Datos Inscriptos / Aprobados Mesas
	</h2>
	<hr>
    @foreach($sedes as $sede)
    <h4>{{ $sede->nombre }}</h4>

    <table class="table mt-1 mb-4">
		<thead class="thead-dark">
			<tr>
				<th scope="col">Carrera</th>
				<th scope="col">Inscriptos</th>
                <th scope="col">Aprobados</th>
			</tr>
		</thead>
		<tbody>
			@foreach($sede->carreras as $carrera)
			<tr>
				<td>{{ $carrera->nombre.':'.$carrera->resolucion }}</td>
				<td>{{$carrerasInscriptos[$carrera->id]}}</td>
                <td>{{$carrerasInscriptos[$carrera->id. '-aprobados']}}</td>
			</tr>
            @endforeach
        </tbody>
    </table>
    @endforeach
    
</div>
@endsection