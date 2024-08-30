@extends('layouts.app-prueba')

@section('content')
    <x-style_libro_digital/>

    @if(Session::has('success_message'))
        <div class="alert alert-success alert-dismissible" role="alert">
            {!! session('success_message') !!}

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(Session::has('alert_message'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            {!! session('alert_message') !!}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card text-bg-theme">

        <div class="card-header d-flex justify-content-between align-items-center p-3">
            <h4 class="m-0">Libros Digitales</h4>
        </div>
        <div class="d-flex justify-content-center align-items-center p-3">
            <nav aria-label="navegación text-center">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        Seleccionar resolución
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        @foreach($resolutions as $resolution)
                            <li><a class="dropdown-item
                             @if($resolution->id == $resolution_id) active @endif
                             " href="{{ route('libros_digitales.libro_digital.index_carrera', ['sede' => $sede, 'resolution' => $resolution->id ]) }}">{{ $resolution->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </nav>
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
                                <div
                                    class="card-header bg-info text-dark d-flex justify-content-between align-items-center p-3 mt-3 my-2">
                                    <div class="col-sm-12 mx-1 px-5">
                                        <h4 class="card-title">
                                            Carrera: {{$libroDigital->resoluciones->name}}</h4>
                                        <h6 class="card-subtitle">
                                            Resolución N°: {{$libroDigital->resoluciones->resolution}}
                                        </h6>
                                    </div>
                                </div>

                            @endif

                            <div class="card col-sm-4 mx-auto border-2 border-primary border-left-0 shadow">
                                <div class="card-body d-flex">
                                    <div class="flex-grow-1 d-flex align-items-center justify-content-center"
                                         style="width: 30%;">
                                        <i class="fa fa-book fa-3x text-primary"></i>
                                    </div>

                                    <div style="width: 70%;">
                                        <h5 class="card-title">Libro {{$libroDigital->romanos}}
                                        </h5>
                                        <p class="card-text">

                                            <a href="{{ route('libros_digitales.libro_digital.showFolios', ['libroDigital' => $libroDigital->id]) }}"
                                               class="btn btn-primary">
                                                <i class="fas fa-eye me-2"></i> Ver folios
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @php
                                $anteriorResolucion = $libroDigital->resoluciones->id;
                            @endphp
                            @php
                                $anteriorSede = $libroDigital->sede->id;
                            @endphp
                            @endforeach
                        </div>

                    @endif
                <hr />
                    <div class="d-flex justify-content-center gutter mt-3" style="font-size: 0.8em">
                        {{ $librosDigitales->withQueryString()->links() }}
                    </div>

            </div>
@endsection

