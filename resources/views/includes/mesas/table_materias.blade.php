<tr>
    <td>
        {{ $materia->nombre }}
    </td>
    @if($instancia->tipo == 0)
    <td>
        @if($materia->mesas)
        @if($materia->mesa($instancia->id) && $materia->mesa($instancia->id)->fecha)
        <strong>
            {{
                date_format(new DateTime($materia->mesa($instancia->id)->fecha),
                'd-m-Y H:i:s'
            )}}
        </strong>
        @endif
        @endif
    </td>
    <td>
        @if($materia->mesas)
        @if($materia->mesa($instancia->id) && $materia->mesa($instancia->id)->fecha_segundo)
        <strong>
            {{
                date_format(new DateTime($materia->mesa($instancia->id)->fecha_segundo),
                'd-m-Y H:i:s'
            )}}
        </strong>
        @endif
        @endif
    </td>
    @endif
    <td>
        @if($instancia->tipo == 0)
        <a class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal{{$materia->id}}">Configurar mesa</a>
        <a href="{{route('mesa.inscriptos',['materia_id'=>$materia->id,'instancia_id'=>$instancia->id])}}" class="btn btn-sm btn-secondary">Ver inscriptos</a>
        @include('includes.mesas.config_mesa')
        @else
        <a href="{{route('mesa.especial.inscriptos',['id'=>$materia->id,'instancia_id'=>$instancia->id])}}" class="btn btn-sm btn-secondary">Ver inscriptos</a>
        @endif

    </td>

</tr>
</tr>