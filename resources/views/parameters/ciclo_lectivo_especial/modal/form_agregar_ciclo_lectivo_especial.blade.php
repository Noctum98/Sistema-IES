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
        <div class="form-group">
            <label for="sedes">Sedes</label>
            <select name="sedes" id="sedes" class="form-control sedes">
                <option value=''> - Seleccione sede -</option>
                @foreach($sedes as $sede)
                    <option value="{{ $sede->id }}">{{ $sede->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="carreras">Carreras<sup>*</sup></label>
            <select name="carrera_id" id="carreras" class="form-select carreras">

            </select>
        </div>

        <div class="form-group">
            <label for="materia_id">Materias</label>
            <select name="materia_id" id="materia_id" required class="form-select materias">

            </select>
        </div>

        <div class="form-group mb-3">
            <label for="cierre_ciclo">Fecha regularidad especial <sup>*</sup></label>
            <input type="date" name="cierre_ciclo" id="cierre_ciclo" class="form-control"
                   value="{{date_format(new DateTime($ciclo_lectivo->anual),'Y-m-d' )}}"
                   required>
        </div>

    </div>
    <div class="col-sm-12 text-center">
        <sup>*</sup> <small>Campos requeridos</small><br/>
        <input type="hidden" name="ciclo_lectivo_id" id="ciclo_lectivo_id" value="{{$ciclo_lectivo->id}}">
        <input type="submit" value="Guardar" class="btn btn-primary col-12">
    </div>
</form>
<script src="{{ asset('js/sedes/sedes_carreras.js') }}"></script>
<script src="{{ asset('js/user/carreras.js') }}"></script>
<script>
    $(".sedes").select2({
        dropdownParent: $('#modalBody'),
        placeholder: 'Seleccione sede',
        width: "100%",
        theme: "classic",
        allowClear: true

    });
    $(".carreras").select2({
        dropdownParent: $('#modalBody'),
        placeholder: 'Seleccione carrera',
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


