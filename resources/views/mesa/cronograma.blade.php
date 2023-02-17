@extends('layouts.app-prueba')
@section('content')
    <div class="container">
        <h4 class="text-info">
            Cronograma: {{$instancia_model->nombre}}
        </h4>
        <hr>
        @if(@session('message'))
            <div class="alert alert-success">
                {{@session('message')}}
            </div>
        @endif
        <div class="row text-center bg-info">

                <div class="col-sm-5">SEDE/UNIDAD ACADÉMICA</div>
                <div class="col-sm-5">CARRERA/RESOLUCIÓN</div>
                <div class="col">PDF</div>
        </div>

            <div class="row bg-info bg-opacity-25">
                @foreach($carreras as $carrera)

                    <div class="col-sm-5"><i>{{$carrera['sede']}}</i></div>
                    <div class="col-sm-5"><b>{{$carrera['nombre']}} - Res {{$carrera['resolucion']}}</b></div>
                    <div class="col">
                        <a href="{{ route('generar_pdf_mesa', ['instancia' => $instancia, 'carrera'=>$carrera->id, 'llamado' => 1]) }}"
                           class="btn btn-link" target="_blank">

                            <i>1° llamado</i>
                        </a>
                    </div>
                    <div class="col-sm-5"><i>{{$carrera['sede']}}</i></div>
                    <div class="col-sm-5"><b>{{$carrera['nombre']}} - Res {{$carrera['resolucion']}}</b></div>
                    <div class="col">

                        <a href="{{ route('generar_pdf_mesa', ['instancia' => $instancia, 'carrera'=>$carrera->id, 'llamado' => 2]) }}"
                           class="btn btn-link" target="_blank">
                            <i>2° llamado</i>
                        </a>
                    </div>

                @endforeach
            </div>
        </div>
@endsection
