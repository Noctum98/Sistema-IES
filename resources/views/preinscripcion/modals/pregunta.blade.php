<div class="modal fade" id="preinscripcion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-secondary" id="exampleModalLabel">¿Estas seguro?</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><b> Se va a enviar tu preinscripción a:</b></p>
                <p>Carrera: {{$carrera->nombre}}</p>
                <p>Turno: {{$carrera->turno}}</p>
                <p>Unidad Académica: {{$carrera->sede->nombre}}</p>

                <div class="form-group">
                    <input type="submit" value="Si, incribirme" class="btn btn-success">
                </div>
            </div>
        </div>
    </div>
</div>