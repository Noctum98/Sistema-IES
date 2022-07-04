@foreach($carreras as $carrera)
    <table>
        <thead>
            <tr>
                <th scope="col">Apellido y Nombre</th>
                <th scope="col">D.N.I</th>
                <th scope="col">Email</th>
                <th scope="col">Localidad</th>
                <th scope="col">{{ $carrera->nombre.' ( '.$carrera->sede->nombre.' ) ' }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($carrera->alumnos as $alumno)
            <tr>
                <td>{{ mb_strtoupper($alumno->apellidos).', '.ucwords($alumno->nombres) }}</td>
                <td>{{ $alumno->dni }}</td>
                <td>{{ $alumno->email }}</td>
                <td>{{ $alumno->localidad }}</td>
            @endforeach
        </tbody>
    </table>
@endforeach