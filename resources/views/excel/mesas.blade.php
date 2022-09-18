<table>
	<thead>

		<tr>
			<th><img src="{{ public_path().'/images/cabecera_iesvu.png' }}" height="90px"></th>
		</tr>
		<tr>
		</tr>
		<tr>
			<th><strong>UNIDAD ACADEMICA: {{ mb_strtoupper($materia->carrera->sede->nombre) }}</strong></th>
			<th><strong>CARRERA: {{ mb_strtoupper($materia->carrera->nombre) }}</strong></th>
		</tr>
		<tr>
			<th><strong>ESPACIO/MODULO: </strong></th>
			<th><strong>{{ mb_strtoupper($materia->nombre) }}</strong></th>
			<th><strong>RESOL. N°: {{ $materia->carrera->resolucion }}</strong></th>
		</tr>
		<tr>
			<th><strong>AÑO: {{ '°'.$materia->año }}</strong></th>
			<th><strong>TURNO: {{ mb_strtoupper($materia->carrera->turno) }}</strong></th>
		</tr>
		<tr>
			<th><strong> N° DE ORDEN </strong></th>
			<th><strong>APELLIDOS Y NOMBRES </strong></th>
			<th><strong> DOCUMENTO DE IDENTIDAD </strong></th>
			<th><strong> CORREO ELECTRONICO </strong></th>
			<th><strong> TELÉFONO</strong></th>
			<th><strong> ESCRITO</strong></th>
			<th><strong> ORAL</strong></th>
			<th><strong> PROMEDIO</strong></th>
		</tr>
	</thead>
	<tbody>
		@foreach ($inscripciones as $key => $inscripcion)
		<tr>
			<td>{{ $key + 1 }}</td>
			<td>{{ mb_strtoupper($inscripcion->apellidos).', '.$inscripcion->nombres  }}</td>
			<td>{{ $inscripcion->dni }}</td>
			<td>{{ $inscripcion->correo }}</td>
			<td>{{ $inscripcion->telefono }}</td>
			<td>{{ $inscripcion->acta_volante ? $inscripcion->acta_volante->nota_escrito : '' }}</td>
			<td>{{ $inscripcion->acta_volante ? $inscripcion->acta_volante->nota_oral : '' }}</td>
			<td>{{ $inscripcion->acta_volante ? $inscripcion->acta_volante->promedio : '' }}</td>
		</tr>
		@endforeach
	</tbody>
</table>