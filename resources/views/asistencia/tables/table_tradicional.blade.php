<table class="table">
    <thead class="thead-dark">
    <th>Nombre y Apellido</th>
    <th>Cargar Porcentaje</th>
    <th>Porcentaje</th>
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
            <td colspan="3">
                @if(!$proceso->alumno()->first()->hasEquivalenciaMateriaCicloLectivo($materia->id,$ciclo_lectivo))
                <form action="" class="col-md-10 m-0 p-0 asis-alumnos form-tradicional" id="{{ $proceso->id }}"
                      method="POST">
                    <div class="input-group mb-1">
                        <input type="number" class="form-control" id="asis-procentaje-{{ $proceso->id }}"
                               @if(!Session::has('profesor') or $proceso->cierre == 1 ) disabled @endif required>
                        <div class="input-group-append">
                            <button type="submit"
                                    class="btn btn-info btn-sm col-md-12 input-group-text @if(!Session::has('profesor') or $proceso->cierre == 1 ) disabled @endif">
                                <i class="fa fa-save"></i></button>
                        </div>
                    </div>

                </form>
                @endif
            </td>
            <td class="porcentaje-{{ $proceso->id }}">
                @if($proceso->asistencia($proceso->id))
                    {{ $proceso->asistencia($proceso->id)->porcentaje_final }} %
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
