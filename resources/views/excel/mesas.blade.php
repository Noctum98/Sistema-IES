<table class="table table-hover mt-4">
	<thead class="thead-dark">
		<tr>
		    <th scope="col">Nombre y Apellido</th>
		    <th scope="col">D.N.I</th>
		    <th scope="col">Email</th>
		    <th scope="col">Teléfono</th>
		    <th scope="col">Materia</th>
		    <th scope="col">Fecha</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($inscripciones as $inscripcion)
		    <tr style="cursor:pointer;">
		      <td>{{ $inscripcion->nombres.' '.$inscripcion->apellidos }}</td>
		      <td>{{ $inscripcion->dni }}</td>
		      <td>{{ $inscripcion->correo }}</td>
		      <td>{{ $inscripcion->telefono }}</td>
		      <td>{{$inscripcion->materia->nombre}}</td>
		      <td>{{$inscripcion->created_at->format('d-m-Y')}}</td>
		    </tr>
		@endforeach
	</tbody>
</table>