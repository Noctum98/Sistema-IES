{{--@foreach(Auth::user()->cargo_materia()->get() as $cargo_materia)--}}
    <div class="border border-secondary border-top-0 pl-2 pt-1">
        {{--                @foreach($cargo_materia->materia as $materia)--}}
        {{--{{$cargo_materia->materia->nombre}} <br/>--}}
                            <h5>{{$cargo->nombre.' - '. $cargo->carrera->nombre.'('.$cargo->carrera->sede->nombre.')'}}</h5>
{{--                            @if(isset($materia))--}}
                            <a type="button" href="{{ route($ruta,['id'=>$cargo_materia->materia->id,'cargo_id'=>$cargo_materia->cargo->id]) }}"
                               class="list-group-item list-group-item-action border-top mt-2 text-success">
                                <strong>
                                    {{$cargo_materia->cargo->nombre}}<br/>
                                    Módulo: {{ $cargo_materia->materia->nombre.' ( '.ucwords($cargo_materia->materia->carrera->turno).' | Res: '.$cargo_materia->materia->carrera->resolucion.' )' }}
                                </strong>
                            </a>
        {{--                    @endif--}}
        {{--                @endforeach--}}
    </div>
@endforeach
