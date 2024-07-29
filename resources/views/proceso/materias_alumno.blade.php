@extends('layouts.app-prueba')
@section('content')
<div class="card mt-3">
    <h5 class="card-header text-secondary">INSCRIPCIÓN A MATERIAS DE SEGUNDO CUATRIMESTRE</h5>
    <div class="card-body">
        @include('alumno.includes.tabla_materias',['año'=>$año,'carrera'=>$carrera,'alumno'=>$matriculacion,'ciclo_lectivo'=>$ciclo_lectivo->year])
    </div>
</div>
@endsection