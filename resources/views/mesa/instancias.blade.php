@extends('layouts.app-prueba')
@section('content')
<div class="container">
    <h5 class="text-info">
        Elige la mesa que deseas rendir
    </h5>
    @if(count($instancias) > 0)
    @foreach($instancias as $instancia)
    <a type="button" href="{{ route('mesa.mate',$instancia->id) }}" class="list-group-item list-group-item-action border-top mt-2 text-primary p-3">
        <strong>
            {{ $instancia->nombre }}
        </strong>
    </a>
    @endforeach
    @else
    <h3 class="text-secondary">No hay mesas abiertas</h3>
    @endif
    <hr>
    <h5 class="text-info">
        Historial de Inscripciones
    </h5>
    @if(count($inscripciones)>0)

    <div class="table-responsive">
        <table class="table mt-1">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Instancia</th>
                    <th scope="col">Materia</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Motivos de baja</th>
                    <th scope="col">Nota</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($inscripciones as $inscripcion)
                <tr style="cursor:pointer;">
                    <td>
                        @if($inscripcion->instancia)
                        {{$inscripcion->instancia->nombre}}
                        @else
                        @if($inscripcion->mesa)
                        {{$inscripcion->mesa->instancia->nombre}}
                        @endif
                        @endif
                    </td>
                    <td>
                        @if($inscripcion->materia_id)
                        {{ $inscripcion->materia->nombre }}
                        @elseif($inscripcion->mesa)
                        @if($inscripcion->mesa->materia)
                        {{$inscripcion->mesa->materia->nombre}}
                        @endif
                        @else
                        -
                        @endif
                    </td>
                    <td>
                        @if($inscripcion->estado_baja)
                        <span class="badge badge-danger">Dada de baja</span>
                        @elseif($inscripcion->confirmado)
                        <span class="badge badge-success">Confirmada</span>
                        @else
                        <span class="badge badge-primary">Solicitada</span>
                        @endif
                    </td>

                    <td>
                        {{ $inscripcion->estado_baja ? $inscripcion->motivo_baja : '-' }}
                    </td>

                    @if($inscripcion->acta_volante && !$inscripcion->estado_baja)
                    <td>@colorAprobado($inscripcion->acta_volante->promedio)</td>
                    @else
                    <td><span class="text-secondary">-</span></td>
                    @endif
                </tr>
                @endforeach
        </table>
    </div>
    <div class="d-flex justify-content-center" style="font-size: 0.8em">
        {{ $inscripciones->links() }}
    </div>


    @else
    <p>No te encuentras inscripto en ninguna materia </p>
    @endif
</div>
@endsection