<tr>
    <td>
        {{ $materia->nombre }}
    </td>

    <td>
        @if($materia->mesas)
        @foreach($materia->mesas as $mesa)
            @if($mesa->instancia_id == $instancia->id && $mesa->fecha)
                <div class="d-block" style="font-size:0.9em">
                @if($mesa->comision_id)
                    <span>{{$mesa->comision->nombre}}:</span>
                @endif
                <small style="font-size:0.9em">
                        {{date_format(new DateTime($mesa->fecha),'d-m-Y H:i')}}
                </small>
                </div>
                
            @endif
        @endforeach
        @endif

    </td>
    <td>
    @if($materia->mesas)
        @foreach($materia->mesas as $mesa)
            @if($mesa->instancia_id == $instancia->id && $mesa->fecha_segundo)
                <div class="d-block" style="font-size:0.9em">
                @if($mesa->comision_id)
                    <span>{{$mesa->comision->nombre}}:</span>
                @endif
                <small style="font-size:0.9em">
                        {{date_format(new DateTime($mesa->fecha_segundo),'d-m-Y H:i')}}
                </small>
                </div>
                
            @endif
        @endforeach
        @endif
    </td>

    <td>
        @if($instancia->tipo == 0)
            <a class="btn btn-sm btn-warning open_modal" data-bs-toggle="modal" data-bs-target="#exampleModal{{$materia->id}}" data-materia_id="{{$materia->id}}" data-instancia_id="{{$instancia->id}}" {{ !Session::get('admin') ? 'disabled':'' }}>Configurar mesa</a>
                <a class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#comisiones{{$materia->id}}">Ver inscriptos</a>
                @include('includes.mesas.mesa_comision')
         
            
            @include('includes.mesas.config_mesa')
        @else
            <a class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal{{$materia->id}}" {{ !Session::get('admin') ? 'disabled':'' }}>Configurar mesa</a>

                <a class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#comisiones{{$materia->id}}">Ver inscriptos</a>
                @include('includes.mesas.mesa_comision')
           

            @include('includes.mesas.config_mesa')
        @endif

    </td>

</tr>
</tr>