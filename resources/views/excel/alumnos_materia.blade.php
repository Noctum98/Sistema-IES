<table>
	<thead>
		<tr>
			<th scope="col">Apellido y Nombre</th>
			<th scope="col">D.N.I</th>
			<th scope="col">Regularidad</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($procesos as $proceso)
		<tr>
			<td>{{ strtoupper($proceso->alumno->apellidos).', '.ucwords($proceso->alumno->nombres) }}</td>
			<td>{{ $proceso->alumno->dni }}</td>
			<td>{{ explode("_",ucwords($proceso->alumno->regularidad))[0] }}</td>
		@endforeach
	</tbody>
</table>