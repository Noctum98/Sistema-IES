@extends('layouts.app')

@section('content')

    <div class="card text-bg-theme">

        <div class="card-header d-flex justify-content-between align-items-center p-3">
            <h4 class="m-0">{{ isset($title) ? $title : 'Nota' }}</h4>
            <div>

            </div>
        </div>

        <div class="card-body">
            <div class="card-body row">
                <h5 class="card-text col-sm-2 ml-5 pl-5">
                    Aprobados: <br/>
                    Desaprobados: <br/>
                    Ausentes: <br/>
                    Turno:
                </h5>
                <h5 class="card-text col-sm-2 ml-5 text-end pr-5 mx-5">
                    {{ $folio->aprobados }} <br/>
                    {{ $folio->desaprobados }}<br/>
                    {{ $folio->ausentes }}<br/>
                    {{ $folio->turno??'-' }}
                </h5>

                <h6 class="card-text col-sm-4 ml-5">
                    Coordinador: <i
                        class="text-primary">{{ optional($folio->coordinador)->getApellidoNombre()??'-' }} </i><br>
                    Operador: <i
                        class="text-primary">{{ optional($folio->operador)->getApellidoNombre()??'-' }}</i>
                    <br>
                    Presidente: <i
                        class="text-primary">{{ optional($folio->presidente)->getApellidoNombre() }}</i>
                    <br>
                    Vocal 1: <i
                        class="text-primary">{{ optional($folio->vocal1)->getApellidoNombre() ??  $folio->vocal_id }} </i><br>
                    Vocal 2: <i
                        class="text-primary">{{ optional($folio->vocal2)->getApellidoNombre() ??  $folio->vocal_2_id }} </i><br>
                </h6>

            </div>
            <div class="card-footer text-left container">
                @foreach($folio->folioNotas()->get() as $folioNota)
                    <div
                        class="row col-sm-12 border border-dark border-1 border-top-0 hover-effect zoom-effect">
                            <span class="col-sm-1">
                                {{$folioNota->orden}}
                            </span>
                        <span class="col-sm-5">
                                {{$folioNota->alumno->getApellidosNombresAttribute()}}
                                    <span style="font-size: 0.75em">
                                        {{$folioNota->alumno->dni}}
                                    </span>
                            </span>
                        <span class="col-sm-2">
                                Escrito: {{$folioNota->escrito === -1 ? 'A' :  $folioNota->escrito??'-'}}
                            </span>
                        <span class="col-sm-2">
                                Oral: {{ $folioNota->oral === -1 ? 'A' : ($folioNota->oral ?? '-') }}
                            </span>
                        <span class="col-sm-2">
                                Definitiva: {{$folioNota->definitiva === -1 ? 'A' : ($folioNota->definitiva ?? '-') }}
                            </span>
                    </div>

                @endforeach
            </div>
            <a href="{{ route('admin.tools.libros_sin_actas_volantes') }}" class="btn btn-primary">
                Ver libros sin cargar
            </a>
        </div>
    </div>

@endsection
