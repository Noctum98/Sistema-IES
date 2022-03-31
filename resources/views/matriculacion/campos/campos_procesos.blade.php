<div class="card mt-3 mb-3">
    <h5 class="card-header">INFORMACIÓN INSCRIPCIÓN</h5>
    <div class="card-body">
        <h6>Recuerda, si eliminas todas las matriculaciónes, deberás volver a matricularte correctamente.</h6>
        <a href="{{ route('descargar_ficha',$matriculacion->id) }}" class="mt-2 btn btn-sm btn-success">Descargar PDF</a>
        <br><br>
        <strong>Inscripto a:</strong>
        <br>
        @foreach($matriculacion->carreras as $carrera)
        <hr>
       <strong> _ {{ $carrera->nombre.' ('.ucwords($carrera->turno).') - '.$carrera->sede->nombre }} </strong>
        <br>
        _ Año: {{ $matriculacion->procesoCarrera($carrera->id,$matriculacion->id)->año }}
        <br>
        <br>
        @foreach($matriculacion->procesos as $proceso)

        @if($proceso->materia->carrera_id == $carrera->id)
            <p>{{$proceso->materia->nombre}}</p> 
        @endif

        @endforeach
        <form class="col-md-6 ml-0 pl-0" action="{{ route('matriculacion.delete',['id'=>$matriculacion->id,'carrera_id'=>$carrera->id,'year'=>$año]) }}" method="POST">
            {{ method_field('DELETE') }}
            <button type="submit" class="btn btn-sm btn-danger">Eliminar matriculación</button>
        </form>
        <br>
        @endforeach
    </div>
    
</div>