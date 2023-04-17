@foreach(Auth::user()->cargo_materia()->get() as $cargo_materia)
    <div class="border border-secondary border-top-0 pl-2 pt-1">
        <a type="button"
           href="{{ route($ruta,['id'=>$cargo_materia->materia->id,'ciclo_lectivo' => $ciclo_lectivo,'cargo_id'=>$cargo_materia->cargo->id]) }}"
           class="list-group-item list-group-item-action border-top mt-2 text-success" data-bs-toggle="modal" data-bs-target="#eligeComision{{$cargo_materia->materia->id}}">
            <strong>
                {{$cargo_materia->cargo->nombre}}<br/>
                Módulo: {{ $cargo_materia->materia->nombre.' ( '.ucwords($cargo_materia->materia->carrera->turno).' | Res: '.$cargo_materia->materia->carrera->resolucion.' )' }}
            </strong>
        </a>
        @include('asistencia.modals.comisiones',['materia'=>$cargo_materia->materia])

    </div>
@endforeach
