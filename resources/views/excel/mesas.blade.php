<table class="table  mt-4">
	<thead class="thead-dark">
		<tr>
		    <th>Nombre y Apellido</th>
		    <th>D.N.I</th>
		    <th>Email</th>
		    <th>Teléfono</th>
			<th>Comisión</th>
		    <th>Materia</th>
		    <th>Fecha</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($inscripciones as $inscripcion)
		    <tr>
		      <td>{{  mb_strtoupper($inscripcion->apellidos).', '.$inscripcion->nombres  }}</td>
		      <td>{{ $inscripcion->dni }}</td>
		      <td>{{ $inscripcion->correo }}</td>
		      <td>{{ $inscripcion->telefono }}</td>
			  <td>{{ $inscripcion->alumno->comisionPorAño($inscripcion->materia->año,$inscripcion->materia->carrera_id) ?? '-' }}</td>
			  @if($inscripcion->mesa)
			  <td>{{$inscripcion->mesa->materia->nombre}}</td>
			  @else
			  <td>{{$inscripcion->materia->nombre}}</td>
			  @endif
		      
		      <td>{{$inscripcion->created_at->format('d-m-Y')}}</td>
		    </tr>
		@endforeach
	</tbody>
</table>