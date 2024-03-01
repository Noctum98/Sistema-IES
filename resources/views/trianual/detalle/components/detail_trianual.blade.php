<div class="col-md-12 mt-5">

    @if(count($detalles) > 0)

        <div class="table-responsive">
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">Materia</th>
                    <th scope="col">Condición</th>
                    <th scope="col" title="Equivalencia">Equi.</th>
                    <th scope="col">Proceso</th>
                    <th scope="col" class="text-center"><i class="fa fa-cogs"></i></th>
                </tr>
                </thead>
                <tbody>

                <tr>
                    <td colspan="5">1er Año</td>
                </tr>
                @foreach($detalles as $detalle)

                    @if($detalle->getMateria()->año == 1)
                        <tr>
                            <td>
                                {{$detalle->getMateria()->nombre}}
                            </td>
                            <td>{{$detalle->getCondicion()->nombre}}</td>
                            <td>
                                @if($detalle->getEquivalencia())
                                    {{$detalle->getEquivalencia()->nota}}
                                @else
                                    <i class='fa fa-minus'></i>
                                @endif
                            </td>
                            <td>
                                @if($detalle->proceso_id)
                                    {{--                            {{$detalle->proceso_id}}--}}
                                    <button class="btn btn-sm btn-info">Ver Proceso</button>
                                @else
                                    <i class='fa fa-minus'></i>
                                @endif
                            </td>
                        </tr>
                    @endif

                @endforeach
                <tr>
                    <td colspan="5" class="text-left text-black">
                        <strong>Observaciones 1<sup>er</sup> año </strong> <br/>
                        <p class="text-right">{!! $trianual->getObservacionesByYear(1) !!}</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">2do Año</td>
                </tr>
                @foreach($detalles as $detalle)

                    @if($detalle->getMateria()->año == 2)
                        <tr>
                            <td>
                                {{$detalle->getMateria()->nombre}}
                            </td>
                            <td>{{$detalle->getCondicion()->nombre}}</td>
                            <td>
                                @if($detalle->getEquivalencia())
                                    {{$detalle->getEquivalencia()->nota}}
                                @else
                                    <i class='fa fa-minus'></i>
                                @endif
                            </td>
                            <td>
                                @if($detalle->proceso_id)
                                    {{--                            {{$detalle->proceso_id}}--}}
                                    <button class="btn btn-sm btn-info">Ver Proceso</button>
                                @else
                                    <i class='fa fa-minus'></i>
                                @endif
                            </td>
                        </tr>
                    @endif

                @endforeach
                <tr>
                    <td colspan="5" class="text-left text-black">
                        <strong>Observaciones 2<sup>do</sup> año </strong> <br/>
                        <p class="text-right">{!! $trianual->getObservacionesByYear(2) !!}</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">3er Año</td>
                </tr>
                @foreach($detalles as $detalle)

                    @if($detalle->getMateria()->año == 3)
                        <tr>
                            <td>
                                {{$detalle->getMateria()->nombre}}
                            </td>
                            <td>{{$detalle->getCondicion()->nombre}}</td>
                            <td>
                                @if($detalle->getEquivalencia())
                                    {{$detalle->getEquivalencia()->nota}}
                                @else
                                    <i class='fa fa-minus'></i>
                                @endif
                            </td>
                            <td>
                                @if($detalle->proceso_id)
                                    {{--                            {{$detalle->proceso_id}}--}}
                                    <button class="btn btn-sm btn-info">Ver Proceso</button>
                                @else
                                    <i class='fa fa-minus'></i>
                                @endif
                            </td>
                        </tr>
                    @endif

                @endforeach
                <tr>
                    <td colspan="5" class="text-left text-black">
                        <strong>Observaciones 3<sup>er</sup> año </strong> <br/>
                        <p class="text-right">{!! $trianual->getObservacionesByYear(3) !!}</p>
                    </td>
                </tr>
                </tbody>
            </table>

        </div>

    @else
        <div class="col-sm-12">
            <h4 class="text-secondary text-center">No se han cargado materias en el trianual</h4>
        </div>
    @endif


</div>
