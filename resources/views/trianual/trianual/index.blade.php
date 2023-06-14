@extends('layouts.app-prueba')
@section('content')
    <div class="container p-3">
        <a href="{{url()->previous()}}">
            <button class="btn btn-outline-info mb-2"><i class="fas fa-angle-left"></i> Volver</button>
        </a>
        <div class="col-md-8 row">
            <div class="col-md-5">
                <form method="GET" action="{{ route('trianual.listar') }}"
                      id="buscador-alumnos-trianual">
                    <div class="form-inline">
                        <div class="input-group">
                            <label for="busqueda"></label>
                            <input type="text" id="busqueda" name="busqueda" class="form-control"
                                   placeholder="Buscar alumno" aria-describedby="inputGroupPrepend2"
                                   value="{{ $busqueda && $busqueda != 1 ?$busqueda: '' }}">

                            <button class="input-group-text" id="inputGroupPrepend2" type="submit">
                                <i class="fa fa-search text-info"></i>
                            </button>
                        </div>
                    </div>
                    {{--                    @include('alumno.modals.filtros_equivalencias')--}}

                </form>

            </div>
        </div>
        <h4 class="text-dark">
            Trianual <span id="datos-trianual"></span>
        </h4>

        <hr>
        @if(Session::has('admin') || Session::has('coordinador') || Session::has('seccionAlumnos'))
            <a href="{{ route('trianual.crear') }}" class="btn btn-success mb-4">
                Crear trianual
            </a>
        @endif

        @if(@session('error_trianual'))
            {{ @session('error_trianual') }}
        @endif
        <div class="col-md-8">

            @if($alumnos)
                @foreach($alumnos as $alumno)
                    <div class="col-12">
                        {{$alumno->nombres}}
                    </div>
                @endforeach
            @else
                <div class="col-12">
                    No se encontraron alumnos con los datos solicitados: {{$busqueda}}
                </div>
            @endif
        </div>
        <a href="{{url()->previous()}}">
            <button class="btn btn-outline-info mb-2"><i class="fas fa-angle-left"></i> Volver</button>
        </a>
    </div>

@endsection
