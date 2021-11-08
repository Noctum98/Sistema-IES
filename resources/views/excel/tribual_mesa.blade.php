<table class="table">
	<thead class="thead-dark">
		<tr>
		    <th scope="col">Espacio Curricular</th>
			<th scope="col">Año</th>
		    <th scope="col">Fecha primer llamado</th>
		    <th scope="col">Hora primer llamado</th>
		    <th scope="col">Fecha segundo llamado</th>
		    <th scope="col">Hora segundo llamado</th>
		    <th scope="col">Presidente</th>
		    <th scope="col">Primer Vocal</th>
		    <th scope="col">Segundo Vocal</th>
		</tr>
	</thead>
	<tbody>
        @foreach($mesas as $mesa)
		<tr>
        <td>{{ $mesa['materia']['nombre'] }}</td>
		<td>{{ $mesa['materia']['año'] }}</td>
        <td>{{ date_format(new DateTime( $mesa['fecha'] ), 'd-m-Y') }}</td>
        <td>{{date_format(new DateTime( $mesa['fecha'] ), 'H:i') }}</td>
        <td>{{  date_format(new DateTime( $mesa['fecha_segundo'] ), 'd-m-Y') }}</td>
        <td>{{  date_format(new DateTime( $mesa['fecha_segundo'] ), 'H:i') }}</td>
        <td>{{ $mesa['presidente'] }}</td>
        <td>{{ $mesa['primer_vocal'] }}</td>
        <td>{{ $mesa['segundo_vocal'] }}</td>
		</tr>
        @endforeach
	</tbody>
</table>