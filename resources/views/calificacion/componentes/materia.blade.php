@foreach($cargos as $cargo)
    <div class="border border-secondary border-top-0 pl-2 pt-1">
        @foreach($cargo->materias as $materia)

            <h5>{{$cargo->nombre.' - '. $cargo->carrera->nombre.'('.$cargo->carrera->sede->nombre.')'}}</h5>
            @if(isset($materia))
                <a type="button" href="{{ route($ruta,['materia_id'=>$materia->id,'ciclo_lectivo' =>$ciclo_lectivo,'cargo_id'=>$cargo->id]) }}"
                   class="list-group-item list-group-item-action border-top mt-2 text-primary"
                   title="Ver calificaciones"
                >
                    <strong>
                        Módulo: {{ $materia->nombre.' ( '.ucwords($materia->carrera->turno).' | Res: '.$materia->carrera->resolucion.' )' }}
                    </strong>
                </a>
            @endif
        @endforeach
    </div>
@endforeach