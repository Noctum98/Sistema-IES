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
            @foreach($cargos as $cargo)
            <th scope="col">{{$cargo->nombre}}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
    @foreach($procesos as $proceso)
        <tr>
        
            <td>{{ mb_strtoupper($proceso->alumno->apellidos).' '.ucwords($proceso->alumno->nombres) }}</td>

            @foreach($cargos as $cargo)
            <td>{{ $proceso->asistencia() && $proceso->asistencia()->getByAsistenciaCargo($cargo->id) ? $proceso->asistencia()->getByAsistenciaCargo($cargo->id)->porcentaje.'%' : '-' }}</td>
            @endforeach
        </tr>
        @endforeach

    </tbody>
</table>