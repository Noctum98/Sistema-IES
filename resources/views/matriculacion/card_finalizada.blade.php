@extends('layouts.app-prueba')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header text-success">

            <h5 class="text-secondary">Inscripción Finalizada</h5>
        </div>
        <div class="card-body ">
            <h5 class="card-title text-secondary">{{ $mensaje }}</h5>
            <p class="card-text">Se enviará un correo electrónico a tu email con los datos de la inscripción y el pdf que deberás presentar a sección alumnos.</p>
        </div>
    </div>
</div>
@endsection
