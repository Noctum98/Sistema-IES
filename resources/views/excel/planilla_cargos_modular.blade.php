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
            @foreach($materia->cargos as $cargo)
            <th scope="col">Ponderación {{$cargo->nombre}}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($procesos as $key => $proceso)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{mb_strtoupper($proceso->alumno->apellidos).' '.ucwords($proceso->alumno->apellidos)}}</td>
            @foreach($materia->cargos as $cargo)
            <td>{{$cargo->ponderacion($materia->id)}}</td>
            @endforeach
        </tr>
        @endforeach
    </tbody>
</table>