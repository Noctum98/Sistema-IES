@extends('layouts.app-prueba')
<link href="{{ asset('vendors/select2/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/font-awesome/4.6.1/css/font-awesome.min.css') }}" rel="stylesheet"/>
<link rel="stylesheet"
      href="{{ asset('css/select2-bootstrap-theme/select2-bootstrap.min.css')}}"
      crossorigin="anonymous" referrerpolicy="no-referrer"/>
@section('content')

    @include('layouts.cssCard')
    <div class="container-fluid">
        <a href="{{ route('materia.admin',['carrera_id'=>$materia->carrera->id]) }}"
           class="btn btn-sm btn-danger">Cancelar</a>
        <div class="card">
            <div class="row p-1">
                <div>
                </div>

                <div class="card-header border-radius col-sm-12 flex-column">
                    <div class="row text-center">
                        <div class="col-sm-7 mx-auto">

                            <h5 class="card-title">
                                <small>Edición de: </small> {{ $materia->nombre }}
                            </h5>
                        </div>
                        <div class="col-sm-5 mx-auto">
                            <h5 class="card-title">
                                {{ $materia->carrera->nombre }}
                            </h5>
                            <p>
                                {{$materia->carrera->sede->nombre}}
                            </p>
                        </div>
                    </div>
                </div>

            </div>
            <div class="card-body">
                <div class="col-md-12">
{{--                    @if(@session('message'))--}}
{{--                        <div class="alert alert-success">--}}
{{--                            {{ @session('message') }}--}}
{{--                        </div>--}}
{{--                    @endif--}}
                </div>
                <div class="row">
                    <form method="POST" action="{{ route('editar_materia',['id'=>$materia->id]) }}">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12 col-md-8">
                                <div class="form-group">

                                    <label for="nombre">Nombre:</label>
                                    <input type="text" id="nombre" name="nombre"
                                           class="form-control @error('nombre') is-invalid @enderror"
                                           value="{{ $materia->nombre }}" required
                                           @if(!Session::has('admin'))
                                               readonly
                                        @endif
                                    />
                                    @error('nombre')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">

                                    <label for="master_materia_id">Genérico:</label>
                                    <select class="form-control select2" id="master_materia_id"
                                            name="master_materia_id" >
                                        <option value="">Seleccione MasterMateria </option>
                                        @foreach($masterMaterias as $master)
                                            @if($master->id == $materia->master_materia_id))
                                                <option value="{{ $master->id }}" selected="selected">
                                                    {{ $master->name }}
                                                </option>
                                            @else
                                                <option value="{{ $master->id }}" >
                                                    {{ $master->name }}
                                                </option>

                                            @endif

                                        @endforeach
                                    </select>
                                    @error('master_materia_id')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="form-group col-sm-2">
                                <label for="año">Año:</label>
                                <input type="number" id="año" name="año"
                                       class="form-control @error('año') is-invalid @enderror"
                                       value="{{ $materia->año }}" required
                                       @if(!Session::has('admin'))
                                           readonly
                                    @endif
                                />
                                @error('año')
                                <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>


                            <div class="form-group col-sm-4">
                                <label for="regimen">Régimen: </label>
                                <select class="form-control select2" id="regimen" name="regimen">
                                    <option value="">
                                        Seleccione régimen
                                    </option>

                                    <option
                                        value="Anual" {{ $materia->regimen == 'Anual' ? 'selected="selected"' :'' }}>
                                        Anual
                                    </option>
                                    <option
                                        value="Cuatrimestral (1er)" {{ $materia->regimen == 'Cuatrimestral (1er)' ?  'selected="selected"' :'' }}>
                                        Cuatrimestral (1er)
                                    </option>
                                    <option
                                        value="Cuatrimestral (2do)" {{ $materia->regimen == 'Cuatrimestral (2do)' ?  'selected="selected"' :'' }}>
                                        Cuatrimestral (2do)
                                    </option>
                                </select>
                            </div>


                            <div class="form-group col-sm-3">
                                <label for="cierre_diferido">Diferenciada <sup>*</sup>: </label>
                                <select class="form-control select2" id="cierre_diferido" name="cierre_diferido">
                                    <option
                                        value="1"
                                        @if($materia->cierre_diferido)
                                            selected="selected"
                                        @endif
                                    >
                                        ☑ Si
                                    </option>
                                    <option
                                        value="0"
                                        @if(!$materia->cierre_diferido)
                                            selected="selected"
                                        @endif
                                    >
                                        ☒ No
                                    </option>
                                </select>
                            </div>

                            <div class="form-group col-sm-3">
                                <label for="etapa_campo">Etapa de Campo</label>
                                <select name="etapa_campo" id="etapa_campo" class="form-select"
                                        @if(!Session::has('admin'))
                                            disabled
                                    @endif
                                >
                                    <option value="1" {{ $materia->etapa_campo ? 'selected="selected' : '' }}

                                    >
                                        ☑ Habilitada
                                    </option>
                                    <option value="0" {{ !$materia->etapa_campo ? 'selected="selected' : '' }}>
                                        ☒ Deshabilitada

                                    </option>
                                </select>
                            </div>


                        </div>
                        <div class="row">
                            <div class="col-sm-6">

                                <label for="correlativa_cursado">Correlatividades para cursar: </label>
                                <select class="form-control select2" id="correlativa_cursado"
                                        name="correlativa_cursado[]" multiple="multiple">
                                    <option value="">No tiene correlativa cursado</option>
                                    @foreach($materias as $mater)
                                        @if(in_array($mater->id, $materia->correlativasCursadoArray()))
                                            <option value="{{ $mater->id }}" selected="selected">
                                                {{ $mater->nombre }}
                                            </option>
                                        @else
                                            @if($mater->id != $materia->id)
                                                <option value="{{ $mater->id }}">
                                                    {{ $mater->nombre }}
                                                </option>
                                            @endif

                                        @endif

                                    @endforeach
                                </select>
                            </div>

                            <div class="col-sm-6">

                                <label for="correlativa">Correlatividades para rendir: </label>
                                <select class="form-control select2" id="correlativa"
                                        name="correlativa[]" multiple="multiple">
                                    <option value="">No tiene correlativa</option>
                                    @foreach($materias as $mater)
                                        @if(in_array($mater->id, $materia->correlativasArray()))
                                            <option value="{{ $mater->id }}" selected="selected">
                                                {{ $mater->nombre }}
                                            </option>
                                        @else
                                            @if($mater->id != $materia->id)
                                                <option value="{{ $mater->id }}">
                                                    {{ $mater->nombre }}
                                                </option>
                                            @endif

                                        @endif

                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6">
                            <label for="tipo_unidad_curricular">Tipo unidad curricular: </label>
                                <select class="form-control select2" id="tipo_unidad_curricular"
                                        name="tipo_unidad_curricular">
                                    <option value="">No tiene tipo</option>
                                    @foreach($tipo_materias as $tipo)
                                        @if($tipo->id == $materia->masterMateria->tipo_unidad_curricular_id)
                                            <option value="{{ $tipo->id }}" selected="selected">
                                                {{ $tipo->nombre }}
                                            </option>
                                        @else
                                        <option value="{{ $tipo->id }}">
                                                    {{ $tipo->nombre }}
                                                </option>
                                        @endif

                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <div class="form-group mt-2">
                            <input type="submit" class="btn btn-success" value="Editar materia">
                            <p>
                                <sup>*</sup>
                                La materia tiene un cierre de ciclo lectivo distinto o un régimen distinto
                                para la sede
                            </p>
                            @if($materia->cierre_diferido)
                                <a class="btn btn-sm btn-info" data-bs-toggle="modal" id="agregarButton"
                                   data-bs-target="#modalModal"
                                   data-loader="{{$materia->id}}"
                                   data-attr="{{ route('ciclo_lectivo_especial.create', $materia->id) }}">
                                    <i class="fas fa-edit text-gray-300"></i>
                                    <i class="fa fa-spinner fa-spin" style="display: none"
                                       id="loader{{$materia->id}}"></i>
                                    Agregar fechas diferenciadas
                                </a>
                            @endif
                        </div>
                    </form>

                </div>
            </div>

            @if($materia->cierre_diferido)
                @include('parameters.ciclo_lectivo.modal.form_modal_ciclo_lectivo')
                <div class="col-sm-12 text-center">
                    <h4>Cierres diferidos</h4>
                </div>
                <table class="table text-center">
                    <thead class="bg-dark text-white">
                    <tr>
                        <th>
                            Ciclo Lectivo
                        </th>
                        <th>
                            Cierre ciclo
                        </th>
                        <th>
                            Régimen
                        </th>
                        @if(Session::has('admin') || Session::has('coordinador'))
                            <th class="text-center">
                                <i class="fa fa-cogs"></i>
                            </th>
                        @endif

                    </tr>

                    </thead>
                    <tbody>
                    @foreach($materia->ciclosLectivosDiferenciados() as $cicloLectivo )
                        <tr>
                            <td>
                                {{$cicloLectivo->ciclo_lectivo_id}}
                            </td>
                            <td>
                                {{date_format(new DateTime($cicloLectivo->cierre_ciclo),'d-m-Y')}}

                            </td>
                            <td>
                                {{$cicloLectivo->regimen}}
                            </td>
                            @if(Session::has('admin') || Session::has('coordinador'))
                                <td>
                                    <a class="btn btn-sm btn-info" data-bs-toggle="modal" id="editarButton"
                                       data-bs-target="#modalModal"
                                       data-loader="{{$materia->id}}"
                                       data-attr="{{ route('ciclo_lectivo_especial.edit', ['ciclo_lectivo_especial' => $cicloLectivo->id]) }}">
                                        <i class="fas fa-edit text-gray-300"></i>
                                        <i class="fa fa-spinner fa-spin" style="display: none"
                                           id="loader{{$materia->id}}"></i>
                                        Editar fecha diferenciada
                                    </a>
                                </td>
                            @endif

                        </tr>
                    @endforeach

                    </tbody>
                </table>

            @endif
        </div>

    </div>
