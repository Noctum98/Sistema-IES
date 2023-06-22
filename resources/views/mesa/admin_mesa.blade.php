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
    <h3 class="text-info">
        Mesas {{$carrera->nombre}}
    </h3>
    <p class="text-info"><i>{{ $instancia->nombre }}</i></p>
    <hr>

    @if($instancia->segundo_llamado)
    <a href="{{ route('generar_pdf_mesa',['instancia'=>$instancia->id,'carrera'=>$carrera->id,'llamado'=>1]) }}" class="btn btn-sm btn-danger mb-3">PDF 1er Llamado</a>
    <a href="{{ route('generar_pdf_mesa',['instancia'=>$instancia->id,'carrera'=>$carrera->id,'llamado'=>2]) }}" class="btn btn-sm btn-danger mb-3">PDF 2do Llamado</a>
    @else
    <a href="{{ route('generar_pdf_mesa',['instancia'=>$instancia->id,'carrera'=>$carrera->id,'llamado'=>1]) }}" class="btn btn-sm btn-danger mb-3">Descargar PDF</a>
    @endif

    @if($carrera->estado != 1)
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Primer Año</th>
                @if($instancia->segundo_llamado)
                <th scope="col">Fecha Primer llamado</th>
                <th scope="col">Fecha Segundo llamado</th>
                @else
                <th scope="col">Fecha</th>
                @endif
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

                @if($instancia->segundo_llamado)
                <th scope="col">Fecha Primer llamado</th>
                <th scope="col">Fecha Segundo llamado</th>
                @else
                <th scope="col">Fecha</th>
                @endif

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

                @if($instancia->segundo_llamado)
                <th scope="col">Fecha Primer llamado</th>
                <th scope="col">Fecha Segundo llamado</th>
                @else
                <th scope="col">Fecha</th>
                @endif

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