<div class="mb-3 row">
    <label for="fecha" class="col-form-label text-lg-end col-lg-2 col-xl-3">Fecha</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('fecha') ? ' is-invalid' : '' }}" name="fecha" type="date" id="fecha"
               value="{{ old('fecha', optional($mesaFolio)->fecha) }}" required="required"
               placeholder="Ingrese fecha aquí...">
        {!! $errors->first('fecha', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<input type="hidden" name="libro_digital_id" value="{{ $libroDigital->id }}">

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
                <option
                    value="{{ $key }}" {{ old('master_materia_id', optional($mesaFolio)->master_materia_id) == $key ? 'selected' : '' }}>
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
    <label for="turno" class="col-form-label text-lg-end col-lg-2 col-xl-3">Turno</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('turno') ? ' is-invalid' : '' }}" name="turno" type="text" id="turno"
               value="{{ old('turno', optional($mesaFolio)->turno) }}" maxlength="191"
               placeholder="Ingrese turno aquí...">
        {!! $errors->first('turno', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="presidente_id" class="col-form-label text-lg-end col-lg-2 col-xl-3">Presidente</label>
    <div class="col-lg-10 col-xl-9">
        <input type="text" id="presidenteSearch" placeholder="Buscar...">
        <select class="form-select{{ $errors->has('presidente_id') ? ' is-invalid' : '' }}" id="presidente_id"
                name="presidente_id">
            <option value="" style="display: none;"
                    {{ old('presidente_id', optional($mesaFolio)->presidente_id ?: '') == '' ? 'selected' : '' }} disabled
                    selected>Seleccione presidente
            </option>
            @foreach ($Users as $User)
                <option value="{{ $User->id }}"
                        {{ old('presidente_id', optional($mesaFolio)->presidente_id) == $User->id ? 'selected' : '' }}
                        data-user-name="{{ $User->getApellidoNombre() }}">
                    <!-- Añadimos un atributo de datos para facilitar la búsqueda -->
                    {{ $User->getApellidoNombre() }}
                </option>
            @endforeach
        </select>

        {!! $errors->first('presidente_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="vocal_1_id" class="col-form-label text-lg-end col-lg-2 col-xl-3">1° Vocal </label>
    <div class="col-lg-10 col-xl-9">
        <input type="text" id="vocal_1Search" placeholder="Buscar...">
        <select class="form-select{{ $errors->has('vocal_1_id') ? ' is-invalid' : '' }}" id="vocal_1_id"
                name="vocal_1_id">
            <option value="" style="display: none;"
                    {{ old('vocal_1_id', optional($mesaFolio)->vocal_1_id ?: '') == '' ? 'selected' : '' }} disabled
                    selected>Seleccione 1° Vocal
            </option>
            @foreach ($Users as $User)
                <option value="{{ $User->id }}"
                        {{ old('vocal_1_id', optional($mesaFolio)->vocal_1_id) == $User->id ? 'selected' : '' }}
                        data-user-name="{{ $User->getApellidoNombre() }}">
                    <!-- Añadimos un atributo de datos para facilitar la búsqueda -->
                    {{ $User->getApellidoNombre() }}
                </option>
            @endforeach
        </select>

        {!! $errors->first('vocal_1_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="vocal_2_id" class="col-form-label text-lg-end col-lg-2 col-xl-3">2° Vocal </label>
    <div class="col-lg-10 col-xl-9">
        <input type="text" id="vocal_2Search" placeholder="Buscar...">
        <select class="form-select{{ $errors->has('vocal_2_id') ? ' is-invalid' : '' }}" id="vocal_2_id"
                name="vocal_2_id">
            <option value="" style="display: none;"
                    {{ old('vocal_2_id', optional($mesaFolio)->vocal_2_id ?: '') == '' ? 'selected' : '' }} disabled
                    selected>Seleccione 2° Vocal
            </option>
            @foreach ($Users as $User)
                <option value="{{ $User->id }}"
                        {{ old('vocal_2_id', optional($mesaFolio)->vocal_2_id) == $User->id ? 'selected' : '' }}
                        data-user-name="{{ $User->getApellidoNombre() }}">
                    <!-- Añadimos un atributo de datos para facilitar la búsqueda -->
                    {{ $User->getApellidoNombre() }}
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
    <label for="coordinador_id" class="col-form-label text-lg-end col-lg-2 col-xl-3">Coordinador </label>
    <div class="col-lg-10 col-xl-9">
        <input type="text" id="coordinadorSearch" placeholder="Buscar...">
        <select class="form-select{{ $errors->has('coordinador_id') ? ' is-invalid' : '' }}" id="coordinador_id"
                name="coordinador_id">
            <option value="" style="display: none;"
                    {{ old('coordinador_id', optional($mesaFolio)->coordinador_id ?: '') == '' ? 'selected' : '' }} disabled
                    selected>Seleccione Coordinador
            </option>
            @foreach ($Users as $User)
                <option value="{{ $User->id }}"
                        {{ old('coordiandor_id', optional($mesaFolio)->coordinador_id) == $User->id ? 'selected' : '' }}
                        data-user-name="{{ $User->getApellidoNombre() }}">
                    <!-- Añadimos un atributo de datos para facilitar la búsqueda -->
                    {{ $User->getApellidoNombre() }}
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

        function buscarUsuario(inputId, selectId) {
            const inputValue = $(`#${inputId}`).val();
            $.ajax({
                url: '/usuarios/buscar_usuario',
                data: {
                    'nombre': inputValue
                },
                success: function(data) {
                    $(`#${selectId}`).empty();
                    $.each(data, function(key, user) {
                        $(`#${selectId}`).append($('<option></option>')
                            .attr('value', user.id)
                            .text(user.apellido + ', '+ user.nombre));
                    });
                }
            });
        }

        $('#presidenteSearch, #vocal_1Search, #vocal_2Search, #coordinadorSearch').on('keyup', function() {
            const inputId = this.id;
            const selectId = inputId.replace('Search', '_id');
            buscarUsuario(inputId, selectId);
        });

    });
</script>
