<table>
    <thead>
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
            <th>
                Estado
            </th>
            <th>
                Nota Final
            </th>
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
                @if($proceso->procesoCalificacion($cc->id)->porcentaje >= 60 )
                 <span style="color:#025827"> {{$proceso->procesoCalificacion($cc->id)->porcentaje}}</span>
                @else
                <span style="color:red"> {{$proceso->procesoCalificacion($cc->id)->porcentaje}}</span>
                @endif
                @if(is_numeric($proceso->procesoCalificacion($cc->id)->porcentaje))
                %
                @endif
                @else
                -
                @endif


            </td>

            {{-- <td>{{$calificacion->nombre}}</td>--}}


            {{-- @if($proceso->procesosCalificaciones())--}}
            {{-- @foreach($proceso->procesosCalificaciones() as $calificacion)--}}
            {{-- <td>--}}
            {{-- {{$calificacion->id}} ({{$calificacion->nombre}})--}}
            {{-- / {{$cc->id}}({{$cc->nombre}}) /--}}

            {{-- @if($calificacion->id == $cc->id)--}}

            {{-- {{$calificacion->porcentaje}}--}}

            {{-- @endif--}}
            {{-- </td>--}}
            {{-- @endforeach--}}
            {{-- @endif--}}
            @endforeach
            @else
            <td>
                -
            </td>
            @endif

            <td>
                {{$proceso->estado_id ? $proceso->estado->nombre : 'Sin asignar'}}
            </td>
            @if($proceso->final_calificaciones && $proceso->final_calificaciones >=4)
            <td style="color:#025827">
                {{$proceso->final_calificaciones ? $proceso->final_calificaciones : 'Sin asignar'}}
            </td>
            @else
            <td style="color:red">
                {{$proceso->final_calificaciones ? $proceso->final_calificaciones : 'Sin asignar'}}
            </td>
            @endif
            <td>
                {{ $proceso->cierre ? 'Proceso cerrado' : 'Proceso abierto' }}
            </td>

        </tr>
        @endforeach
    </tbody>
</table>