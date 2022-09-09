<style>
    thead th {
        position: sticky;
        z-index: 1;
        top: 0;
    }

    table thead tr th:first-child,
    table.f30 tbody tr td:first-child {
        width: 25%;
    }
</style>
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
                    @foreach($cargo->calificacionesTPByCargoByMateria($materia->id) as $calificacion)
                        <col class="col-">
                    @endforeach
                    <col class="col-">
                    <col class="col-">
                    <col class="col-">
                </colgroup>
                <thead>
                <tr>
                    <th scope="col">Cargo</th>
                    @foreach($cargo->calificacionesTPByCargoByMateria($materia->id) as $calificacion)
                        <th scope="col">{{$calificacion->nombre}}</th>
                    @endforeach
                    <th>% x̄</th>
                    <th>% Asist.</th>
                    <th>Parcial</th>
                    <th>% Final</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        {{$cargo->nombre}} (x̄ = {{$cargo->ponderacion($materia->id)}} %)
                    </td>
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
                    <td>
                        {{optional(optional($proceso->procesoRelacionado()->first()->asistencia())->getByAsistenciaCargo($cargo->id))->porcentaje }} %
                    </td>
                    <td>
                        @foreach($cargo->calificacionesParcialByCargoByMateria($materia->id) as $calificacionP)
                            {{number_format($calificacionP->obtenerParcial($alumno->id), 2, '.', ',')??'-'}}
                            @php
                                $pparcial = $calificacionP->obtenerParcial($alumno->id);
                            @endphp
                        @endforeach
                    </td>
                    <td>
                        @php
                            $p70 = 0;
                            if($cant > 0) $p70 = ($suma/$cant * 0.7);

                                $pfinal =($pparcial * 0.3) + $p70
                        @endphp
                        {{number_format($pfinal, 2, '.', ',')}}
                    </td>
                </tr>
                </tbody>
            </table>
        @endforeach

</div>
