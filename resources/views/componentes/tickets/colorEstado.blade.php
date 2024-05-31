@if($estado->identificador == 'abierto')
    <span class="badge bg-primary">{{ $estado->nombre }}</span>
@endif
@if($estado->identificador == 'en proceso')
    <span class="badge bg-success">{{ $estado->nombre }}</span>
@endif