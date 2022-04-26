<table class="table">
    <thead class="thead-dark">
        <th>Nombre y Apellido</th>
        <th>Porcentaje</th>
        <th>Cargar</th>
    </thead>
    <tbody>
        @foreach($procesos as $proceso)
        <tr>
            <td>
                {{ $proceso->alumno->nombres.' '.$proceso->alumno->apellidos }}
            </td>
            <td class="porcentaje-{{ $proceso->id }}">
                @if($proceso->asistencia($proceso->id))
                % {{ $proceso->asistencia($proceso->id)->porcentaje_final }}
                @endif
            </td>
            <td>
                <form action="" class="col-md-3 m0 p-0 asis-alumnos form-tradicional" id="{{ $proceso->id }}" method="POST">
                    <input type="number" class="form-control" id="asis-procentaje-{{ $proceso->id }}" required>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>