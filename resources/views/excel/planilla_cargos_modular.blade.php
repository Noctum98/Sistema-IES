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
            <th scope="col">Apeliido y Nombre</th>
            <th>% Actividades Aprobadas</th>
            <th>Nota Tps</th>
            <th>Nota Parciales</th>
            <th>Nota Final</th>
            <th>Asistencia</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        @foreach($procesos as $proceso)
        <tr>
            <td>{{ mb_strtoupper($proceso->alumno->apellidos).' '.ucwords($proceso->alumno->apellidos) }}</td>
            <td>{{ number_format($cargo->getCargoProceso($proceso->procesoModularOne->id)->nota_tp , 2, '.', ',') }}</td>
            <td>{{ number_format($cargo->getCargoProceso($proceso->procesoModularOne->id)->nota_ps , 2, '.', ',') }}</td>
            <td>{{ number_format($cargo->getCargoProceso($proceso->procesoModularOne->id)->nota_cargo, 2, '.', ',') }}</td>
            <td>{{optional(optional($proceso->procesoModularOne->asistencia())->getByAsistenciaCargo($cargo->id))->porcentaje }}</td>
            <td>{{ optional($cargo->obtenerProcesoCargo(optional($proceso->procesoModularOne)->id))->isClose() ? 'Cerrado' : 'Abierto' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>