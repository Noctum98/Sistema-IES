<div id="alerts">

</div>
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
            @if($proceso->asistencia())
                 @if($proceso->asistencia()->getByAsistenciaCargo($cargo->id))
                % {{ $proceso->asistencia()->getByAsistenciaCargo($cargo->id)->porcentaje }}
                 @endif
                @endif
            </td>
            <td>
                <form action="" class="col-md-3 m0 p-0 asis-alumnos float-right form-modular_7030" id="{{ $proceso->id }}" method="POST">
                    <input type="hidden" name="cargo_id" class="cargo_id" value="{{ $cargo->id }}">

                    <input type="number" class="form-control" id="asis-presencial-{{ $proceso->id }}" value="{{ $proceso->asistencia() && $proceso->asistencia()->getByAsistenciaCargo($cargo->id) ? $proceso->asistencia()->getByAsistenciaCargo($cargo->id)->porcentaje_presencial : ''  }}" required>
            </td>
            <td>
                    <input type="number" class="form-control float-right col-md-3" value="{{ $proceso->asistencia() && $proceso->asistencia()->getByAsistenciaCargo($cargo->id) ? $proceso->asistencia()->getByAsistenciaCargo($cargo->id)->porcentaje_virtual : '' }}" id="asis-virtual-{{ $proceso->id }}" required>

            </td>
            <td>
                    <button type="submit" class="btn btn-sm btn-outline-success">Cargar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>