<table>
	<thead>
		<tr>
			<th scope="col">Nombre y Apellido</th>
			<th scope="col">D.N.I</th>
			<th scope="col">Regularidad</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($procesos as $proceso)
		<tr>
			<td>{{ $proceso->alumno->apellidos.' '.$proceso->alumno->nombres }}</td>
			<td>{{ $proceso->alumno->dni }}</td>
			<td>{{ explode("_",ucwords($proceso->alumno->regularidad))[0] }}</td>
		@endforeach
	</tbody>
</table>