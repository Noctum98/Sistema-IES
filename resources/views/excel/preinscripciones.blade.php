<table class="table table-hover mt-4">
	<thead class="thead-dark">
		<tr>
		    <th scope="col">Fecha de Actualización</th>
		    <th scope="col">Nombres</th>
		    <th scope="col">Apellidos</th>
		    <th scope="col">D.N.I</th>
		    <th scope="col">Email</th>
		    <th scope="col">Edad</th>
		    <th scope="col">Residencia</th>
		    <th scope="col">Teléfono</th>
		    <th scope="col">Sede</th>
		    <th scope="col">Carrera</th>
		    <th scope="col">Turno</th>
		    <th scope="col">Fecha</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($preinscripciones as $preinscripcion)
		    <tr style="cursor:pointer;">
		      <td>{{$preinscripcion->updated_at->format('d-m-Y')}}</td>
		      <td>{{ ucwords($preinscripcion->nombres)}}</td>
		      <td>{{ ucwords($preinscripcion->apellidos)}}</td>
		      <td>{{ $preinscripcion->dni }}</td>
		      <td>{{ $preinscripcion->email }}</td>
		      <td>{{ $preinscripcion->edad }}</td>
		      <td>{{ ucwords($preinscripcion->residencia) }}</td>
		      <td>{{ $preinscripcion->telefono }}</td>
		      <td>{{$preinscripcion->carrera->sede->nombre}}</td>
		      <td>{{$preinscripcion->carrera->nombre}}</td>
		      <td>{{ucwords($preinscripcion->carrera->turno)}}</td>
		      <td>{{$preinscripcion->created_at->format('d-m-Y')}}</td>
		    </tr>
		@endforeach
	</tbody>
</table>