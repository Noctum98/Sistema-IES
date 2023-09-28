<div class="modal fade" id="eliminarRegularidadModal{{$regularidad->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-secondary" id="exampleModalLabel">
                    Eliminar regularidad
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    ¡ATENCIÓN! Al pulsar "Eliminar regularidad" se borrarán los datos de la misma..
                </div>

                <a href="{{route('regularidad.borrar', ['regularidad' => $regularidad])}}"
                   class="btn btn-sm btn-danger ps-1"
                >
                    <i class="fa fa-trash"></i> Eliminar regularidad
                </a>
            </div>

        </div>
    </div>
</div>
