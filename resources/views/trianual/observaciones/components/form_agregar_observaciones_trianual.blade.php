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
<div class="col-sm-5" >
    <h5 class="text-dark text-center" id="agregarObservaciones">Agregar observaciones</h5>
    <form action="{{ route('observaciones_trianual.guardar') }}" method="POST">

        <div class="row">

            <div class="form-group">
                <label for="year">Año <sup>*</sup></label>
                <select name="year" id="year" class="form-control years" required>
                    <option value=''> - Seleccione año -</option>

                        <option value="1">Primer Año</option>
                        <option value="2">Segundo Año</option>
                        <option value="3">Tercer Año</option>

                </select>
            </div>
            <div class="form-group">
                <label for="observation">Observación <sup>*</sup></label>
                <textarea name="observation" id="observation" class="form-select" required>

                </textarea>
            </div>



        </div>
        <div class="col-sm-12 text-center">
            <sup>*</sup> <small>Campos requeridos</small><br/>
            <input type="hidden" name="trianual_id" id="trianual_id" value="{{$trianual->id}}">
            <input type="submit" value="Guardar" class="btn btn-primary col-12">
        </div>
    </form>
</div>

<script src="{{ asset('js/sedes/sedes_carreras.js') }}"></script>
<script>
    $(".years").select2({
        // dropdownParent: $('#agregarBody'),
        placeholder: 'Seleccione año',
        width: "100%",
        theme: "classic",
        allowClear: true

    });

</script>
