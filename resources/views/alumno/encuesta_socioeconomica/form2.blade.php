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
                    <input class="form-check-input" type="radio" name="motivo_para_estudiar" id="distancia_ies1" value="superación personal" {{ old('distancia_ies') === 'superación personal' ? 'checked' : '' }}>
                    <label class="form-check-label" for="distancia_ies1">
                    Superación personal
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="motivo_para_estudiar" id="distancia_ies2" value="mejorar las condiciones del trabajo que poseo" {{ old('distancia_ies') === 'mejorar las condiciones del trabajo que poseo' ? 'checked' : '' }}>
                    <label class="form-check-label" for="distancia_ies2">
                    Mejorar las condiciones del trabajo que poseo
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="motivo_para_estudiar" id="distancia_ies2" value="mejorar las condiciones del trabajo que poseo" {{ old('distancia_ies') === 'mejorar las condiciones del trabajo que poseo' ? 'checked' : '' }}>
                    <label class="form-check-label" for="distancia_ies2">
                    Mejorar las condiciones del trabajo que poseo
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="motivo_para_estudiar" id="distancia_ies2" value="mejorar las condiciones del trabajo que poseo" {{ old('distancia_ies') === 'mejorar las condiciones del trabajo que poseo' ? 'checked' : '' }}>
                    <label class="form-check-label" for="distancia_ies2">
                    Mejorar las condiciones del trabajo que poseo
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="motivo_para_estudiar" id="distancia_ies2" value="mejorar las condiciones del trabajo que poseo" {{ old('distancia_ies') === 'mejorar las condiciones del trabajo que poseo' ? 'checked' : '' }}>
                    <label class="form-check-label" for="distancia_ies2">
                    Mejorar las condiciones del trabajo que poseo
                    </label>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection