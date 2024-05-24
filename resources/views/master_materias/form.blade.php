<div class="mb-3 row">
    <label for="name" class="col-form-label text-lg-end col-lg-2 col-xl-3">Nombre</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" type="text" id="name"
               value="{{ old('name', optional($masterMateria)->name) }}" minlength="1" maxlength="191" required="required"
               placeholder="Ingrese nombre aquí...">
        {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="year" class="col-form-label text-lg-end col-lg-2 col-xl-3">Año</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('year') ? ' is-invalid' : '' }}" name="year" type="number" id="year"
               value="{{ old('year', optional($masterMateria)->year) }}" min="0" max="6" required="required"
               placeholder="Ingrese años en el que se dicta la carrera">
        {!! $errors->first('year', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="field_stage" class="col-form-label text-lg-end col-lg-2 col-xl-3">Etapa Campo</label>
    <div class="col-lg-10 col-xl-9">
        <div class="form-check checkbox">
            <input id="field_stage_1" class="form-check-input" name="field_stage" type="checkbox"
                   value="1" {{ old('field_stage', optional($masterMateria)->field_stage) == '1' ? 'checked' : '' }}>
            <label class="form-check-label" for="field_stage_1">
                Si
            </label>
        </div>


        {!! $errors->first('field_stage', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="delayed_closing" class="col-form-label text-lg-end col-lg-2 col-xl-3">Cierre diferido</label>
    <div class="col-lg-10 col-xl-9">
        <div class="form-check checkbox">
            <input id="delayed_closing_1" class="form-check-input" name="delayed_closing" type="checkbox"
                   value="1" {{ old('delayed_closing', optional($masterMateria)->delayed_closing) == '1' ? 'checked' : '' }}>
            <label class="form-check-label" for="delayed_closing_1">
                Si
            </label>
        </div>


        {!! $errors->first('delayed_closing', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="resoluciones_id" class="col-form-label text-lg-end col-lg-2 col-xl-3">Resolución</label>
    <div class="col-lg-10 col-xl-9">
        <select class="form-select{{ $errors->has('resoluciones_id') ? ' is-invalid' : '' }}" id="resoluciones_id"
                name="resoluciones_id" required="required">
            <option value="" style="display: none;"
                    {{ old('resoluciones_id', optional($masterMateria)->resoluciones_id ?: '') == '' ? 'selected' : '' }} disabled
                    selected>Seleccione resolución
            </option>
            @foreach ($Resoluciones as $key => $resolution)
                <option
                    value="{{ $key }}" {{ old('resoluciones_id', optional($masterMateria)->resoluciones_id) == $key ? 'selected' : '' }}>
                    {{ $resolution }}
                </option>
            @endforeach
        </select>

        {!! $errors->first('resoluciones_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="regimen_id" class="col-form-label text-lg-end col-lg-2 col-xl-3">Régimen</label>
    <div class="col-lg-10 col-xl-9">
        <select class="form-select{{ $errors->has('regimen_id') ? ' is-invalid' : '' }}" id="regimen_id"
                name="regimen_id" required="required">
            <option value="" style="display: none;"
                    {{ old('regimen_id', optional($masterMateria)->regimen_id ?: '') == '' ? 'selected' : '' }} disabled
                    selected>Seleccione régimen
            </option>
            @foreach ($Regimens as $key => $regimen)
                <option
                    value="{{ $key }}" {{ old('regimen_id', optional($masterMateria)->regimen_id) == $key ? 'selected' : '' }}>
                    {{ $regimen }}
                </option>
            @endforeach
        </select>

        {!! $errors->first('regimen_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
