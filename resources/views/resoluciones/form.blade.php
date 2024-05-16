<div class="mb-3 row">
    <label for="name" class="col-form-label text-lg-end col-lg-2 col-xl-3">Nombre</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" type="text" id="name"
               value="{{ old('name', optional($resoluciones)->name) }}" minlength="1" maxlength="191" required="required"
               placeholder="Ingrese nombre aquí...">
        {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="title" class="col-form-label text-lg-end col-lg-2 col-xl-3">Título</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" type="text" id="title"
               value="{{ old('title', optional($resoluciones)->title) }}" minlength="1" maxlength="191" required="required"
               placeholder="Ingrese título aquí...">
        {!! $errors->first('title', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="duration" class="col-form-label text-lg-end col-lg-2 col-xl-3">Duración</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('duration') ? ' is-invalid' : '' }}" name="duration" type="number"
               id="duration" value="{{ old('duration', optional($resoluciones)->duration) }}" min="0" max="6"
               required="required" placeholder="Ingrese duración aquí...">
        {!! $errors->first('duration', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="resolution" class="col-form-label text-lg-end col-lg-2 col-xl-3">Resolución</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('resolution') ? ' is-invalid' : '' }}" name="resolution" type="text"
               id="resolution" value="{{ old('resolution', optional($resoluciones)->resolution) }}" minlength="1"
               maxlength="191" required="required" placeholder="Ingrese resolución aquí...">
        {!! $errors->first('resolution', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="modality" class="col-form-label text-lg-end col-lg-2 col-xl-3">Modalidad</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('modality') ? ' is-invalid' : '' }}" name="modality" type="text" id="modality"
               value="{{ old('modality', optional($resoluciones)->modality) }}" minlength="1" maxlength="191" required="required"
               placeholder="Ingrese modalidad aquí...">
        {!! $errors->first('modality', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="vaccines" class="col-form-label text-lg-end col-lg-2 col-xl-3">Vacunas</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('vaccines') ? ' is-invalid' : '' }}" name="vaccines" type="text"
               id="vaccines" value="{{ old('vaccines', optional($resoluciones)->vaccines) }}" minlength="1"
               maxlength="191"  placeholder="Ingrese vacunas requeridas aquí...">
        {!! $errors->first('vaccines', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="tipo_carrera_id" class="col-form-label text-lg-end col-lg-2 col-xl-3">Tipo Carrera</label>
    <div class="col-lg-10 col-xl-9">
        <select class="form-select{{ $errors->has('tipo_carrera_id') ? ' is-invalid' : '' }}" id="tipo_carrera_id"
                name="tipo_carrera_id" required="required">
            <option value="" style="display: none;"
                    {{ old('tipo_carrera_id', optional($resoluciones)->tipo_carrera_id ?: '') == '' ? 'selected' : '' }} disabled
                    selected>Seleccione tipo carrera
            </option>
            @foreach ($TipoCarreras as $key => $TipoCarrera)
                <option
                    value="{{ $key }}" {{ old('tipo_carrera_id', optional($resoluciones)->tipo_carrera_id) == $key ? 'selected' : '' }}>
                    {{ $TipoCarrera }}
                </option>
            @endforeach
        </select>

        {!! $errors->first('tipo_carrera_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="estados_id" class="col-form-label text-lg-end col-lg-2 col-xl-3">Estados</label>
    <div class="col-lg-10 col-xl-9">
        <select class="form-select{{ $errors->has('estados_id') ? ' is-invalid' : '' }}" id="estados_id"
                name="estados_id" required="required">
            <option value="" style="display: none;"
                    {{ old('estados_id', optional($resoluciones)->estados_id ?: '') == '' ? 'selected' : '' }} disabled
                    selected>Seleccione estados
            </option>
            @foreach ($estados as $key => $estado)
                <option
                    value="{{ $key }}" {{ old('estados_id', optional($resoluciones)->estados_id) == $key ? 'selected' : '' }}>
                    {{ $estado }}
                </option>
            @endforeach
        </select>

        {!! $errors->first('estados_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

