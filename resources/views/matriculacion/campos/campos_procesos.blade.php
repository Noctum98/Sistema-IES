<div class="card mt-3 mb-3">
    <h5 class="card-header text-secondary">INFORMACIÓN INSCRIPCIÓN</h5>
    <div class="card-body">
        <div class="alert alert-secondary">
        <h3 class="text-primary">LE RECOMENDAMOS QUE DISPONGA DE TIEMPO ANTES DE LLENAR ESTE FORMULARIO YA QUE ES EXTENSO, PASOS A SEGUIR:</h3>
        <BR>
        <h3>1 - LLENAR DATOS PERSONALES Y GENERALES</h3>
        <h3>2 - REALIZAR INSCRIPCIÓN A MATERIAS</h3>
        <h3>3 - COMPLETAR ENCUESTA SOCIECONOMICA</h3>
        <h3>4 - COMPLETAR ENCUESTA MOTIVACIONAL</h3>
        </div>
        
        <strong>Inscripto a:</strong>
        <br>
        <hr>
        <strong> _ {{ $carrera->nombre.' ('.ucwords($carrera->turno).') - '.$carrera->sede->nombre }} </strong>
        <br>
        _ Año: {{ $matriculacion->lastProcesoCarrera($carrera->id)->año }}

    </div>

</div>

{{--
    @if($matriculacion->procesos_actuales->count() > 0)
        <p>Materias {{date('Y')}}: </p>

        
        @foreach($matriculacion->procesos_actuales as $proceso)

        @if($proceso->materia->carrera_id == $carrera->id)
        <p id="{{ $proceso->id }}">{{$proceso->materia->nombre.' ('.$proceso->materia->año.'° año)'}} </p>
        @endif
        @endforeach

        <div class="spinner-border text-secondary d-none" role="status" id="spinner">
            <span class="sr-only">Loading...</span>
        </div> 
        @endif    
--}}