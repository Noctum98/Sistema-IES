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
<h5 class="modal-title text-dark text-center" id="agregarModalLabel">Trianual: <i>{{$alumno->getApellidosNombresAttribute()}}</i> </h5>
<form action="{{ route('ciclo_lectivo_especial.store') }}" method="POST">

    <div class="row">
        @foreach($campos as $campo)
            @if($campo == 'carrera')
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
            @endif
            @if($campo == 'cohorte')
                <div class="form-group mb-3 col-sm-6">
                    <label for="cohorte">Cohorte<sup>*</sup></label>
                    <input id="cohorte" name="cohorte" class="form-control" type="number" min="1986" required>
                </div>
            @endif
            @if($campo == 'matricula')
                <div class="form-group mb-3 col-sm-6">
                    <label for="matricula">Matrícula</label>
                    <input id="matricula" name="matricula" class="form-control" type="text">
                </div>
            @endif
            @if($campo == 'resolucion')
                <div class="form-group mb-3">
                    <label for="resolucion">Resolución<sup>*</sup></label>
                    <input id="resolucion" name="resolucion" class="form-control" type="text">
                </div>
            @endif

            @if($campo == 'libro')
                <div class="form-group mb-3 col-6">
                    <label for="libro">Libro</label>
                    <input id="libro" name="libro" class="form-control" type="text">
                </div>
            @endif
            @if($campo == 'folio')
                <div class="form-group mb-3 col-6">
                    <label for="folio">Folio</label>
                    <input id="folio" name="folio" class="form-control" type="text">
                </div>
            @endif
            @if($campo == 'promedio')
                <div class="form-group mb-3 col-6">
                    <label for="promedio">Promedio</label>
                    <input id="promedio" name="promedio" class="form-control" type="number">
                </div>
            @endif
            @if($campo == 'fecha_egreso')
                <div class="form-group mb-3 col-6">
                    <label for="fecha_egreso">Fecha egreso</label>
                    <input id="fecha_egreso" name="fecha_egreso" class="form-control" type="date">
                </div>
            @endif
            @if($campo == 'preceptor')
                <div class="form-group mb-3">
                    <label for="preceptor">Preceptor</label>
                    <select name="preceptor" id="preceptor" class="form-control preceptor">
                        <option value=''> - Seleccione preceptor -</option>
                        @foreach($bedeles as $bedel)
                            <option value="{{ $bedel->id }}">{{ $bedel->nombre }}</option>
                        @endforeach
                    </select>

                </div>
            @endif
            @if($campo == 'coordinator')
                <div class="form-group mb-3">
                    <label for="coordinator">Coordinador</label>
                    <select name="coordinator" id="coordinator" class="form-control coordinator">
                        <option value=''> - Seleccione coordinador -</option>
                        @foreach($coordinadores as $coordinador)
                            <option value="{{ $coordinador->id }}">{{ $coordinador->nombre }}</option>
                        @endforeach
                    </select>

                </div>
            @endif
        @endforeach

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


