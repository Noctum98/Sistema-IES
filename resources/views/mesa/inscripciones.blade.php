@extends('layouts.app-prueba')
@section('content')
<div class="container">

    @if($mesa)
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

    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#inscribirAlumno">Inscribir alumno</button>
    @include('mesa.modals.inscribir_alumno')
    
    <h2 class="text-info">Primer llamado</h2>
    @if( count($primer_llamado) > 0)
    <div class="row">
        <a href="{{route('mesa.descargar',['id'=>$mesa->id,'instancia_id'=>$mesa->instancia_id,'llamado'=>'primero'])}}" class="btn btn-sm btn-success ml-3 col-md-2">
            Descargar 1<sup>er</sup> llamado
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

                    <a class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#baja{{$inscripcion->id}}">
                        Dar baja
                    </a>
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
            Descargar 2<sup>do</sup> llamado
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
@endsection