<table class="table">
    <thead class="thead-dark">
        <th>Nombre y Apellido</th>
        <th>Porcentaje</th>
        <th class="text-right">Presencial</th>
        <th class="text-right">Virtual</th>
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
                <form action="" class="col-md-3 m0 p-0 asis-alumnos float-right form-tradicional_7030" id="{{ $proceso->id }}" method="POST">
                    <input type="number" class="form-control" id="asis-presencial-{{ $proceso->id }}" required>
            </td>
            <td>
                    <input type="number" class="form-control float-right col-md-3" id="asis-virtual-{{ $proceso->id }}" required>
               
            </td>
            <td>
                <button type="submit" class="btn btn-sm btn-outline-success">Cargar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>