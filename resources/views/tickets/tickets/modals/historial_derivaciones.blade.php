<div class="modal fade" id="historialDerivaciones" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-secondary" id="exampleModalLabel">Historial de Derivaciones</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Derivaciones</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Estados</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="list-group" id="listaDerivaciones">


                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="list-group">
                            @foreach($ticket->estados_ticket as $i => $estadoTicket)
                            @if($i != ($ticket->estados_ticket->count() - 1))
                            <div class="list-group-item list-group-item-action flex-column align-items-start active">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">De: @include('componentes.tickets.colorEstado',['estado'=>$estadoTicket->fromEstadoTicket])</h5>
                                    <h5 class="mb-1">A: @include('componentes.tickets.colorEstado',['estado'=>$estadoTicket->toEstadoTicket])</h5>

                                    <small>{{$estadoTicket->created_at->diffForHumans()}}</small>
                                </div>
                                <p class="mb-1">Usuario Responsable: {{ $estadoTicket->user->nombre.' '.$estadoTicket->user->apellido }}</p>
                            </div>
                            @endif
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>