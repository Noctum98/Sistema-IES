<table>
	<thead class="thead-dark">
		<tr>
			<td>Total: {{ count($preinscripciones)}}</td>
		</tr>
		<tr>
			<th>N°</th>
			<th scope="col">Fecha de Actualización</th>
			<th scope="col">Nombres</th>
			<th scope="col">Apellidos</th>
			<th scope="col">D.N.I</th>
			<th scope="col">CUIL</th>
			<th scope="col">Domicilio</th>
			<th scope="col">Residencia</th>
			<th scope="col">Terminalidad</th>
			<th scope="col">Título</th>
			<th scope="col">Escuela Secundaria</th>
			<th scope="col">Email</th>
			<th scope="col">Edad</th>
			<th scope="col">Teléfono</th>
			<th scope="col">Sede</th>
			<th scope="col">Carrera</th>
			<th scope="col">Turno</th>
			<th scope="col">Articulo 7mo</th>
			<th scope="col">Fecha</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($preinscripciones as $i => $preinscripcion)
		<tr>
			<td>{{ $i + 1 }}</td>
			<td>{{$preinscripcion->updated_at->format('d-m-Y')}}</td>
			<td>{{ ucwords($preinscripcion->nombres)}}</td>
			<td>{{ ucwords($preinscripcion->apellidos)}}</td>
			<td>{{ $preinscripcion->dni }}</td>
			<td>{{ $preinscripcion->cuil }}</td>
			<td>{{ ucwords($preinscripcion->domicilio) }}</td>
			<td>{{ ucwords($preinscripcion->residencia) }}</td>
			<td>{{$preinscripcion->condicion_s == 'secundario completo' ? 'Si' : 'No' }}</td>
			<td> {{ ucwords($preinscripcion->escolaridad) }}</td>
			<td>{{ ucwords($preinscripcion->escuela_s) }}</td>
			<td>{{ $preinscripcion->email }}</td>
			<td>{{ $preinscripcion->edad }}</td>
			<td>{{ $preinscripcion->telefono }}</td>
			<td>{{$preinscripcion->carrera->sede->nombre}}</td>
			<td>{{$preinscripcion->carrera->nombre}}</td>
			<td>{{ucwords($preinscripcion->carrera->turno)}}</td>
			<td>{{ $preinscripcion->ctrabajo ? 'Si' : 'No' }}</td>
			<td>{{$preinscripcion->created_at->format('d-m-Y')}}</td>
		</tr>
		@endforeach
	</tbody>
</table>
