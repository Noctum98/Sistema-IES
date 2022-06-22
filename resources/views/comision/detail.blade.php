@extends('layouts.app-prueba')
@section('content')
<div class="container p-3">
    <a href="{{url()->previous()}}"><button class="btn btn-outline-info mb-2"><i class="fas fa-angle-left"></i> Volver</button> </a>

    <h2 class="h1 text-info">
        Comisión de {{ $comision->nombre.' - '.$comision->carrera->nombre }}
    </h2>
    <hr>
    @if(@session('mensaje_success'))
    <div class="alert alert-success">
        {{ @session('mensaje_success') }}
    </div>
    @endif

    @if(@session('mensaje_error'))
    <div class="alert alert-danger">
        {{ @session('mensaje_error') }}
    </div>
    @endif

    @if(@session('profesor_deleted'))
    <div class="alert alert-warning">
        {{ @session('profesor_deleted') }}
    </div>
    @endif

    @if(Session::has('coordinador') || Session::has('regente') || Session::has('admin'))
    <p><button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#agregarProfesor">Agregar Profesor</button></p>
    @endif
    @if(count($comision->profesores) == 0)
    <p>No hay profesores vinculados a la comisión.</p>
    @else

    <table class="table mt-4">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                <th scope="col">
                    <i class="fa fa-cog" style="font-size:20px;"></i>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($comision->profesores as $profesor)
            <tr>
                <th scope="row">{{ $profesor->id }}</th>
                <td>{{ $profesor->nombre.' '.$profesor->apellido }}</td>
                <td>
                    <form action="{{ route('comision.delprofesor',$comision->id) }}" method="POST">
                        {{ method_field('DELETE') }}
                        <input type="hidden" name="profesor_id" value="{{$profesor->id}}">
                        <input type="submit" value="Eliminar" class="btn btn-sm btn-danger">
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <table class="table mt-4">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                <th scope="col">
                    <i class="fa fa-cog" style="font-size:20px;"></i>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($alumnos as $alumno)
            <tr>
                <th scope="row">{{ $alumno->id }}</th>
                <td>{{ $alumno->apellidos.' '.$alumno->nombres }}</td>
                <td>
                    <form action="" id="{{$alumno->id}}" method="POST">
                        @foreach($comisiones as $comision)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="comision_id" id="{{$alumno->id.'-'.$comision->id}}" value="{{$comision->id}}" @if($alumno->comision_id == $comision->id) checked @endif>
                            <label class="form-check-label" for="exampleRadios1">
                                {{$comision->nombre}}
                            </label>
                        </div>
                        @endforeach
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <hr>
</div>
@include('comision.modals.agregar_profesor')
@endsection
@section('scripts')
<script src="{{ asset('js/comision/asignar_alumnos.js') }}"></script>
@endsection