<div class="modal fade" id="nota{{$inscripcion->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-secondary" id="exampleModalLabel">Nota de Mesa</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="">
                    <div class="form-group">
                        <label for="nota_escrito">Escrito</label>
                        <input type="number" name="nota_escrito" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="nota_escrito">Oral</label>
                        <input type="number" name="nota_escrito" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="nota_escrito">Porcentaje</label>
                        <input type="number" name="nota_escrito" class="form-control">
                    </div>

                    <input type="submit" value="Guardar" class="btn btn-success">
                </form>
            </div>
        </div>
    </div>
</div>