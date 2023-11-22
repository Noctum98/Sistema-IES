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

</div>
@endsection