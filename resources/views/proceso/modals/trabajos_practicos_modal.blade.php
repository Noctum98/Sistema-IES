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
                                @include('componentes.colorNotas',[
    'year' => $ciclo_lectivo,
    'nota' => number_format($calificacion->procesosCalificacionByProceso($proceso->procesoRelacionado()->first()->id)[0]->nota, 2, '.', ',')
])
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
