<style>
    sup {
        color: #dc3545;
    }

    .select2-selection__rendered {
        line-height: 31px !important;
    }

    .select2-container .select2-selection--single {
        height: 35px !important;
    }

    .select2-selection__arrow {
        height: 34px !important;
    }
</style>
<h5 class="modal-title text-dark text-center" id="agregarModalLabel"> </h5>
<form action="{{ route('ciclo_lectivo_especial.store') }}" method="POST">

    <div class="row">
        <label for="ciclo_lectivo_id">Ciclo Lectivo</label>
        <select name="ciclo_lectivo_id" id="ciclo_lectivo_id" class="form-control ciclo_lectivo">
            <option value=''> - Seleccione Ciclo Lectivo -</option>
            @foreach($ciclos_lectivos as $ciclo_lectivo)
                <option value="{{ $ciclo_lectivo->id }}">{{ $ciclo_lectivo->year }}</option>
            @endforeach
        </select>


        <div class="form-group">
            <label for="regimen">Régimen:</label>
            <select class="form-control regimen" id="regimen" name="regimen">
                <option
                    value="Anual" {{ $materia->regimen == 'Anual' ? 'selected="selected"' :'' }}>
                    Anual
                </option>
                <option
                    value="Cuatrimestral (1er)" {{ $materia->regimen == 'Cuatrimestral (1er)' ?  'selected="selected"' :'' }}>
                    Cuatrimestral (1er)
                </option>
                <option
                    value="Cuatrimestral (2do)" {{ $materia->regimen == 'Cuatrimestral (2do)' ?  'selected="selected"' :'' }}>
                    Cuatrimestral (2do)
                </option>
            </select>
        </div>
        <div class="form-group mb-3">
            <label for="cierre_ciclo">Fecha regularidad especial <sup>*</sup></label>
            <input type="date" name="cierre_ciclo" id="cierre_ciclo" class="form-control"
                   value=""
                   required>
        </div>

    </div>
    <div class="col-sm-12 text-center">
        <sup>*</sup> <small>Campos requeridos</small><br/>
        <input type="hidden" name="materia_id" id="materia_id" value="{{$materia->id}}">
        <input type="hidden" name="sede_id" id="sede_id" value="{{$materia->carrera->sede->id}}">
        <input type="submit" value="Guardar" class="btn btn-primary col-12">
    </div>
</form>
<script src="{{ asset('js/sedes/sedes_carreras.js') }}"></script>
<script src="{{ asset('js/user/carreras.js') }}"></script>
<script>
    $(".ciclo_lectivo").select2({
        dropdownParent: $('#modalBody'),
        placeholder: 'Seleccione ciclo lectivo',
        width: "100%",
        theme: "classic",
        allowClear: true

    });
    $(".regimen").select2({
        dropdownParent: $('#modalBody'),
        placeholder: 'Seleccione régimen',
        theme: "classic",
        width: "100%",
        allowClear: true

    });
    $(".materias").select2({
        dropdownParent: $('#modalBody'),
        placeholder: 'Seleccione materia',
        theme: "classic",
        width: "100%",
        allowClear: true
    });

</script>


