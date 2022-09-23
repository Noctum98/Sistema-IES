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



    <div class="row col-md-12">

        @if(Session::has('coordinador') || Session::has('admin'))
            <button class="btn btn-sm btn-primary col-md-2 m-1" data-bs-toggle="modal" data-bs-target="#inscribirAlumno"><i class="fas fa-clipboard"></i> Inscribir alumno</button>
            @include('mesa.modals.inscribir_alumno')
        @endif

        @if(count($inscripciones) > 0)
            <a href="{{ route('mesa.descargar',['id'=>$materia->id,'instancia_id'=>$instancia->id]) }}" class="btn btn-sm btn-success col-md-2 m-1">
                <i class="fas fa-download"></i>
                Descargar Inscriptos
            </a>
        @endif
        
    </div>
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
                    @if(Session::has('admin') || Session::has('coordinador'))
                    <td>
                        <a class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#baja{{$inscripcion->id}}">
                            <i class="fas fa-arrow-down"></i>
                            Dar baja
                        </a>
                    @endif
                        
                        <button id="{{$inscripcion->id}}" class="btn btn-sm btn-info inscripcion_id {{$inscripcion->confirmado ? 'd-none' : ''}}"><i class="fas fa-check"></i> Confirmar</button>
                        <button class="btn btn-sm btn-success d-none" id="confirmado-{{$inscripcion->id}}" disabled><i class="fas fa-check"></i>Confirmado </button>

                        @if($inscripcion->confirmado)
                            <button class="btn btn-sm btn-success" disabled><i class="fas fa-check"></i>Confirmado </button>
                        @endif
                        {{--
                        <button class="btn btn-sm btn-primary {{!$inscripcion->confirmado ? 'd-none' : ''}}" id="nota-{{$inscripcion->id}}" data-bs-toggle="modal" data-bs-target="#nota{{$inscripcion->id}}"><i class="fas fa-clipboard"></i> Nota</button>--}}

                    </td>
                    @include('mesa.modals.dar_baja_mesa')
                    @include('mesa.modals.nota_mesa')


                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @else
    <br>
    <h3>No existen inscripciones para esta materia.</h3>
    <br>
    @endif

    @if(count($inscripciones_baja) > 0)
    <h3 class="text-secondary">Dados de baja</h3>

    <div class="table-responsive">
        <table class="table mt-4">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellido</th>
                    <th scope="col">D.N.I</th>
                    <th scope="col">Teléfono</th>
                    <th>Responsable</th>
                    <th>Fecha de baja</th>
                    <th scope="col">Motivos</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($inscripciones_baja as $inscripcion)
                <tr style="cursor:pointer;">
                    <td>{{ $inscripcion->nombres }}</td>
                    <td>{{ $inscripcion->apellidos }}</td>
                    <td>{{ $inscripcion->dni }}</td>
                    <td>{{ $inscripcion->telefono }}</td>
                    <td>{{ $inscripcion->user ? ucwords($inscripcion->user->nombre).' '.ucwords($inscripcion->user->apellido) : '' }}</td>
                    <td>{{ date_format(new DateTime($inscripcion->updated_at ), 'd-m-Y H:i') }}</td>
                    <td>
                        {{ $inscripcion->motivo_baja }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @endif
</div>
@endsection
@section('scripts')
<script src="{{ asset('js/mesas/confirmacion.js') }}"></script>
<script src="{{ asset('js/mesas/inscripcion.js') }}"></script>
@endsection