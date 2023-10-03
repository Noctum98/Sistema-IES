<style>
    sup {
        color: #dc3545;
    }
</style>
<form action="{{ route('cargaHoraria.guardar', ['persona' => $profesor->id]) }}"
      method="POST">

    <div class="form-group mb-3">
        <label for="materia_id">Materia<sup>*</sup></label>
        <select name="materia_id" id="materia_id" class="form-select" required>
            <option value="">Seleccione materia</option>
            @foreach($carreras as $carrera)
                @foreach($carrera->materias()->get() as $materia)
                    <option value="{{ $materia->id }}">{{ $materia->nombre }}</option>
                @endforeach
            @endforeach
        </select>
    </div>
    <div class="form-group mb-3">
        <label for="cantidad_horas">Cantidad de horas <sup>*</sup></label>
        <input type="number" name="cantidad_horas" id="cantidad_horas" class="form-control"
               placeholder="Cantidad de horas" required>
    </div>


    {{--    <div class="form-group mb-3">--}}
    {{--        <label for="fecha_vencimiento">Fecha Vencimiento</label>--}}
    {{--        <input type="date" name="fecha_vencimiento" id="fecha_vencimiento" class="form-control"--}}
    {{--               placeholder="Fecha Vencimiento" required>--}}
    {{--    </div>--}}


    <hr>
    <sup>*</sup> <small>Campos requeridos</small><br/>
    <input type="submit" value="Guardar" class="btn btn-primary">
</form>
