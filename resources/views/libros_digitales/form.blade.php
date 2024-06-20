<div class="mb-3 row">
    <label for="acta_inicio" class="col-form-label text-lg-end col-lg-2 col-xl-3">Acta Inicio</label>
    <div class="col-lg-10 col-xl-9">
        <textarea class="form-control{{ $errors->has('acta_inicio') ? ' is-invalid' : '' }}" name="acta_inicio"
                  id="acta_inicio"
                  placeholder="Ingrese acta de inicio...">{{ old('acta_inicio', optional($librosDigitales)->acta_inicio) }}</textarea>
        {!! $errors->first('acta_inicio', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="number" class="col-form-label text-lg-end col-lg-2 col-xl-3">Número</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('number') ? ' is-invalid' : '' }}" name="number" type="number"
               id="number" value="{{ old('number', optional($librosDigitales)->number) }}" min="1" max="4294967295"
               required="required" placeholder="Ingrese número aquí...">
        {!! $errors->first('number', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="romanos" class="col-form-label text-lg-end col-lg-2 col-xl-3">N° Romanos</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('romanos') ? ' is-invalid' : '' }}" name="romanos" type="text"
               id="romanos" value="{{ old('romanos', optional($librosDigitales)->romanos) }}" minlength="1" maxlength="191"
               required="required" placeholder="Número en romanos aquí...">
        {!! $errors->first('romanos', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="resoluciones_id" class="col-form-label text-lg-end col-lg-2 col-xl-3">Resoluciones</label>
    <div class="col-lg-10 col-xl-9">
        <select class="form-select{{ $errors->has('resoluciones_id') ? ' is-invalid' : '' }}" id="resoluciones_id"
                name="resoluciones_id" required="required">
            <option value="" style="display: none;"
                    {{ old('resoluciones_id', optional($librosDigitales)->resoluciones_id ?: '') == '' ? 'selected' : '' }} disabled
                    selected>Select resoluciones
            </option>
            @foreach ($Resoluciones as $key => $Resolucione)
                <option
                    value="{{ $key }}" {{ old('resoluciones_id', optional($librosDigitales)->resoluciones_id) == $key ? 'selected' : '' }}>
                    {{ $Resolucione }}
                </option>
            @endforeach
        </select>

        {!! $errors->first('resoluciones_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="fecha_inicio" class="col-form-label text-lg-end col-lg-2 col-xl-3">Fecha Inicio</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('fecha_inicio') ? ' is-invalid' : '' }}" name="fecha_inicio"
               type="text" id="fecha_inicio" value="{{ old('fecha_inicio', optional($librosDigitales)->fecha_inicio) }}"
               placeholder="Ingrese fecha inicio aquí...">
        {!! $errors->first('fecha_inicio', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="sede_id" class="col-form-label text-lg-end col-lg-2 col-xl-3">Sede</label>
    <div class="col-lg-10 col-xl-9">
        <select class="form-select{{ $errors->has('sede_id') ? ' is-invalid' : '' }}" id="sede_id" name="sede_id"
                required="required">
            <option value="" style="display: none;"
                    {{ old('sede_id', optional($librosDigitales)->sede_id ?: '') == '' ? 'selected' : '' }} disabled selected>
                Select sede
            </option>
            @foreach ($Sedes as $key => $Sede)
                <option
                    value="{{ $key }}" {{ old('sede_id', optional($librosDigitales)->sede_id) == $key ? 'selected' : '' }}>
                    {{ $Sede }}
                </option>
            @endforeach
        </select>

        {!! $errors->first('sede_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="resolucion_original" class="col-form-label text-lg-end col-lg-2 col-xl-3">Resolucion Original</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('resolucion_original') ? ' is-invalid' : '' }}"
               name="resolucion_original" type="text" id="resolucion_original"
               value="{{ old('resolucion_original', optional($librosDigitales)->resolucion_original) }}" maxlength="191"
               placeholder="Ingrese resolución original aquí...">
        {!! $errors->first('resolucion_original', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="operador_id" class="col-form-label text-lg-end col-lg-2 col-xl-3">Operador</label>
    <div class="col-lg-10 col-xl-9">
        <select class="form-select{{ $errors->has('operador_id') ? ' is-invalid' : '' }}" id="operador_id"
                name="operador_id">
            <option value="" style="display: none;"
                    {{ old('operador_id', optional($librosDigitales)->operador_id ?: '') == '' ? 'selected' : '' }} disabled
                    selected>Seleccione operador
            </option>
            @foreach ($Users as $key => $User)
                <option
                    value="{{ $key }}" {{ old('operador_id', optional($librosDigitales)->operador_id) == $key ? 'selected' : '' }}>
                    {{ $User }}
                </option>
            @endforeach
        </select>

        {!! $errors->first('operador_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="observaciones" class="col-form-label text-lg-end col-lg-2 col-xl-3">Observaciones</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('observaciones') ? ' is-invalid' : '' }}" name="observaciones"
               type="text" id="observaciones" value="{{ old('observaciones', optional($librosDigitales)->observaciones) }}"
               minlength="1" maxlength="191" required="required" placeholder="Ingrese observaciones aquí...">
        {!! $errors->first('observaciones', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
