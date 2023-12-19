<div class="modal fade" id="createFecha" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Fecha</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('calendario.store') }}" method="POST">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="mes">Mes</label>
                            <select name="mes" id="mes" class="form-select">
                                <option value="1">Enero</option>
                                <option value="2">Febrero</option>
                                <option value="3">Marzo</option>
                                <option value="4">Abril</option>
                                <option value="5">Mayo</option>
                                <option value="6">Junio</option>
                                <option value="7">Julio</option>
                                <option value="8">Agosto</option>
                                <option value="9">Septiembre</option>
                                <option value="10">Octubre</option>
                                <option value="11">Noviembre</option>
                                <option value="12">Diciembre</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="dia">Día</label>
                            <input type="number" class="form-control" name="dia" id="dia" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="descripcion">Descripción</label>
                            <textarea name="descripcion" class="form-control" id="descripcion" cols="30" rows="3"></textarea>
                        </div>
                        <div class="col-md-12">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tipo" id="tipo1" value="feriado" checked>
                                <label class="form-check-label" for="tipo1">
                                    Feriado
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tipo" id="tipo2" value="especial">
                                <label class="form-check-label" for="tipo2">
                                    Especial
                                </label>
                            </div>
                            <div class="justify-content-center text-center">
                                <input type="submit" value="Guardar" class="col-md-8 btn btn-success mt-3">
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>