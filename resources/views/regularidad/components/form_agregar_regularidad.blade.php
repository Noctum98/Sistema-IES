<style>
    sup {
        color: #dc3545;
    }
</style>
<form action="{{ route('regularidad.store') }}"
      method="POST">

    <div class="form-group mb-3">
        <label for="proceso_id">Materia<sup>*</sup></label>
        <select name="proceso_id" id="proceso_id" class="form-select" required>
            <option value="">Seleccione materia</option>
            @foreach($procesos as $proceso)
                <option value="{{ $proceso->id }}">{{ $proceso->materia()->first()->nombre }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group mb-3">
        <label for="fecha_regularidad">Fecha Regularidad <sup>*</sup></label>
        <input type="date" name="fecha_regularidad" id="fecha_regularidad" class="form-control"
               placeholder="Fecha de regularidad" required>
    </div>

    <div class="form-group mb-3">
        <label for="observaciones">Observaciones <sup>*</sup> </label>
        <textarea name="observaciones" id="observaciones" class="form-control"
                  required></textarea>
    </div>
{{--    <div class="form-group mb-3">--}}
{{--        <label for="fecha_vencimiento">Fecha Vencimiento</label>--}}
{{--        <input type="date" name="fecha_vencimiento" id="fecha_vencimiento" class="form-control"--}}
{{--               placeholder="Fecha Vencimiento" required>--}}
{{--    </div>--}}


    <div class="form-group mb-3">
        <label for="estado_id">Condición <sup>*</sup></label>
        <select name="estado_id" id="estado_id" class="form-select" required>
            <option value="">Seleccione regularidad</option>
            @foreach($estados as $estado)
                <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
            @endforeach
        </select>
    </div>
    <hr/>
    <div class="form-group mb-3">
        <label for="ciclo_anterior">Ciclo lectivo original</label>
        <input name="ciclo_anterior" id="ciclo_anterior" class="form-control" type="number" min="1986"  />

    </div>
    <hr>
    <sup>*</sup> <small>Campos requeridos</small><br/>
    <input type="submit" value="Guardar" class="btn btn-primary">
</form>
