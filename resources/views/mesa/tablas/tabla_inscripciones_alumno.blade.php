<div class="table-responsive">
    <table class="table mt-1">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Materia</th>
                <th scope="col">Estado</th>
                <th scope="col">Motivos de baja</th>
                <th scope="col">Nota</th>
                <th scope="col"><i class="fa fa-cog" style="font-size:20px;"></i></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($inscripciones as $inscripcion)
            <tr style="cursor:pointer;">
                <td>{{ $instancia->tipo != 0 ? $inscripcion->materia->nombre : $inscripcion['mesa']['materia']['nombre'] }}</td>
                <td>
                    @if($inscripcion->estado_baja)
                    <span class="badge badge-danger">Dada de baja</span>
                    @elseif($inscripcion->confirmado)
                    <span class="badge badge-success">Confirmada</span>
                    @else
                    <span class="badge badge-primary">En revisión</span>
                    @endif
                </td>
                <td>{{ $inscripcion->estado_baja ? $inscripcion->motivo_baja : '-' }}</td>
                @if($inscripcion->acta_volante && !$inscripcion->estado_baja)
                    <td>@colorAprobado($inscripcion->acta_volante->promedio)</td>
                @else
                    <td><span class="text-secondary">-</span></td>
                @endif
                <td>
                    @if($instancia->tipo == 1)
                    <a href="{{route('mesa.baja',['id'=>$inscripcion->id,'instancia_id'=>$instancia->id])}}" class="btn btn-sm btn-danger" {{ $inscripcion->estado_baja ? 'disabled' : '' }}>Bajarme</a>
                    @else

                    @if($inscripcion->estado_baja || $inscripcion->confirmado)
                    <button class="btn btn-sm btn-danger" disabled>Bajarme</button>

                    @elseif($inscripcion['segundo_llamado'] && time() < $inscripcion['mesa']['cierre_segundo']) - <a href="{{route('mesa.baja',['id'=>$inscripcion['id'],'instancia_id'=>$instancia->id])}}" class="btn btn-sm btn-danger">Bajarme</a>
                        @elseif(!$inscripcion['segundo_llamado'] && time() < $inscripcion['mesa']['cierre']) - <a href="{{route('mesa.baja',['id'=>$inscripcion['id'],'instancia_id'=>$instancia->id])}}" class="btn btn-sm btn-danger">Bajarme</a>
                            @endif
                            @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>