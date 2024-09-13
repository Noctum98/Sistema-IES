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
                @if($proceso->asistencia($proceso->id))
                    {{ $proceso->asistencia($proceso->id)->porcentaje_final }} %
                @endif
            </td>
            <td colspan="3">
                @if(!$proceso->alumno()->first()->hasEquivalenciaMateriaCicloLectivo($materia->id,$ciclo_lectivo))
                    <form action="" class="col-md-10 m-0 p-0 asis-alumnos float-right form-tradicional_7030 input-group"
                          id="{{ $proceso->id }}" method="POST">
                        <input type="number" class="form-control" id="asis-presencial-{{ $proceso->id }}"
                               value="{{ $proceso->asistencia($proceso->id) ? $proceso->asistencia($proceso->id)->porcentaje_presencial: ''  }}"
                               required>

                        <input type="number" class="form-control"
                               value="{{ $proceso->asistencia($proceso->id) ? $proceso->asistencia($proceso->id)->porcentaje_virtual: '' }}"
                               id="asis-virtual-{{ $proceso->id }}" required>


                        <button type="submit" class="btn btn-sm btn-outline-success">Cargar</button>
                    </form>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
