@extends('layouts.app-prueba')
@section('content')
<div class="container col-md-8">
    <h2 class="h1 mb-4">
        Editar matriculación de  a {{ $carrera->sede->nombre }} - {{ $carrera->nombre }} : {{ ucwords($carrera->turno) }} 
    </h2>
    <p>
       <b>ATENCIÓN:</b> El siguiente formulario reviste carácter de Declaración Jurada. Los datos que usted brinde serán utilizados para la carga del Sistema de Gestión Mendoza (GEM) de la Dirección General de Escuelas. Por lo cual le solicitamos que al momento de la carga consigne la información sin errores y teniendo en cuenta la documentación respaldatoria.
    </p>
    <p>
       <b>IMPRESIÓN Y PRESENTACIÓN DE DOCUMENTACIÓN:</b> Para finalizar el proceso al terminar la carga, usted deberá realizar la IMPRESIÓN del formulario y acercarlo a la Sección Alumnos de su carrera y/o Unidad Académica. La carga del Formulario le llegará a la cuenta de correo que usted consigne.
    </p>
    <p>
       <b>RECUERDE: </b> Usted deberá responder un solo formulario con todos sus datos. En caso de querer modificar la información suministrada podrá hacerlo desde el mail de respuesta que recibirá una vez finalizado el proceso de carga y generado su envío.
    </p>
    <form action="{{ route('matriculacion.update',$matriculacion->id) }}" method="POST">
        {{ method_field('PUT') }}
        @include('matriculacion.campos')
        <hr>
        @include('matriculacion.campos.campos_generales')
        @include('matriculacion.campos.campos_domicilio')
        @include('matriculacion.campos.campos_personales')
        @include('matriculacion.campos.campos_discapacidad')
        
        <input type="submit" value="Siguiente" class="btn btn-primary mt-3 col-md-12">
    </form>
</div>
@endsection
@section('scripts')
<script src="{{ asset('js/matriculacion/create.js') }}"></script>
@endsection