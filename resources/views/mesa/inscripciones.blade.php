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
                @if(Auth::user()->rol == 'rol_admin')
                <th scope="col"><i class="fa fa-cog" style="font-size:20px;"></i></th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($primer_llamado as $inscripcion)
            <tr style="cursor:pointer;">
                <td>{{ $inscripcion->nombres }}</td>
                <td>{{ $inscripcion->apellidos }}</td>
                <td>{{ $inscripcion->dni }}</td>
                <td>{{ $inscripcion->telefono }}</td>
                @if(Auth::user()->rol == 'rol_admin')
                <td>
                    <a href="{{route('mesa.borrar',['id'=>$inscripcion->id])}}" class="btn-sm btn-danger">
                        Borrar
                    </a>
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p>No existen inscripciones en este llamado</p>
    @endif
    
    <h2 class="text-info">Segundo llamado</h2>
    @if( count($segundo_llamado) > 0)
    <div class="row">
        <a href="{{route('mesa.descargar',['id'=>$mesa->id,'llamado'=>'segundo'])}}" class="btn btn-sm btn-success ml-3">
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
                @if(Auth::user()->rol == 'rol_admin')
                <th scope="col"><i class="fa fa-cog" style="font-size:20px;"></i></th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($segundo_llamado as $inscripcion)
            <tr style="cursor:pointer;">
                <td>{{ $inscripcion->nombres }}</td>
                <td>{{ $inscripcion->apellidos }}</td>
                <td>{{ $inscripcion->dni }}</td>
                <td>{{ $inscripcion->telefono }}</td>
                @if(Auth::user()->rol == 'rol_admin')
                <td>
                    <a href="{{route('mesa.borrar',['id'=>$inscripcion->id])}}" class="btn-sm btn-danger">
                        Borrar
                    </a>
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p>No existen inscripciones en este llamado</p>
    @endif
    @else
    <h2 class="h1 text-info">
        La mesa no esta configurada.
    </h2>
    @endif
</div>
@endsection