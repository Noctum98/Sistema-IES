@extends('layouts.app-prueba')
@section('content')
<div class="card mt-3">
    <h5 class="card-header text-secondary">INSCRIPCIÓN A MATERIAS DE SEGUNDO CUATRIMESTRE</h5>
    <div class="card-body">
        @include('alumno.includes.tabla_materias',['año'=>$año,'materias'=>$inscripcion->carrera->materias_segundo_cuatrimestre(),'alumno'=>$inscripcion->alumno,'ciclo_lectivo'=>$ciclo_lectivo->year,'alumnoMod'=>true])
    </div>
</div>
@endsection