<div class="mb-3 row">
    <label for="mensaje" class="col-form-label text-lg-end col-lg-2 col-xl-3">Mensaje</label>
    <div class="col-lg-10 col-xl-9">
        <textarea class="form-control{{ $errors->has('mensaje') ? ' is-invalid' : '' }}" name="mensaje" id="mensaje"
                  required="required"
                  placeholder="Ingrese aviso aquí...">{{ old('mensaje', optional($aviso)->mensaje) }}</textarea>
        {!! $errors->first('mensaje', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="role_destinatario" class="col-form-label text-lg-end col-lg-2 col-xl-3">Role Destinatario</label>
    <select class="form-select{{ $errors->has('role_destinatario') ? ' is-invalid' : '' }} col-6" multiple id="role_destinatario"
            name="role_destinatario[]" required="required">
        <option value="0" style="display: none;" selected> Todos los destinatarios
        </option>
        @foreach ($roles as $rol)
            <option
                value="{{ $rol->id }}" {{ old('role_destinatario', optional($aviso)->role_destinatario) == $rol->id ? 'selected' : '' }}>
                {{ $rol->nombre }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3 row">
    <label for="visible_desde" class="col-form-label text-lg-end col-lg-2 col-xl-3">Visible Desde</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('visible_desde') ? ' is-invalid' : '' }}" name="visible_desde"
               type="datetime-local" id="visible_desde"
               value="{{ old('visible_desde', optional($aviso)->visible_desde) }}"
               placeholder="Enter visible desde here...">
        {!! $errors->first('visible_desde', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="visible_hasta" class="col-form-label text-lg-end col-lg-2 col-xl-3">Visible Hasta</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('visible_hasta') ? ' is-invalid' : '' }}" name="visible_hasta"
               type="datetime-local" id="visible_hasta"
               value="{{ old('visible_hasta', optional($aviso)->visible_hasta) }}"
               placeholder="Enter visible hasta here...">
        {!! $errors->first('visible_hasta', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="disabled" class="col-form-label text-lg-end col-lg-2 col-xl-3">Deshabilitar</label>
    <div class="col-lg-10 col-xl-9">

        <input class="custom-checkbox {{ $errors->has('disabled') ? ' is-invalid' : '' }}" name="disabled"
               type="checkbox" id="disabled" value="{{ old('disabled', optional($aviso)->disabled) }}"
               placeholder="Marque si desea deshabilitar el aviso">
        <div id="disabledHelpBlock" class="form-text">
            Marque si desea deshabilitar el aviso
        </div>
        {!! $errors->first('disabled', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
{{--<div class="mb-3 row">--}}
{{--    <label for="todos" class="col-form-label text-lg-end col-lg-2 col-xl-3">Todos los roles</label>--}}
{{--    <div class="col-lg-10 col-xl-9">--}}

{{--        <input class="custom-checkbox {{ $errors->has('todos') ? ' is-invalid' : '' }}" name="todos" type="checkbox"--}}
{{--               id="todos" value="{{ old('todos', optional($aviso)->todos) }}"--}}
{{--               placeholder="Marque si desea que el aviso sea para todos los roles">--}}
{{--        <div id="todosHelpBlock" class="form-text">--}}
{{--            Marque si desea que el aviso sea visible para todos los roles--}}
{{--        </div>--}}
{{--        {!! $errors->first('todos', '<div class="invalid-feedback">:message</div>') !!}--}}
{{--    </div>--}}
{{--</div>--}}

<script>
    Simditor.locale = 'es-AR';
    let editor = new Simditor({
        textarea: $('#mensaje'),
//optional options
    });

    $(document).ready(function () {


        $('#role_destinatario').select2({
            width: "50%",
            placeholder: "Seleccione roles para el mensaje"

        });

    });
</script>
