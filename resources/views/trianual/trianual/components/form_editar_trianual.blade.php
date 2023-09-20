<style>
    sup {
        color: #dc3545;
    }
</style>
<form action="{{ route('regularidad.update', ['regularidad' => $regularidad]) }}"
      method="POST">

    <div class="form-group mb-3">
        <label >Materia {{$regularidad->obtenerMateria()->nombre}} </label>

    </div>
    <div class="form-group mb-3">
        <label for="fecha_regularidad">Fecha Regularidad <sup>*</sup></label>
        <input type="date" name="fecha_regularidad" id="fecha_regularidad" class="form-control"
               value="{{date_format(new DateTime($regularidad->fecha_regularidad),'Y-m-d' )}}"
               required>
    </div>

    <div class="form-group mb-3">
        <label for="observaciones">Observaciones <sup>*</sup> </label>
        <textarea name="observaciones" id="observaciones" class="form-control"

                  required>{{$regularidad->observaciones}}</textarea>
    </div>
    <div class="form-group mb-3">
        <label for="fecha_vencimiento">Fecha Vencimiento</label>
        <input type="date" name="fecha_vencimiento" id="fecha_vencimiento" class="form-control"
               value="{{date_format(new DateTime($regularidad->fecha_vencimiento),'Y-m-d' )}}"
               placeholder="Fecha Vencimiento" required>
    </div>


    <div class="form-group mb-3">
        <label for="estado_id">Condición <sup>*</sup></label>
        <select name="estado_id" id="estado_id" class="form-select" required>
            <option value="">Seleccione regularidad</option>
            @foreach($estados as $estado)
                @if($estado->id == $regularidad->obtenerEstado()->id)
                    <option selected value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                @else
                    <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                @endif

            @endforeach
        </select>
    </div>
    <hr/>
{{--    <div class="form-group mb-3">--}}
{{--        <label for="ciclo_anterior">Ciclo lectivo original</label>--}}
{{--        <input name="ciclo_anterior" id="ciclo_anterior" class="form-control" type="number" min="1986"  />--}}

{{--    </div>--}}
    <hr>
            <input name="proceso_id" id="proceso_id"  type="hidden" value="{{$regularidad->proceso_id}}"  />
    <sup>*</sup> <small>Campos requeridos</small><br/>
    <input type="submit" value="Guardar" class="btn btn-primary">
</form>
