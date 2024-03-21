
<div class="mb-3 row">
    <label for="nombre" class="col-form-label text-lg-end col-lg-2 col-xl-3">Nombre</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('nombre') ? ' is-invalid' : '' }}" name="nombre" type="text" id="nombre" value="{{ old('nombre', optional($condicionCarrera)->nombre) }}" minlength="1" maxlength="191" required="true" placeholder="Enter nombre here...">
        {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="identificador" class="col-form-label text-lg-end col-lg-2 col-xl-3">Identificador</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('identificador') ? ' is-invalid' : '' }}" name="identificador" type="text" id="identificador" value="{{ old('identificador', optional($condicionCarrera)->identificador) }}" minlength="1" maxlength="191" required="true" placeholder="Enter identificador here...">
        {!! $errors->first('identificador', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="habilitado" class="col-form-label text-lg-end col-lg-2 col-xl-3">Habilitado</label>
    <div class="col-lg-10 col-xl-9">
        <div class="form-check checkbox">
            <input id="habilitado_1" class="form-check-input" name="habilitado" type="checkbox" value="1" {{ old('habilitado', optional($condicionCarrera)->habilitado) == '1' ? 'checked' : '' }}>
            <label class="form-check-label" for="habilitado_1">
                Si
            </label>
        </div>


        {!! $errors->first('habilitado', '<div class="invalid-feedback">:message</div>') !!}
    </div>

    <input type="hidden" id="operador_id" name="operador_id" value="{{auth()->user()->id}}">
</div>



