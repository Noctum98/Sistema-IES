@extends('layouts.app-prueba')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header text-success">

            <h5>Matriculación Finalizada</h5>
        </div>
        <div class="card-body ">
            <h5 class="card-title">{{ $mensaje }}</h5>
            <p class="card-text">Se enviara un correo electronico a tu email con los datos de la matriculación.</p>
        </div>
    </div>
</div>
@endsection