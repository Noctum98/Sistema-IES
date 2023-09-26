<table class="table mt-4">
    <thead class="thead-dark">
        <tr>
            <th>D.N.I</th>
            <th>Acción</th>
            <th>Carrera</th>
            <th>Materia</th>
            <th>Por equivalencia</th>
            <th>Usuario Responsable</th>
            <th>Fecha</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($registros as $registro)
        @if(!$registro->proceso->hasEquivalencia())
        <tr>
            <th><a href="{{ route('alumno.detalle',$registro->proceso->alumno_id) }}"> {{$registro->proceso->alumno->dni}} </a></th>
            <td>{{ $registro->changes == 'CREATE' || $registro->changes == 'DELETE' ? $registro->changes : 'UPDATE' }}</td>
            <td>{{ $registro->proceso->materia->carrera->nombre }}</td>
            <td>
                @if($registro->user)
                {{ $registro->user->apellido.' '.$registro->user->nombre }}
                @else
                Usuario eliminado
                @endif
            </td>
            <td>{{ $registro->updated_at->format('d-m-Y H:i') }}</td>
        </tr>
        @endif
        @endforeach
    </tbody>
</table>
<div class="d-flex justify-content-center" style="font-size: 0.8em">
    {{ $registros->links() }}
</div>