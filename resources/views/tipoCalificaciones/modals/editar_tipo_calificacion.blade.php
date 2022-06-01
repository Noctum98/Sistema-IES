<h3>
    Editar un Tipo de Calificación
</h3>
<form action="{{ route('tipoCalificaciones.update', ['tipoCalificacione' => $tipoCalificaciones->id]) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-row">
        <label for="title">Nombre
            <input type="text" id="nombre" name="nombre" class="form-control"
                   value="{{ old('nombre') ?? $tipoCalificaciones->nombre }}" required>
        </label>
        <label for="description">Descripción
            <input type="number" min="0" id="descripcion" name="descripcion" class="form-control"
                   value="{{ old('descripcion') ??$tipoCalificaciones->descripcion }}" required>
        </label>
    </div>
    <div class="form-row mt-3">
        <button type="submit" class="btn btn-primary btn-lg "> Editar Tipo de Calificación</button>
    </div>

</form>
