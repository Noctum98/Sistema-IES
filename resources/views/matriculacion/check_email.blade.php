@extends('layouts.app-prueba')
@section('content')
<div class="container col-md-8">
    <h2 class="h1 mb-4 text-info">
        Matriculación a {{ $carrera->sede->nombre }} - {{ $carrera->nombre }}: {{ ucwords($carrera->turno) }}
    </h2>
    @if(@session('alumno_deleted'))
		<div class="alert alert-warning">
			{{ @session('alumno_deleted') }}
		</div>
	@endif
    @if(@session('email_error'))
    <div class="d-block alert alert-danger">
        {{ @session('email_error') }}
    </div>
    @endif
    <p>
        <b>ATENCIÓN:</b> el siguiente formulario reviste carácter de Declaración Jurada. Los datos que usted brinde serán utilizados para la carga del Sistema de Gestión Mendoza (GEM) de la Dirección General de Escuelas. Por lo cual le solicitamos que al momento de la carga consigne la información sin errores y teniendo en cuenta la documentación respaldatoria.
    </p>
    <p>
        <b>IMPRESIÓN Y PRESENTACIÓN DE DOCUMENTACIÓN:</b> para finalizar el proceso, al terminar la carga, usted deberá realizar la IMPRESIÓN del formulario y acercarlo a la Sección Alumnos de su carrera y/o Unidad Académica. La carga del Formulario le llegará a la cuenta de correo que usted consigne.
    </p>
    <p>
        <b>RECUERDE: </b> usted deberá responder un solo formulario con todos sus datos. En caso de querer modificar la información suministrada, podrá hacerlo desde el mail de respuesta que recibirá una vez finalizado el proceso de carga y generado su envío.
    </p>
    <form action="{{ route('matriculacion.verificar',['carrera_id'=>$carrera->id,'year'=>$año]) }}" method="POST">
        @include('matriculacion.campos')
        <input type="submit" class="btn btn-primary" value="Comprobar correo">
    </form>
</div>
@endsection
