@extends('layouts.app-prueba')
@section('content')
    <div class="container">
        <h2 class="h1 text-info">
            Editar alumno {{ $alumno->nombres.' '.$alumno->apellidos }}
        </h2>
        <p>Edita los datos de el alumno</p>
        <hr>
        <div class="col-md-7">
            @if(@session('message'))
                <div class="alert alert-success">
                    {{ @session('message') }}
                </div>
            @endif
            <form method="POST" action="{{route('editar_alumno',['id'=>$alumno->id])}}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="imagen">
                        Foto tipo carnet digital (La imagen cambiará al subir el formulario)
                    </label>
                    <div class="imagen-alumno ml-4 mb-2">
                        <img src="{{ route('ver_imagen',['foto'=>$alumno->imagen]) }}" alt="Imagen Alumno IESVU">
                    </div>
                    <input type="file" id="imagen" name="imagen"
                           class="form-control @error('imagen') is-invalid @enderror" value="{{ old('imagen') }}">

                    @error('imagen')
                    <span class="invalid-feedback d-block" role="alert">
						    <strong>{{ $message }}</strong>
						</span>
                    @enderror
                </div>
                @if(Auth::user())
                    <div class="form-group">
                        <label for="carrera_id">Carrera:</label>
                        <select name="carrera_id" class="form-control" id="carrera_id">
                            @foreach($carreras as $carrera)
                                @if($carrera->id == $alumno->carrera_id)
                                    <option value="{{$carrera->id}}" selected="selected">{{$carrera->nombre}}
                                        - {{ucwords($carrera->turno)}} -
                                        {{$carrera->resolucion}}</option>
                                @else
                                    <option value="{{$carrera->id}}">{{$carrera->nombre}} - {{ucwords($carrera->turno)}}
                                        -
                                        {{$carrera->resolucion}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="cohorte">Cohorte:</label>
                        <input type="text" id="cohorte" name="cohorte"
                               class="form-control @error('cohorte') is-invalid @enderror" value="{{ $alumno->cohorte }}" />

                        @error('cohorte')
                        <span class="invalid-feedback d-block" role="alert">
						    <strong>{{ $message }}</strong>
						</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="fecha_primera_acreditacion">Fecha Primera Acreditación:</label>
                        <input type="date" id="fecha_primera_acreditacion" name="fecha_primera_acreditacion"
                               class="form-control @error('fecha_primera_acreditacion') is-invalid @enderror" value="{{ $alumno->fecha_primera_acreditacion }}" />

                        @error('fecha_primera_acreditacion')
                        <span class="invalid-feedback d-block" role="alert">
						    <strong>{{ $message }}</strong>
						</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="fecha_ultima_acreditacion">Fecha Última Acreditación:</label>
                        <input type="text" id="fecha_ultima_acreditacion" name="fecha_ultima_acreditacion"
                               class="form-control @error('fecha_ultima_acreditacion') is-invalid @enderror" value="{{ $alumno->fecha_ultima_acreditacion }}" />

                        @error('fecha_ultima_acreditacion')
                        <span class="invalid-feedback d-block" role="alert">
						    <strong>{{ $message }}</strong>
						</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="active">Activo:</label>
                        <input type="text" id="active" name="active"
                               class="form-control @error('active') is-invalid @enderror" value="{{ $alumno->active }}"
                               required/>

                        @error('active')
                        <span class="invalid-feedback d-block" role="alert">
						    <strong>{{ $message }}</strong>
						</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="año">Año:</label>
                        <select class="form-control" id="año" name="año">
                            <option value="{{$alumno->año}}">{{$alumno->año}} (Actual)</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>

                        @error('año')
                        <span class="invalid-feedback d-block" role="alert">
						    <strong>{{ $message }}</strong>
						</span>
                        @enderror
                    </div>
                @endif
                <div class="form-group">
                    <label for="nombres">Nombres (como figura en el documento):</label>
                    <input type="text" id="nombres" name="nombres"
                           class="form-control @error('nombres') is-invalid @enderror" value="{{ $alumno->nombres }}"
                           required/>

                    @error('nombres')
                    <span class="invalid-feedback d-block" role="alert">
						    <strong>{{ $message }}</strong>
						</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="apellidos">Apellidos (como figura en el documento):</label>
                    <input type="text" id="apellidos" name="apellidos"
                           class="form-control @error('apellidos') is-invalid @enderror"
                           value="{{ $alumno->apellidos }}" required/>

                    @error('apellidos')
                    <span class="invalid-feedback d-block" role="alert">
						    <strong>{{ $message }}</strong>
						</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="dni">D.N.I (Sin puntos):</label>
                    <input type="number" id="dni" name="dni" class="form-control @error('dni') is-invalid @enderror"
                           value="{{$alumno->dni }}" required/>

                    @error('dni')
                    <span class="invalid-feedback d-block" role="alert">
						    <strong>{{ $message }}</strong>
						</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="cuil">N° de C.U.I.L. (Sin guiones ni puntos):</label>
                    <input type="number" id="cuil" name="cuil" class="form-control @error('cuil') is-invalid @enderror"
                           value="{{ $alumno->cuil }}" required/>

                    @error('cuil')
                    <span class="invalid-feedback d-block" role="alert">
						    <strong>{{ $message }}</strong>
						</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="fecha">Fecha de Nacimiento:</label>
                    <input type="date" id="fecha" name="fecha" class="form-control @error('fecha') is-invalid @enderror"
                           value="{{ $alumno->fecha }}" required/>

                    @error('fecha')
                    <span class="invalid-feedback d-block" role="alert">
						    <strong>{{ $message }}</strong>
						</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="edad">Edad:</label>
                    <input type="number" id="edad" name="edad" class="form-control @error('edad') is-invalid @enderror"
                           value="{{ $alumno->edad }}" required/>

                    @error('edad')
                    <span class="invalid-feedback d-block" role="alert">
						    <strong>{{ $message }}</strong>
						</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email"
                           class="form-control @error('email') is-invalid @enderror" value="{{ $alumno->email }}" email
                           required/>

                    @error('email')
                    <span class="invalid-feedback d-block" role="alert">
						    <strong>{{ $message }}</strong>
						</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="nacionalidad">Nacionalidad:</label>
                    <input type="text" id="nacionalidad" name="nacionalidad"
                           class="form-control @error('nacionalidad') is-invalid @enderror"
                           value="{{$alumno->nacionalidad }}" placeholder="Argentina, Uruguaya, etc" required/>

                    @error('nacionalidad')
                    <span class="invalid-feedback d-block" role="alert">
						    <strong>{{ $message }}</strong>
						</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="domicilio">Domicilio:</label>
                    <input type="text" id="domicilio" name="domicilio"
                           class="form-control @error('domicilio') is-invalid @enderror"
                           value="{{ $alumno->domicilio }}" required/>

                    @error('domicilio')
                    <span class="invalid-feedback d-block" role="alert">
						    <strong>{{ $message }}</strong>
						</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="residencia">Residencia:</label>
                    <input type="text" id="residencia" name="residencia"
                           class="form-control @error('residencia') is-invalid @enderror"
                           value="{{ $alumno->residencia }}" placeholder="Capital, San Carlos, Tupungato, etc"
                           required/>

                    @error('residencia')
                    <span class="invalid-feedback d-block" role="alert">
						    <strong>{{ $message }}</strong>
						</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="telefono">Teléfono:</label>
                    <input type="number" id="telefono" name="telefono"
                           class="form-control @error('telefono') is-invalid @enderror" value="{{ $alumno->telefono }}"
                           required/>

                    @error('telefono')
                    <span class="invalid-feedback d-block" role="alert">
						    <strong>{{ $message }}</strong>
						</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="condicion_s">Situación de Escolaridad:</label>
                    <select class="form-control" name="condicion_s" id="condicion_s">
                        <option value="{{ $alumno->condicion_s }}">
                            {{ucwords($alumno->condicion_s)}} (Actual)
                        </option>
                        <option value="primario completo">Primario Completo</option>
                        <option value="secundario completo">Secundario Completo</option>
                        <option value="secundario incompleto">Secundario Incompleto</option>
                        <option value="cursando actualmente secundario">Cursando actualmente el nivel secundario
                        </option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="escolaridad">Titulo Secundario:</label>
                    <select class="form-control" name="escolaridad" id="escolaridad">
                        <option value="{{ $alumno->escolaridad }}">
                            {{ucwords($alumno->escolaridad)}} (Actual)
                        </option>
                        <option value="no">No</option>
                        <option value="si">Si</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="escuela_s">Nombre de escuela donde egresó: (Número y Nombre):</label>
                    <input type="text" id="escuela_s" name="escuela_s"
                           class="form-control @error('escuela_s') is-invalid @enderror"
                           value="{{ $alumno->escuela_s }}" required/>

                    @error('escuela_s')
                    <span class="invalid-feedback d-block" role="alert">
						    <strong>{{ $message }}</strong>
						</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="materias_s">Adeuda materias:</label>
                    <select class="form-control" name="materias_s" id="materias_s">
                        <option value="{{$alumno->materias_s}}">{{ucwords($alumno->materias_s)}} (Actual)</option>
                        <option value="no">No</option>
                        <option value="si">Si</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="conexion">Conexión a Internet:</label>
                    <select class="form-control" name="conexion" id="conexion">
                        <option value="{{$alumno->conexion}}">{{ucwords($alumno->conexion)}} (Actual)</option>
                        <option value="no">No</option>
                        <option value="si">Si</option>
                    </select>
                </div>
                <br>
                <h4>Documentación a adjuntar</h4>
                <hr>
                <div class="form-group">
                    <label for="dni_archivo">
                        DNI:
                        @if($alumno->dni_archivo)
                            (Ya hay un archivo subido, si sube otro, el anterior se eliminará)
                        @endif
                    </label>
                    <input type="file" id="dni_archivo" name="dni_archivo"
                           class="form-control @error('dni_archivo') is-invalid @enderror"
                           value="{{ old('dni_archivo') }}">

                    @error('dni_archivo')
                    <span class="invalid-feedback d-block" role="alert">
						    <strong>{{ $message }}</strong>
						</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="partida_archivo">
                        Partida de Nacimiento:
                        @if($alumno->partida_archivo)
                            (Ya hay un archivo subido, si sube otro, el anterior se eliminará)
                        @endif
                    </label>
                    <input type="file" id="partida_archivo" name="partida_archivo"
                           class="form-control @error('partida_archivo') is-invalid @enderror"
                           value="{{ old('partida_archivo') }}">

                    @error('partida_archivo')
                    <span class="invalid-feedback d-block" role="alert">
						    <strong>{{ $message }}</strong>
						</span>
                    @enderror
                </div>

                <br>
                <h4>Trayecto de nivel medio</h4>
                <hr>
                <div class="form-group">
                    <label for="titulo_archivo">
                        A- Título de Nivel Secundario:
                        @if($alumno->titulo_archivo)
                            (Ya hay un archivo subido, si sube otro, el anterior se eliminará)
                        @endif
                    </label>
                    <input type="file" id="titulo_archivo" name="titulo_archivo"
                           class="form-control @error('titulo_archivo') is-invalid @enderror"
                           value="{{ old('titulo_archivo') }}">

                    @error('titulo_archivo')
                    <span class="invalid-feedback d-block" role="alert">
						    <strong>{{ $message }}</strong>
						</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="certificado_archivo">
                        B- Certificación de Nivel Secundario:
                        @if($alumno->certificado_archivo)
                            (Ya hay un archivo subido, si sube otro, el anterior se eliminará)
                        @endif
                    </label>
                    <input type="file" id="certificado_archivo" name="certificado_archivo"
                           class="form-control @error('certificado_archivo') is-invalid @enderror"
                           value="{{ old('certificado_archivo') }}">

                    @error('certificado_archivo')
                    <span class="invalid-feedback d-block" role="alert">
						    <strong>{{ $message }}</strong>
						</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="psicofisico">
                        Psicofísico:
                        @if($alumno->psicofisico_archivo)
                            (Ya hay un archivo subido, si sube otro, el anterior se eliminará)
                        @endif
                    </label>
                    <input type="file" id="psicofisico" name="psicofisico"
                           class="form-control @error('psicofisico') is-invalid @enderror"
                           value="{{ old('psicofisico') }}">

                    @error('psicofisico')
                    <span class="invalid-feedback d-block" role="alert">
						    <strong>{{ $message }}</strong>
						</span>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="submit" value="Editar Alumno" class="btn btn-success">
                </div>

            </form>
        </div>
    </div>
@endsection
