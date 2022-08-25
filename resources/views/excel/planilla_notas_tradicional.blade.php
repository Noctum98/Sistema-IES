<table>
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
            <th>
                Alumno
            </th>
            @if(count($calificaciones) > 0)
                @foreach($calificaciones as $calificacion)
                <th>{{$calificacion->nombre}}</th>
                @endforeach
            @else
            <th>
                Notas
            </th>
            @endif
            <th>Promedio Final TP</th>

            <th>Asistencia %</th>
            @if($carrera->tipo == 'tradicional2')
            <th>Asistencia Presencial</th>
            <th>Asistencia Virtual</th>
            @endif
            <th>
                Estado
            </th>
            <th>Nota Global</th>
           
            <th>
                Cierre
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($procesos as $proceso)
        <tr>
            <td>
                {{$proceso->alumno->apellidos}}, {{$proceso->alumno->nombres}}
            </td>
            @if(count($calificaciones) > 0)
            @foreach($calificaciones as $cc)
            <td>

                @if($proceso->procesoCalificacion($cc->id))
                <span class="{{ $proceso->procesoCalificacion($cc->id)->porcentaje >= 60 ? 'text-success' : 'text-danger' }}">
                    {{$proceso->procesoCalificacion($cc->id)->porcentaje != -1 ? $proceso->procesoCalificacion($cc->id)->porcentaje : 'A'}}
                </span>
                @if($proceso->procesoCalificacion($cc->id)->porcentaje > 0)
                %
                @endif

                @if($proceso->procesoCalificacion($cc->id)->porcentaje_recuperatorio)
                <span class="{{ $proceso->procesoCalificacion($cc->id)->porcentaje_recuperatorio >= 60 ? 'text-success' : 'text-danger' }}">
                    - R: {{$proceso->procesoCalificacion($cc->id)->porcentaje_recuperatorio}}
                </span>
                @if(is_numeric($proceso->procesoCalificacion($cc->id)->porcentaje_recuperatorio))
                %
                @endif
                @endif
                @else
                -
                @endif
            </td>
            @endforeach
            @else
            <td>
                -
            </td>
            @endif

            @if($proceso->final_trabajos && $proceso->final_trabajos >=4)
            <td style="color:#025827">
                {{ $proceso->final_trabajos ?? '-' }}
            </td>
            @else
            <td style="color:red">
                {{ $proceso->final_trabajos ?? '-' }}
            </td>
            @endif

            <td>{{ $proceso->asistencia() ? $proceso->asistencia()->porcentaje_final : '-' }}%</td>
            @if($carrera->tipo == 'tradicional2')
            <td>{{ $proceso->asistencia() ? $proceso->asistencia()->porcentaje_presencial : '-' }}%</td>
            <td>{{ $proceso->asistencia() ? $proceso->asistencia()->porcentaje_virtual : '-' }}%</td>
            @endif
            <td>
                {{$proceso->estado_id ? $proceso->estado->nombre : 'Sin asignar'}}
            </td>
            
            @if($proceso->nota_global && $proceso->nota_global >=4)
            <td style="color:#025827">
                {{$proceso->nota_global ?? '-'}}
            </td>
            @else
            <td style="color:red">
                {{$proceso->nota_global ?? '-'}}
            </td>
            @endif
            <td>
                {{ $proceso->cierre ? 'Proceso cerrado' : 'Proceso abierto' }}
            </td>

        </tr>
        @endforeach
    </tbody>
</table>