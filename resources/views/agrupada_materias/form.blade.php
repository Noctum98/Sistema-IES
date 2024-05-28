<div class="mb-3 row">
    <label for="correlatividad_agrupada_id" class="col-form-label text-lg-end col-lg-2 col-xl-3">Correlatividad
        Agrupada</label>
    <div class="col-lg-10 col-xl-9">
        <select class="form-select{{ $errors->has('correlatividad_agrupada_id') ? ' is-invalid' : '' }}"
                id="correlatividad_agrupada_id" name="correlatividad_agrupada_id" required="required">
            <option value="" style="display: none;"
                    {{ old('correlatividad_agrupada_id', optional($agrupadaMateria)->correlatividad_agrupada_id ?: '') == '' ? 'selected' : '' }} disabled
                    selected>Seleccione una correlatividad agrupada
            </option>
            @foreach ($CorrelatividadAgrupadas as $key => $CorrelatividadAgrupada)
                <option
                    value="{{ $key }}" {{ old('correlatividad_agrupada_id', optional($agrupadaMateria)->correlatividad_agrupada_id) == $key ? 'selected' : '' }}>
                    {{ $CorrelatividadAgrupada }}
                </option>
            @endforeach
        </select>

        {!! $errors->first('correlatividad_agrupada_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="disabled" class="col-form-label text-lg-end col-lg-2 col-xl-3">Deshabilitada</label>
    <div class="col-lg-10 col-xl-9">
        <div class="form-check checkbox">
            <input id="disabled_1" class="form-check-input" name="disabled" type="checkbox"
                   value="1" {{ old('disabled', optional($agrupadaMateria)->disabled) == '1' ? 'checked' : '' }}>
            <label class="form-check-label" for="disabled_1">
                Si
            </label>
        </div>


        {!! $errors->first('disabled', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="master_materia_id" class="col-form-label text-lg-end col-lg-2 col-xl-3">Master Materia</label>
    <div class="col-lg-10 col-xl-9">
        <select class="form-select{{ $errors->has('master_materia_id') ? ' is-invalid' : '' }}" id="master_materia_id"
                name="master_materia_id" required="required">
            <option value="" style="display: none;"
                    {{ old('master_materia_id', optional($agrupadaMateria)->master_materia_id ?: '') == '' ? 'selected' : '' }} disabled
                    selected>Seleccione una materia
            </option>
            @foreach ($MasterMaterias as $key => $masterMateria)
                <option
                    value="{{ $key }}" {{ old('master_materia_id', optional($agrupadaMateria)->master_materia_id) == $key ? 'selected' : '' }}>
                    {{ $masterMateria }}
                </option>
            @endforeach
        </select>

        {!! $errors->first('master_materia_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
