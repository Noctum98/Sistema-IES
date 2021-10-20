<div class="col-md-12">
	<div id="accordion">
		@foreach($carreras as $carrera)
			<div class="card">
				<div class="card-header" id="heading{{$carrera->id}}">
				   	<h5 class="mb-0">
				        <h2 style="cursor: pointer;" data-toggle="collapse" data-target="#collapse{{$carrera->id}}" aria-expanded="false" aria-controls="collapse{{$carrera->id}}">
				          {{$carrera->nombre.' ('.$carrera->sede->nombre.')'}}
				        </h2>
				      </h5>
				</div>

				<div id="collapse{{$carrera->id}}" class="collapse" aria-labelledby="heading{{$carrera->id}}" data-parent="#accordion">
				    <div class="card-body">
				        <table class="table">
						  <thead>
						    <tr>
						      <th scope="col">Materia</th>
						      <th scope="col">Año</th>
						      <th scope="col">Accion</th>
						    </tr>
						  </thead>
						  <tbody>
						  	@foreach($carrera->materias as $materia)
						  	<tr>
						  		<td>{{ $materia->nombre }}</td>
						  		<td>{{ $materia->año }}</td>
						  		<td>
						  			<a href="{{ route($ruta,['id'=>$materia->id]) }}" class="btn-sm btn-primary">
						  				Elegir
						  			</a>
						  		</td>
						  	</tr>
						  	@endforeach
						  </tbody>
						</table>
				    </div>
				</div>
			@endforeach
		</div>
	</div>
</div>