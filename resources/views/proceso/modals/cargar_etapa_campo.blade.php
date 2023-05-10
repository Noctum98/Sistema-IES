<div class="modal fade" id="etapaCampo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-info" id="title_modal">Etapa de Campo</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                <p><b><i>AVISO</i></b></p>
                <ul>
                    <li>Las notas solo se ponen del 1 al 10 y la asistencia de 1 a 100.</li>
                    <li>En el caso de no querer colocar algún dato, solo dejar el campo vacío, de esta forma obviará el dato a la hora de promediar el porcentaje final.</li>
                </ul>
                </div>
                
                <form action="" id="etapaCampoForm">
                
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="habilitado" disabled>
                    <label class="form-check-label" for="habilitado">
                        Habilitar
                    </label>
                </div>
                <div class="form-group">
                    <label for="primera_evaluacion">Evaluación 1</label>
                    <input type="number" class="form-control" name="primera_evaluacion" id="primera_evaluacion" pattern="^[1-9]|10$" required disabled>
                </div>

                <div class="form-group">
                    <label for="segunda_evaluacion">Evaluación 2</label>
                    <input type="number" class="form-control" name="segunda_evaluacion" id="segunda_evaluacion" pattern="^[1-9]|10$" required disabled>
                </div>

                <div class="form-group">
                    <label for="tercera_evaluacion">Evaluación 3</label>
                    <input type="number" class="form-control" name="tercera_evaluacion" id="tercera_evaluacion" pattern="^[1-9]|10$" required disabled>
                </div>
                <p id="porcentaje_final"></p>
                <hr>
                <div class="form-group">
                    <label for="primera_evaluacion">Asistencia</label>
                    <input type="number" class="form-control" name="asistencia" id="asistencia" pattern="^[1-9]|100$" disabled>
                </div>

                <input type="hidden" name="proceso_id" id="proceso_id">
            </div>
            <input type="submit" class="btn btn-primary" value="Guardar" id="submit_button" disabled>
            </form>
        </div>
    </div>
</div>