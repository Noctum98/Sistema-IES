<div class="container-fluid border border-info border-top-0" id="container-scroll">
    <div class="col-sm-12">
        {{--            {{$alumno->nombre}} {{$alumno->apellidos}}, DU: {{$alumno->dni}}--}}
    </div>
    @foreach($cargos as $cargo )
        @php
            $suma=0;
            $suma_parcial = null;
            $cant=count($cargo->calificacionesTPByCargoByMateria($materia->id));
            $cant_parciales = count($cargo->calificacionesParcialByCargoByMateria($materia->id));
            $valor_parcial = 0;
        @endphp
        <table class="table table-striped f30">
            <colgroup>
                <col class="col-md-2">
                <col class="col-">
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
                <th scope="col">% Act. Ap.</th>
                <th class="border border-1 border-right">TP's</th>
                @foreach($cargo->calificacionesTPByCargoByMateria($materia->id) as $calificacion)
                    <th scope="col">{{$calificacion->nombre}}</th>
                @endforeach
                <th>% x̄</th>

                <th class="border border-1 border-right">P's</th>

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
                <td>
                    @if($proceso->porcentaje_actividades_aprobado)
{{--                        {{number_format($proceso->porcentaje_actividades_aprobado , 2, '.', ',')}} %--}}
                        {{$proceso->porcentaje_actividades_aprobado}} %
                    @else
                        0 %
                    @endif
                </td>
                <td class="border border-1 border-right"></td>
                @foreach($cargo->calificacionesTPByCargoByMateria($materia->id) as $calificacion)
                    <td>
                        {{--                        {{$calificacion->procesosCalificacionByProceso($proceso->procesoRelacionado()->first()->id)}}--}}
                        @if(count($calificacion->procesosCalificacionByProceso($proceso->procesoRelacionado()->first()->id)) > 0)

                            @if($calificacion->procesosCalificacionByProceso($proceso->procesoRelacionado()->first()->id)[0]->porcentaje >= 0)
                                {{number_format($calificacion->procesosCalificacionByProceso($proceso->procesoRelacionado()->first()->id)[0]->porcentaje, 2, '.', ',') }}
                                @php
                                    $sumaCalificacion = $calificacion->procesosCalificacionByProceso($proceso->procesoRelacionado()->first()->id)[0]->porcentaje
                                @endphp

                            @endif
                            @if($calificacion->procesosCalificacionByProceso($proceso->procesoRelacionado()->first()->id)[0]->porcentaje == -1)
                                A
                                @php
                                    $sumaCalificacion = 0;
                                @endphp
                            @endif
                            @php
                                if(is_numeric($sumaCalificacion)){
                                    $suma+=$sumaCalificacion;
                                    }else{
                                    $suma+= 0;
                                    }
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
                            @if($calificacionP->obtenerParcialByProceso($proceso->procesoRelacionado()->first()->id) > 0)
                                {{number_format($calificacionP->obtenerParcialByProceso($proceso->procesoRelacionado()->first()->id), 2, '.', ',')}}
                                @php
                                    $valor_parcial = $calificacionP->obtenerParcialByProceso($proceso->procesoRelacionado()->first()->id);
                                @endphp
                            @endif
                            @if($calificacionP->obtenerParcialByProceso($proceso->procesoRelacionado()->first()->id) <= 0)
                                @if($calificacionP->obtenerAusenteParcialByProceso($proceso->procesoRelacionado()->first()->id) == 'A')
                                    A

                                @else
                                    {{$calificacionP->obtenerParcialByProceso($proceso->procesoRelacionado()->first()->id)}}
                                @endif

                            @endif
                        @else
                            -
                        @endif

                        @php
                            if(is_numeric($valor_parcial)){
                                $suma_parcial+=$valor_parcial;
                                }else{
                                $suma_parcial+= 0;
                                }
                        @endphp
                    </td>
                @endforeach

                <td>
                    @inject('cargoService', 'App\Services\CargoService')
                    @php
                        $pfinal = $cargoService->calculoPorcentajeCalificacionFromBlade($cant, $suma, $cant_parciales, $suma_parcial);
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
