<div class="col-md-7">

    @if(count($detalles) > 0)

        <div class="table-responsive">
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">Materia</th>
                    <th scope="col">Condición</th>
                    <th scope="col">Equivalencia</th>
                    <th scope="col">Proceso</th>
                    <th scope="col" class="text-center"><i class="fa fa-cogs"></i></th>
                </tr>
                </thead>
                <tbody>

                @foreach($detalles as $detalle)
<tr>
                    <td>
                        @if($detalle->recursado == 0)
                            {{$detalle->getMateria()->nombre}}
                        @else
                            Recursado {{$detalle->recursado}}
                        @endif

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
                @endforeach
                </tbody>
            </table>

        </div>

    @else
        <div class="col-sm-12">
            <h4 class="text-secondary text-center">No se han cargado materias en el trianual</h4>
        </div>
    @endif


</div>
