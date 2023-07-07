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
    <h5 class="text-dark text-center" id="agregarMateria">Agregar materia</h5>
    <form action="{{ route('detalleTrianual.guardar') }}" method="POST">

        <div class="row">

            <div class="form-group">
                <label for="materia_id">Materia <sup>*</sup></label>
                <select name="materia_id" id="materia_id" class="form-control materias" required>
                    <option value=''> - Seleccione materia -</option>
                    @foreach($trianual->getCarrera()->materias()->get() as $materia)
                        <option value="{{ $materia->id }}">{{ $materia->nombre }} - ({{$materia->año}} año)</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="condicion_id">Condición <sup>*</sup></label>
                <select name="condicion_id" id="condicion_id" class="form-select estados" required>
                    <option value=''> - Seleccione condición -</option>
                    @foreach($estados as $estado)
                        <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="recursado">Recursado <sup>*</sup></label>
                <select name="recursado" id="recursado" class="form-select recursado" required>

                    <option value="0" selected>No Recursa</option>
                    <option value="1">1<sup>er</sup> Recursado</option>
                    <option value="2">2<sup>do</sup> Recursado</option>

                </select>
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
    $(".materias").select2({
        // dropdownParent: $('#agregarBody'),
        placeholder: 'Seleccione materia',
        width: "100%",
        theme: "classic",
        allowClear: true

    });
    $(".estados").select2({
        // dropdownParent: $('#agregarBody'),
        placeholder: 'Seleccione condición',
        theme: "classic",
        width: "100%",
        allowClear: true

    });
    $(".recursado").select2({
        // dropdownParent: $('#agregarBody'),
        placeholder: 'Seleccione si recursa',
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


