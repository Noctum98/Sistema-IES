@extends('layouts.app')

@section('content')

    @if(Session::has('success_message'))
        <div class="alert alert-success alert-dismissible" role="alert">
            {!! session('success_message') !!}

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card text-bg-theme">

        <div class="card-header d-flex justify-content-between align-items-center p-3">
            <h4 class="m-0">Libros Digitales</h4>
        </div>

        @if(count($librosDigitales) === 0)
            <div class="card-body text-center">
                <h4>No se encontraron libros digitales.</h4>
            </div>
        @else
            <div class="col-sm-12">
                @php
                    $anteriorResolucion = '';
                    $anteriorSede = '';
                @endphp

                @foreach($librosDigitales as $libroDigital)
                    @if($anteriorSede !== $libroDigital->sede->id)
                        <hr>
                        <div class="col-sm-12">
                            <div class="card-header d-flex justify-content-between align-items-center mx-0 my-2">
{{--                                <div class="col-sm-12">--}}
                                    <h4 class="card-title">Sede: {{$libroDigital->sede->nombre}}</h4>
{{--                                </div>--}}
                            </div>
                        </div>
                        <div class="row">
                    @endif
                    @if($anteriorResolucion !== $libroDigital->resoluciones->id)
                                <hr>

                            <div class="card-header bg-primary d-flex justify-content-between align-items-center p-3 my-2">
                                <div class="col-sm-12 mx-1 px-5">
                                    <h4 class="card-title">
                                        Carrera: {{$libroDigital->resoluciones->name}}</h4>
                                    <h6 class="card-subtitle">
                                         Resolución N°: {{$libroDigital->resoluciones->resolution}}
                                    </h6>
                                </div>
                            </div>

                                @endif

                                <div class="card col-sm-3 mx-auto my-2">
                                    <div class="card-header">
                                        <h2 class="card-title"><i
                                                class="fas fa-book me-2"></i>Libro {{$libroDigital->romanos}}
                                        </h2>


                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">

                                            <a href="{{ route('libros_digitales.libro_digital.show', ['libroDigital' => $libroDigital->id]) }}"
                                               class="btn btn-primary">
                                                <i class="fas fa-eye me-2"></i> Ver folios
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                @if($anteriorResolucion !== $libroDigital->resoluciones->name)



                    @endif
        @php
            $anteriorResolucion = $libroDigital->resoluciones->id;
        @endphp
        @php
            $anteriorSede = $libroDigital->sede->id;
        @endphp
        @endforeach
    </div>



    @endif

    </div>
@endsection

