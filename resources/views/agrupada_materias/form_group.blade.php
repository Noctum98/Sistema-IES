<div class="mb-3 row">
    <h4 class="col-form-label text-lg-end col-lg-2 col-xl-3">
        Correlatividad Agrupada <b>{{ $correlatividadAgrupada->name }}</b>
    </h4>
    <input type="hidden" id="correlatividad_agrupada_id" name="correlatividad_agrupada_id"
           value="{{ old('correlatividad_agrupada_id', optional($correlatividadAgrupada)->id) }}">
</div>
<div class="mb-3 row">
    <label for="master_materia_id" class="col-form-label text-lg-end col-lg-2 col-xl-3">Master Materia</label>
    <div class="col-lg-10 col-xl-9">
        <select class="form-select{{ $errors->has('master_materia_id') ? ' is-invalid' : '' }}" id="master_materia_id"
                name="master_materia_id[]" required="required" multiple="multiple">
            <option value="" style="display: none;"
            @foreach ($MasterMaterias as $key => $masterMateria)
                {{--                <option value="" style="display: none;"--}}
                {{--                        {{ old('master_materia_id', optional($agrupadaMateria)->master_materia_id ?: '') == '' ? 'selected' : '' }} disabled--}}
                {{--                        selected>Seleccione una materia--}}
                {{--                </option>--}}
                <option
                    value="{{ $key }}" {{ old('master_materia_id', optional($agrupadaMateria)->master_materia_id) == $key ? 'selected' : '' }}>
                    {{ $masterMateria }}
                </option>
            @endforeach
        </select>

        {!! $errors->first('master_materia_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
