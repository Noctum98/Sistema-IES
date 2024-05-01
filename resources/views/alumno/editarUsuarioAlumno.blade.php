@extends('layouts.app-prueba')
@section('content')
    <div class="container col-md-8">
        <a href="{{url()->previous()}}">
            <button class="btn btn-outline-info mb-2"><i class="fas fa-angle-left"></i> Volver</button>
        </a>
        <h4 class="mb-4">
            Edición simple usuario/alumno: <b>{{ $alumno->nombres.' '.$alumno->apellidos }}</b>
        </h4>
        @if(@session('mensaje_editado'))
            <div class="alert alert-success">
                {{ @session('mensaje_editado') }}
            </div>
        @endif
        @if(@session('alumno_deleted'))
            <div class="alert alert-warning">
                {{ @session('alumno_deleted') }}
            </div>
        @endif
        <form
            action="{{ route('update-usuario-alumno',['alumno_id'=>$alumno->id]) }}"
            method="POST">
            {{ method_field('PUT') }}

            <div class="card mt-3">
                <h5 class="card-header text-secondary">DATOS GENERALES</h5>
                <div class="card-body">
                    <h5 class="card-title text-secondary">
                        Le recordamos que esta edición modifica los datos del alumno y del usuario simultáneamente.<br/>
                        <small><sup class="text-danger">*</sup> Todos los campos son obligatorios.</small>
                    </h5>
                    <div class="mt-4 row">
                        <div class="form-group">
                            <label for="email">Correo Electrónico</label>
                            <input type="email" name="email" id="email" class="form-control"
                                   value="{{ $alumno->email ? $alumno->email: old('email') }}" required/>
                            @error('email')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="nombre">Nombres</label>
                            <input type="text" name="nombres" id="nombres"
                                   value="{{  $alumno->nombres?? old('nombres') }}"
                                   class="form-control" required/>

                            @error('nombres')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="apellidos">Apellidos</label>
                            <input type="text" name="apellidos" id="apellidos"
                                   value="{{ $alumno->apellidos??  old('apellidos') }}"
                                   class="form-control" required/>

                            @error('apellidos')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="dni">D.N.I o Pasaporte</label>
                            <input type="number" name="dni" id="dni"
                                   value="{{ $alumno->dni ?? old('dni') }}"
                                   class="form-control" required/>

                            @error('dni')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="cuil">CUIL</label>
                            <input type="text" name="cuil" id="cuil"
                                   value="{{ $alumno->cuil?? old('cuil') }}"
                                   class="form-control" required/>

                            @error('cuil')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="fecha">Fecha de Nacimiento</label>
                            <input type="date" name="fecha" id="fecha" class="form-control"
                                   value="{{ $alumno->fecha?? old('fecha') }}" required/>
                            @error('fecha')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="fecha">Teléfono</label>
                            <input type="tel" name="telefono" id="telefono" class="form-control"
                                   value="{{ $alumno->telefono?? old('telefono') }}" required/>
                            @error('telefono')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="nacionalidad">Nacionalidad</label>
                            <select name="nacionalidad" id="nacionalidad" class="form-select">
                                <option
                                    value="argentina" {{ $alumno->nacionalidad == 'argentina' ? 'selected="selected"' : '' }}>
                                    Argentina
                                </option>
                                <option
                                    value="bolivia" {{  $alumno->nacionalidad == 'bolivia' ? 'selected="selected"' : '' }}>
                                    Bolivia
                                </option>
                                <option
                                    value="brasil" {{  $alumno->nacionalidad == 'brasil' ? 'selected="selected"' : '' }}>
                                    Brasil
                                </option>
                                <option
                                    value="chile" {{  $alumno->nacionalidad == 'chile' ? 'selected="selected"' : '' }}>
                                    Chile
                                </option>
                                <option
                                    value="colombia" {{  $alumno->nacionalidad == 'colombia' ? 'selected="selected"' : '' }}>
                                    Colombia
                                </option>
                                <option
                                    value="ecuador" {{  $alumno->nacionalidad == 'ecuador' ? 'selected="selected"' : '' }}>
                                    Ecuador
                                </option>
                                <option
                                    value="paraguay" {{  $alumno->nacionalidad == 'paraguay' ? 'selected="selected"' : '' }}>
                                    Paraguay
                                </option>
                                <option
                                    value="perú" {{  $alumno->nacionalidad == 'perú' ? 'selected="selected"' : '' }}>
                                    Perú
                                </option>
                                <option
                                    value="uruguay" {{  $alumno->nacionalidad == 'uruguay' ? 'selected="selected"' : '' }}>
                                    Uruguay
                                </option>
                                <option
                                    value="venezuela" {{  $alumno->nacionalidad == 'venezuela' ? 'selected="selected"' : '' }}>
                                    Venezuela
                                </option>
                                <option
                                    value="otro" {{  $alumno->nacionalidad == 'otro' ? 'selected="selected"' : '' }}>
                                    Otro país de America
                                </option>
                                <option
                                    value="europa" {{  $alumno->nacionalidad == 'europa' ? 'selected="selected"' : '' }}>
                                    Europa
                                </option>
                                <option
                                    value="asia" {{  $alumno->nacionalidad == 'asia' ? 'selected="selected"' : '' }}>
                                    Asia
                                </option>
                            </select>
                        </div>
                        <!-------
            <div class="form-group col-md-6">
                <label for="otra">Otra nacionalidad</label>
                <input type="text" name="nacionalidad_otra" id="otra" value=" {{ isset($alumno) ? $alumno->nacionalidad_otra : old('nacionalidad_otra') }} " class="form-control">
            </div>
            ---------->
                        <div class="form-group col-md-6">
                            <label for="genero">Género</label>
                            <select name="genero" id="genero" class="form-select">
                                <option
                                    value="masculino" {{  $alumno->genero == 'masculino' ? 'selected="selected"' : '' }}>
                                    Masculino
                                </option>
                                <option
                                    value="femenino" {{  $alumno->genero == 'femenino' ? 'selected="selected"' : '' }}>
                                    Femenino
                                </option>
                                <option
                                    value="no_binario" {{  $alumno->genero == 'no_binario' ? 'selected="selected"' : '' }}>
                                    No binario
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>


            @if(Session::has('coordinador') || Session::has('regente') || Session::has('admin') || Session::has('seccionAlumnos'))
                <input type="submit" value="Editar Alumno/Usuario" class="btn btn-primary mt-3 col-md-12">
            @endif


        </form>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/alumnos/create.js') }}"></script>
@endsection
