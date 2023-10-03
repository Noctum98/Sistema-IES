@extends('layouts.app-prueba')
@section('content')
    <div class="col-md-12 d-flex flex-column align-items-center mt-4">
        <div class="col-md-7">
            <div class="card">
                @if(!isset($delete) && isset($preinscripcion))
                    <h5 class="card-header text-secondary">
                        Preinscripción {{ $preinscripcion->nombres.' '.$preinscripcion->apellidos }}</h5>
                @elseif(isset($carrera) && (isset($edit) && !$edit) )
                    <h5 class="card-header text-secondary">Preinscripción enviada</h5>

                @else
                    <h5 class="card-header text-secondary">Baja de preinscripción</h5>
                @endif
                <div class="card-body p-4">
                    @if(!isset($delete))
                        <h5 class="card-title {{$edit ? 'text-primary' : 'text-success'}}">
                            {{$title}}
                        </h5>
                    @else
                        <h5 class="card-title text-danger">
                            {{$title}}
                        </h5>
                    @endif
                    <p class="card-text">
                        {{$content}}
                    </p>
                    @if(isset($edit) && $edit)
                        <a href="{{route('pre.editar',['timecheck'=>$preinscripcion->timecheck,'id'=>$preinscripcion->id])}}"
                           class="btn btn-secondary">Editar formulario</a>
                    @endif
                    <a href="https://iesvu.edu.ar/" class="btn btn-primary">Volver a Página principal</a>
                </div>
            </div>
        </div>

    </div>

@endsection
