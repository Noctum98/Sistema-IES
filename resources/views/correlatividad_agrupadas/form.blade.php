<div class="mb-3 row">
    <label for="Description" class="col-form-label text-lg-end col-lg-2 col-xl-3">Descripción</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('Description') ? ' is-invalid' : '' }}" name="Description" type="text"
               id="Description" value="{{ old('Description', optional($correlatividadAgrupada)->Description) }}"
               minlength="1" maxlength="191" required="required">
        {!! $errors->first('Description', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="Disabled" class="col-form-label text-lg-end col-lg-2 col-xl-3">Desactivada</label>
    <div class="col-lg-10 col-xl-9">
        <div class="form-check checkbox">
            <input id="Disabled_1" class="form-check-input" name="Disabled" type="checkbox"
                   value="1" {{ old('Disabled', optional($correlatividadAgrupada)->Disabled) == '1' ? 'checked' : '' }}>
            <label class="form-check-label" for="Disabled_1">
                Si
            </label>
        </div>


        {!! $errors->first('Disabled', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="Identifier" class="col-form-label text-lg-end col-lg-2 col-xl-3">Identificador</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('Identifier') ? ' is-invalid' : '' }}" name="Identifier" type="text"
               id="Identifier" value="{{ old('Identifier', optional($correlatividadAgrupada)->Identifier) }}"
               minlength="1" maxlength="191" required="required" placeholder="Ingres identificador aquí">
        {!! $errors->first('Identifier', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="Name" class="col-form-label text-lg-end col-lg-2 col-xl-3">Nombre</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('Name') ? ' is-invalid' : '' }}" name="Name" type="text" id="Name"
               value="{{ old('Name', optional($correlatividadAgrupada)->Name) }}" minlength="1" maxlength="191"
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
    <label for="user_id" class="col-form-label text-lg-end col-lg-2 col-xl-3">User</label>
    <div class="col-lg-10 col-xl-9">
        <select class="form-select{{ $errors->has('user_id') ? ' is-invalid' : '' }}" id="user_id" name="user_id"
                required="true">
            <option value="" style="display: none;"
                    {{ old('user_id', optional($correlatividadAgrupada)->user_id ?: '') == '' ? 'selected' : '' }} disabled
                    selected>Select user
            </option>
            @foreach ($users as $key => $user)
                <option
                    value="{{ $key }}" {{ old('user_id', optional($correlatividadAgrupada)->user_id) == $key ? 'selected' : '' }}>
                    {{ $user }}
                </option>
            @endforeach
        </select>

        {!! $errors->first('user_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

