<style>
    thead th {
        position: sticky;
        z-index: 1;
        top: 0;
    }

    table thead tr th:first-child,
    table tbody tr td:first-child {
        width: 30%;
    }

    table th, td {
        font-size: 0.9em !important;
        vertical-align: center;
    }

    /*table {*/
    /*    table-layout: fixed;*/
    /*    word-wrap: break-word;*/
    /*}*/

    /*table th, table td {*/
    /*    overflow: hidden;*/
    /*}*/

    /*.table td, .table th {*/
    /*    min-width: 100px;*/
    /*}*/

</style>
<div class="container" id="container-scroll">
    <div class="tableFixHead">
        <div class="col-sm-12">
            {{$alumno->nombre}} {{$alumno->apellidos}}, DU: {{$alumno->dni}}
        </div>
        @foreach($cargos as $cargo )
            @php
                $suma=0;
                $cant=count($cargo->calificacionesTPByCargoByMateria($materia->id));
                $pparcial = 0;
            @endphp
            <table class="table table-striped">
                <colgroup>
                    <col class="col-md-3">
                    @foreach($cargo->calificacionesTPByCargoByMateria($materia->id) as $calificacion)
                        <col class="col-">
                    @endforeach
                    <col class="col-">
                    <col class="col-">
                    <col class="col-">

                </colgroup>
                <thead>
                <tr>
                    <th scope="col">
                        Cargo
                    </th>
                    @foreach($cargo->calificacionesTPByCargoByMateria($materia->id) as $calificacion)
                        <th scope="col">{{$calificacion->nombre}}</th>
                    @endforeach
                    <th>% x̄</th>
                    <th>Parcial</th>
                    <th>% Final</th>
                </tr>
                </thead>
                <tbody>
                <tr>

                    <td>
                        {{$cargo->nombre}}
                    </td>

                    @foreach($cargo->calificacionesTPByCargoByMateria($materia->id) as $calificacion)
                        <td>

                            @if(count($calificacion->procesosCalificacionByAlumno($alumno->id)) > 0)
                                {{$calificacion->procesosCalificacionByAlumno($alumno->id)[0]->porcentaje}}
                                @php
                                    $suma+=$calificacion->procesosCalificacionByAlumno($alumno->id)[0]->porcentaje;
                                @endphp
                            @else
                                -
                            @endif
                        </td>
                    @endforeach
                    <td>{{$suma/$cant}}</td>
                    <td>
                        @foreach($cargo->calificacionesParcialByCargoByMateria($materia->id) as $calificacionP)
                            {{$calificacionP->obtenerParcial($alumno->id)}}
                            @php
                                $pparcial = $calificacionP->obtenerParcial($alumno->id);
                            @endphp
                        @endforeach
                    </td>
                    <td>
                        @php
                            $pfinal =($pparcial * 0.3) + ($suma/$cant * 0.7)
                        @endphp
                        {{$pfinal}}
                    </td>
                </tr>

                </tbody>
            </table>
        @endforeach
    </div>
</div>