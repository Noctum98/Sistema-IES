<div class="modal fade" id="crearComision" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Crear comisión</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('comisiones.crear',$carrera->id) }}" method="POST">
                    <input type="hidden" name="carrera_id" value="{{ $carrera->id }}">
                    <div class="form-group">
                        <label for="año">Año:</label>
                        <input type="number" id="año" name="año" min="1" step="1" max="3"
                               class="form-control @error('año') is-invalid @enderror" value="{{ old('año') }}"
                               required/>
                        @error('año')
                        <span class="invalid-feedback d-block" role="alert">
			                <strong>{{ $message }}</strong>
			            </span>
                        @enderror

                    </div>
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" name="nombre"
                               class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}"
                               required/>
                        @error('nombre')
                        <span class="invalid-feedback d-block" role="alert">
			                <strong>{{ $message }}</strong>
			            </span>
                        @enderror
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>