<div class="mb-3 row">
    <label for="acta_volante_id" class="col-form-label text-lg-end col-lg-2 col-xl-3">Acta Volante</label>
    <div class="col-lg-10 col-xl-9">
        <select class="form-select{{ $errors->has('acta_volante_id') ? ' is-invalid' : '' }}" id="acta_volante_id"
                name="acta_volante_id">
            <option value="" style="display: none;"
                    {{ old('acta_volante_id', optional($folioNota)->acta_volante_id ?: '') == '' ? 'selected' : '' }} disabled
                    selected>Seleccione Acta Volante
            </option>
            @foreach ($ActasVolantes as $key => $ActasVolante)
                <option
                    value="{{ $key }}" {{ old('acta_volante_id', optional($folioNota)->acta_volante_id) == $key ? 'selected' : '' }}>
                    {{ $ActasVolante }}
                </option>
            @endforeach
        </select>

        {!! $errors->first('acta_volante_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="mesa_folio_id" class="col-form-label text-lg-end col-lg-2 col-xl-3">Folio (Mesa)</label>
    <div class="col-lg-10 col-xl-9">
        <select class="form-select{{ $errors->has('mesa_folio_id') ? ' is-invalid' : '' }}" id="mesa_folio_id"
                name="mesa_folio_id" required="required">
            <option value="" style="display: none;"
                    {{ old('mesa_folio_id', optional($folioNota)->mesa_folio_id ?: '') == '' ? 'selected' : '' }} disabled
                    selected>Seleccione Folio
            </option>
            @foreach ($MesaFolios as $key => $MesaFolio)
                <option
                    value="{{ $key }}" {{ old('mesa_folio_id', optional($folioNota)->mesa_folio_id) == $key ? 'selected' : '' }}>
                    {{ $MesaFolio }}
                </option>
            @endforeach
        </select>

        {!! $errors->first('mesa_folio_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="orden" class="col-form-label text-lg-end col-lg-2 col-xl-3">Orden</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('orden') ? ' is-invalid' : '' }}" name="orden" type="number"
               id="orden" value="{{ old('orden', optional($folioNota)->orden) }}" min="1" max="26"
               required="required" placeholder="Ingrese orden aquí...">
        {!! $errors->first('orden', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="permiso" class="col-form-label text-lg-end col-lg-2 col-xl-3">Permiso</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('permiso') ? ' is-invalid' : '' }}" name="permiso" type="number"
               id="permiso" value="{{ old('permiso', optional($folioNota)->permiso) }}" min="1"
               max="2147483647" placeholder="Ingrese permiso aquí...">
        {!! $errors->first('permiso', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="alumno_id" class="col-form-label text-lg-end col-lg-2 col-xl-3">Alumno</label>
    <div class="col-lg-10 col-xl-9">
        <select class="form-select{{ $errors->has('alumno_id') ? ' is-invalid' : '' }}" id="alumno_id" name="alumno_id">
            <option value="" style="display: none;"
                    {{ old('alumno_id', optional($folioNota)->alumno_id ?: '') == '' ? 'selected' : '' }} disabled
                    selected>Seleccione Alumno
            </option>
            @foreach ($Alumnos as $key => $Alumno)
                <option
                    value="{{ $key }}" {{ old('alumno_id', optional($folioNota)->alumno_id) == $key ? 'selected' : '' }}>
                    {{ $Alumno }}
                </option>
            @endforeach
        </select>

        {!! $errors->first('alumno_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>


<div class="mb-3 row">
    <label for="escrito" class="col-form-label text-lg-end col-lg-2 col-xl-3">Escrito</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('escrito') ? ' is-invalid' : '' }}" name="escrito" type="number"
               id="escrito" value="{{ old('escrito', optional($folioNota)->escrito) }}" min="0"
               max="10" placeholder="Ingrese nota escrito aquí...">
        {!! $errors->first('escrito', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>


<div class="mb-3 row">
    <label for="oral" class="col-form-label text-lg-end col-lg-2 col-xl-3">Oral</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('oral') ? ' is-invalid' : '' }}" name="oral" type="number" id="oral"
               value="{{ old('oral', optional($folioNota)->oral) }}" min="0" max="10"
               placeholder="Ingrese nota oral aquí...">
        {!! $errors->first('oral', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="definitiva" class="col-form-label text-lg-end col-lg-2 col-xl-3">Calificación Definitiva</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('definitiva') ? ' is-invalid' : '' }}" name="definitiva" type="number"
               id="definitiva" value="{{ old('definitiva', optional($folioNota)->definitiva) }}" min="0"
               max="10" placeholder="Ingrese calificación definitiva aquí...">
        {!! $errors->first('definitiva', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
