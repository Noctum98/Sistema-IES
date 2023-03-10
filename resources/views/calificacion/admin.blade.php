@extends('layouts.app-prueba')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-8">
                <h6 class="text-dark">
                    Calificaciones
                </h6>
                <h4>
                    <small>Carrera:</small> <i>{{$materia->carrera->nombre}}, {{$materia->carrera->sede->nombre}}<br/>
                    <small>Turno:</small> {{$materia->carrera->turno}}</i><br/>
                    <small>Materia:</small> <i>{{ $materia->nombre }}</i>
                </h4>
            </div>
            <div class="col-4">
                <div class="dropdown">
                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdown1"
                            data-bs-toggle="dropdown">
                        Ciclo lectivo
                    </button>
                    <ul class="dropdown-menu">
                        @for ($i = $ahora; $i >= $last; $i--)
                            <li>
                                @if(isset($cargo))
                                    <a class="dropdown-item @if($i == $ciclo_lectivo) active @endif "
                                       href="{{route('calificacion.admin', ['materia_id'=>$materia->id,'ciclo_lectivo' =>$i,'cargo_id'=>$cargo->id])}}">{{$i}}</a>
                                @else
                                    <a class="dropdown-item @if($i == $ciclo_lectivo) active @endif "
                                       href="{{route('calificacion.admin', ['materia_id'=>$materia->id,'ciclo_lectivo'=> $i])}}">{{$i}}</a>
                                @endif
                            </li>
                        @endfor
                    </ul>
                </div>
            </div>
            <div class="col-12">

                @if(isset($cargo))
                    Cargo: <b><i> {{ $cargo->nombre }}</i></b>
                @endif
                Ciclo lectivo: <b><i>{{$ciclo_lectivo}}</i></b>
            </div>
        </div>
        <hr>
        @if(Session::has('profesor'))
            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#crearCalificacion">
                Crear Calificación
            </button>
        @endif
        @if(Session::has('profesor') || Session::has('coordinador') || Session::has('admin') || Session::has('regente') || Session::has('seccionAlumnos'))
            @if($materia->getTotalAttribute() > 0)
                @foreach($materia->comisiones as $comision)
                    @if(Auth::user()->hasComision($comision->id))
                        @if($cargo)
                            <a href="{{ route('proceso.listadoCargo', ['materia_id'=> $materia->id, 'cargo_id' => $cargo->id, 'comision_id' => $comision->id]) }}"
                               class="btn btn-info">
                                Ver Planilla de Calificaciones / {{$cargo->nombre}} / {{$comision->nombre}}
                            </a>
                        @else
                            <a href="{{ route('proceso.listado', ['materia_id'=> $materia->id, 'comision_id' => $comision->id]) }}"
                               class="btn btn-info">Ver Planilla de Calificaciones {{$comision->nombre}}</a>
                        @endif
                    @elseif(Session::has('coordinador') || Session::has('seccionAlumnos'))
                        <a href="{{ route('proceso.listado', ['materia_id'=> $materia->id, 'comision_id' => $comision->id]) }}"
                           class="btn btn-info">Ver Planilla de Calificaciones {{$comision->nombre}}</a>
                    @endif
                @endforeach
            @else
                @if($cargo && $materia->carrera->tipo == 'modular' || $materia->carrera->tipo == 'modular2')

                    <a href="{{ route('proceso.listadoCargo', ['materia_id'=> $materia->id, 'cargo_id' => $cargo->id]) }}"
                       class="btn btn-info">
                        Ver Planilla de Calificaciones {{$cargo->nombre}}
                    </a>
                    <a href="{{ route('proceso_modular.list', ['materia'=> $materia->id, 'cargo_id'=> $cargo->id]) }}"
                       class="btn btn-secondary">
                        Ver Planilla de Calificaciones Módulo {{$materia->nombre}}
                    </a>
                @else
                    <a href="{{ route('proceso.listado', ['materia_id'=> $materia->id]) }}" class="btn btn-info">
                        Ver procesos
                    </a>
                @endif

            @endif
        @endif
        <!---
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0 mt-1" method="GET" action="#" id="buscador">
        <div class="input-group mt-3">
            <input class="form-control ml-3" type="text" id="busqueda" placeholder="Buscar calificación" aria-label="Search for..." aria-describedby="btnNavbarSearch" />
            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
        </div>
    </form>
    --->
        @if(@session('calificacion_creada'))
            <div class="alert alert-success mt-2">{{@session('calificacion_creada')}}</div>
        @endif

        @if(@session('calificacion_fallo'))
            <div class="alert alert-warning mt-2">{{@session('calificacion_fallo')}}</div>
        @endif

        @if(@session('calificacion_eliminada'))
            <div class="alert alert-danger mt-2">{{@session('calificacion_eliminada')}}</div>
        @endif

        @if(@session('error_comision'))
            <div class="alert alert-danger mt-2">{{@session('error_comision')}}</div>
        @endif

        @if(count($calificaciones) > 0)
            <table class="table  mt-4">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">Tipo</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Creador</th>
                    <th scope="col">Fecha</th>
                    @if($materia->carrera->tipo == 'modular' )
                        <th scope="col">Cargo</th>
                    @endif
                    <th scope="col">Comisión</th>
                    <th scope="col" class="text-center"><i class="fa fa-cog" style="font-size:20px;"></i>-</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($calificaciones as $calificacion)
                    <tr style="cursor:pointer;">
                        <td>{{ $calificacion->tipo->nombre }}</td>
                        <td>{{ $calificacion->nombre }}</td>
                        <td>
                            {{ $calificacion->user->nombre.' '.$calificacion->user->apellido }}
                        </td>
                        <td>{{ $calificacion->fecha }}</td>
                        @if($materia->carrera->tipo == 'modular' )
                            <td> {{optional($calificacion->modelCargo)->nombre }}</td>
                        @endif
                        @if( $calificacion->comision_id)
                            @if($calificacion->comision)
                                <td>{{ $calificacion->comision->nombre }}</td>
                            @endif
                        @else
                            <td>General</td>
                        @endif
                        <td>
                            <a href="{{ route('calificacion.create',$calificacion->id) }}" class="btn btn-sm btn-secondary
                    @if (Session::has('profesor') && !Session::has('coordinador') && $calificacion->comision_id && !Auth::user()->hasComision($calificacion->comision_id)) disabled @endif">
                                Notas
                            </a>

                            @if (Session::has('profesor') && $calificacion->user_id == Auth::user()->id)

                                <a class="btn btn-sm btn-warning" data-bs-toggle="modal" id="editButton"
                                   data-bs-target="#editModal"
                                   data-loader="{{$calificacion->id}}"
                                   data-attr="{{ route('calificacion.edit', $calificacion) }}">
                                    <i class="fas fa-edit text-gray-300"></i>
                                    <i class="fa fa-spinner fa-spin" style="display: none"
                                       id="loader{{$calificacion->id}}"></i>
                                </a>

                                <form action="{{ route('calificacion.delete',$calificacion->id) }}" method="POST"
                                      class="d-inline">
                                    {{ method_field('DELETE') }}
                                    <input type="submit" value="Eliminar" class="btn btn-sm btn-danger"/>

                                </form>

                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p class="mt-3">No has creado ninguna calificación.</p>
        @endif
    </div>
    @include('calificacion.modals.crear_calificacion')
    @include('calificacion.modals.editar_calificacion')
@endsection
@section('scripts')
    <script>

        $(document).on('click', '#editButton', function (event) {
            event.preventDefault();
            let href = $(this).attr('data-attr');
            let referencia = $(this).attr('data-loader');
            const $laoder = $('#loader' + referencia);

            $.ajax({
                url: href,
                beforeSend: function () {
                    $laoder.show();
                },
                // return the result
                success: function (result) {
                    $('#editModal').modal("show");
                    $('#editBody').html(result).show();
                },
                complete: function () {
                    $laoder.hide();
                },
                error: function (jqXHR, testStatus, error) {
                    console.log(error);

                    $laoder.hide();
                },
                timeout: 8000
            })
        });
    </script>
@endsection