<form action="{{ route('calificacion.update', ['calificacion' => $calificacion->id]) }}"
      method="POST">
    <input type="hidden" name="materia_id" value="{{ $calificacion->materia_id }}">
    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

    @if(isset($calificacion->cargo_id))
        <input type="hidden" name="cargo_id" value="{{ $calificacion->cargo_id }}">
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
        <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') ?? $calificacion->nombre }}" required>
    </div>


    <div class="form-group">
        <label for="fecha">Fecha</label>
        <input type="date" name="fecha" id="fecha" class="form-control" value="{{ old('fecha') ?? $calificacion->fecha }}" required>
    </div>

    <div class="form-group">
        <label for="description">Descripción</label>
        <textarea  name="description" id="description" class="form-control" required>
            {{ old('description') ?? $calificacion->description }}
        </textarea>
    </div>

    @if($calificacion->materia->getTotalAttribute() > 0)
        <div class="form-group">
            <label for="comision_id">Comisión</label>
            <select name="comision_id" id="comision_id" class="form-select" required>
                @foreach($calificacion->materia->comisiones as $comisiones)
                    <option value="{{ $comisiones->id }}">{{ $comisiones->nombre }}</option>
                @endforeach
            </select>
        </div>
    @endif

    <input type="submit" value="Editar" class="btn btn-primary">
</form>