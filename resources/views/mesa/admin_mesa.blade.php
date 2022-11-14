@extends('layouts.app-prueba')

<link href="{{ asset('vendors/select2/css/select2.min.css') }}" rel="stylesheet">

@section('content')
<div class="container">
    <a href="{{ route('mesa.carreras',['sede_id'=>$carrera->sede->id,'instancia_id'=>$instancia->id]) }}">
        <button class="btn btn-outline-info mb-2">
            <i class="fas fa-angle-left"></i>
            Volver
        </button>
    </a>
    <h2 class="h1 text-info">
        Mesas {{$carrera->nombre}}
    </h2>
    <hr>
    @if(@session('message'))
    <div class="alert alert-success">
        {{@session('message')}}
    </div>
    @endif
    @if(@session('message_edit'))
    <div class="alert alert-primary">
        {{@session('message_edit')}}
    </div>
    @endif
    @if(@session('error_fecha'))
    <div class="alert alert-danger">
        {{@session('error_fecha')}}
    </div>
    @endif

    <a href="{{ route('mesa.tribunal',['id'=>$carrera->id,'instancia_id'=>$instancia->id]) }}" class="btn btn-sm btn-success mb-3">Descargar tribunal</a>

    @if($carrera->estado != 1)
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Primer Año</th>
                <th scope="col">Fecha Primer llamado</th>
                <th scope="col">Fecha Segundo llamado</th>
                <th scope="col"><i class="fa fa-cog" style="font-size:20px;"></i></th>
            </tr>
        </thead>
        <tbody>

            @foreach($carrera->materias as $materia)
            @if($materia->año == 1)
            @include('includes.mesas.table_materias')
            @endif
            @endforeach

        </tbody>
    </table>
    @endif
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Segundo Año</th>

                <th scope="col">Fecha Primer llamado</th>
                <th scope="col">Fecha Segundo llamado</th>

                <th scope="col"><i class="fa fa-cog" style="font-size:20px;"></i></th>
            </tr>
        </thead>
        <tbody>
            @foreach($carrera->materias as $materia)
            @if($materia->año == 2)
            @include('includes.mesas.table_materias')
            @endif
            @endforeach

        </tbody>
    </table>
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Tercer Año</th>

                <th scope="col">Fecha Primer llamado</th>
                <th scope="col">Fecha Segundo llamado</th>

                <th scope="col"><i class="fa fa-cog" style="font-size:20px;"></i></th>
            </tr>
        </thead>
        <tbody>
            @foreach($carrera->materias as $materia)
            @if($materia->año == 3)
            @include('includes.mesas.table_materias')
            @endif
            @endforeach

        </tbody>
    </table>
</div>
@endsection
@section('scripts')
<script src="{{ asset('vendors/select2/js/select2.full.min.js') }}"></script>

<script src="{{ asset('js/mesas/configuracion.js') }}"></script>
<script src="{{asset('vendors/select2/js/select2.min.js')}}"></script>
<script>
    $('.js-data-example-ajax').select2({

        ajax: {
            url: 'carrera/verProfesores/' + $(this).attr('id'),
            dataType: 'json'
            // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
        }
    });
</script>

@endsection