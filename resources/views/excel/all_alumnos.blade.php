    <table>
        <thead>
            <tr>
                <th scope="col">Apellido y Nombre</th>
                <th scope="col">D.N.I</th>
                <th scope="col">Email</th>
                <th scope="col">Localidad</th>
            </tr>
        </thead>
        <tbody>
            @foreach($alumnos as $alumno)
            <tr>
                <td>{{ mb_strtoupper($alumno->apellidos).', '.ucwords($alumno->nombres) }}</td>
                <td>{{ $alumno->dni }}</td>
                <td>{{ $alumno->email }}</td>
                <td>{{ $alumno->localidad }}</td>
                @endforeach
        </tbody>
    </table>