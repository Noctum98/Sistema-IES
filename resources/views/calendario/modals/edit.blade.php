<div class="modal fade" id="editFecha{{ $calendario->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Fecha</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('calendario.update',$calendario->id) }}" method="POST">
                    {{ method_field('PUT') }}
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="mes">Mes</label>
                            <select name="mes" id="mes" class="form-select">
                                <option value="1" {{ $calendario->mes == '1' ? 'selected' : '' }}>Enero</option>
                                <option value="2" {{ $calendario->mes == '2' ? 'selected' : '' }}>Febrero</option>
                                <option value="3" {{ $calendario->mes == '3' ? 'selected' : '' }}>Marzo</option>
                                <option value="4" {{ $calendario->mes == '4' ? 'selected' : '' }}>Abril</option>
                                <option value="5" {{ $calendario->mes == '5' ? 'selected' : '' }}>Mayo</option>
                                <option value="6" {{ $calendario->mes == '6' ? 'selected' : '' }}>Junio</option>
                                <option value="7" {{ $calendario->mes == '7' ? 'selected' : '' }}>Julio</option>
                                <option value="8" {{ $calendario->mes == '8' ? 'selected' : '' }}>Agosto</option>
                                <option value="9" {{ $calendario->mes == '9' ? 'selected' : '' }}>Septiembre</option>
                                <option value="10" {{ $calendario->mes == '10' ? 'selected' : '' }}>Octubre</option>
                                <option value="11" {{ $calendario->mes == '11' ? 'selected' : '' }}>Noviembre</option>
                                <option value="12" {{ $calendario->mes == '12' ? 'selected' : '' }}>Diciembre</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="dia">Día</label>
                            <input type="number" class="form-control" name="dia" id="dia" value="{{ $calendario->dia }}" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="descripcion">Descripción</label>
                            <textarea name="descripcion" class="form-control" id="descripcion"  cols="30" rows="3">{{ $calendario->descripcion }}</textarea>
                        </div>
                        <div class="col-md-12">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tipo" id="tipo1" value="feriado" {{ $calendario->tipo == 'feriado' ? 'checked' : '' }}>
                                <label class="form-check-label" for="tipo1">
                                    Feriado
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tipo" id="tipo2" value="especial"  {{ $calendario->tipo == 'especial' ? 'checked' : '' }}>
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