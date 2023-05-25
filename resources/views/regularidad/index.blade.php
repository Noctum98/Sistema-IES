@extends('layouts.app-prueba')
@section('content')
    <div class="container p-3">
        <div class="row">
            <div class="col-8">
                <h4 class="text-primary">
                    Administrar regularidad de los alumnos <small class="text-dark"> Ciclo lectivo
                        <b>{{$ciclo_lectivo}}</b></small>
                </h4>
                <p>Agrega, edita o busca regularidad de alumnos</p>
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
                                <a class="dropdown-item @if($i == $ciclo_lectivo) active @endif "
                                   href="{{route('regularidad.index', ['ciclo_lectivo'=> $i, 'busqueda' => $busqueda])}}">{{$i}}</a>

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
                <form method="GET" action="{{ route('regularidad.index', ['ciclo_lectivo'=> $ciclo_lectivo]) }}"
                      id="buscador-alumnos-regularidad">
                    <div class="form-inline">
                        <div class="input-group">

                            <label for="busqueda"></label>
                            <input type="text" id="busqueda" name="busqueda" class="form-control"
                                   placeholder="Buscar alumno" aria-describedby="inputGroupPrepend2"
                                   value="{{ $busqueda && $busqueda != 1 ?$busqueda: '' }}">

                            <input type="hidden" id="ciclo_lectivo" name="ciclo_lectivo" class="form-control"
                                   value="{{ $ciclo_lectivo }}">

                            <button class="input-group-text" id="inputGroupPrepend2" type="submit">
                                <i class="fa fa-search text-info"></i>
                            </button>
                        </div>
                    </div>
                    {{--                    @include('alumno.modals.filtros_equivalencias')--}}

                </form>

            </div>
        </div>
        <div class="col-md-12">
            @if(!$busqueda)
                <div>Por favor ingrese número de documento o apellido del alumno</div>
            @elseif(!empty($alumnos))
                @if(count($alumnos) > 0)

                    {{--                    <a id="descargar_busqueda" class="btn btn-sm btn-success"><i class="fas fa-download"></i>Descargar--}}
                    {{--                        Alumnos</a>--}}
                    <table class="table mt-4 table-bordered table-striped">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">Nombre</th>
                            <th scope="col">DNI</th>
                            <th>Email</th>
                            <th>Cohorte</th>
                            <th scope="col" colspan="2"><i class="fa fa-cog" style="font-size:20px;"></i></th>
                        </tr>
                        </thead>

                        @foreach ($alumnos as $alumno)
                            <tbody class="table-striped table-bordered">
                            <tr>
                                <td>{{ mb_strtoupper($alumno->apellidos).' '.ucwords($alumno->nombres) }}</td>
                                <td>{{ $alumno->dni }}</td>
                                <td>{{ $alumno->email }}</td>
                                <td>{{ $alumno->cohorte ?? '-' }}</td>
                                <td colspan="2">
                                    <div class="btn-group" role="group" aria-label="Botones de acción">
                                        <a href="{{ route('alumno.detalle',['id'=>$alumno->id, 'ciclo_lectivo' => $ciclo_lectivo]) }}"
                                           class="btn btn-sm btn-link ">
                                            <i class="fa fa-external-link-alt"></i>
                                            Ver datos alumno
                                        </a>
                                        <a class="btn btn-sm btn-warning" data-bs-toggle="modal" id="agregarButton"
                                           data-bs-target="#agregarModal"
                                           data-loader="{{$alumno->id}}"
                                           data-attr="{{ route('regularidad.create', ['id'=>$alumno->id,'ciclo_lectivo' => $ciclo_lectivo]) }}">
                                            <i class="fas fa-edit text-gray-300"></i>
                                            <i class="fa fa-spinner fa-spin" style="display: none"
                                               id="loader{{$alumno->id}}"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @if (count($alumno->getRegularidades()) > 0)

                                <tr class="table-responsive-md text-center table-borderless">
                                    <td colspan="6" class="text-center h4">Regularidades</td>

                                </tr>
                                <tr class="table-responsive-md text-center border-2 border-info">

                                    <td>Materia <br/>
                                        <small
                                            style="font-size: 0.8em">(Carrera)</small></td>
                                    <td>Condición</td>
                                    <td>Fecha Regularidad</td>
                                    <td>Vto. Regularidad</td>
                                    <td>Ciclo Lectivo</td>
                                    <td><i class="fa fa-cogs"></i></td>
                                </tr>
                                @foreach ($alumno->getRegularidades() as $regularidad)
                                    <tr class="table-responsive-md text-center border-2 border-primary">

                                        {{--                                        <td>{{$equivalencia->materia_id}}</td>--}}
                                        <td rowspan="2">{{$regularidad->obtenerMateria()->nombre}}<br/>
                                            <small
                                                style="font-size: 0.8em">
                                                {{$regularidad->obtenerMateria()->carrera()->first()->nombre}}</small>
                                        </td>
                                        <td>

                                            {{$regularidad->obtenerEstado()->nombre}}</td>
                                        <td>{{date_format(new DateTime($regularidad->fecha_regularidad),'d-m-Y')}}</td>
                                        <td>{{date_format(new DateTime($regularidad->fecha_vencimiento),'d-m-Y')}}</td>
                                        <td>{{$regularidad->getCicloLectivo()}}</td>
                                        <td rowspan="2">
                                            <div class="btn-group" role="group" aria-label="Botones de acción">
                                                {{--                                                <a--}}
                                                {{--                                                    --}}{{--                                                    data-bs-toggle="modal" data-bs-target="#eliminarEquivalenciaModal{{$equivalencia->id}}"--}}
                                                {{--                                                    class="btn btn-sm btn-danger ps-1"--}}
                                                {{--                                                >--}}
                                                {{--                                                    <i class="fa fa-trash"></i> Clonar--}}
                                                {{--                                                </a>--}}
                                                {{--                                                @include('regularidad.components.eliminar_regularidad')--}}
                                                <a href="!#"
                                                   {{--                                                   data-bs-toggle="modal" data-bs-target="#edit{{$equivalencia->id}}"--}}
                                                   class="btn btn-sm btn-outline-success ms-1"

                                                >
                                                    <i class="fa fa-edit"></i> Editar
                                                </a>
                                                {{--                                                @include('alumno.modals.editar_equivalencias')--}}
                                            </div>


                                        </td>
                                    </tr>
                                    <tr class="border-bottom border-primary">
                                        <td colspan="4">
                                            <small
                                                style="font-size: 0.8em">
                                                Observaciones: {{$regularidad->observaciones}}
                                            </small>
                                        </td>
                                    </tr>
                                @endforeach

                            @else
                                <tr>
                                    <td colspan="5">
                                        <h6>No se encontraron regularidades para
                                            {{ mb_strtoupper($alumno->apellidos).' '.ucwords($alumno->nombres) }}
                                        </h6>
                                    </td>

                                </tr>

                            @endif
                            @if (count($alumno->isRegular($ciclo_lectivo)) > 0)
                                <tr class="table-responsive-md text-center table-bordered border-top-0 border-2">
                                    <td colspan="6" class="text-center h4">Procesos regulares</td>
                                </tr>
                                <tr class="text-center table-bordered border-top-0 border-2">
                                    <td>Materia<br/>
                                        <small style="font-size: 0.8em">(Carrera)</small>
                                    </td>
                                    <td>
                                        Condición<br/>
                                        <small style="font-size: 0.8em">(Cerrada)</small>
                                    </td>
                                    <td>Últ. actualización</td>
                                    <td>Ciclo lectivo</td>
                                    <td><i class="fa fa-cogs"></i></td>
                                </tr>
                                @foreach($alumno->isRegular() as $proceso)
                                    <tr class="text-center table-bordered border-top-0 border-2">
                                        <td>
                                            {{$proceso->materia()->first()->nombre}}<br/>
                                            <small
                                                style="font-size: 0.8em">{{$proceso->materia()->first()->carrera()->first()->nombre}}</small>
                                        </td>
                                        <td>{{$proceso->estado()->first()->nombre}}
                                            <br/>
                                            <small style="font-size: 0.8em">
                                                @if ($proceso->cierre === 1)
                                                    <i class='fas fa-check text-success'></i>
                                                @else
                                                    <i class='fas fa-times text-danger'></i>
                                                @endif
                                            </small>
                                        </td>
                                        <td>

                                            <small style="font-size: 0.7em">
                                                {{date_format(new DateTime($proceso->updated_at),'d-m-Y H:i')}}
                                            </small>

                                        </td>
                                        <td>{{$proceso->ciclo_lectivo}}</td>
                                        <td>Copiar condición</td>
                                    </tr>
                                @endforeach

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
    @include('regularidad.components.agregar_regularidad')
@endsection
@section('scripts')
    <script src="{{ asset('js/user/carreras.js') }}"></script>
    <script src="{{ asset('js/alumnos/filtros.js') }}"></script>

    <script>

        $(document).on('click', '#agregarButton', function (event) {
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
                    $('#agregaModal').modal("show");
                    $('#agregarBody').html(result).show();
                },
                complete: function () {
                    $laoder.hide();
                },
                error: function (jqXHR, testStatus, error) {
                    console.log(error);

                    $laoder.hide();
                },
                timeout: 2000
            })
        });
    </script>
@endsection
