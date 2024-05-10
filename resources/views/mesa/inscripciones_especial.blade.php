@extends('layouts.app-prueba')
@section('content')
<div class="container">
    <h2 class="h1 text-info">
        Inscripciones en {{$materia->nombre}}
    </h2>
    <hr>
    @if(@session('baja_exitosa'))
    <div class="alert alert-warning">
        {{@session('baja_exitosa')}}
    </div>
    @endif
    @if(@session('alumno_success'))
    <div class="alert alert-success">
        {{@session('alumno_success')}}
    </div>
    @endif
    @if(@session('alumno_error'))
    <div class="alert alert-danger">
        {{@session('alumno_error')}}
    </div>
    @endif



    <div class="row">
        @if(Session::has('coordinador') || Session::has('admin'))
        <button class="btn btn-sm btn-primary col-md-2 m-1" data-bs-toggle="modal" data-bs-target="#inscribirAlumno"><i class="fas fa-clipboard"></i> Inscribir alumno</button>
        @include('mesa.modals.inscribir_alumno')
        @endif

        {{--
        @if(count($inscripciones) > 0)
        <a href="{{ route('mesa.descargar',['id'=>$materia->id,'instancia_id'=>$instancia->id]) }}" class="btn btn-sm btn-success col-md-2 ml-1 mt-1 mb-1">
        <i class="fas fa-download"></i>
        Descargar Inscriptos
        </a>
        @endif
        --}}
    </div>
    @if($mesa && !$mesa->comision_id)
    <div class="row">
        @if($mesa->cierre_profesor && !$cierre_primer_llamado || !Session::has('admin'))
        <form action="{{route('mesa.abrir_acta',['mesa_id'=>$mesa->id])}}" method="POST" class="col-md-1 mt-1">
            {{method_field('PUT')}}
            <input type="hidden" name="llamado" value="1" id="llamado">
            <input type="submit" value="Abrir Mesa" class="btn btn-sm btn-warning">
        </form>
        @endif

        @if(Session::has('admin'))
        <button type="button" class="btn btn-sm btn-danger col-md-2 m-1" data-bs-toggle="modal" data-bs-target="#borrar_mesa">Borrar Mesa</button>
        @include('mesa.modals.borrar_mesa')
        @endif


        <button class="btn btn-sm btn-secondary button-modal col-md-2 m-1" id="1" data-bs-toggle="modal" data-bs-target="#libro_folio_1">
            Libro/Folio
        </button>
        @include('mesa.modals.libro_folio_1',['llamado'=>1,'folios'=>$mesa->folios()])
        @php
        $contador_boton = 1;
        @endphp
        @while($contador_boton <= $mesa->folios() )
            <a class="btn btn-sm btn-success m-1 col-md-2" href="{{ route('generar_pdf_acta_volante', ['instancia' => $mesa->instancia_id, 'carrera'=>$mesa->materia->carrera_id,'materia' => $mesa->materia_id ,'llamado' => 1, 'comision' => $mesa->comision_id ?? null,'orden'=>$contador_boton]) }}">
                <i>Folio {{$contador_boton}}</i>
                <small style="font-size: 0.6em">Descargar Acta Volante</small>
            </a>
            @php
            $contador_boton++;
            @endphp
            @endwhile
    </div>

    @endif

    @if(count($inscripciones) > 0)

    <div class="table-responsive">
        <table class="table mt-4">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellido</th>
                    <th scope="col">D.N.I</th>
                    <th>Teléfono</th>
                    <th>Comisión</th>
                    @if(Session::has('admin') || Session::has('coordinador') || Session::has('seccionAlumnos'))
                    <th scope="col"><i class="fa fa-cog" style="font-size:20px;"></i></th>
                    @endif
                </tr>
            </thead>
            <tbody>

                @foreach ($inscripciones as $inscripcion)
                <tr style="cursor:pointer;">
                    @if(!$inscripcion->alumno_id)
                    <td>{{ $inscripcion->nombres }}</td>
                    @else
                    <td><a href="{{ route('alumno.detalle',$inscripcion->alumno_id) }}">{{ $inscripcion->nombres }}</a></td>
                    @endif
                    <td>{{ $inscripcion->apellidos }}</td>
                    <td>{{ $inscripcion->dni }}</td>
                    <td>{{ $inscripcion->telefono ?? '-'  }}</td>
                    <td>{{ $inscripcion->alumno->comisionPorAño($inscripcion->materia->carrera_id,$inscripcion->materia->año) ?? '-' }}</td>
                    <td>

                        @if(Session::has('admin') || Session::has('coordinador'))

                        <a class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#baja{{$inscripcion->id}}">
                        <i class="fas fa-chevron-circle-down"></i>
                            Dar baja
                        </a>

                        @endif

                        <button class="{{$inscripcion->confirmado ? 'd-none' : '' }} inscripcion_id btn btn-sm btn-info" data-inscripcion_id="{{ $inscripcion->id }}" data-materia_id="{{ $materia->id }}" data-bs-toggle="modal" data-bs-target="#confirmar_alumno">Verificar Inscripción
                    </button>
                   
                        @if($inscripcion->confirmado)
                        <button class="btn btn-sm btn-success" disabled><i class="fas fa-check"></i>Confirmado</button>
                        @endif
                        @if(count($materia->mesas_instancias($instancia->id)) >= 1 && $comisiones)
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#asignarMesa{{$inscripcion->id}}" id="asignar-{{$inscripcion->id}}" {{ $inscripcion->mesa_id || !$inscripcion->confirmado ? 'disabled':'' }}>Asingar Mesa</button>
                        @include('mesa.modals.asignar_mesa')
                        @endif

                    </td>
                    @include('mesa.modals.dar_baja_mesa')
                    @include('mesa.modals.confirmacion')

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($materia->getTotalAttribute() >= 1)
    @foreach($materia->mesas_instancias($instancia->id) as $mesa)
    <h3 class="text-info">Mesa: {{ $mesa->comision->nombre }}</h3>
    @if(count($mesa->mesa_inscriptos()->get()) > 0)
    @if($mesa->cierre_profesor && !$cierre_primer_llamado || !Session::has('admin'))
    <form action="{{route('mesa.abrir_acta',['mesa_id'=>$mesa->id])}}" method="POST" class="mt-2">
        {{method_field('PUT')}}
        <input type="hidden" name="llamado" value="1" id="llamado">
        <input type="submit" value="Abrir Acta Volante" class="btn btn-sm btn-warning">
    </form>
    @endif
    @if(Session::has('admin'))
    <a class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#borrar_mesa">Borrar Mesa</a>
    @include('mesa.modals.borrar_mesa')
    @endif
    @include('mesa.tablas.tabla_inscripciones',['inscripciones'=>$mesa->mesa_inscriptos,'folios'=>$mesa->folios(),'llamado'=>1])
    @else
    <p>No hay alumnos en la mesa.</p>
    @endif
    @endforeach
    @endif
    @else
    <br>
    <h3>No existen inscripciones para esta materia.</h3>
    <br>
    @endif

    @include('mesa.tablas.tablas_bajas_inscripciones_especiales')

</div>
@endsection
@section('scripts')
<script src="{{ asset('js/mesas/confirmacion.js') }}"></script>
<script src="{{ asset('js/mesas/inscripcion.js') }}"></script>
<script src="{{ asset('js/mesas/mesas.js') }}"></script>
@endsection