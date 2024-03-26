@extends('layouts.app-prueba')
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="float-start">
                    <h2 class="text-info">
                        Crear carreras
                    </h2>
                    <p>Agrega una carrera a tu institución</p>
                </div>
                <div class="float-end">
                    <a href="{{route('carrera.admin')}}" class="btn btn-info"> Ver listado carreras</a>

                </div>
            </div>

        </div>
        <hr>
        <div class="col-md-12">
            <form method="POST" action="{{ route('crear_carrera') }}" class="form-row">
                @csrf
                <div class="form-group col-sm-4">
                    <label for="nombre">Nombre de la carrera:</label>
                    <input type="text" id="nombre" name="nombre"
                           class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}"
                           required/>

                    @error('nombre')
                    <span class="invalid-feedback d-block" role="alert">
			                <strong>{{ $message }}</strong>
			            </span>
                    @enderror
                </div>
                <div class="form-group col-sm-4">
                    <label for="sede">Sede:</label>
                    <select id="sede" name="sede_id" class="form-control">
                        @foreach($sedes as $sede)
                            <option value="{{ $sede->id }}">{{ $sede->nombre }}</option>
                        @endforeach
                    </select>

                    @error('cargo')
                    <span class="invalid-feedback d-block" role="alert">
			                <strong>{{ $message }}</strong>
			            </span>
                    @enderror
                </div>
                <div class="form-group col-sm-4">
                    <label for="titulo">Nombre del título:</label>
                    <input type="text" id="titulo" name="titulo"
                           class="form-control @error('titulo') is-invalid @enderror" value="{{ old('titulo') }}"
                           required/>

                    @error('titulo')
                    <span class="invalid-feedback d-block" role="alert">
			                <strong>{{ $message }}</strong>
			            </span>
                    @enderror
                </div>
                <div class="form-group col-sm-2">
                    <label for="años">Años de duración:</label>
                    <input type="number" id="años" name="años" class="form-control @error('años') is-invalid @enderror"
                           value="{{ old('años') }}" required/>

                    @error('años')
                    <span class="invalid-feedback d-block" role="alert">
			                <strong>{{ $message }}</strong>
			            </span>
                    @enderror
                </div>
                <div class="form-group col-sm-5">
                    <label for="resolucion">Resolución:</label>
                    <input type="text" id="resolucion" name="resolucion"
                           class="form-control @error('resolucion') is-invalid @enderror"
                           value="{{ old('resolucion') }}">

                    @error('resolucion')
                    <span class="invalid-feedback d-block" role="alert">
			                <strong>{{ $message }}</strong>
			            </span>
                    @enderror
                </div>
                <div class="form-group col-sm-5">
                    <label for="vacunas">Vacunas:</label>
                    <select class="form-control" name="vacunas" id="vacunas">
                        <option value="todas">
                            Todas
                        </option>
                        <option value="antitetánica">
                            Antitetánica
                        </option>
                        <option value="ninguna">
                            Ninguna
                        </option>
                    </select>
                </div>
                <div class="form-group col-sm-3">
                    <label for="modalidad">Modalidad:</label>
                    <input type="text" id="modalidad" name="modalidad"
                           class="form-control @error('modalidad') is-invalid @enderror" value="{{ old('modalidad') }}">

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
                            value="tradicional">Tradicional
                        </option>
                        <option
                            value="tradicional2">
                            Tradicional 70/30
                        </option>
                        <option value="modular">
                            Modular
                        </option>
                        <option value="modular2">
                            Modular 70/30
                        </option>
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label for="turno">Turno:</label>
                    <select class="form-control" name="turno" id="turno">
                        <option value="mañana">Mañana</option>
                        <option value="tarde">Tarde</option>
                        <option value="vespertino">Vespertino</option>
                    </select>
                </div>
                {{--Para el nuevo ram--}}
                <div class="col-sm-6 col-md-3">
                    <label for="condicion_id">Condiciónes Carrera:</label>
                    <select id="condicion_id" name="condicion_id" class="form-control">
                        <option value="">Seleccione condición</option>
                        @foreach($condicionesCarrera as $condicion)

                            <option value="{{ $condicion->id }}">{{ $condicion->nombre }}</option>

                        @endforeach
                    </select>

                    @error('cargo')
                    <span class="invalid-feedback d-block" role="alert">
							<strong>{{ $message }}</strong>
						</span>
                    @enderror
                </div>

                <div class="form-group">
                    <input type="submit" value="Agregar carrera" class="btn btn-success">
                </div>
            </form>
        </div>
    </div>
@endsection
