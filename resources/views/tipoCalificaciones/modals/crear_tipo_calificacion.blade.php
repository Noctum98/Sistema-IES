<!-- Modal -->
<div class="modal fade" id="crearTipoCalificacion" tabindex="-1" aria-labelledby="tipoCalificacionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tipoCalificacionModalLabel">Agregar Tipo Calificación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('tipoCalificaciones.store') }}" method="POST">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" required/>
                    </div>
                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <input type="number" min="0" name="descripcion" id="descripcion" class="form-control" required/>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit"  class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
