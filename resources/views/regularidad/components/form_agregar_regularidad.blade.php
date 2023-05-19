<form action="{{ route('regularidad.store') }}"
      method="POST">

    <div class="form-group">
        <label for="proceso_id">Materia</label>
        <select name="proceso_id" id="proceso_id" class="form-select" required>
            @foreach($procesos as $proceso)
                <option value="{{ $proceso->id }}">{{ $proceso->materia()->first()->nombre }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="fecha_regularidad">Fecha Regularidad</label>
        <input type="date" name="fecha_regularidad" id="fecha_regularidad" class="form-control"
               placeholder="Fecha de regularidad" required>
    </div>

    <div class="form-group">
        <label for="observaciones">Observaciones</label>
        <textarea name="observaciones" id="observaciones" class="form-control"
                  required></textarea>
    </div>
    <div class="form-group">
        <label for="fecha_vencimiento">Fecha Vencimiento</label>
        <input type="date" name="fecha_vencimiento" id="fecha_vencimiento" class="form-control"
               placeholder="Fecha Vencimiento" required>
    </div>


    <div class="form-group">
        <label for="estado_id">Condición</label>
        <select name="estado_id" id="estado_id" class="form-select" required>
            @foreach($estados as $estado)
                <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
            @endforeach
        </select>
    </div>

    <input type="submit" value="Guardar" class="btn btn-primary">
</form>
