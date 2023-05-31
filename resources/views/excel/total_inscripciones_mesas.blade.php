<table class="table table-hover mt-4">
	<thead class="thead-dark">
		<tr>
		    <th scope="col">Nombre y Apellido</th>
		    <th scope="col">D.N.I</th>
		    <th scope="col">Email</th>
		    <th scope="col">Teléfono</th>
		    <th scope="col">Materia</th>
		    <th scope="col">Fecha</th>
            <th scope="col">Carrera</th>
            <th scope="col">Turno</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($carreras as $carrera)
            @if($carrera->materias)
            @foreach($carrera->materias as $materia)
                @if($materia->mesas)
                @foreach($materia->mesas as $mesa)
                    @if($mesa->instancia_id == $instancia->id)
                    @foreach($mesa->mesa_inscriptos_total as $inscripcion)
                    <tr style="cursor:pointer;">
                        <td>{{ $inscripcion->nombres.' '.$inscripcion->apellidos }}</td>
                        <td>{{ $inscripcion->dni }}</td>
                        <td>{{ $inscripcion->correo }}</td>
                        <td>{{ $inscripcion->telefono }}</td>
                        @if($inscripcion->mesa)
                        <td>{{$inscripcion->mesa->materia->nombre}}</td>
                        @else
                        <td>{{$inscripcion->materia->nombre}}</td>
                        @endif
                        
                        <td>{{$inscripcion->created_at->format('d-m-Y')}}</td>
                        <td>{{$inscripcion->mesa->materia->carrera->nombre}}</td>
                        <td>{{ucwords($inscripcion->mesa->materia->carrera->turno)}}</td>
                    </tr>
                    @endforeach
                    @endif
                @endforeach
               @endif
            @endforeach
            @endif
		@endforeach
	</tbody>
</table>