@endsection
@section('scripts')

    <script src="{{asset('vendors/select2/js/select2.min.js')}}"></script>
    <script src="{{ asset('vendors/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $(".select2").select2({
// dropdownParent: $('#agregaModal'),
                theme: "bootstrap",
                width: "100%",
                placeholder: 'Seleccione una opción',
                allowClear: true
            });
        });
        $(document).on('click', '#agregarButton', function (event) {
            event.preventDefault();
            let href = $(this).attr('data-attr');

            let referencia = $(this).attr('data-loader');
            const $laoder = $('#loader' + referencia);
            $("#modalModal").on("hidden.bs.modal", function () {
                $("#modalBody").html("");
            });

            $.ajax({

                url: href,
                beforeSend: function () {
                    $laoder.show();
                    $("#modalBody").html("");
                },
// return the result
                success: function (result) {


                    $('#modalModal').modal("show");


                    $('#modalBody').html(result).show();
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

        $(document).on('click', '#editarButton', function (event) {
            event.preventDefault();
            let href = $(this).attr('data-attr');

            let referencia = $(this).attr('data-loader');
            const $laoder = $('#loader' + referencia);
            $("#modalModal").on("hidden.bs.modal", function () {
                $("#modalBody").html("");
            });

            $.ajax({

                url: href,
                beforeSend: function () {
                    $laoder.show();
                    $("#modalBody").html("");
                },
// return the result
                success: function (result) {


                    $('#modalModal').modal("show");


                    $('#modalBody').html(result).show();
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
