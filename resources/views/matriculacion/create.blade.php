@extends('layouts.app-prueba')
@section('content')
<div class="container col-md-8">
    <h2 class="h1 mb-4 text-info">
        Inscripción a {{ $carrera->sede->nombre }} - {{ $carrera->nombre }}: {{ ucwords($carrera->turno) }}
    </h2>
    @if(@session('alumno_deleted'))
		<div class="alert alert-warning">
			{{ @session('alumno_deleted') }}
		</div>
	@endif
    <p>
        <b>ATENCIÓN:</b> el siguiente formulario reviste carácter de Declaración Jurada. Los datos que usted brinde serán utilizados para la carga del Sistema de Gestión Mendoza (GEM) de la Dirección General de Escuelas. Por lo cual le solicitamos que al momento de la carga consigne la información sin errores y teniendo en cuenta la documentación respaldatoria.
    </p>
    <p>
        <b>IMPRESIÓN Y PRESENTACIÓN DE DOCUMENTACIÓN:</b> para finalizar el proceso, al terminar la carga, usted deberá realizar la IMPRESIÓN del formulario y acercarlo a la Sección Alumnos de su carrera y/o Unidad Académica. La carga del formulario le llegará a la cuenta de correo que usted consigne.
    </p>
    <p>
        <b>RECUERDE: </b> usted deberá responder un solo formulario con todos sus datos. En caso de querer modificar la información suministrada, podrá hacerlo desde el mail de respuesta que recibirá una vez finalizado el proceso de carga y generado su envío.
    </p>

    @if($email_checked)
    <form action="{{ route('matriculacion.store',['id'=>$carrera->id,'year'=>$año]) }}" method="POST">
        @include('matriculacion.campos')
        <hr>
        @if($año == 1)
        @include('matriculacion.campos.campos_primero')
        @elseif($año == 2)
        @include('matriculacion.campos.campos_segundo')
        @elseif($año == 3)
        @include('matriculacion.campos.campos_tercero')
        @endif
        @include('matriculacion.campos.campos_generales')
        @include('matriculacion.campos.campos_domicilio')
        @include('matriculacion.campos.campos_personales')
        @include('matriculacion.campos.campos_discapacidad')
        <iframe class="mt-2" src="{{ $carrera->inscripcion }}" width="740" height="400" frameborder="0" marginheight="0" marginwidth="0">Cargando…</iframe>

        <input type="submit" value="Matricularme" class="btn btn-primary col-md-12">
    </form>
    @else
        @include('matriculacion.check_email')
    @endif


</div>
@endsection
@section('scripts')
<script src="{{ asset('js/matriculacion/create.js') }}"></script>
<script src="{{ asset('js/matriculacion/botones.js') }}"></script>
@endsection
