<table>
	<thead class="thead-dark">
		<tr>
			<th scope="col">Apellido y Nombre</th>
			<th scope="col">D.N.I</th>
			<th scope="col">Email</th>
			<th scope="col">Teléfono</th>
			<th scope="col">Regularidad</th>
			<th scope="col">Materias</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($alumnos as $alumno)
		<tr>
			<td>{{ ucwords($alumno->apellidos).' '.ucwords($alumno->nombres) }}</td>
			<td>{{ $alumno->dni }}</td>
			<td>{{ $alumno->email }}</td>
			<td>{{ $alumno->telefono }}</td>
			<td>{{ explode("_",ucwords($alumno->regularidad))[0] }}</td>
			<td>
				@foreach($alumno->procesos_date($ciclo_lectivo) as $proceso)
					| {{ $proceso->materia->nombre }} 
				@endforeach
			</td>
		</tr>
		@endforeach
		<tr></tr>
		<tr>
			<td>Hombres</td>
			<td>{{ $generos['hombres'] }}</td>
		</tr>
		<tr>
			<td>Mujeres</td>
			<td>{{ $generos['mujeres'] }}</td>
		</tr>
		<tr>
			<td>Otro</td>
			<td>{{ $generos['otro'] }}</td>
		</tr>
	</tbody>
</table>
