<table class="table table-striped f30">
    <thead>
        <tr>
            <th><b>UNIDAD ACADEMICA: {{$materia->carrera->sede->nombre}}</b></th>
            <th><b>CARRERA: {{ $materia->carrera->nombre.' ( '.ucwords($materia->carrera->turno).' )' }} </b></th>
            <th><b>Docentes:
                @foreach($cargos as $cargo)
                    @foreach($cargo->users as $key => $user)
                        {{ mb_strtoupper($user->apellido).' '.ucwords($user->nombre) }}
                        @if (!$loop->last)
                        -
                        @endif
                    @endforeach
                @endforeach
                </b></th>
        </tr>
        <tr>
            <th><b>MÓDULO: {{ $materia->nombre }} </b></th>
            <th> <b>RESOLUCION: {{ $materia->carrera->resolucion }} </b></th>
        </tr>
        <tr>
            <th><b>AÑO: {{ $materia->año }}
            <th style="text-align: left;"><b>Ciclo Lectivo: {{ $ciclo_lectivo }} </b></th>
        </tr>
        <tr>
            <th scope="col">Apeliido y Nombre</th>
            <th class="sticky-top text-center">Nota Proceso</th>
            <th class="sticky-top text-center">% Asist. Final</th>
            <th class="sticky-top text-center">TFI</th>
            <th class="sticky-top text-center">Nota Final</th>
            <th class="sticky-top col-sm-1">Nota Global</th>
            <th class="sticky-top col-sm-1">Regularidad</th>
        </tr>
    </thead>
    <tbody>
        @foreach($procesos as $proceso)
        @if($proceso->procesoModularOne)
        <tr>
            <td style="text-align: right;">
                {{ optional($proceso->alumno)->apellidos_nombres }}
            </td>
            <td style="text-align: right;">
                {{ $proceso->procesoModularOne->promedio_final_nota }}
            </td>
            <td style="text-align: right;">
                {{ $proceso->procesoModularOne->asistencia_final_porcentaje }} %
            </td>
            <td style="text-align: right;">
                {{ $proceso->procesoModularOne->trabajo_final_nota ? $proceso->procesoModularOne->trabajo_final_nota : '-'}}
            </td>
            <td style="text-align: right;">
                {{ $proceso->procesoModularOne->nota_final_nota ? $proceso->procesoModularOne->nota_final_nota : '-'}}
            </td>
            <td style="text-align: right;">
                {{ $proceso->procesoModularOne->nota_global ? $proceso->procesoModularOne->nota_global : '-' }}
            </td>
            <td>
                {{ $proceso->cierre ? mb_strtoupper($proceso->estado->nombre) : '-' }}
            </td>
        </tr>
        @endif
        @endforeach
    </tbody>
</table>