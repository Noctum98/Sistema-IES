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
                    {{--                    (Ponderación {{$cargo->ponderacion($materia->id)}}%)--}}
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


        </tr>
        </thead>
        <tbody>
        {{--        @foreach($procesos as $proceso)--}}
        {{--            <tr>--}}
        {{--                <td>--}}
        {{--                    {{$proceso->alumno->apellidos}}, {{$proceso->alumno->nombres}}--}}
        {{--                    @if(Session::has('admin'))--}}
        {{--                        <br/>--}}
        {{--                        <small>#{{$proceso->id}}</small>--}}
        {{--                    @endif--}}
        {{--                </td>--}}
        {{--                @if(count($calificaciones) > 0)--}}
        {{--                    @foreach($calificaciones as $cc)--}}
        {{--                        <td class="text-center">--}}
        {{--                            @if($proceso->procesoCalificacion($cc->id))--}}
        {{--                                <span--}}
        {{--                                    class="text-center {{ $proceso->procesoCalificacion(--}}
        {{--    $cc->id)->porcentaje >= 60 ? 'text-success' : 'text-danger' }}">--}}
        {{--                                                <b>{{$proceso->procesoCalificacion(--}}
        {{--    $cc->id)->nota != -1 ? $proceso->procesoCalificacion($cc->id)->nota : 'A'}}</b>--}}
        {{--                                                <small class="text-center">--}}
        {{--                                                    <br/>--}}
        {{--                                                    ({{$proceso->procesoCalificacion(--}}
        {{--    $cc->id)->porcentaje != -1 ? $proceso->procesoCalificacion($cc->id)->porcentaje : '0'}}--}}
        {{--                                                    @if($proceso->procesoCalificacion(--}}
        {{--    $cc->id)->porcentaje >= 0)--}}
        {{--                                                    @endif--}}
        {{--                                                    %)--}}
        {{--                                                </small>--}}
        {{--                            </span>--}}

        {{--                                @if($proceso->procesoCalificacion($cc->id)->porcentaje_recuperatorio)--}}
        {{--                                    <span--}}
        {{--                                        class="text-center {{ $proceso->procesoCalificacion(--}}
        {{--    $cc->id)->porcentaje_recuperatorio >= 60 ? 'text-success' : 'text-danger' }}">--}}
        {{--                                                    R: <b>{{$proceso->procesoCalificacion(--}}
        {{--    $cc->id)->nota_recuperatorio}}</b>--}}
        {{--                                                    <small class="text-center">--}}
        {{--                                                        <br/>--}}
        {{--                                                        ({{$proceso->procesoCalificacion(--}}
        {{--    $cc->id)->porcentaje_recuperatorio}}--}}
        {{--                                                        @if(is_numeric($proceso->procesoCalificacion(--}}
        {{--    $cc->id)->porcentaje_recuperatorio))--}}
        {{--                                                        @endif--}}
        {{--                                                        %)--}}
        {{--                                                    </small>--}}
        {{--                            </span>--}}

        {{--                                @endif--}}
        {{--                            @else--}}
        {{--                                ---}}
        {{--                            @endif--}}
        {{--                        </td>--}}
        {{--                    @endforeach--}}
        {{--                @else--}}
        {{--                    <td class="text-center">--}}
        {{--                        ---}}
        {{--                    </td>--}}
        {{--                @endif--}}
        {{--                <td class="text-center">--}}
        {{--                    {{ $proceso->asistencia() ?--}}
        {{--                    optional($proceso->asistencia()->getByAsistenciaCargo($cargo->id))->porcentaje : '-' }}--}}
        {{--                    %--}}
        {{--                </td>--}}
        {{--                --}}{{-- Nota final--}}
        {{--                <td class="text-center">--}}
        {{--                    @if($proceso->getCargosProcesos($cargo->id))--}}
        {{--                        {{$proceso->getCargosProcesos($cargo->id)->nota_cargo}}<br/>--}}
        {{--                        <small--}}
        {{--                            style="font-size: 0.8em">--}}
        {{--                            ({{$proceso->getCargosProcesos($cargo->id)->nota_ponderada}})--}}
        {{--                        </small>--}}
        {{--                    @else--}}
        {{--                        <a href="{{route('cargo_proceso.store',--}}
        {{--                                        ['proceso_id' => $proceso->id, 'cargo_id' => $cargo->id])}}"--}}
        {{--                           class="btn btn-sm btn-primary">--}}
        {{--                            <i class="fa fa-plus" title="Por favor haga clic aquí"></i>--}}
        {{--                        </a>--}}
        {{--                    @endif--}}
        {{--                </td>--}}

        {{--                <td class="text-center">--}}
        {{--                    @if($proceso->getCargosProcesos($cargo->id))--}}
        {{--                        <a href="{{route('cargo_proceso.actualizar',--}}
        {{--['cargo_proceso' => $proceso->getCargosProcesos($cargo->id)])}}" class="btn btn-sm btn-primary">--}}
        {{--                            <i class="fa fa-upload" title="Por favor actualice haciendo clic aquí"></i>--}}
        {{--                        </a>--}}
        {{--                    @else--}}
        {{--                        <small><i class="fa fa-arrow-left"></i> </small>--}}
        {{--                    @endif--}}
        {{--                </td>--}}
        {{--                <td class="text-center">--}}
        {{--                                <span class="d-none" id="span-{{$proceso->id}}">--}}
        {{--                                    <small style="font-size: 0.6em" class="text-success">Cambio realizado</small>--}}
        {{--                                </span>--}}
        {{--                    <span class="d-none" id="spin-{{$proceso->id}}">--}}
        {{--                                    <i class="fa fa-spinner fa-spin"></i>--}}
        {{--                                </span>--}}
        {{--                    <span>--}}
        {{--                                     @if ($proceso->cierre == 1)--}}
        {{--                            <i class="fa fa-check text-success"></i>--}}
        {{--                        @else--}}
        {{--                            <label for="{{$proceso->id}}"></label>--}}
        {{--                            <input type="checkbox" class="check-cierre"--}}
        {{--                                   id="{{$proceso->id}}"--}}
        {{--                                   @if($proceso->obtenerProcesoCargo($cargo->id))--}}
        {{--                                       {{$proceso->obtenerProcesoCargo($cargo->id)->isClose() ?--}}
        {{--                                        'checked':'unchecked'}}--}}
        {{--                                   @endif--}}
        {{--                                   data-tipo="modular" data-cargo="{{$cargo->id}}"--}}
        {{--                            >--}}
        {{--                        @endif--}}
        {{--                                </span>--}}
        {{--                </td>--}}
        {{--            </tr>--}}
        {{--        @endforeach--}}
        </tbody>
    </table>
</div>
