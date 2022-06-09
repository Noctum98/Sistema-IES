<div class="modal fade" id="crearCalificacion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-info" id="exampleModalLabel">Crear Calificación</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('calificacion.store') }}" method="POST">
                    <input type="hidden" name="materia_id" value="{{ $materia->id }}">
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

                    @if(isset($cargo_id))
                    <input type="hidden" name="cargo_id" value="{{ $cargo_id }}">
                    @endif

                    <div class="form-group">
                        <label for="tipo_id">Tipo de calificación</label>
                        <select name="tipo_id" id="tipo_id" class="form-select" required>
                            @foreach($tiposCalificaciones as $tipoCalificacion)
                                <option value="{{ $tipoCalificacion->id }}">{{ $tipoCalificacion->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" required>
                    </div>

                    
                    <div class="form-group">
                        <label for="fecha">Fecha</label>
                        <input type="date" name="fecha" id="fecha" class="form-control" required>
                    </div>

                    <input type="submit" value="Guardar" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
</div>