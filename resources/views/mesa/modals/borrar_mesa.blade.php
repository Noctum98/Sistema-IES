<div class="modal fade" id="borrar_mesa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-secondary" id="exampleModalLabel">Crear Instancia</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    ¿Estas seguro que deseas borrar la mesa? Se borrarán todos los datos de la misma
                </div>
                <form action="{{ route('mesa.delete',$mesa->id) }}" method="POST">
                    {{ method_field('DELETE') }}
                    <input type="submit" value="Eliminar" class="btn btn-danger">
                </form>
            </div>
        </div>
    </div>
</div>