@extends('layouts.app-prueba')
@section('content')
	<div class="container">
		<h2 class="h1 text-info">
			Parciales de {{ $materia->nombre }}
		</h2>
		<hr>
		<div class="col-md-8">
			<a href="{{ route('parci.crear',['id'=>$materia->id]) }}" class="btn btn-primary">
				Crear Parcial
			</a>
			<br>
			<br>
			<div id="accordion">
					@foreach($parciales as $parci)
					  <div class="card">
					    <div class="card-header" id="heading{{$parci->id}}">
					      <h5 class="mb-0">
					        <h6 style="cursor: pointer;" data-toggle="collapse" data-target="#collapse{{$parci->id}}" aria-expanded="false" aria-controls="collapse{{$parci->id}}" class="font-weight-bold text-secondary">

					          {{$parci->nombre}}

					        </h6>
					      </h5>
					    </div>

					    <div id="collapse{{$parci->id}}" class="collapse" aria-labelledby="heading{{$parci->id}}" data-parent="#accordion">
					      <div class="card-body">
					        <table class="table">
							  <thead>
							    <th scope="col">Nombre</th>
							    <th scope="col">Fecha</th>
							    <th scope="col">Porcentaje</th>
							    <th scope="col">Nota</th>
							    <th scope="col">Recuperatorio</th>
							  </thead>
							  <tbody>

							  	@foreach($parci->parciales as $parcial)
							  	<tr>
							  		<td><strong>
							  			{{ $parcial->alumno->apellidos.' '.$parcial->alumno->nombres }}
							  		</strong></td>
							  		<td class="fecha-titulo">{{$parci->fecha}}</td>
							  		<td>{{$parcial->porcentaje_nota}} %</td>
							  		<td class="font-weight-bold {{$parcial->nota >= 6 ? 'text-success' : 'text-danger'}}">
							  			{{ ucwords($parcial->nota) }}
							  		</td>
							  		<td class="font-weight-bold {{ $parcial->recuperatorio >= 6 ? ('text-success') : ($parcial->recuperatorio > 0 && $parcial->recuperatorio < 6 ? ('text-danger'): ('')) }}">
							  			{{
							  				$parcial->recuperatorio ? $parcial->recuperatorio : 'Sin asignar'
							  			}}
							  		</td>
							  	</tr>
							  	@endforeach

							  </tbody>
							</table>
							<a href="{{ route('parci.editar',['id'=>$parci->id]) }}" class="btn-sm btn-warning mr-2">
								Editar Notas
							</a>
							<a href="{{ route('parci.recu',['id'=>$parci->id]) }}" class="btn-sm btn-secondary">
								Recuperatorio
							</a>


					    </div>
					</div>
				@endforeach
			</div>
		</div>
	</div>
@endsection
