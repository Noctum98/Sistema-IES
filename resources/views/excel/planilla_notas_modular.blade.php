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
            @foreach($cargo->calificacionesTPByCargoByMateria($materia->id) as $calificacion)
            <th scope="col">{{$calificacion->nombre}}</th>
            @endforeach
            <th>Parcial</th>
            <th>% Final</th>
            <th># Final</th>
        </tr>
    </thead>
    <tbody>
        @foreach($procesos as $proceso)
        @php
        $suma=0;
        $sumaNota=0;
        $cant=count($cargo->calificacionesTPByCargoByMateria($materia->id));
        $pparcial = 0;
        @endphp
        <tr>
            <td>{{ mb_strtoupper($proceso->alumno->apellidos).' '.ucwords($proceso->alumno->nombres) }}</td>


            <!--Trabajos Prácticos-->
            @foreach($cargo->calificacionesTPByCargoByMateria($materia->id) as $calificacion)
            <td>
                @if(count($calificacion->procesosCalificacionByAlumno($proceso->alumno->id)) > 0)
                {{number_format($calificacion->procesosCalificacionByAlumno($proceso->alumno->id)[0]->porcentaje, 2, '.', ',').'%' }}
                @php
                $suma+=$calificacion->procesosCalificacionByAlumno($proceso->alumno->id)[0]->porcentaje;
                $sumaNota+=$calificacion->procesosCalificacionByAlumno($proceso->alumno->id)[0]->nota;
                @endphp
                @else
                -
                @endif
            </td>
            @endforeach


            <!--Parciales-->

            <td>
                @foreach($cargo->calificacionesParcialByCargoByMateria($materia->id) as $calificacionP)
                {{number_format($calificacionP->obtenerParcial($proceso->alumno->id), 2, '.', ',')}}
                @php
                $pparcial = $calificacionP->obtenerParcial($proceso->alumno->id);
                @endphp
                @endforeach
            </td>
            <td>
                @php
                $p70 = 0;
                if($cant > 0) $p70 = ($suma/$cant * 0.7);

                $pfinal =($pparcial * 0.3) + $p70
                @endphp
                {{number_format($pfinal, 2, '.', ',') !=0 ? number_format($pfinal, 2, '.', ',').'%' :  '-'}}
            </td>
            <td>
                @php
                $p70 = 0;
                if($cant > 0) $p70 = ($sumaNota/$cant * 0.7);

                $pfinal =($pparcial * 0.3) + $p70
                @endphp
                {{number_format($pfinal, 2, '.', ',') != 0 ? number_format($pfinal, 2, '.', ',') : '-'}}
            </td>

        </tr>
        @endforeach
    </tbody>
</table>