<h1 class="text-info mt-3">Inscripciones</h2>

    @if(count($inscripciones) > 0 )
    @foreach($inscripciones as $inscripcion)
    <div class="card p-4 mb-4">
        <strong>{{$inscripcion->carrera->nombre.'('.ucwords($inscripcion->carrera->turno).'-'. $inscripcion->carrera->resolucion .') - '.$inscripcion->carrera->sede->nombre}}</strong>
        <table class="table mt-2 col-md-12">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Año</th>
                    <th scope="col">Ciclo Lectivo</th>

                    <th scope="col">Cohorte</th>

                    <th scope="col">Conidición</th>
                    <th scope="col">Legajo Completo</th>
                    <th scope="col">1er Acreditación:</th>
                    <th scope="col">Última Acreditación:</th>
                    <th scope="col">Libreta</th>

                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $inscripcion->año.'°' }}</td>
                    <td>{{ $inscripcion->ciclo_lectivo }}</td>
                    <td>{{ $inscripcion->cohorte ?? 'No indicada' }}</td>
                    <td>
                        {{ $inscripcion->regularidad ? explode("_",ucwords($inscripcion->regularidad))[0].' '.explode("_",ucwords($inscripcion->regularidad))[1] : 'Sin asignar' }}
                    </td>
                    <td>{{ $inscripcion->legajo_completo ? 'SI' : 'NO' }}</td>
                    <td>{{ $inscripcion->fecha_primera_acreditacion ?? 'No indicada'}}</td>
                    <td>{{ $inscripcion->fecha_ultima_acreditacion ?? 'No indicada'}}</td>

                    <td>
                        <a href="{{route('proceso.alumnoCarrera', ['idAlumno'=>$alumno->id, 'idCarrera' => $inscripcion->carrera_id])}}" class="btn btn-sm btn-info">
                            <i class="fa fa-eye"></i> Ver Libreta
                        </a>
                    </td>


                </tr>
            </tbody>
        </table>
        <div class="row col-md-12">
            @if(Session::has('admin') || Session::has('regente') || Session::has('coordinador') || Session::has('seccionAlumnos'))
            @if(!$inscripcion->aprobado)
            <a href="{{ route('crear_usuario_alumno',['id'=>$inscripcion->id]) }}" class="col-md-2 mr-2 btn btn-sm btn-success">
                Confirmar alumno
            </a>
            @endif
            <a href="{{ route('proceso.admin',['alumno_id' => $alumno->id,'carrera_id' =>$inscripcion->carrera_id,'ciclo_lectivo'=>$ciclo_lectivo]) }}" class="btn btn-sm btn-light col-md-2 mr-2">Ver materias</a>

            <button class="btn btn-sm btn-primary col-md-2 mr-2" data-bs-toggle="modal" data-bs-target="#carrerasAñoModal{{$inscripcion->carrera_id}}"> Editar datos</button>

            @include('alumno.modals.carreras_year')
            @elseif(Session::has('areaSocial'))
            @if(Auth::user()->hasCarrera($inscripcion->carrera_id) || Session::has('areaSocial'))
            <button class="btn btn-sm btn-warning col-md-3 mr-2" data-bs-toggle="modal" data-bs-target="#carrerasMatriculacionModal{{$inscripcion->carrera_id}}">Ver
                materias
            </button>
            @include('alumno.modals.carreras_matriculacion')
            @endif
            @elseif(Session::has('alumno'))
            <button class="btn btn-sm btn-primary col-md-3 mr-2" data-bs-toggle="modal" data-bs-target="#carrerasMatriculacionModal{{$inscripcion->carrera_id}}">Ver
                materias inscriptas {{$ciclo_lectivo}}
            </button>
            @include('alumno.modals.carreras_matriculacion')
            @endif
            @if(Session::has('admin'))
            <button class="btn btn-sm btn-secondary col-md-2 ml-2" data-bs-toggle="modal" data-bs-target="#eliminarMatriculacionModal{{$inscripcion->carrera_id}}">
                Eliminar
                Inscripción
            </button>
            @include('alumno.modals.correo_eliminar')
            @elseif(Session::has('regente') || Session::has('coordinador'))
            @if(Auth::user()->hasCarrera($inscripcion->carrera_id))
            <button class="btn btn-sm btn-secondary col-md-3" data-bs-toggle="modal" data-bs-target="#eliminarMatriculacionModal{{$inscripcion->carrera_id}}">
                Eliminar Inscripción
            </button>
            @include('alumno.modals.correo_eliminar')
            @endif
            @endif
        </div>
    </div>

    @endforeach
    @else
    <p>Ninguna carrera.</p>
    @endif