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
            <th><i class="fa fa-cog" style="font-size:20px;"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($bajas as $inscripcion)
        <tr style="cursor:pointer;">
            <td>{{ $inscripcion->alumno ? $inscripcion->alumno->nombres : $inscripcion->nombres }}</td>
            <td>{{ $inscripcion->alumno ? $inscripcion->alumno->apellidos : $inscripcion->apellidos  }}</td>
            <td>{{ $inscripcion->alumno ? $inscripcion->alumno->dni : $inscripcion->dni }}</td>
            <td>{{ $inscripcion->alumno ? $inscripcion->alumno->telefono : $inscripcion->telefono }}</td>
            <td>{{ $inscripcion->user ? ucwords($inscripcion->user->nombre).' '.ucwords($inscripcion->user->apellido) : '' }}</td>
            <td>{{ date_format(new DateTime($inscripcion->updated_at ), 'd-m-Y H:i') }}</td>
            <td>
                {{ $inscripcion->motivo_baja }}
            </td>
            <td><a href="{{ route('alta.mesa',$inscripcion->id) }}" class="btn btn-sm btn-info"><i class="fas fa-chevron-circle-up"></i> Dar Alta</a></td>
        </tr>
        @endforeach
    </tbody>
</table>