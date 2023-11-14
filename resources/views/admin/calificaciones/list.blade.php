@extends('layouts.app-prueba')
@section('content')
    <div class="container">
        <h4 class="text-dark">
            Seleccionar carrera para ver calificaciones
        </h4>
        <hr>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach($carreras as $carrera)

                <div class="col">
                    <div class="card h-100">

                        <div class="card-body">
                            <h5 class="card-title">#{{ $carrera->id}} - {{$carrera->nombre }}</h5>
                            <p class="card-text">
                                @if($carrera->estado == 1)
                                    <span class="text-danger font-weight-bold">En cierre</span>
                                @elseif($carrera->estado == 0)
                                    <span class="text-success font-weight-bold">En curso</span>
                                @elseif($carrera->estado == 2)
                                    <span class="text-primary font-weight-bold">En Apertura</span>
                                @endif
                                Res. N°.: {{ $carrera->resolucion }}
                            </p>
                        </div>
                        <div class="card-footer">
                            <small>{{ $carrera->sede->nombre }}</small><br/>
                            <a href="#" class="btn btn-primary">Acceder a notas</a>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>


    </div>
@endsection
