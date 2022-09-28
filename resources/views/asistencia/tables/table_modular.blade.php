<table class="table">
    <thead class="thead-dark">
    <tr>
        <th>Nombre y Apellido</th>
        <th>Cargar</th>
        <th>Porcentaje</th>
    </tr>
    </thead>
    <tbody>
    @foreach($procesos as $proceso)
        <tr>
            <td>
                {{ mb_strtoupper($proceso->alumno->apellidos).' '.$proceso->alumno->nombres }}
            </td>
            <td>
                <form action="" class="col-md-3 m0 p-0 asis-alumnos form-modular" id="{{ $proceso->id }}" method="POST">
                    <input type="hidden" name="cargo_id" class="cargo_id" value="{{ $cargo->id }}">
                    <input type="hidden" name="materia_id" class="materia_id" value="{{$materia->id}}">
                    <input type="number" class="form-control" id="asis-procentaje-{{ $proceso->id }}"
                           @if(!Session::has('profesor') or $proceso->cierre == 1 ) disabled @endif required>
                    <button type="submit"
                            class="btn btn-info btn-sm col-md-12 input-group-text @if(!Session::has('profesor') or $proceso->cierre == 1 ) disabled @endif">
                        <i class="fa fa-save"></i></button>
                </form>
            </td>
            <td class="porcentaje-{{ $proceso->id }}">
                @if($proceso->asistencia())
                    @if($proceso->asistencia()->getByAsistenciaCargo($cargo->id))
                        {{ $proceso->asistencia()->getByAsistenciaCargo($cargo->id)->porcentaje }}  %
                    @endif
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
