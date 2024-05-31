<div class="mb-3 row">
    <label for="description" class="col-form-label text-lg-end col-lg-2 col-xl-3">Descripción</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" type="text"
               id="description" value="{{ old('description', optional($correlatividadAgrupada)->description) }}"
               minlength="1" maxlength="191" required="required">
        {!! $errors->first('Description', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="disabled" class="col-form-label text-lg-end col-lg-2 col-xl-3">Desactivada</label>
    <div class="col-lg-10 col-xl-9">
        <div class="form-check checkbox">
            <input id="disabled_1" class="form-check-input" name="disabled" type="checkbox"
                   value="1" {{ old('disabled', optional($correlatividadAgrupada)->disabled) == '1' ? 'checked' : '' }}>
            <label class="form-check-label" for="disabled_1">
                Si
            </label>
        </div>


        {!! $errors->first('disabled', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="identifier" class="col-form-label text-lg-end col-lg-2 col-xl-3">Identificador</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('identifier') ? ' is-invalid' : '' }}" name="identifier" type="text"
               id="identifier" value="{{ old('identifier', optional($correlatividadAgrupada)->identifier) }}"
               minlength="1" maxlength="191" required="required" placeholder="Ingrese identificador aquí">
        {!! $errors->first('identifier', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="name" class="col-form-label text-lg-end col-lg-2 col-xl-3">Nombre</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" type="text" id="name"
               value="{{ old('name', optional($correlatividadAgrupada)->name) }}" minlength="1" maxlength="191"
               required="required" placeholder="Ingrese nombre aquí">
        {!! $errors->first('Name', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="resoluciones_id" class="col-form-label text-lg-end col-lg-2 col-xl-3">Resoluciones</label>
    <div class="col-lg-10 col-xl-9">
        <select class="form-select{{ $errors->has('resoluciones_id') ? ' is-invalid' : '' }}" id="resoluciones_id"
                name="resoluciones_id" required="required">
            <option value="" style="display: none;"
                    {{ old('resoluciones_id', optional($correlatividadAgrupada)->resoluciones_id ?: '') == '' ? 'selected' : '' }} disabled
                    selected>Selecciones resolución
            </option>
            @foreach ($Resoluciones as $key => $Resolucion)
                <option
                    value="{{ $key }}" {{ old('resoluciones_id', optional($correlatividadAgrupada)->resoluciones_id) == $key ? 'selected' : '' }}>
                    {{ $Resolucion }}
                </option>
            @endforeach
        </select>

        {!! $errors->first('resoluciones_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
<div class="mb-3 row">
    <label for="cantidad_min" class="col-form-label text-lg-end col-lg-2 col-xl-3">Mínimo requerido</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('cantidad_min') ? ' is-invalid' : '' }}" name="cantidad_min" type="number" min="1" max="15" id="cantidad_min"
               value="{{ old('cantidad_min', optional($correlatividadAgrupada)->cantidad_min) }}"
               required="required" placeholder="Ingrese mínimo requerido aquí">
        {!! $errors->first('cantidad_min', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
