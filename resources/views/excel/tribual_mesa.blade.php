<table class="table">
	<thead class="thead-dark">
		<tr>
		    <th scope="col">Espacio Curricular</th>
			<th scope="col">Año</th>
		    <th scope="col">Fecha Primer llamado</th>
		    <th scope="col">Hora Primer llamado</th>
			<th scope="col">Presidente Primer llamado</th>
		    <th scope="col">Primer Vocal Primer llamado</th>
		    <th scope="col">Segundo Vocal Primer llamado</th>
		    <th scope="col">Fecha Segundo llamado</th>
		    <th scope="col">Hora Segundo llamado</th>
			<th scope="col">Presidente Segundo llamado</th>
		    <th scope="col">Primer Vocal Segundo llamado</th>
		    <th scope="col">Segundo Vocal Segundo llamado</th>

		</tr>
	</thead>
	<tbody>
        @foreach($mesas as $mesa)
		<tr>
        <td>{{ $mesa['materia']['nombre'] }}</td>
		<td>{{ $mesa['materia']['año'] }}</td>
        <td>{{ date_format(new DateTime( $mesa['fecha'] ), 'd-m-Y') }}</td>
        <td>{{date_format(new DateTime( $mesa['fecha'] ), 'H:i') }}</td>
		<td>{{ $mesa['presidente'] }}</td>
        <td>{{ $mesa['primer_vocal'] }}</td>
        <td>{{ $mesa['segundo_vocal'] }}</td>
        <td>{{  date_format(new DateTime( $mesa['fecha_segundo'] ), 'd-m-Y') }}</td>
        <td>{{  date_format(new DateTime( $mesa['fecha_segundo'] ), 'H:i') }}</td>
		<td>{{ $mesa['presidente_segundo'] }}</td>
        <td>{{ $mesa['primer_vocal_segundo'] }}</td>
        <td>{{ $mesa['segundo_vocal_segundo'] }}</td>
		</tr>
        @endforeach
	</tbody>
</table>