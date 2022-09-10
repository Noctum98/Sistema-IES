@extends('layouts.app-prueba')
@section('content')
    <div class="container p-2">
        <h2 class="h1 text-info">
            Editar carrera {{ $cargo->nombre }}
        </h2>
        <p>Edita las carreras y nombre de un cargo</p>
        <hr>
        <div class="col-md-8">
            @if(@session('message'))
                <div class="alert alert-success">
                    {{ @session('message') }}
                </div>
            @endif
            <form method="POST" action="{{ route('editar_cargo',['cargo'=>$cargo->id]) }}">
                @csrf
                <div class="row">
                    <div class="d-flex flex-column col-md-6">
                        <div class="form-group">
                            <label for="nombre">Nombre del cargo:</label>
                            <input type="text" id="nombre" name="nombre"
                                   class="form-control @error('nombre') is-invalid @enderror"
                                   value="{{ $cargo->nombre }}" required/>

                            @error('nombre')
                            <span class="invalid-feedback d-block" role="alert">
							<strong>{{ $message }}</strong>
						</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="sede">Carrera:</label>
                            <select id="sede" name="carrera_id" class="form-control">
                                <option value="">Seleccione carrera</option>
                                @foreach($carreras as $carrera)
                                    @if($cargo->carrera_id == $carrera->id)
                                        <option value="{{ $carrera->id }}"
                                                selected="selected">{{ $carrera->nombre }}</option>
                                    @else
                                        <option value="{{ $carrera->id }}">{{ $carrera->nombre }}</option>
                                    @endif

                                @endforeach
                            </select>

                            @error('cargo')
                            <span class="invalid-feedback d-block" role="alert">
							<strong>{{ $message }}</strong>
						</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="tipo_materia_id">Tipo cargo:</label>
                            <select id="tipo_materia_id" name="tipo_materia_id" class="form-control">
                                <option value="">Selecciones tipo cargo</option>
                                @foreach($tipo_cargos as $tp)
                                    @if($cargo->tipo_materia_id == $tp->id)
                                        <option value="{{ $tp->id }}" selected="selected">{{ $tp->nombre }}</option>
                                    @else
                                        <option value="{{ $tp->id }}">{{ $tp->nombre }}</option>
                                    @endif

                                @endforeach
                            </select>

                            @error('cargo')
                            <span class="invalid-feedback d-block" role="alert">
							<strong>{{ $message }}</strong>
						</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input type="submit" value="Editar cargo" class="btn btn-success">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
