@extends('layouts.app-prueba')
@section('content')
    <div class="container-fluid p-2">
        <div class="card">
            <div class="card-header">
                <div class="float-start">
                    <h2 class="text-info">
                        Editar carrera {{ $carrera->nombre }}
                    </h2>
                    <p>Edita los datos y personal encargado de la carrera</p>
                </div>
                <div class="float-end">
                    <a href="{{route('carrera.admin')}}" class="btn btn-info"> Ver listado carreras</a>

                </div>
            </div>

        </div>
        <hr>
        <div class="col-md-12">
            @if(@session('message'))
                <div class="alert alert-success">
                    {{ @session('message') }}
                </div>
            @endif
            <form method="POST" action="{{ route('editar_carrera',['id'=>$carrera->id]) }}" class="w-100">
                @csrf
                <div class="row">

                    <div class="col-sm-6 col-md-4">
                        <label for="nombre">Nombre de la carrera:</label>
                        <input type="text" id="nombre" name="nombre"
                               class="form-control @error('nombre') is-invalid @enderror"
                               value="{{ $carrera->nombre }}" required/>

                        @error('nombre')
                        <span class="invalid-feedback d-block" role="alert">
							<strong>{{ $message }}</strong>
						</span>
                        @enderror
                    </div>

                    <div class="col-sm-6 col-md-4">
                        <label for="sede">Sede:</label>
                        <select id="sede" name="sede_id" class="form-control">
                            @foreach($sedes as $sede)
                                @if($carrera->sede_id == $sede->id)
                                    <option value="{{ $sede->id }}" selected="selected">{{ $sede->nombre }}</option>
                                @else
                                    <option value="{{ $sede->id }}">{{ $sede->nombre }}</option>
                                @endif

                            @endforeach
                        </select>

                        @error('cargo')
                        <span class="invalid-feedback d-block" role="alert">
							<strong>{{ $message }}</strong>
						</span>
                        @enderror
                    </div>

                    <div class="col-sm-6 col-md-4">
                        <label for="titulo">Nombre del título:</label>
                        <input type="text" id="titulo" name="titulo"
                               class="form-control @error('titulo') is-invalid @enderror"
                               value="{{ $carrera->titulo }}" required/>

                        @error('titulo')
                        <span class="invalid-feedback d-block" role="alert">
							<strong>{{ $message }}</strong>
						</span>
                        @enderror
                    </div>
                </div>
                <div class="row">

                    <div class="col-sm-6 col-md-2">
                        <label for="años">Años de duración:</label>
                        <input type="number" id="años" name="años"
                               class="form-control @error('años') is-invalid @enderror" value="{{ $carrera->años }}"
                               required/>

                        @error('años')
                        <span class="invalid-feedback d-block" role="alert">
							<strong>{{ $message }}</strong>
						</span>
                        @enderror
                    </div>

                    <div class="col-sm-6 col-md-5">
                        <label for="resolucion">Resolución:</label>
                        <input type="text" id="resolucion" name="resolucion"
                               class="form-control @error('resolucion') is-invalid @enderror"
                               value="{{ $carrera->resolucion }}">

                        @error('resolucion')
                        <span class="invalid-feedback d-block" role="alert">
							<strong>{{ $message }}</strong>
						</span>
                        @enderror
                    </div>
                    <div class="col-sm-6 col-md-5">
                        <label for="vacunas">Vacunas:</label>
                        <select class="form-control" name="vacunas" id="vacunas">
                            <option value="todas" {{$carrera->vacunas == 'todas' ? 'selected="selected"':''}}>
                                Todas
                            </option>
                            <option
                                value="antitetánica" {{$carrera->vacunas == 'antitetánica' ? 'selected="selected"':''}}>
                                Antitetánica
                            </option>
                            <option value="ninguna" {{$carrera->vacunas == 'ninguna' ? 'selected="selected"':''}}>
                                Ninguna
                            </option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-md-3">
                        <label for="modalidad">Modalidad:</label>
                        <input type="text" id="modalidad" name="modalidad"
                               class="form-control @error('modalidad') is-invalid @enderror"
                               value="{{ $carrera->modalidad }}">

                        @error('modalidad')
                        <span class="invalid-feedback d-block" role="alert">
							<strong>{{ $message }}</strong>
						</span>
                        @enderror
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <label for="tipo">Tipo:</label>
                        <select class="form-select" name="tipo" id="tipo">
                            <option
                                value="tradicional" {{$carrera->tipo == 'tradicional' ? 'selected="selected"':''}}>
                                Tradicional
                            </option>
                            <option
                                value="tradicional2" {{$carrera->tipo == 'tradicional2' ? 'selected="selected"':''}}>
                                Tradicional 70/30
                            </option>
                            <option value="modular" {{$carrera->tipo == 'modular' ? 'selected="selected"':''}}>
                                Modular
                            </option>
                            <option value="modular2" {{$carrera->tipo == 'modular2' ? 'selected="selected"':''}}>
                                Modular 70/30
                            </option>
                        </select>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <label for="turno">Turno:</label>
                        <select class="form-control" name="turno" id="turno">
                            <option value="mañana" {{$carrera->turno == 'mañana' ? 'selected="selected"':''}}>
                                Mañana
                            </option>
                            <option value="tarde" {{$carrera->turno == 'tarde' ? 'selected="selected"':''}}>
                                Tarde
                            </option>
                            <option
                                value="vespertino" {{$carrera->turno == 'vespertino' ? 'selected="selected"':''}}>
                                Vespertino
                            </option>
                            <option value="virtual" {{$carrera->turno == 'virtual' ? 'selected="selected"':''}}>
                                Virtual
                            </option>
                            <option value="sin turno" {{$carrera->turno == 'sin turno' ? 'selected="selected"':''}}>
                                Sin Turno
                            </option>
                        </select>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <label for="estado">Estado:</label>
                        <select class="form-control" name="estado" id="estado">
                            <option value=0 {{ !$carrera->estado ? 'selected="selected"':''}}>
                                En curso
                            </option>
                            <option value=1 {{$carrera->estado == 1 ? 'selected="selected"':''}}>
                                En cierre
                            </option>
                            <option value=2 {{$carrera->estado == 2 ? 'selected="selected"':''}}>
                                En apertura
                            </option>

                        </select>
                    </div>
                </div>
                <hr class="mb-1">

                <div class="row">
                    <div class="col-sm">
                        <label for="link_inscripcion">Link de Inscripción:</label>
                        <input type="text" id="link_inscripcion" name="link_inscripcion"
                               class="form-control @error('link_inscripcion') is-invalid @enderror"
                               value="{{ $carrera->link_inscripcion }}">

                        @error('link_inscripcion')
                        <span class="invalid-feedback d-block" role="alert">
							<strong>{{ $message }}</strong>
						</span>
                        @enderror
                    </div>
                    <div class="col-sm">
                        <label for="preinscripcion_habilitada">Preinscripción:</label>
                        <select class="form-select" name="preinscripcion_habilitada"
                                id="preinscripcion_habilitada">
                            <option
                                value="1" {{$carrera->preinscripcion_habilitada ? 'selected="selected"':''}}>
                                Habilitada
                            </option>
                            <option
                                value="0" {{!$carrera->preinscripcion_habilitada ? 'selected="selected"':''}}>
                                Deshabilitada
                            </option>
                        </select>
                    </div>
                    <div class="col-sm">
                        <label for="matriculacion_habilitada">Inscripción:</label>
                        <select class="form-select" name="matriculacion_habilitada"
                                id="matriculacion_habilitada">
                            <option value="1" {{$carrera->matriculacion_habilitada ? 'selected="selected"':''}}>
                                Habilitada
                            </option>
                            <option
                                value="0" {{!$carrera->matriculacion_habilitada ? 'selected="selected"':''}}>
                                Deshabilitada
                            </option>
                        </select>
                    </div>
                </div>
                {{--Para el nuevo ram--}}
                @if(Session::has('admin'))
                    <div class="col-sm-6 col-md-4">
                        <label for="condicion_id">Condiciónes Carrera:</label>
                        <select id="condicion_id" name="condicion_id" class="form-control">
                            <option value="">Seleccione condición</option>
                            @foreach($condicionesCarrera as $condicion)

                                @if(optional($carrera->condicionCarrera)->id == $condicion->id)
                                    <option value="{{ $condicion->id }}"
                                            selected="selected">{{ $condicion->nombre }}</option>
                                @else
                                    <option value="{{ $condicion->id }}">{{ $condicion->nombre }}</option>
                                @endif

                            @endforeach
                        </select>

                        @error('condicion')
                        <span class="invalid-feedback d-block" role="alert">
							<strong>{{ $message }}</strong>
						</span>
                        @enderror
                    </div>
                @endif
                <div class="form-group mt-2">
                    <input type="submit" value="Editar carrera" class="btn btn-success">
                </div>


            </form>
        </div>
    </div>
@endsection
