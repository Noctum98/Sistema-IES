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
<form action="{{ route('ciclo_lectivo_especial.store', ['materia'=> 429]) }}" method="POST">

    <div class="row">


    </div>
    <div class="col-sm-12 text-center">
        <sup>*</sup> <small>Campos requeridos</small><br/>
        <input type="hidden" name="alumno" id="alumno" value="{{$alumno->id}}">
        <input type="submit" value="Guardar" class="btn btn-primary col-12">
    </div>
</form>
<script src="{{ asset('js/sedes/sedes_carreras.js') }}"></script>
<script>
    $(".sedes").select2({
        dropdownParent: $('#agregarBody'),
        placeholder: 'Seleccione sede',
        width: "100%",
        theme: "classic",
        allowClear: true

    });
    $(".carreras").select2({
        dropdownParent: $('#agregarBody'),
        placeholder: 'Seleccione carrera',
        theme: "classic",
        width: "100%",
        allowClear: true

    });
    $(".preceptor").select2({
        dropdownParent: $('#agregarBody'),
        placeholder: 'Seleccione preceptor',
        theme: "classic",
        width: "100%",
        allowClear: true

    });
    $(".coordinator").select2({
        dropdownParent: $('#agregarBody'),
        placeholder: 'Seleccione coordinador',
        theme: "classic",
        width: "100%",
        allowClear: true

    });
</script>


