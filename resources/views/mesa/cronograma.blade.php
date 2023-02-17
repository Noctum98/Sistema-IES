@extends('layouts.app-prueba')
@section('content')
    <div class="container">
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
                           class="btn">

                            <i>1° llamado</i> <br/>
{{--                            <small style="font-size: 0.6em">DESCARGAR PDF</small>--}}
                        </a>
                    </div>
                    <div class="col-sm-5"><i>{{$carrera['sede']}}</i></div>
                    <div class="col-sm-5"><b>{{$carrera['nombre']}} - Res {{$carrera['resolucion']}}</b></div>
                    <div class="col">

                        <a href="{{ route('generar_pdf_mesa', ['instancia' => $instancia, 'carrera'=>$carrera->id, 'llamado' => 2]) }}"
                           class="btn">
                            <i>2° llamado</i> <br/>
{{--                            <small style="font-size: 0.6em">DESCARGAR PDF</small>--}}
                        </a>
                    </div>

                @endforeach
            </div>
        </div>
    </div>
@endsection
