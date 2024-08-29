<div class="mb-3 row">
    <label for="mesa_id" class="col-form-label text-lg-end col-lg-2 col-xl-3">Mesa</label>
    <div class="col-lg-10 col-xl-9">
        <select class="form-select{{ $errors->has('mesa_id') ? ' is-invalid' : '' }}" id="mesa_id" name="mesa_id">
            <option value="" style="display: none;"
                    {{ old('mesa_id', optional($mesaFolio)->mesa_id ?: '') == '' ? 'selected' : '' }} disabled selected>
                Seleccione mesa
            </option>
            @foreach ($Mesas as $key => $Mesa)
                <option value="{{ $key }}" {{ old('mesa_id', optional($mesaFolio)->mesa_id) == $key ? 'selected' : '' }}>
                    {{ $Mesa }}
                </option>
            @endforeach
        </select>

        {!! $errors->first('mesa_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="fecha" class="col-form-label text-lg-end col-lg-2 col-xl-3">Fecha</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('fecha') ? ' is-invalid' : '' }}" name="fecha" type="date" id="fecha"
               value="{{ old('fecha', optional($mesaFolio)->fecha) }}" required="required"
               placeholder="Ingrese fecha aquí...">
        {!! $errors->first('fecha', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="libro_digital_id" class="col-form-label text-lg-end col-lg-2 col-xl-3">Libro Digital</label>
    <div class="col-lg-10 col-xl-9">
        <select class="form-select{{ $errors->has('libro_digital_id') ? ' is-invalid' : '' }}" id="libro_digital_id"
                name="libro_digital_id" required="required">
            <option value="" style="display: none;"
                    {{ old('libro_digital_id', optional($mesaFolio)->libro_digital_id ?: '') == '' ? 'selected' : '' }} disabled
                    selected>Seleccione libro digital
            </option>
            @foreach ($LibrosDigitales as  $LibrosDigital)
                <option value="{{ $LibrosDigital->id }}"
                    {{ old('libro_digital_id', optional($mesaFolio)->libro_digital_id) == $LibrosDigital->id ? 'selected' : '' }}>
                    {{ $LibrosDigital->romanos }} - {{ $LibrosDigital->sede->nombre }}
                </option>
            @endforeach
        </select>

        {!! $errors->first('libro_digital_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="master_materia_id" class="col-form-label text-lg-end col-lg-2 col-xl-3">Master Materia</label>
    <div class="col-lg-10 col-xl-9">
        <select class="form-select{{ $errors->has('master_materia_id') ? ' is-invalid' : '' }}" id="master_materia_id"
                name="master_materia_id" required="required">
            <option value="" style="display: none;"
                    {{ old('master_materia_id', optional($mesaFolio)->master_materia_id ?: '') == '' ? 'selected' : '' }} disabled
                    selected>Selecciones master materia
            </option>
            @foreach ($MasterMaterias as $key => $MasterMaterium)
                <option value="{{ $key }}" {{ old('master_materia_id', optional($mesaFolio)->master_materia_id) == $key ? 'selected' : '' }}>
                    {{ $MasterMaterium }}
                </option>
            @endforeach
        </select>

        {!! $errors->first('master_materia_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="folio" class="col-form-label text-lg-end col-lg-2 col-xl-3">Folio</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('folio') ? ' is-invalid' : '' }}" name="folio" type="number"
               id="folio" value="{{ old('folio', optional($mesaFolio)->folio) }}" min="1" max="2147483647"
               required="required" placeholder="Ingrese folio aquí...">
        {!! $errors->first('folio', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="presidente_id" class="col-form-label text-lg-end col-lg-2 col-xl-3">Presidente</label>
    <div class="col-lg-10 col-xl-9">
        <select class="form-select{{ $errors->has('presidente_id') ? ' is-invalid' : '' }}" id="presidente_id"
                name="presidente_id">
            <option value="" style="display: none;"
                    {{ old('presidente_id', optional($mesaFolio)->presidente_id ?: '') == '' ? 'selected' : '' }} disabled
                    selected>Seleccione presidente
            </option>
            @foreach ($Users as $User)
                <option value="{{ $User->id }}" {{ old('presidente_id', optional($mesaFolio)->presidente_id) == $Users->id ? 'selected' : '' }}>
                    {{ $User->getApellidoNombre() }}
                </option>
            @endforeach
        </select>

        {!! $errors->first('presidente_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="turno" class="col-form-label text-lg-end col-lg-2 col-xl-3">Turno</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('turno') ? ' is-invalid' : '' }}" name="turno" type="text" id="turno"
               value="{{ old('turno', optional($mesaFolio)->turno) }}" maxlength="191"
               placeholder="Ingrese turno aquí...">
        {!! $errors->first('turno', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="vocal_1_id" class="col-form-label text-lg-end col-lg-2 col-xl-3">Vocal 1</label>
    <div class="col-lg-10 col-xl-9">
        <select class="form-select{{ $errors->has('vocal_1_id') ? ' is-invalid' : '' }}" id="vocal_1_id"
                name="vocal_1_id">
            <option value="" style="display: none;"
                    {{ old('vocal_1_id', optional($mesaFolio)->vocal_1_id ?: '') == '' ? 'selected' : '' }} disabled
                    selected>Seleccione vocal 1
            </option>
            @foreach ($Users as $key => $User)
                <option value="{{ $key }}" {{ old('vocal_1_id', optional($mesaFolio)->vocal_1_id) == $key ? 'selected' : '' }}>
                    {{ $User }}
                </option>
            @endforeach
        </select>

        {!! $errors->first('vocal_1_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="vocal_2_id" class="col-form-label text-lg-end col-lg-2 col-xl-3">Vocal 2</label>
    <div class="col-lg-10 col-xl-9">
        <select class="form-select{{ $errors->has('vocal_2_id') ? ' is-invalid' : '' }}" id="vocal_2_id"
                name="vocal_2_id">
            <option value="" style="display: none;"
                    {{ old('vocal_2_id', optional($mesaFolio)->vocal_2_id ?: '') == '' ? 'selected' : '' }} disabled
                    selected>Seleccione vocal 2
            </option>
            @foreach ($Users as $key => $User)
                <option value="{{ $key }}" {{ old('vocal_2_id', optional($mesaFolio)->vocal_2_id) == $key ? 'selected' : '' }}>
                    {{ $User }}
                </option>
            @endforeach
        </select>

        {!! $errors->first('vocal_2_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="aprobados" class="col-form-label text-lg-end col-lg-2 col-xl-3">Aprobados</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('aprobados') ? ' is-invalid' : '' }}" name="aprobados" type="number"
               id="aprobados" value="{{ old('aprobados', optional($mesaFolio)->aprobados) }}" min="-2147483648"
               max="2147483647" placeholder="Ingrese aprobados aquí...">
        {!! $errors->first('aprobados', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="desaprobados" class="col-form-label text-lg-end col-lg-2 col-xl-3">Desaprobados</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('desaprobados') ? ' is-invalid' : '' }}" name="desaprobados"
               type="number" id="desaprobados" value="{{ old('desaprobados', optional($mesaFolio)->desaprobados) }}"
               min="-2147483648" max="2147483647" placeholder="Ingrese desaprobados aquí...">
        {!! $errors->first('desaprobados', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="ausentes" class="col-form-label text-lg-end col-lg-2 col-xl-3">Ausentes</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('ausentes') ? ' is-invalid' : '' }}" name="ausentes" type="number"
               id="ausentes" value="{{ old('ausentes', optional($mesaFolio)->ausentes) }}" min="-2147483648"
               max="2147483647" placeholder="Ingrese ausentes aquí...">
        {!! $errors->first('ausentes', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="coordinador_id" class="col-form-label text-lg-end col-lg-2 col-xl-3">Coordinador</label>
    <div class="col-lg-10 col-xl-9">
        <select class="form-select{{ $errors->has('coordinador_id') ? ' is-invalid' : '' }}" id="coordinador_id"
                name="coordinador_id">
            <option value="" style="display: none;"
                    {{ old('coordinador_id', optional($mesaFolio)->coordinador_id ?: '') == '' ? 'selected' : '' }} disabled
                    selected>Select coordinador
            </option>
            @foreach ($Users as $key => $User)
                <option value="{{ $key }}" {{ old('coordinador_id', optional($mesaFolio)->coordinador_id) == $key ? 'selected' : '' }}>
                    {{ $User }}
                </option>
            @endforeach
        </select>

        {!! $errors->first('coordinador_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<script>

    $(document).ready(function () {
        $('#mesa_id').select2({
            width: "100%",
            theme: "classic",
            placeholder: "Seleccione mesa",
            allowClear: true
        });
        $('#libro_digital_id').select2({
            width: "100%",
            theme: "classic",
            placeholder: "Seleccione libro",
            allowClear: true
        });
        $('#master_materia_id').select2({
            width: "100%",
            theme: "classic",
            placeholder: "Seleccione materia",
            allowClear: true
        });
        $('#presidente_id').select2({
            width: "100%",
            theme: "classic",
            placeholder: "Seleccione profesor",
            allowClear: true
        });
        $('#vocal_1_id').select2({
            width: "100%",
            theme: "classic",
            placeholder: "Seleccione profesor",
            allowClear: true
        });
        $('#vocal_2_id').select2({
            width: "100%",
            theme: "classic",
            placeholder: "Seleccione profesor",
            allowClear: true
        });
        $('#coordinador_id').select2({
            width: "100%",
            theme: "classic",
            placeholder: "Seleccione profesor",
            allowClear: true
        });

    });
</script>
