<table class="table mt-4">
    <thead class="thead-dark">
        <tr>
            <th>D.N.I</th>
            <th>Acción</th>
            <th>Carrera</th>
            <th>Materia</th>
            <th>Usuario Responsable</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($registros as $registro)
        <tr>
            <th><a href="{{ route('alumno.detalle',$registro->proceso->alumno_id) }}"> {{$registro->proceso->alumno->dni}} </a></th>
            <td>{{ $registro->changes == 'CREATE' || $registro->changes == 'DELETE' ? $registro->changes : 'UPDATE' }}</td>
            <td>{{ $registro->proceso->materia->carrera->nombre }}</td>
            <td> {{ $registro->proceso->materia->nombre }} </td>
            <td>
                @if($registro->user)
                {{ $registro->user->apellido.' '.$registro->user->nombre }}
                @else
                Usuario eliminado
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="d-flex justify-content-center" style="font-size: 0.8em">
    {{ $registros->links() }}
</div>