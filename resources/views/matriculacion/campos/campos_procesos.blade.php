<div class="card mt-3 mb-3">
    <h5 class="card-header text-secondary">INFORMACIÓN INSCRIPCIÓN</h5>
    <div class="card-body">
        <h6 class="text-secondary">Recuerda, si eliminas todas las inscripciones, deberás volver a inscribirte correctamente.</h6>
        <a href="{{ route('descargar_ficha',$matriculacion->id) }}" target="__blank" class="mt-2 btn btn-sm btn-success"><i class="fas fa-download"></i> Descargar PDF</a>
        <br><br>
        <strong>Inscripto a:</strong>
        <br>

        <hr>
        <strong> _ {{ $carrera->nombre.' ('.ucwords($carrera->turno).') - '.$carrera->sede->nombre }} </strong>
        <br>
        _ Año: {{ $matriculacion->procesoCarrera($carrera->id,$matriculacion->id)->año }}
        <br>
        <br>
        <p>Materias {{date('Y')}}: </p>

        @if($matriculacion->procesos_actuales->count() > 0)
        @foreach($matriculacion->procesos_actuales as $proceso)

        @if($proceso->materia->carrera_id == $carrera->id)
        <p id="{{ $proceso->id }}">{{$proceso->materia->nombre.' ('.$proceso->materia->año.'° año)'}} - <span class="text-danger procesos" id="{{ $proceso->id.'-'.$matriculacion->id }}" style="cursor:pointer"><i class="fas fa-times"></i></span></p>
        @endif
        @endforeach

        <div class="spinner-border text-secondary d-none" role="status" id="spinner">
            <span class="sr-only">Loading...</span>
        </div> @else
        <p>No tienes ninguna inscripción.</p>
        @endif

        @if(!Auth::user())
        <form class="col-md-6 ml-0 pl-0" action="{{ route('matriculacion.delete',['id'=>$matriculacion->id,'carrera_id'=>$carrera->id,'year'=>$año]) }}" method="POST">
            {{ method_field('DELETE') }}
            <button type="submit" class="btn btn-sm btn-danger">Eliminar inscripción</button>
        </form>
        @endif
        <br>
    </div>

</div>