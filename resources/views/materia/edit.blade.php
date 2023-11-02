@extends('layouts.app-prueba')
<link href="{{ asset('vendors/select2/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/font-awesome/4.6.1/css/font-awesome.min.css') }}" rel="stylesheet"/>
<link rel="stylesheet"
      href="{{ asset('css/select2-bootstrap-theme/select2-bootstrap.min.css')}}"
      crossorigin="anonymous" referrerpolicy="no-referrer"/>
@section('content')
    <style>
        .card {
            /*margin-top: 2em;*/
            padding: 0 0.5em;
            border-radius: 2em;
            /*text-align: center;*/
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        }

        .card li {
            list-style: none;
        }

        .card_img {
            /*width: 65%;*/
            /*border-radius: 50%;*/
            border-radius: 2em;
            margin: 0 auto 0 -50px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            background: #1a1e21;
            color: white;
            font-size: 6em;
            font-weight: bold;
        }

        .card .card-title {
            font-weight: 700;
            font-size: 1.5em;
        }

        /*.card .btn {*/
        /*    border-radius: 2em;*/
        /*    background-color: teal;*/
        /*    color: #ffffff;*/
        /*    padding: 0.5em 1.5em;*/
        /*}*/

        .border-radius {
            border-radius: 2em 2em 0 0;
            padding: 1em;
        }

        .card .btn:hover {
            background-color: rgba(0, 128, 128, 0.7);
            color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .select2-container .select2-selection--single {
            height: calc(1.6em + .75rem + 2px)
        }
    </style>
    <div class="container-fluid">
        <div class="card">
            <div class="row">
                <div>
                </div>

                <div class="card-header border-radius col-sm-12 flex-column">
                    <div class="row text-center">
                        <div class="col-sm-7 mx-auto">

                            <h5 class="card-title">
                                <small>Edición de</small> {{ $materia->nombre }}
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
                    @if(@session('message'))
                        <div class="alert alert-success">
                            {{ @session('message') }}
                        </div>
                    @endif
                </div>
                <div class="row">
                    <form method="POST" action="{{ route('editar_materia',['id'=>$materia->id]) }}">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">
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
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
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
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="regimen">Régimen:</label>
                                    <select class="form-control select2" id="regimen" name="regimen">
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
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="correlativa">Correlatividad: </label>
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
                                                        {{ $mater->nombre }} }}
                                                    </option>
                                                @endif

                                            @endif

                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
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
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-success" value="Editar materia">
                        </div>
                    </form>
                </div>
            </div>
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
                theme: "classic",
                width: "100%",
                placeholder: 'Seleccione una opción',
                allowClear: true
            });
        });
    </script>

@endsection
