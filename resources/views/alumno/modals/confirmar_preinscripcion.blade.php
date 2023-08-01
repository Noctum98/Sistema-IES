<div class="modal fade" id="confirmar_preinscripcion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-secondary" id="exampleModalLabel">
                    Confirmar Pre Inscripción
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                    <div class="alert alert-danger">
                        !ATENCIÓN! Revisa los datos antes de enviar el formulario.
                    </div>
                    <div id="datos_preinscripcion">
                        <p>Carrera: {{ $carrera->nombre }}</p>
                        <p>Turno: {{ ucwords($carrera->turno) }}</p>
                        <p>Sede: {{ $carrera->sede->nombre }}</p>
                        <p>Ubicación: {{ $carrera->sede->ubicacion }}</p>
                        </div>
                    <input type="submit" value="Confirmar preinscripción" class="btn btn-sm btn-success">
                    <button type="button" class="btn btn-sm btn-warning" data-bs-dismiss="modal">Cerrar</button>
            </div>

        </div>
    </div>
</div>