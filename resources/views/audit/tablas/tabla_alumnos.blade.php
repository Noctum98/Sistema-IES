<table class="table mt-4">
    <thead class="thead-dark">
        <tr>
            <th>D.N.I</th>
            <th>Acción</th>
            <th>Cambios</th>
            <th>Usuario Responsable</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($registros as $registro)
        <tr>
            <th>
                @if(!$registro->deleted_at)
                <a href="{{ route('alumno.detalle',$registro->id) }}"> 
                    {{$registro->dni}} 
                </a>
                @else
                {{$registro->dni}} 
                @endif
            </th>
            <td> {{ $registro->changes == 'CREATE' || $registro->changes == 'DELETE' ? $registro->changes : 'UPDATE' }} </td>
            <td> 
                @if($registro->user)
                {{ $registro->user->apellido.' '.$registro->user->nombre }} 
                @else
                Usuario Eliminado
                @endif
            </td>

            <td> 
                @if($registro->changes != 'CREATE' && $registro->changes != 'DELETE')
                    <button class="btn btn-sm btn-warning modal_cambios" data-changes="{{ $registro->changes }}" data-bs-toggle="modal" data-bs-target="#modalCambios">Ver cambios</button>
                @else
                -
                @endif 
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="d-flex justify-content-center" style="font-size: 0.8em">
    {{ $registros->links() }}
</div>

@include('audit.modals.modal_cambios')
@section('scripts')
<script src="{{ asset('js/audit/cambios.js') }}"></script>
@endsection