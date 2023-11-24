@extends('layouts.app-prueba')
@section('content')
<div class="container col-md-8 p-3">
    <div class="card text-white bg-primary mb-3">
        <div class="card-header">
            <h2>{{$carrera->sede->nombre.' - '.$carrera->nombre}} - Encuesta Socioeconómica y Motivacional {{ date('Y') }}</h2>
        </div>
        <div class="card-body">
            <p>Queremos ahora conocer más sobre tu trayectoria educativa en el nivel secundario, tus motivaciones, expectativas y aquellos factores que de alguna manera puedan interferir en el cursado regular de la carrera que has elegido.</p>
            <p>Si disponemos de esta información de manera veraz, podremos ofrecerte un mejor acompañamiento.</p>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="form-group">
                <label for="nombre_preferido" class="text-primary">
                    <h4>Motivos que te animan a seguir estudiando:</h4>
                </label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="motivo_para_estudiar" id="motivo_para_estudiar1" value="superación personal" {{ old('distancia_ies') === 'superación personal' ? 'checked' : '' }}>
                    <label class="form-check-label" for="motivo_para_estudiar1">
                        Superación personal
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="motivo_para_estudiar" id="motivo_para_estudiar2" value="mejorar las condiciones del trabajo que poseo" {{ old('distancia_ies') === 'mejorar las condiciones del trabajo que poseo' ? 'checked' : '' }}>
                    <label class="form-check-label" for="motivo_para_estudiar2">
                        Mejorar las condiciones del trabajo que poseo
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="motivo_para_estudiar" id="motivo_para_estudiar3" value="tener mayor acceso laboral" {{ old('distancia_ies') === 'tener mayor acceso laboral' ? 'checked' : '' }}>
                    <label class="form-check-label" for="motivo_para_estudiar3">
                        Tener mayor acceso laboral
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="motivo_para_estudiar" id="motivo_para_estudiar6" value="cercanía con mi domicilio" {{ old('distancia_ies') === 'cercanía con mi domicilio' ? 'checked' : '' }}>
                    <label class="form-check-label" for="motivo_para_estudiar6">
                        Cercanía con mi domicilio
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="motivo_para_estudiar" id="motivo_para_estudiar4" value="porque me gusta la carrera" {{ old('distancia_ies') === 'porque me gusta la carrera' ? 'checked' : '' }}>
                    <label class="form-check-label" for="motivo_para_estudiar4">
                        Mejorar las condiciones del trabajo que poseo
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="motivo_para_estudiar" id="motivo_para_estudiar5" value="otro" {{ old('distancia_ies') === 'otro' ? 'checked' : '' }}>
                    <label class="form-check-label" for="motivo_para_estudiar5">
                        Otros
                    </label>
                </div>
                <div class="form-group d-none" id="otra_identidad_genero">
                    <label for="motivo_para_estudiar_otro">Cual?</label>
                    <input type="text" class="form-control mt-2" id="motivo_para_estudiar_otro" name="motivo_para_estudiar_otro" value="{{ old('motivo_para_estudiar_otro') }}">
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="form-group">
                <label for="nombre_preferido" class="text-primary">
                    <h4>¿Cómo conociste el instituto?</h4>
                </label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="motivo_para_estudiar" id="motivo_para_estudiar1" value="por otra persona" {{ old('distancia_ies') === 'por otra persona' ? 'checked' : '' }}>
                    <label class="form-check-label" for="motivo_para_estudiar1">
                    Por otra persona
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="motivo_para_estudiar" id="motivo_para_estudiar2" value="mejorar las condiciones del trabajo que poseo" {{ old('distancia_ies') === 'mejorar las condiciones del trabajo que poseo' ? 'checked' : '' }}>
                    <label class="form-check-label" for="motivo_para_estudiar2">
                        Mejorar las condiciones del trabajo que poseo
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="motivo_para_estudiar" id="motivo_para_estudiar3" value="tener mayor acceso laboral" {{ old('distancia_ies') === 'tener mayor acceso laboral' ? 'checked' : '' }}>
                    <label class="form-check-label" for="motivo_para_estudiar3">
                        Tener mayor acceso laboral
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="motivo_para_estudiar" id="motivo_para_estudiar6" value="cercanía con mi domicilio" {{ old('distancia_ies') === 'cercanía con mi domicilio' ? 'checked' : '' }}>
                    <label class="form-check-label" for="motivo_para_estudiar6">
                        Cercanía con mi domicilio
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="motivo_para_estudiar" id="motivo_para_estudiar4" value="porque me gusta la carrera" {{ old('distancia_ies') === 'porque me gusta la carrera' ? 'checked' : '' }}>
                    <label class="form-check-label" for="motivo_para_estudiar4">
                        Mejorar las condiciones del trabajo que poseo
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="motivo_para_estudiar" id="motivo_para_estudiar5" value="otro" {{ old('distancia_ies') === 'otro' ? 'checked' : '' }}>
                    <label class="form-check-label" for="motivo_para_estudiar5">
                        Otros
                    </label>
                </div>
                <div class="form-group d-none" id="otra_identidad_genero">
                    <label for="motivo_para_estudiar_otro">Cual?</label>
                    <input type="text" class="form-control mt-2" id="motivo_para_estudiar_otro" name="motivo_para_estudiar_otro" value="{{ old('motivo_para_estudiar_otro') }}">
                </div>
            </div>
        </div>
    </div>

</div>
@endsection