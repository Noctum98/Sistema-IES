<div class="table-responsive tableFixHead">
    <table class="table mt-4" aria-describedby="tabla de notas del cargo">
        <thead class="thead-dark ">
        <tr>
            <th>
                Alumno
            </th>
            @if(count($calificaciones) > 0)
                @foreach($calificaciones as $calificacion)
                    @if($calificacion->tipo()->first()->descripcion == 2)
                        <th class="text-center">
                        <span
                            class="text-white" title="{{$calificacion->description}}"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                        >
                            {{$calificacion->nombre}}
                        </span>
                        </th>
                    @endif
                @endforeach
                @foreach($calificaciones as $calificacion)
                    @if($calificacion->tipo()->first()->descripcion == 1)
                        <th class="text-center">
                        <span
                            class="text-white" title="{{$calificacion->description}}"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                        >
                            {{$calificacion->nombre}}
                        </span>
                        </th>
                    @endif
                @endforeach
            @else
                <th class="text-center">
                    -
                </th>
            @endif
            <th class="text-center">
                <span
                    class="text-white">
                    Asistencia %
                </span>
            </th>
            <th class="text-center">N. Final /<br/>
                <small style="font-size: 0.8em">
                    (Ponderación {{$ponderacion}}%)
                </small>
            </th>
            @foreach($calificaciones as $calificacion)
                @if($calificacion->tipo()->first()->descripcion == 3)
                    <th class="text-center">
                        <span
                            class="text-white" title="{{$calificacion->description}}"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                        >
                            {{$calificacion->nombre}}
                        </span>
                    </th>
                @endif
            @endforeach
            <th>
                <small>
                    Cierre
                </small>
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($procesos as $proceso)
            <tr>
                <td>
                    {{$proceso->alumno->apellidos}}, {{$proceso->alumno->nombres}}
                    @if(Session::has('admin'))
                        <br/>
                        <small>#{{$proceso->id}}</small>
                    @endif
                </td>
                @if(count($calificaciones) > 0)
                    @foreach($calificaciones as $cc)
                        @if($cc->tipo()->first()->descripcion == 2)
                            <td class="text-center">
                                @if($cc->getProcesosCalificacionByProceso($proceso->id))
                                    <span
                                        class="text-center @classAprobado(
                                        $cc->getProcesosCalificacionByProceso($proceso->id)->nota)
                                            ">
                                            <b>
                                                {{$cc->getProcesosCalificacionByProceso($proceso->id)->nota != -1
                                            ? $cc->getProcesosCalificacionByProceso($proceso->id)->nota
                                            : 'A'}}
                                            </b>
                                    </span>
                                @else
                                    -
                                @endif
                            </td>
                        @endif
                    @endforeach
                    @foreach($calificaciones as $cc)
                        @if($cc->tipo()->first()->descripcion == 1)
                            <td class="text-center">
                                @if($cc->getProcesosCalificacionByProceso($proceso->id))
                                    <span
                                        class="text-center @classAprobado(
                                        $cc->getProcesosCalificacionByProceso($proceso->id)->nota)
                                            ">
                                            <b>
                                                {{$cc->getProcesosCalificacionByProceso($proceso->id)->nota != -1
                                            ? $cc->getProcesosCalificacionByProceso($proceso->id)->nota
                                            : 'A'}}
                                            </b>
                                        </span>
                                    @if($cc->getProcesosCalificacionByProceso($proceso->id)->nota_recuperatorio)
                                        <br/>
                                        <span
                                            class="text-center @classAprobado(
                                        $cc->getProcesosCalificacionByProceso($proceso->id)->nota_recuperatorio)
                                            ">
                                        <i>(R:
                                        {{$cc->getProcesosCalificacionByProceso($proceso->id)->nota_recuperatorio != -1
                                        ? $cc->getProcesosCalificacionByProceso($proceso->id)->nota_recuperatorio
                                        : 'A'}}
                                        )</i>
                                    </span>
                                    @endif
                                @else
                                    -
                                @endif
                            </td>
                        @endif
                    @endforeach
                @else
                    <td class="text-center">
                        -
                    </td>
                @endif

                {{-- Asistencial--}}
                <td class="text-center">
                    {{ $proceso->asistencia() ?
                    optional($proceso->asistencia()->getByAsistenciaCargo($cargo->id))->porcentaje : '-' }}
                    %
                </td>
                {{-- Nota final--}}
                <td class="text-center">
                    @if($proceso->getCargosProcesos($cargo->id))
                        {{$proceso->getCargosProcesos($cargo->id)->nota_cargo}}<br/>
                        <small
                            style="font-size: 0.8em">
                            ({{$proceso->getCargosProcesos($cargo->id)->nota_ponderada}})
                        </small>
                    @else
                        -
                    @endif
                </td>
                {{--            Nota TFI --}}
                @foreach($calificaciones as $cc)
                    @if($cc->tipo()->first()->descripcion == 3)
                        <td class="text-center">
                            @if($cc->getProcesosCalificacionByProceso($proceso->id))
                                <span
                                    class="text-center @classAprobado(
                                        $cc->getProcesosCalificacionByProceso($proceso->id)->nota)
                                            ">
                                            <b>
                                                {{$cc->getProcesosCalificacionByProceso($proceso->id)->nota != -1
                                            ? $cc->getProcesosCalificacionByProceso($proceso->id)->nota
                                            : 'A'}}
                                            </b>
                                    </span>
                            @else
                                -
                            @endif
                        </td>
                    @endif
                @endforeach

                {{--        Cierre --}}

                <td class="text-center">
                    <span>
                        @if ($proceso->cierre == 1)
                            <i class="fa fa-check text-success"></i>
                        @elseif($proceso->obtenerProcesoCargo($cargo->id))
                            @if($proceso->obtenerProcesoCargo($cargo->id)->isClose())
                                <i class="fa fa-check text-success"></i>
                            @else
                                <i class="fa fa-minus text-danger"></i>
                            @endif
                        @else
                            <i class="fa fa-minus text-danger"></i>
                        @endif
                    </span>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
