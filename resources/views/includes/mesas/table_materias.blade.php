<tr>
    <td>
        {{ $materia->nombre }}
    </td>
    @if($instancia->tipo == 0)
    @if($materia->mesas)
    <td>
        @if(count($materia->mesas) == 0)
        <strong>
            Sin configurar
        </strong>
        @elseif(count($materia->mesas) > 0)
        @foreach($materia->mesas as $mesa)
        @if($mesa->instancia_id == $instancia->id && $mesa->fecha)
        <strong>
            {{date_format(new DateTime($mesa->fecha), 'd-m-Y H:i:s')}}
        </strong>
        @elseif($mesa->instancia_id == $instancia->id && !$mesa->fecha)
        <strong>
            Sin configurar
        </strong>
        @else
        <strong>
            Sin configurar
        </strong>
        @endif
        @endforeach
        @endif
    </td>
    <td>
        @if(count($materia->mesas) == 0)
        <strong>
            Sin configurar
        </strong>
        @elseif(count($materia->mesas) > 0)
        @foreach($materia->mesas as $mesa)
        @if($mesa->instancia_id == $instancia->id && $mesa->fecha_segundo)
        <strong>
            {{date_format(new DateTime($mesa->fecha_segundo), 'd-m-Y H:i:s')}}
        </strong>
        @elseif($mesa->instancia_id == $instancia->id && !$mesa->fecha_segundo)
        <strong>
            Sin configurar
        </strong>
        @else
        <strong>
            Sin configurar
        </strong>
        @endif
        @endforeach
        @endif
    </td>
    @endif
    @endif
    <td>
        @if($instancia->tipo == 0)
        @foreach($materia->mesas as $mesa)
        <a href="{{route('mesa.inscriptos',['id'=>$mesa->id])}}" class="btn-sm btn-secondary">Ver inscriptos</a>
        @if(Auth::user()->rol == 'rol_admin')
        <a href="{{route('mesa.inscriptos',['id'=>$mesa->id])}}" data-toggle="modal" data-target="#editModal{{$materia->id}}" class="btn-sm btn-primary">Editar mesa</a>
        @endif       
        @endforeach

        @if(($materia->mesas && count($materia->mesas)==0) || !$materia->mesas)
        <a href="{{route('mesa.inscriptos',['id'=>$materia->id])}}" class="btn-sm btn-warning" data-toggle="modal" data-target="#exampleModal{{$materia->id}}">Configurar mesa</a>
        @elseif($materia->mesas && count($materia->mesas)>0)

        @include('includes.mesas.edit_mesa')

        @foreach($materia->mesas as $mesa)
        @if($mesa->instancia_id == $instancia->id && !$mesa->fecha)
        <a href="{{route('mesa.inscriptos',['id'=>$mesa->id])}}" class="btn-sm btn-warning" data-toggle="modal" data-target="#exampleModal{{$materia->id}}">Configurar mesa</a>
        @endif
        @endforeach
        @else
        <a href="{{route('mesa.inscriptos',['id'=>$mesa->id])}}" class="btn-sm btn-success">Descargar excel</a>
        @endif
        @include('includes.mesas.config_mesa')
        @else
        <a href="{{route('mesa.inscriptos',['id'=>$materia->id])}}" class="btn-sm btn-success">Descargar excel</a>
        @endif
    </td>
</tr>