<table>
	<thead>
		<tr>
			<th scope="col">Nombre y Apellido</th>
			<th scope="col">D.N.I</th>
			<th scope="col">Email</th>
			<th scope="col">Teléfono</th>
			<th scope="col">Regularidad</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($alumnos as $alumno)
		<tr>
			<td>{{ $alumno->nombres.' '.$alumno->apellidos }}</td>
			<td>{{ $alumno->dni }}</td>
			<td>{{ $alumno->email }}</td>
			<td>{{ $alumno->telefono }}</td>
			<td>{{ explode("_",ucwords($alumno->regularidad))[0] }}</td>
		@endforeach
	</tbody>
</table>