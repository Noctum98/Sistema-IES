<table class="table table-hover mt-4">
	<thead class="thead-dark">
		<tr>
		    <th scope="col">Nombre y Apellido</th>
		    <th scope="col">D.N.I</th>
		    <th scope="col">Email</th>
		    <th scope="col">Teléfono</th>
			<th>Comisión</th>
		    <th scope="col">Materia</th>
		    <th scope="col">Fecha</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($inscripciones as $inscripcion)
		    <tr style="cursor:pointer;">
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