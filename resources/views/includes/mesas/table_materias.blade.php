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
            <a href="{{route('mesa.inscriptos',['id'=>$materia->mesa($instancia->id,$materia->id)->id])}}" class="btn-sm btn-secondary">Ver inscriptos</a>
            @if(Session::has('admin'))
            <a href="{{route('mesa.inscriptos',['id'=>$materia->mesa($instancia->id,$materia->id)->id])}}" data-toggle="modal" data-target="#editModal{{$materia->id}}" class="btn-sm btn-primary">Editar mesa</a>
            @endif
            @include('includes.mesas.edit_mesa')
            @else
            <a href="{{route('mesa.inscriptos',['id'=>$materia->id])}}" class="btn-sm btn-warning" data-toggle="modal" data-target="#exampleModal{{$materia->id}}">Configurar mesa</a>
            @endif
            @endif
            @include('includes.mesas.config_mesa')
        @else
        <a href="{{route('mesa.inscriptos',['id'=>$mesa->id,'instancia_id'=>$instancia->id])}}" class="btn-sm btn-secondary">Ver inscriptos</a>
        @endif
    </td>
    @endif
    <td>
    
        <a href="{{route('mesa.especial.inscriptos',['id'=>$materia->id,'instancia_id'=>$instancia->id])}}" class="btn btn-sm btn-secondary">Ver inscriptos</a>

    </td>
</tr>
</tr>