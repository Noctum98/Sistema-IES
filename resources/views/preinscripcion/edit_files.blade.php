@extends('layouts.app-prueba')
@section('content')
<div class="container p-3">
    <div class="col-md-12 d-flex flex-column align-items-center">
        <div class="card col-md-8 p-4 text-light bg-dark">
            <div class="card-body">
                <h5 class="card-title text-info">Artículo 7mo: {{ $preinscripcion->nombres.' '.$preinscripcion->apellidos }}</h5>
                <h6 class="card-subtitle mb-2 text-light">
                    <ul>
                        <li>Carrera: {{ $preinscripcion->carrera->nombre }}</li>
                        <li>Turno: {{ucwords($preinscripcion->carrera->turno)}}</li>
                        <li>Ubicación: {{ucwords($preinscripcion->carrera->sede->ubicacion)}}</li>
                        <li>Sede: {{ucwords($preinscripcion->carrera->sede->nombre)}}</li>

                    </ul>
                </h6>
            </div>
            <div>

                <hr>
                <div id="archivos_articulo_septimo">
                    <form action="{{ route('pre.filesUpload',['id'=>$preinscripcion->id,'timecheck'=>$preinscripcion->timecheck]) }}" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="primario_file">
                            Título de Nivel Primario:
                            @if($preinscripcion->primario)
                            <b class="text-primary">(Ya hay un archivo subido, si sube otro, el anterior se eliminará)</b>
                            @endif
                        </label><br>
                        <input type="file" id="primario_file" name="primario_file" class="@error('primario_file') is-invalid @enderror" value="{{ old('primario_file') }}">

                        @error('primario_file')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="ctrabajo_file">
                            Certificado de Trabajo con firma y sello de quien lo emite
                            @if($preinscripcion->ctrabajo)
                            <b class="text-primary">(Ya hay un archivo subido, si sube otro, el anterior se eliminará)</b>
                            @endif
                        </label><br>
                        <input type="file" id="ctrabajo_file" name="ctrabajo_file" class="@error('ctrabajo_file') is-invalid @enderror" value="{{ old('ctrabajo_file') }}">

                        @error('ctrabajo_file')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="curriculum_file">
                            Currículum Vitae (en formato PDF)
                            @if($preinscripcion->curriculum)
                            <b class="text-primary">(Ya hay un archivo subido, si sube otro, el anterior se eliminará)</b>
                            @endif
                        </label><br>
                        <input type="file" id="curriculum_file" name="curriculum_file" class="@error('curriculum_file') is-invalid @enderror" value="{{ old('curriculum_file') }}">

                        @error('curriculum_file')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="nota_file">
                            Nota a la Rectora (en PDF)
                            @if($preinscripcion->nota)
                            <b class="text-primary">(Ya hay un archivo subido, si sube otro, el anterior se eliminará)</b>
                            @endif
                        </label><br>
                        <input type="file" id="nota_file" name="nota_file" class="@error('nota_file') is-invalid @enderror" value="{{ old('nota_file') }}">

                        @error('nota_file')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <input type="submit" value="Enviar archivos" class="btn btn-success">
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
</div>
@endsection