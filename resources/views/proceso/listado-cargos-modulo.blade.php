<div class="container-fluid border border-info border-top-0" id="container-scroll">
    <div class="col-sm-12">
        {{--            {{$alumno->nombre}} {{$alumno->apellidos}}, DU: {{$alumno->dni}}--}}
    </div>
    @foreach($cargos as $cargo )
        @php
            $suma=0;
            $cant=count($cargo->calificacionesTPByCargoByMateria($materia->id));
            $pparcial = 0;
        @endphp
        <table class="table table-striped f30">
            <colgroup>
                <col class="col-md-2">
                <col class="col-">
                @foreach($cargo->calificacionesTPByCargoByMateria($materia->id) as $calificacion)
                    <col class="col-">
                @endforeach
                <col class="col-">

                <col class="col-">
                @foreach($cargo->calificacionesParcialByCargoByMateria($materia->id) as $calificacion)
                    <col class="col-">
                @endforeach
                <col class="col-">
                <col class="col-">
                <col class="col-">
            </colgroup>
            <thead>
            <tr>
                <th scope="col">Cargo</th>
                <th>TP's</th>
                @foreach($cargo->calificacionesTPByCargoByMateria($materia->id) as $calificacion)
                    <th scope="col">{{$calificacion->nombre}}</th>
                @endforeach
                <th>% x̄</th>

                <th>P's</th>

                @foreach($cargo->calificacionesParcialByCargoByMateria($materia->id) as $calificacion)
                    <th scope="col">{{$calificacion->nombre}}</th>
                @endforeach
                <th>% Final</th>
                <th>% Asist.</th>
                <th>Cerrado</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>
                    {{$cargo->nombre}} (x̄ = {{$cargo->ponderacion($materia->id)}} %)
                </td>
                <td></td>
                @foreach($cargo->calificacionesTPByCargoByMateria($materia->id) as $calificacion)
                    <td>
                        @if(count($calificacion->procesosCalificacionByAlumno($alumno->id)) > 0)
                            {{number_format($calificacion->procesosCalificacionByAlumno($alumno->id)[0]->porcentaje, 2, '.', ',') }}
                            @php
                                $suma+=$calificacion->procesosCalificacionByAlumno($alumno->id)[0]->porcentaje;
                            @endphp
                        @else
                            -
                        @endif
                    </td>
                @endforeach
                <td>
                    @if($cant > 0)
                        {{number_format($suma/$cant , 2, '.', ',')}}
                    @endif
                </td>

                <td></td>

                @foreach($cargo->calificacionesParcialByCargoByMateria($materia->id) as $calificacionP)
                    <td>
                        @if($calificacionP->obtenerParcialByProceso($proceso->procesoRelacionado()->first()->id))
                            @if($calificacionP->obtenerParcialByProceso($proceso->procesoRelacionado()->first()->id) >= 0)
                                {{number_format($calificacionP->obtenerParcialByProceso($proceso->procesoRelacionado()->first()->id), 2, '.', ',')}}
                            @endif
                              @if($calificacionP->obtenerParcialByProceso($proceso->procesoRelacionado()->first()->id) == -1)
                                A
                            @endif
                        @else
                            -
                        @endif

                        @php
                            $pparcial = $calificacionP->obtenerParcialByProceso($proceso->procesoRelacionado()->first()->id);
                        @endphp
                    </td>
                @endforeach

                <td>
                    @php
                        $p70 = 0;
                        if($cant > 0) $p70 = ($suma/$cant * 0.7);

                            $pfinal =($pparcial * 0.3) + $p70
                    @endphp
                    {{number_format($pfinal, 2, '.', ',')}}
                </td>
                <td>
                    {{optional(optional($proceso->procesoRelacionado()->first()->asistencia())->getByAsistenciaCargo($cargo->id))->porcentaje }}
                    %
                </td>
                <td>
                    @if (optional($cargo->obtenerProcesoCargo(optional($proceso->procesoRelacionado()->first())->id))->isClose())
                        <i class="fa fa-check text-success"></i>
                    @else
                        <i class="fa fa-minus text-danger"></i>
                    @endif
                </td>
            </tr>
            </tbody>
        </table>
    @endforeach

</div>
