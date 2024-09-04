<div id="alerts">

</div>
<table class="table">
    <thead class="thead-dark">
    <tr>
        <th>Nombres y Apellidos</th>
        <th>Porcentaje</th>
        <th class="text-right">Presencial</th>
        <th class="text-right">Virtual</th>
        <th>Cargar</th>
    </tr>
    </thead>
    <tbody>
    @foreach($procesos as $proceso)
        <tr
                @if($proceso->alumno()->first()->hasEquivalenciaMateriaCicloLectivo($materia->id,$ciclo_lectivo))
                    class="text-muted"
                data-bs-toggle="tooltip" data-bs-placement="top"
                data-bs-title="{{$proceso->alumno()->first()->infoEquivalenciaMateriaCicloLectivo($materia->id,$ciclo_lectivo)}}"
                @endif
        >
            <td>
                {{ mb_strtoupper($proceso->alumno->apellidos).' '.$proceso->alumno->nombres }}
            </td>
            <td class="porcentaje-{{ $proceso->id }}">
                @if($proceso->asistencia())
                    @if($proceso->asistencia()->getByAsistenciaCargo($cargo->id))
                        {{ $proceso->asistencia()->getByAsistenciaCargo($cargo->id)->porcentaje }} %
                    @endif
                @endif
            </td>
            <td colspan="3">
                @if(!$proceso->alumno()->first()->hasEquivalenciaMateriaCicloLectivo($materia->id,$ciclo_lectivo))
                    <form action="" class="col-md-10 m-0 p-0 asis-alumnos float-right form-modular_7030"
                          id="{{ $proceso->id }}" method="POST">
                        <input type="hidden" name="cargo_id" class="cargo_id" value="{{ $cargo->id }}">
                        <input type="hidden" name="materia_id" class="materia_id" value="{{$materia->id}}">


                        <input type="number" class="form-control" id="asis-presencial-{{ $proceso->id }}"
                               value="{{ $proceso->asistencia() && $proceso->asistencia()->getByAsistenciaCargo($cargo->id) ? $proceso->asistencia()->getByAsistenciaCargo($cargo->id)->porcentaje_presencial : ''  }}"
                               required>

                        <input type="number" class="form-control float-right col-md-3"
                               value="{{ $proceso->asistencia() && $proceso->asistencia()->getByAsistenciaCargo($cargo->id) ? $proceso->asistencia()->getByAsistenciaCargo($cargo->id)->porcentaje_virtual : '' }}"
                               id="asis-virtual-{{ $proceso->id }}" required>


                        <button type="submit" class="btn btn-sm btn-outline-success">Cargar</button>
                    </form>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
