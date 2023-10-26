<div class="container-fluid border border-info border-top-0" id="container-scroll">
    <div class="col-sm-12">
        {{--            {{$alumno->nombre}} {{$alumno->apellidos}}, DU: {{$alumno->dni}}--}}
    </div>
    @foreach($cargos as $cargo )

        <table class="table table-striped f30">
            <colgroup>
                <col class="col-sm-2">
                <col class="col-sm-1">
                <col class="col-sm-2">
                <col class="col-">
                <col class="col-">
                <col class="col-">
                <col class="col-sm-1">
                <col class="col-sm-1">
                <col class="col-sm-1">
            </colgroup>
            <thead>
            <tr>
                <th scope="col">Cargo</th>
                <th scope="col">
                    <abbr title="Porcentaje de Actividades Aprobadas">
                        % Act. Ap.
                    </abbr>
                </th>
                <th class="border border-1 border-right">
                    <abbr title="Trabajos Prácticos">
                        TP's
                    </abbr>
                </th>
                <th>
                    <abbr title="Nota Promedio Trabajos Prácticos">
                        N TPs x̄
                    </abbr>
                </th>
                <th class="border border-1 border-right">
                    <abbr title="Parciales">
                        P's
                    </abbr>
                </th>
                <th>
                    <abbr title="Nota Promedio Parciales">
                        N Ps x̄
                    </abbr>
                </th>
                <th>
                    <abbr title="Nota Final">
                        N Final
                    </abbr>
                </th>
                <th>
                    <abbr title="Porcentaje de asistencia">% Asist.</abbr></th>
                <th>Cerrado</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                {{-- Columna cargo --}}
                <td>
                    {{$cargo->nombre}} (x̄ = {{$cargo->ponderacion($materia->id)}} %)
                </td>
                {{-- Columna Porcentaje de Actividades Aprobadas --}}
                <td>
                    {{number_format($proceso->obtenerPorcentajeActividadesAprobadasPorMateriaCargo($materia->id, $cargo->id, $ciclo_lectivo) , 2, '.', ',')}}
                    %
                </td>
                {{-- Columna Trabajos Prácticos --}}
                <td>
                    <button class="btn-info" data-bs-toggle="modal"
                            data-bs-target="#tp-{{$proceso->procesoRelacionado()->first()->id}}-{{$cargo->id}}">
                        Ver Trabajos Prácticos
                    </button>
                    <div class="modal fade" id="tp-{{$proceso->procesoRelacionado()->first()->id}}-{{$cargo->id}}"
                         tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title text-dark" id="exampleModalLabel">Trabajos prácticos</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body ">
                                    <div class="container-fluid">
                                        <div class="row">

                                            <table
                                                class="table-responsive-sm table-striped table-bordered border-secondary table-success ms-auto text-center">
                                                <colgroup>
                                                    @foreach($cargo->calificacionesTPByCargoByMateria($materia->id, $ciclo_lectivo) as $calificacion)
                                                        <col class="p-2">
                                                    @endforeach
                                                </colgroup>
                                                <thead class="thead-dark text-white">
                                                @foreach($cargo->calificacionesTPByCargoByMateria($materia->id, $ciclo_lectivo) as $calificacion)
                                                    <th scope="col" class="p-2"><h5>   {{$calificacion->nombre}}</h5>
                                                    </th>
                                                @endforeach
                                                </thead>
                                                <tbody>

                                                @foreach($cargo->calificacionesTPByCargoByMateria($materia->id, $ciclo_lectivo) as $calificacion)
                                                    <td class="p-2">
                                                        <h6>
                                                            {{--                                                            {{$calificacion->procesosCalificacionByProceso($proceso->procesoRelacionado()->first()->id)}}--}}
                                                            @if(count($calificacion->procesosCalificacionByProceso($proceso->procesoRelacionado()->first()->id)) > 0)

                                                                @if($calificacion->procesosCalificacionByProceso($proceso->procesoRelacionado()->first()->id)[0]->nota >= 0)
                                                                    @colorAprobado(number_format($calificacion->procesosCalificacionByProceso($proceso->procesoRelacionado()->first()->id)[0]->nota,
                                                                    2, '.', ',') )

                                                                @endif
                                                                @if($calificacion->procesosCalificacionByProceso($proceso->procesoRelacionado()->first()->id)[0]->nota == -1)
                                                                    A

                                                                @endif
                                                            @else
                                                                -
                                                            @endif
                                                        </h6>
                                                    </td>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
                {{-- Columna Nota Promedio Trabajos Prácticos --}}
                <td>
                    @if($cargo->getCargoProceso($proceso->procesoRelacionado()->first()->id))
                        @colorAprobado(number_format($cargo->getCargoProceso($proceso->procesoRelacionado()->first()->id)->nota_tp
                        , 2, '.', ','))
                    @else
                        -
                    @endif
                </td>
                {{-- Columna Parciales --}}
                <td>
                    <button class="btn-info" data-bs-toggle="modal"
                            data-bs-target="#parcial-{{$proceso->procesoRelacionado()->first()->id}}-{{$cargo->id}}">
                        Ver Parciales
                    </button>
                    <div class="modal fade " id="parcial-{{$proceso->procesoRelacionado()->first()->id}}-{{$cargo->id}}"
                         tabindex="-1" role="dialog" aria-labelledby="parcialModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl bg-light" role="document">
                            <div class="modal-header">
                                <h5 class="modal-title text-dark" id="parcialModalLabel">Parciales</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body ">
                                <div class="container-fluid">
                                    <div class="row">
                                        <table
                                            class="table-responsive-sm table-striped table-bordered border-secondary table-success ms-auto text-center">
                                            <colgroup>
                                                @foreach($cargo->calificacionesParcialByCargoByMateria($materia->id, $ciclo_lectivo) as $calificacion)
                                                    <col class="p-2">
                                                @endforeach
                                            </colgroup>
                                            <thead class="thead-dark text-white">
                                            @foreach($cargo->calificacionesParcialByCargoByMateria($materia->id, $ciclo_lectivo) as $calificacion)
                                                <th scope="col" class="p-2"><h5>   {{$calificacion->nombre}}</h5></th>
                                                <th scope="col" class="p-2"><h5>   {{$calificacion->nombre}} <small>Recuperatorio</small>
                                                    </h5></th>
                                            @endforeach
                                            </thead>
                                            <tbody class="bg-light">

                                            @foreach($cargo->calificacionesParcialByCargoByMateria($materia->id, $ciclo_lectivo) as $calificacion)
                                                <td class="p-2"><h6>
                                                        @if(count($calificacion->procesosCalificacionByProceso($proceso->procesoRelacionado()->first()->id)) > 0)

                                                            @if($calificacion->procesosCalificacionByProceso($proceso->procesoRelacionado()->first()->id)[0]->nota >= 0)
                                                                @colorAprobado(number_format($calificacion->procesosCalificacionByProceso($proceso->procesoRelacionado()->first()->id)[0]->nota,
                                                                2, '.', ',') )
                                                            @endif
                                                            @if($calificacion->procesosCalificacionByProceso($proceso->procesoRelacionado()->first()->id)[0]->nota == -1)
                                                                A
                                                            @endif
                                                        @else
                                                            -
                                                        @endif
                                                    </h6>
                                                </td>
                                                <td class="p-2"><h6>
                                                        @if(count($calificacion->procesosCalificacionByProceso($proceso->procesoRelacionado()->first()->id)) > 0)

                                                            @if($calificacion->procesosCalificacionByProceso($proceso->procesoRelacionado()->first()->id)[0]->nota_recuperatorio >= 0)
                                                                @if(is_numeric($calificacion->procesosCalificacionByProceso($proceso->procesoRelacionado()->first()->id)[0]->nota_recuperatorio))

                                                                    @colorAprobado(number_format($calificacion->procesosCalificacionByProceso($proceso->procesoRelacionado()->first()->id)[0]->nota_recuperatorio,
                                                                    2, '.', ',') )
                                                                @else
                                                                    {{$calificacion->procesosCalificacionByProceso($proceso->procesoRelacionado()->first()->id)[0]->nota_recuperatorio}}

                                                                @endif
                                                            @endif
                                                            @if($calificacion->procesosCalificacionByProceso($proceso->procesoRelacionado()->first()->id)[0]->nota_recuperatorio == -1)
                                                                A
                                                            @endif
                                                        @else
                                                            -
                                                        @endif
                                                    </h6>
                                                </td>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
                {{-- Nota Promedio Parciales --}}
                <td>
                    @if($cargo->getCargoProceso($proceso->procesoRelacionado()->first()->id))
                        @colorAprobado(number_format($cargo->getCargoProceso($proceso->procesoRelacionado()->first()->id)->nota_ps
                        , 2, '.', ','))
                    @else
                        -
                    @endif
                </td>
                {{-- Columna Nota Final --}}
                <td>
                    @colorAprobado(number_format($cargo->getCargoProceso($proceso->procesoRelacionado()->first()->id)->nota_cargo,
                    2, '.', ','))
                    <br/>
                    <small>

                        {{number_format($cargo->getCargoProceso($proceso->procesoRelacionado()->first()->id)->nota_ponderada, 2, '.', ',')}}

                    </small>
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
