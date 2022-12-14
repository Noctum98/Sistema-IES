<table class="table table-striped f30">
    <thead>
        <tr>
            <th><b>UNIDAD ACADEMICA:</b></th>
            <th><b>{{$materia->carrera->sede->nombre}} </b></th>
        </tr>
        <tr>
            <th><b>CARRERA:</b></th>
            <th> <b> {{ $materia->carrera->nombre.' ( '.ucwords($materia->carrera->turno).' )' }}</b></th>
        </tr>
        <tr>
            <th><b>RESOLUCION: </b></th>
            <th style="text-align: left;"><b> {{ $materia->carrera->resolucion }} </b></th>
        </tr>
        <tr>
            <th>N°</th>
            <th>DNI</th>
            <th scope="col">Apeliido y Nombre</th>
            <th>Promedio Final %</th>
            <th>Promedio Final #</th>
            <th>TIF</th>
            <th>Asistencia</th>
            <th>Condición</th>
        </tr>
    </thead>
    <tbody>
        @foreach($procesos as $key => $proceso)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $proceso->alumno->dni }}</td>
            <td>{{ mb_strtoupper($proceso->alumno->apellidos).' '.ucwords($proceso->alumno->apellidos) }}</td>
            <td>{{ $proceso->promedio_final_nota }}</td>
            <td>{{ $proceso->promedio_final_porcentaje }}</td>
            <td>{{ $proceso->calificacionTFI() ? $proceso->calificacionTFI()->nota : '-' }}</td>
            <td>{{ $proceso->asistencia() ? $proceso->asistencia()->porcentaje_final : '-' }}</td>
            <td>{{ $proceso->estado ? mb_strtoupper($proceso->estado->nombre) : '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>