<td>
    - {{optional($proceso->procesoRelacionado->alumno)->apellidos_nombres}}
</td>
<td class="text-center">
                                                <span id="pfn-{{$proceso->id}}" class="m-0 p-0">
                                                    @include('componentes.colorNotas',
                                                              ['year' => $proceso->ciclo_lectivo,
                                                              'nota' => $proceso->promedio_final_nota])
                                                </span>
</td>
<td class="text-center">
    {{$proceso->asistencia_final_porcentaje}} %
</td>
<td class="text-center">
    {{--    @colorAprobado($proceso->trabajo_final_nota)--}}
    @include('componentes.colorNotas',
                     ['year' => $proceso->ciclo_lectivo,
                     'nota' => $proceso->trabajo_final_nota])

</td>
<td class="text-center">
    @include('componentes.colorNotas',
                     ['year' => $proceso->ciclo_lectivo,
                     'nota' => $proceso->nota_final_nota])
</td>
<td class="row">
    <form action="" id="{{ $proceso->procesoRelacionado->id }}"
          class="form_nota_global">
        <div class="input-group">
            <input type="text"
                   class="form-control btn-sm nota_global
{{--                                                   @classAprobado($proceso->procesoRelacionado->nota_global)"--}}
                   @include('componentes.classNota',
                                                             ['year' => $proceso->procesoRelacionado->ciclo_lectivo,
                                                             'nota' => $proceso->procesoRelacionado->nota_global])"
                   id="global-{{ $proceso->procesoRelacionado->id }}"
                   value="{{ $proceso->procesoRelacionado->nota_global != -1 ?
                                                            $proceso->procesoRelacionado->nota_global : 'A' }}"
                   @if(($proceso->procesoRelacionado->estado
                        && ($proceso->procesoRelacionado->estado->identificador != 5
                        || $proceso->procesoRelacionado->estado->identificador != 7))
                        || !$puede_procesar
                        || $proceso->procesoRelacionado->cierre)
                       disabled
                @endif>
            <div class="input-group-append">
                <button type="submit"
                        class="btn btn-info btn-sm input-group-text"
                        id="btn-global-{{ $proceso->procesoRelacionado->id }}"
                        @if(!Session::has('profesor') or
                            $proceso->procesoRelacionado->cierre)
                            disabled
                    @endif>
                    <i class="fa fa-save"></i>
                </button>
            </div>
        </div>
    </form>
</td>
<td>
    <input type="checkbox" class="check-cierre"
           id="{{$proceso->procesoRelacionado->id}}"
           @if($proceso->procesoRelacionado->cierre == 1)
               checked
           @else
               unchecked
           @endif

           @if($proceso->procesoRelacionado->cierre && !Session::has('cierres'))
               disabled
        @endif
    />
</td>
