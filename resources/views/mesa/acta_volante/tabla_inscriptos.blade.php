<table class="table mt-4">
    <thead class="thead-dark">
        <tr>
            <th scope="col">Apellidos</th>
            <th scope="col">Nombres</th>
            <th scope="col">D.N.I</th>
            <th scope="col">Teléfono</th>
            <th scope="col">Confirmado</th>
            <th scope="col"><i class="fa fa-cog" style="font-size:20px;"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($inscripciones as $inscripcion)
        <tr style="cursor:pointer;">
            <td>{{ $inscripcion->apellidos }}</td>
            <td>{{ $inscripcion->nombres }}</td>
            <td>{{ $inscripcion->dni }}</td>
            <td>{{ $inscripcion->telefono }}</td>
            <td>
                @if($inscripcion->confirmado)
                <i class="fas fa-check text-success"></i>
                @else
                <i class="fas fa-times text-danger"></i>
                @endif
            </td>
            <td>
                @include('mesa.modals.nota_mesa')
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#nota{{$inscripcion->id}}" {{ !$inscripcion->confirmado ? 'disabled':'' }}>
                    Nota
                </button>
            </td>

        </tr>
        @endforeach
    </tbody>
</table>