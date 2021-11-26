<tr>
    <td>
        {{ $materia->nombre }}
    </td>
    @if($instancia->tipo == 0)
    <td>
        @if($materia->mesas)
        @if($materia->mesa($instancia->id,$materia->id) && $materia->mesa($instancia->id,$materia->id)->fecha)
        <strong>
            {{
                date_format(new DateTime($materia->mesa($instancia->id,$materia->id)->fecha),
                'd-m-Y H:i:s'
            )}}
        </strong>
        @endif
        @endif
    </td>
    <td>
        @if($materia->mesas)
        @if($materia->mesa($instancia->id,$materia->id) && $materia->mesa($instancia->id,$materia->id)->fecha_segundo)
        <strong>
            {{
                date_format(new DateTime($materia->mesa($instancia->id,$materia->id)->fecha_segundo),
                'd-m-Y H:i:s'
            )}}
        </strong>
        @endif
        @endif
    </td>
    <td>
        @if($instancia->tipo == 0)
        @if($materia->mesas)
        @if($materia->mesa($instancia->id,$materia->id))
        <a href="{{route('mesa.descargar',['id'=>$materia->mesa($instancia->id,$materia->id)->id])}}" class="btn-sm btn-success">Descargar excel</a>
        @include('includes.mesas.edit_mesa')
        @else
        <a href="{{route('mesa.descargar',['id'=>$materia->id])}}" class="btn-sm btn-warning" data-toggle="modal" data-target="#exampleModal{{$materia->id}}">Configurar mesa</a>
        @endif
        @endif
        @include('includes.mesas.config_mesa')
        @else
        <a href="{{route('mesa.descargar',['id'=>$materia->id])}}" class="btn-sm btn-success">Descargar excel</a>
        @endif
    </td>
    @endif
</tr>