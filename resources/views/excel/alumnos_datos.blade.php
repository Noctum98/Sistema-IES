<table>
    <thead>
        <tr>
            <th scope="col">Apellido y Nombre</th>
            <th scope="col">D.N.I</th>
            <th scope="col">Email</th>
            <th scope="col">Cohorte</th>
            <th scope="col">Localidad</th>
            <th scope="col">Provincia</th>
            <th scope="col">Discapacidad Visual</th>
            <th scope="col">Discapacidad Motriz</th>
            <th scope="col">Discapacidad Mental</th>
            <th scope="col">Discapacidad Intelectual</th>
            <th scope="col">Discapacidad Auditiva</th>
            <th scope="col">Población Indigena</th>
            <th scope="col">Privado de libertad</th>
        </tr>
    </thead>
    <tbody>
        @foreach($alumnos as $alumno)
        <tr>
            <td>{{ mb_strtoupper($alumno->apellidos).', '.ucwords($alumno->nombres) }}</td>
            <td>{{ $alumno->dni }}</td>
            <td>{{ $alumno->email }}</td>
            <td>{{ $alumno->cohorte ?? '-' }}</td>
            <td>{{ $alumno->localidad }}</td>
            <td>{{ $alumno->provincia }}</td>
            <td>{{ $alumno->discapacidad_visual ? 'Si' : 'No' }}</td>
            <td>{{ $alumno->discapacidad_motriz ? 'Si' : 'No' }}</td>
            <td>{{ $alumno->discapacidad_mental ? 'Si' : 'No' }}</td>
            <td>{{ $alumno->discapacidad_intelectual != 'ninguna' ? 'Si' : 'No' }}</td>
            <td>{{ $alumno->discapacidad_auditiva != 'ninguna' ? 'Si' : 'No' }}</td>
            <td>{{ $alumno->poblacion_indigena ? 'Si' : 'No' }}</td>
            <td>{{ $alumno->privacidad ? 'Si' : 'No' }}</td>
            @endforeach
    </tbody>
</table>