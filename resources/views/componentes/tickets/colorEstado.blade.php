@if($estado->identificador == 'abierto')
    <span class="badge bg-primary">{{ $estado->nombre }}</span>
@endif
@if($estado->identificador == 'en_proceso')
    <span class="badge bg-success">{{ $estado->nombre }}</span>
@endif
@if($estado->identificador == 'cerrado')
    <span class="badge bg-danger">{{ $estado->nombre }}</span>
@endif