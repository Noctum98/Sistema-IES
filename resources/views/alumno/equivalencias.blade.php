@extends('layouts.app-prueba')
@section('content')
    <div class="container p-3">
        <div class="row">
            <div class="col-8">
                <h4 class="text-primary">
                    Administrar equivalencias de alumnos <small class="text-dark"> Ciclo lectivo
                        <b>{{$ciclo_lectivo}}</b></small>
                </h4>
                <p><i>Agrega, edita o busca equivalencias de alumnos</i></p>
            </div>
            <div class="col-4">
                <div class="dropdown">
                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdown1"
                            data-bs-toggle="dropdown">
                        Ciclo lectivo {{$ciclo_lectivo}}
                    </button>
                    <ul class="dropdown-menu">
                        @for ($i = $changeCicloLectivo[1]; $i >= $changeCicloLectivo[0]; $i--)
                            <li>
                                @if(isset($cargo))
                                    <a class="dropdown-item @if($i == $ciclo_lectivo) active @endif "
                                       href="{{route('alumno.equivalencias', ['ciclo_lectivo' =>$i])}}">{{$i}}</a>
                                @else
                                    <a class="dropdown-item @if($i == $ciclo_lectivo) active @endif "
                                       href="{{route('alumno.equivalencias', ['ciclo_lectivo'=> $i])}}">{{$i}}</a>
                                @endif
                            </li>
                        @endfor
                    </ul>
                </div>
            </div>

            @if(@session('alumno_notIsset'))
                <div class="alert alert-warning">
                    {{ @session('alumno_notIsset') }}
                </div>
            @endif
            @if (session()->has('success'))
                <div class="alert alert-success">
                    {{session()->get('success') }}
                </div>
            @endif
            @if((isset($errors)) && $errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{__($error)}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        <div class="col-md-8 row">
            <div class="col-md-5">
                <form method="GET" action="{{ route('alumno.equivalencias', ['ciclo_lectivo'=> $ciclo_lectivo]) }}"
                      id="buscador-alumnos-equivalencias">
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
                    @include('alumno.modals.filtros_equivalencias')

                </form>

            </div>
        </div>
        <div class="col-md-12">
            @if(!$busqueda)
                <div>Por favor indique número de documento o apellido del alumno</div>
            @elseif(!empty($alumnos))
                @if(count($alumnos) > 0)

                    {{--                    <a id="descargar_busqueda" class="btn btn-sm btn-success"><i class="fas fa-download"></i>Descargar--}}
                    {{--                        Alumnos</a>--}}
                    <table class="table mt-4 ">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">Nombre</th>
                            <th scope="col">DNI</th>
                            <th>Email</th>
                            <th>Cohorte</th>
                            <th scope="col"><i class="fa fa-cog" style="font-size:20px;"></i></th>
                        </tr>
                        </thead>

                        @foreach ($alumnos as $alumno)
                            <tbody class="table-striped">
                            <tr>
                                <td>{{ mb_strtoupper($alumno->apellidos).' '.ucwords($alumno->nombres) }}</td>
                                <td>{{ $alumno->dni }}</td>
                                <td>{{ $alumno->email }}</td>
                                <td>{{ $alumno->cohorte ?? '-' }}</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Botones de acción">
                                        <a href="{{ route('alumno.detalle',['id'=>$alumno->id, 'ciclo_lectivo' => $ciclo_lectivo]) }}"
                                           class="btn btn-sm btn-link ">
                                            <i class="fa fa-external-link-alt"></i>
                                            Ver datos alumno
                                        </a>
                                        <button type="button" class="ms-2 btn btn-sm btn-info" data-bs-toggle="modal"
                                                data-bs-target="#equivalenciasModal{{$alumno->id}}">
                                            Agregar Equivalencia
                                        </button>
                                        @include('alumno.modals.admin_equivalencias')
                                    </div>
                                </td>
                            </tr>
                            @if (count($alumno->getEquivalencias()) > 0)

                                <tr class="table-responsive-md text-center table-bordered border-top-0 border-2">
                                    <td colspan="4" class="text-center">Equivalencias</td>

                                </tr>
                                <tr class="table-responsive-md text-center table-bordered border-top-0 border-2">

                                    <td>Materia/<br/><small>(Carrera)</small></td>
                                    <td>Nota</td>
                                    <td>Fecha</td>
                                    <td>N° Resolución</td>
                                    <td><i class="fa fa-cogs"></i></td>
                                </tr>
                                @foreach ($alumno->getEquivalencias() as $equivalencia)
                                    <tr class="table-responsive-md text-center table-bordered border-top-0 border-2 table-striped">

                                        {{--                                        <td>{{$equivalencia->materia_id}}</td>--}}
                                        <td>{{$equivalencia->nombreMateria()}}</td>
                                        <td>{{$equivalencia->nota}}</td>
                                        <td>{{$equivalencia->fecha}}</td>
                                        <td>{{$equivalencia->resolution}}</td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Botones de acción">
                                                <a data-bs-toggle="modal" data-bs-target="#eliminarEquivalenciaModal{{$equivalencia->id}}"
                                                   class="btn btn-sm btn-danger ps-1"
                                                >
                                                    <i class="fa fa-trash"></i> Borrar
                                                </a>
                                                @include('alumno.modals.eliminar_equivalencias')
                                                <a href="!#" data-bs-toggle="modal"
                                                   class="btn btn-sm btn-outline-success ms-1"
                                                   data-bs-target="#edit{{$equivalencia->id}}"
                                                >
                                                    <i class="fa fa-edit"></i> Editar
                                                </a>
                                                @include('alumno.modals.editar_equivalencias')
                                            </div>


                                        </td>
                                    </tr>
                                @endforeach

                            @else
                                <tr>
                                    <td colspan="5">
                                        <h6>No se encontraron equivalencias para
                                            {{ mb_strtoupper($alumno->apellidos).' '.ucwords($alumno->nombres) }}
                                        </h6>
                                    </td>

                                </tr>

                            @endif
                            <tr>
                                <td colspan="4"></td>
                            </tr>
                            </tbody>
                        @endforeach


                    </table>
                @else
                    <br/>
                    <h5>No existen coincidencias con {{$busqueda}}</h5>
                @endif
            @endif

        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/user/carrerasInscripto.js') }}"></script>
    <script src="{{ asset('js/alumnos/filtros.js') }}"></script>

@endsection
