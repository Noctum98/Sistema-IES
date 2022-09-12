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
    @if(count($inscripciones) > 0)
    <div class="row">
        <a href="{{ route('mesa.descargar',['id'=>$materia->id,'instancia_id'=>$instancia->id]) }}" class="btn btn-sm btn-success col-md-2 ml-3">
            Descargar Inscriptos
        </a>
    </div>
    <table class="table mt-4">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Apellido</th>
                <th scope="col">D.N.I</th>
                <th>Teléfono</th>
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
                @if(Session::has('admin') || Session::has('coordinador'))
                <td>
                    <a  class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#baja{{$inscripcion->id}}">
                        Dar baja
                    </a>
                    <button id="{{$inscripcion->id}}" class="btn btn-sm btn-info inscripcion_id {{$inscripcion->confirmado ? 'd-none' : ''}}">Confirmar</button>
                    <button class="btn btn-sm btn-primary {{!$inscripcion->confirmado ? 'd-none' : ''}}" id="nota-{{$inscripcion->id}}" data-bs-toggle="modal" data-bs-target="#nota{{$inscripcion->id}}">Nota</button>

                </td>
                @include('mesa.modals.dar_baja_mesa')
                @include('mesa.modals.nota_mesa')

                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <br>
    <h3>No existen inscripciones para esta materia.</h3>
    <br>
    @endif

    @if(count($inscripciones_baja) > 0)
    <h3 class="text-secondary">Dados de baja</h3>

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
    @endif
</div>
@endsection
@section('scripts')
<script src="{{ asset('js/mesas/confirmacion.js') }}"></script>
<script src="{{ asset('js/mesas/inscripcion.js') }}"></script>

@endsection