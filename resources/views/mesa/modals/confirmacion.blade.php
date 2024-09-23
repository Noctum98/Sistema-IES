<div class="modal fade" id="confirmar_alumno" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-secondary" id="exampleModalLabel">Confirmar a <span id="nombre_alumno"></span></h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert">
                    <b>Corroborar que el estudiante cumpla los requisitos obligatorios para acceder a la mesa de examen, de lo contrario utilizar el botón Dar de Baja:</b>
                </div>
                <div id="cohorte" class="alert alert-danger">
                    <strong>El alumno no tiene cohorte, por lo que los datos no pueden ser verificados.</strong>
                </div>
                <div id="datos">
                    <input type="hidden" id="inscripcion_id_modal" value="">

                    <div class="alert" id="legajo">
                        <strong>Legajo Completo: <span id="resultado_legajo"></span></strong>
                    </div>

                    <div class="alert" id="regularidad">
                        <p><strong>Regularidad: <span id="resultado_regularidad"></span></strong></p>
                        <p><strong>Proceso: <span id="proceso"></span></strong></p>
                    </div>

                    <div class="alert" id="correlativas">
                        <strong>Correlativas Aprobadas: <span id="resultado_correlativas"></span></strong>
                        <ul id="lista_correlativas">

                        </ul>
                    </div>

                    <div class="alert" id="correlativas_folios">
                        <strong>Correlativas Aprobadas(libros): <span id="resultado_correlativas_folios"></span></strong>
                        <ul id="lista_correlativas_folios">

                        </ul>
                    </div>
                    <div class="alert" id="actas">
                        <strong>Actas volantes no cargadas: <span id="resultado_actas_incompletas"></span></strong>
                        <ul id="actas_incompletas">

                        </ul>
                    </div>
                    <button class="btn btn-success" id="confirmarButton">Inscribir</button>
                    <button class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>

                </div>
            </div>
        </div>
    </div>
</div>
