<table class="table">
    <thead class="thead-dark">
        <th>Nombre y Apellido</th>
        <th>Porcentaje</th>
        <th>Cargar Porcentaje</th>
    </thead>
    <tbody>
        @foreach($procesos as $proceso)
        <tr>
            <td>
                {{ mb_strtoupper($proceso->alumno->apellidos).' '.$proceso->alumno->nombres }}
            </td>
            <td class="porcentaje-{{ $proceso->id }}">
                @if($proceso->asistencia($proceso->id))
                % {{ $proceso->asistencia($proceso->id)->porcentaje_final }}
                @endif
            </td>
            <td>
                <form action="" class="col-md-6 m0 p-0 asis-alumnos form-tradicional" id="{{ $proceso->id }}" method="POST">
                    <input type="number" class="form-control" id="asis-procentaje-{{ $proceso->id }}"  @if(!Session::has('profesor') or $proceso->cierre == 1 ) disabled @endif required>
                    <button type="submit" class="btn btn-info btn-sm col-md-12 input-group-text @if(!Session::has('profesor') or $proceso->cierre == 1 ) disabled @endif">
                        <i class="fa fa-save"></i></button>

                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>