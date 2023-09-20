<table>
    <thead>
        <tr>
            <th colspan="7" style="text-align: center;"><b>PLANILLA DE CALIFICACIONES</b></th>
        </tr>
        <tr>
            <th colspan="7" style="text-align: center;" valign="middle">
            </th>
        </tr>
        <tr>
            <th colspan="7"><b>INSTITUTO DE EDUCACION SUPERIOR 9-015 VALLE DE UCO</b></th>
        </tr>
        <tr>
            <th colspan="7"><b>UNIDAD ACADEMICA: {{$materia->carrera->sede->nombre}}</b></th>
        </tr>
        <tr>
            <th colspan="7"><b>CARRERA: {{ $materia->carrera->nombre.' ( '.ucwords($materia->carrera->turno).' )' }} </b></th>
        </tr>
        <tr>
            <th colspan="7"><b>ESPACIO CURRICULAR: {{ $materia->nombre }} </b></th>
        </tr>
        <tr>
            <th colspan="7"><b>Docentes:
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
            <th colspan="7"> <b>MODALIDAD: {{ $materia->carrera->modalidad }} </b></th>
        </tr>
        <tr>
            <th style="text-align: left;" colspan="7"><b>Ciclo Lectivo: {{ $ciclo_lectivo }} </b></th>
        </tr>
        <tr>
            <th colspan="7"><b>AÑO: {{ $materia->año }} </b></th>
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
            <td style="text-align: left;">
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