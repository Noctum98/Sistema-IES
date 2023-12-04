@extends('layouts.app-prueba')
@section('content')
    @include('layouts.cssCard')
    <div class="container">
        <div class="card">
            <div class="row p-1">
                <div class="card-header border-radius">
                    <div class="row p-0">
                        <div class="col-sm-4">
                            <small>
                                <a href="{{route('carrera.admin')}}">
                                    <button class="btn btn-sm btn-outline-info mb-2">
                                        <i class="fas fa-angle-left"></i>
                                        Listado de carreras
                                    </button>
                                </a>
                            </small>
                        </div>
                        <div class="col-sm-8">
                            <p class="ms-5">Plan de estudios</p>
                            <h4 class="text-dark">
                                {{ $carrera->nombre }}
                                <br/> <small>{{ucwords($carrera->tipo)}}</small>
                            </h4>
                        </div>
                    </div>

                </div>

                <div class="card-body">
                    @if(Session::has('admin') || Session::has('coordinador') || Session::has('seccionAlumnos'))
                        <a href="{{ route('materia.crear',['carrera_id'=>$carrera->id]) }}"
                           class="btn btn-success mb-4">
                            Agregar módulo
                        </a>
                        <a href="{{ route('comisiones.ver',$carrera->id) }}" class="btn btn-warning mb-4">
                            Ver comisiones
                        </a>
                        <button class="btn btn-info mb-4"
                                data-bs-toggle="modal" data-bs-target="#crearComision"
                        >
                            Crear comisión
                        </button>
                    @endif

                    @if(@session('error_procesos'))
                        {{ @session('error_procesos') }}
                    @endif
                    <div class="col-md-12">
                        @if($carrera->estado != 1)
                            <h3 class="text-secondary">Primer Año</h3>
                            <table class="table table-hover mt-4">
                                <caption> 1er año</caption>
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Módulo</th>
                                    <th scope="col" class="text-center">
                                        <i class="fa fa-cog"></i>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($materias as $materia)
                                    @if($materia->año == 1)
                                        <tr style="cursor:pointer;" class="m-0 p-0">
                                            <td class="col-sm-4">{{ $materia->nombre }}</td>
                                            <td class="d-flex justify-content-between w-100 m-0">
                                                <span class="m-0 p-0 col-1">
                                                @if(Auth::user()->hasRole('regente') ||
                                                    Auth::user()->hasRole('coordinador') ||
                                                    Auth::user()->hasRole('seccionAlumnos') ||
                                                    Auth::user()->hasRole('admin'))
                                                        <a href="{{ route('materia.editar',['id'=>$materia->id]) }}"
                                                           class="btn btn-sm btn-warning">Editar</a>
                                                    @endif
                                                </span>
                                                <span class="ms-1 me-1 my-0 p-0 col-8">
                                                @empty($cargo)
                                                        {{$cargo = null}}
                                                    @else
                                                        {{$cargo = $cargo->id}}
                                                    @endif
                                                <a href="{{ route('proceso_modular.list',
                                                    ['materia'=> $materia->id, 'cargo_id'=> $cargo]) }}"
                                                   class="btn btn-info btn-sm">
                                                    <small>Ver Planilla de Calificaciones
                                                        Módulo {{$materia->nombre}}</small>
                                                </a>
                                                </span>
                                                <span class="m-0 p-0 col-2">

                                                <a href="{{ route('modulos.ver',['materia'=>$materia->id]) }}"
                                                   class="btn btn-sm btn-secondary"><i class="fa fa-cogs"></i> Módulo</a>
                                                <!-----
                                    <a href="{{ route('descargar_planilla',$materia->id) }}"
                                       class="btn btn-sm btn-success"><i class="fas fa-download"></i> Descargar Alumnos</a>-->
                                                </span>
                                                <span class="m-0 p-0 col-1">
                                                <sup class="badge badge-info" title="Total Comisiones">
                                                    {{$materia->getTotalAttribute()}}
                                                    @if($materia->getTotalAttribute() > 0)
                                                        <a href="{{ route('comisiones.ver',$carrera->id)}}/?año={{$materia->año}}">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                    @endif
                                                </sup>
                                                </span>

                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                            <hr>
                        @endif
                        <h3 class="text-secondary">Segundo Año</h3>
                        <table class="table table-hover mt-4">
                            <caption>2do año</caption>
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">Materia</th>
                                <th scope="col" class="text-center"><i class="fa fa-cog" style="font-size:20px;"></i>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($materias as $materia)
                                @if($materia->año == 2)
                                    <tr style="cursor:pointer;" class="m-0 p-0">
                                        <td class="col-sm-4">{{ $materia->nombre }}</td>
                                        <td class="d-flex justify-content-between w-100 m-0">
                                                <span class="m-0 p-0 col-1">
                                                @if(Auth::user()->hasRole('regente') ||
                                                    Auth::user()->hasRole('coordinador') ||
                                                    Auth::user()->hasRole('seccionAlumnos') ||
                                                    Auth::user()->hasRole('admin'))
                                                        <a href="{{ route('materia.editar',['id'=>$materia->id]) }}"
                                                           class="btn btn-sm btn-warning">Editar</a>
                                                    @endif
                                                </span>
                                            <span class="ms-1 me-1 my-0 p-0 col-8">
                                                @empty($cargo)
                                                    {{$cargo = null}}
                                                @else
                                                    {{$cargo = $cargo->id}}
                                                @endif
                                                <a href="{{ route('proceso_modular.list',
                                                    ['materia'=> $materia->id, 'cargo_id'=> $cargo]) }}"
                                                   class="btn btn-info btn-sm">
                                                    <small>Ver Planilla de Calificaciones
                                                        Módulo {{$materia->nombre}}</small>
                                                </a>
                                                </span>
                                            <span class="m-0 p-0 col-2">

                                                <a href="{{ route('modulos.ver',['materia'=>$materia->id]) }}"
                                                   class="btn btn-sm btn-secondary"><i class="fa fa-cogs"></i> Módulo</a>
                                                <!-----
                                    <a href="{{ route('descargar_planilla',$materia->id) }}"
                                       class="btn btn-sm btn-success"><i class="fas fa-download"></i> Descargar Alumnos</a>-->
                                                </span>
                                            <span class="m-0 p-0 col-1">
                                                <sup class="badge badge-info" title="Total Comisiones">
                                                    {{$materia->getTotalAttribute()}}
                                                    @if($materia->getTotalAttribute() > 0)
                                                        <a href="{{ route('comisiones.ver',$carrera->id)}}/?año={{$materia->año}}">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                    @endif
                                                </sup>
                                                </span>

                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                        <hr>
                        <h3 class="text-secondary">Tercer Año</h3>
                        <table class="table table-hover mt-4">
                            <caption>3er año</caption>
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">Materia</th>
                                <th scope="col" class="text-center"><i class="fa fa-cog" style="font-size:20px;"></i>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($materias as $materia)
                                @if($materia->año == 3)
                                    <tr style="cursor:pointer;" class="m-0 p-0">
                                        <td class="col-sm-4">{{ $materia->nombre }}</td>
                                        <td class="d-flex justify-content-between w-100 m-0">
                                                <span class="m-0 p-0 col-1">
                                                @if(Auth::user()->hasRole('regente') ||
                                                    Auth::user()->hasRole('coordinador') ||
                                                    Auth::user()->hasRole('seccionAlumnos') ||
                                                    Auth::user()->hasRole('admin'))
                                                        <a href="{{ route('materia.editar',['id'=>$materia->id]) }}"
                                                           class="btn btn-sm btn-warning">Editar</a>
                                                    @endif
                                                </span>
                                            <span class="ms-1 me-1 my-0 p-0 col-8">
                                                @empty($cargo)
                                                    {{$cargo = null}}
                                                @else
                                                    {{$cargo = $cargo->id}}
                                                @endif
                                                <a href="{{ route('proceso_modular.list',
                                                    ['materia'=> $materia->id, 'cargo_id'=> $cargo]) }}"
                                                   class="btn btn-info btn-sm">
                                                    <small>Ver Planilla de Calificaciones
                                                        Módulo {{$materia->nombre}}</small>
                                                </a>
                                                </span>
                                            <span class="m-0 p-0 col-2">

                                                <a href="{{ route('modulos.ver',['materia'=>$materia->id]) }}"
                                                   class="btn btn-sm btn-secondary"><i class="fa fa-cogs"></i> Módulo</a>
                                                <!-----
                                    <a href="{{ route('descargar_planilla',$materia->id) }}"
                                       class="btn btn-sm btn-success"><i class="fas fa-download"></i> Descargar Alumnos</a>-->
                                                </span>
                                            <span class="m-0 p-0 col-1">
                                                <sup class="badge badge-info" title="Total Comisiones">
                                                    {{$materia->getTotalAttribute()}}
                                                    @if($materia->getTotalAttribute() > 0)
                                                        <a href="{{ route('comisiones.ver',$carrera->id)}}/?año={{$materia->año}}">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                    @endif
                                                </sup>
                                                </span>

                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <a href="{{url()->previous()}}">
                        <button class="btn btn-outline-info mb-2"><i class="fas fa-angle-left"></i> Volver</button>
                    </a>
                </div>
    @include('comision.modals.crear_comision')
@endsection
@section('scripts')
<script src="{{ asset('js/comision/crear.js') }}"></script>
@endsection
