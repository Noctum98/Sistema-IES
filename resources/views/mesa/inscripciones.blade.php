@extends('layouts.app-prueba')
@section('content')
<div class="container">

    @if($mesa)
    <a href="{{ route('mesa.carreras',['sede_id'=>$mesa->materia->carrera->sede->id,'instancia_id'=>$instancia->id]) }}">
        <button class="btn btn-outline-info mb-2">
            <i class="fas fa-angle-left"></i>
            Volver
        </button>
    </a>
    <h2 class="h1 text-info">
        Inscripciones en {{$mesa->materia->nombre}}
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

    <div class="mb-3">
        <button class="btn btn-sm btn-primary " data-bs-toggle="modal" data-bs-target="#inscribirAlumno">Inscribir alumno</button>
        @include('mesa.modals.inscribir_alumno')

        @if($mesa)
        <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#libro_folio">Libro/Folio</button>
        @include('mesa.modals.libro_folio')
            <a href="{{ route('generar_pdf_acta_volante', ['instancia' => $mesa->instancia_id, 'carrera'=>$mesa->materia($mesa->materia_id)->first()->carrera()->first()->id,'materia' => $mesa->materia_id ,'llamado' => 1, 'comision' => optional($mesa->comision()->first())->id]) }}"
               class="btn btn-sm btn-success">
                <i>1° llamado</i>
                <small style="font-size: 0.6em">Descargar Acta Volante</small>
            </a>
            <a href="{{ route('generar_pdf_acta_volante', ['instancia' => $mesa->instancia_id, 'carrera'=>$mesa->materia($mesa->materia_id)->first()->carrera()->first()->id,'materia' => $mesa->materia_id ,'llamado' => 1, 'comision' => optional($mesa->comision()->first())->id]) }}"
               class="btn btn-sm btn-success">
                <i>2° llamado</i>
                <small style="font-size: 0.6em">Descargar Acta Volante</small>
            </a>
        @endif
    </div>


    <h2 class="text-info">Primer llamado</h2>
    @if( count($primer_llamado) > 0)
    <div class="row">
        <a href="{{route('mesa.descargar',['id'=>$mesa->id,'instancia_id'=>$mesa->instancia_id,'llamado'=>'primero'])}}" class="btn btn-sm btn-success ml-3 col-md-2">
            <i class="fas fa-download"></i> Descargar 1<sup>er</sup> llamado
        </a>
    </div>
    <table class="table mt-4">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Apellido</th>
                <th scope="col">D.N.I</th>
                <th scope="col">Teléfono</th>
                <th scope="col"><i class="fa fa-cog" style="font-size:20px;"></i></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($primer_llamado as $inscripcion)
            <tr style="cursor:pointer;">
                <td>{{ $inscripcion->nombres }}</td>
                <td>{{ $inscripcion->apellidos }}</td>
                <td>{{ $inscripcion->dni }}</td>
                <td>{{ $inscripcion->telefono }}</td>

                <td>
                    @include('mesa.modals.dar_baja_mesa')
                    @include('mesa.modals.mover')

                    <a class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#baja{{$inscripcion->id}}">
                        Dar baja
                    </a>
                    @if($mesa->materia->getTotalAttribute() > 0)
                    <a class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#mover{{$inscripcion->id}}">
                        Mover
                    </a>
                    @endif
                    
                    <button class="{{$inscripcion->confirmado ? 'd-none' : '' }} inscripcion_id btn btn-sm btn-info" id="{{$inscripcion->id}}">Confirmar</button>
                    <button class="{{ !$inscripcion->confirmado ? 'd-none' : '' }} btn btn-sm btn-success" id="confirmado-{{$inscripcion->id}}" disabled>Confirmado</button>  
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p>No existen inscripciones para este llamado.</p>
    @endif

    @if(count($primer_llamado_bajas) > 0)
    <h2 class="text-info">Primer llamado bajas</h2>

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
            @foreach ($primer_llamado_bajas as $inscripcion)
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
    @endif

    @if( count($segundo_llamado) > 0)
    <h2 class="text-info">Segundo llamado</h2>

    <div class="row">
        <a href="{{route('mesa.descargar',['id'=>$mesa->id,'instancia_id'=>$mesa->instancia_id,'llamado'=>'segundo'])}}" class="btn btn-sm btn-success ml-3 col-md-2">
            <i class="fas fa-download"></i> Descargar 2<sup>do</sup> llamado
        </a>
    </div>
    <table class="table mt-4">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Apellido</th>
                <th scope="col">D.N.I</th>
                <th scope="col">Teléfono</th>

                <th scope="col"><i class="fa fa-cog" style="font-size:20px;"></i></th>

            </tr>
        </thead>
        <tbody>
            @foreach ($segundo_llamado as $inscripcion)
            <tr style="cursor:pointer;">
                <td>{{ $inscripcion->nombres }}</td>
                <td>{{ $inscripcion->apellidos }}</td>
                <td>{{ $inscripcion->dni }}</td>
                <td>{{ $inscripcion->telefono }}</td>

                <td>
                <a class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#baja{{$inscripcion->id}}">
                        Dar baja
                    </a>
                    @if($mesa->materia->getTotalAttribute() > 0)
                    <a class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#mover{{$inscripcion->id}}">
                        Mover
                    </a>
                    @endif
                    
                    <button class="{{$inscripcion->confirmado ? 'd-none' : '' }} inscripcion_id btn btn-sm btn-info" id="{{$inscripcion->id}}">Confirmar</button>
                    <button class="{{ !$inscripcion->confirmado ? 'd-none' : '' }} btn btn-sm btn-success" id="confirmado-{{$inscripcion->id}}" disabled>Confirmado</button>

                    @include('mesa.modals.dar_baja_mesa')
                    @include('mesa.modals.mover')
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
    @if(count($segundo_llamado_bajas) > 0)
    <h2 class="text-info">Segundo llamado bajas</h2>

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
            @foreach ($segundo_llamado_bajas as $inscripcion)
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
    @endif
    @else
    <h2 class="h1 text-info">
        La mesa no esta configurada.
    </h2>
    @endif
</div>
@endsection
@section('scripts')
<script src="{{ asset('js/mesas/inscripcion.js') }}"></script>
<script src="{{ asset('js/mesas/confirmacion.js') }}"></script>
@endsection