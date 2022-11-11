<table class="table mt-4">
    <thead class="thead-dark">
        <tr>
            <th scope="col">Nombre</th>
            <th scope="col">Apellido</th>
            <th scope="col">D.N.I</th>
            <th scope="col">Teléfono</th>
            <th>Responsable</th>
            <th>Fecha de baja</th>
            <th scope="col">Motivos</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($inscripciones as $inscripcion)
        <tr style="cursor:pointer;">
            <td>{{ $inscripcion->nombres }}</td>
            <td>{{ $inscripcion->apellidos }}</td>
            <td>{{ $inscripcion->dni }}</td>
            <td>{{ $inscripcion->telefono }}</td>
            <td>{{ $inscripcion->user ? ucwords($inscripcion->user->nombre).' '.ucwords($inscripcion->user->apellido) : '' }}</td>
            <td>{{ date_format(new DateTime($inscripcion->updated_at ), 'd-m-Y H:i') }}</td>
            <td>
                {{ $inscripcion->motivo_baja }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>