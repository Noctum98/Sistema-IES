@extends('layouts.app-prueba')
@section('content')
    <div class="container">
        <h2 class="h1 text-info">
            Ficha de {{ $personal->nombres.' '.$personal->apellidos }}
        </h2>
        <hr>
        <div class="row">
            <div class="col-md-8">
                <div class="d-flex flex-column">
                    @include('includes.personal')
                    <div class="ml-3 col-md-5 row">
                        <a href="{{ route('personal.editar',['id'=>$personal->id]) }}" class="mr-2 btn-sm btn-warning">
                            Editar ficha
                        </a>
                        <a href="{{ route('descargar_ficha',['id'=>$personal->id]) }}" class="btn-sm btn-danger">
                        <i class="fas fa-download"></i> Descargar ficha
                        </a>
                    </div>

                </div>


            </div>
            <div class="col-md-4">
                <!--Modal Ver-->
                <button type="button" class="btn-sm btn-secondary" data-bs-toggle="modal"
                        data-bs-target="#modal-sede-{{$personal->id}}">
                    Agregar Sede
                </button>
                @include('personal.modals.ver_sedes')
            </div>
        </div>
    </div>
@endsection
