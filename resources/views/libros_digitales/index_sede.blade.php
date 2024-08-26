@extends('layouts.app-prueba')

@section('content')
    <style>

        .card {
            /*margin-top: 2em;*/
            padding: 0.5em;
            border-radius: 2em;
            /*text-align: center;*/
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        }

        .card .card-header {

            padding: 0.5em;
            border-top-left-radius: 2em;
            border-top-right-radius: 2em;
            /*text-align: center;*/
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        }


        .card li {
            list-style: none;
        }

        .card_img {
            /*width: 65%;*/
            /*border-radius: 50%;*/
            border-radius: 2em;
            margin: 0 auto 0 -50px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            background: #1a1e21;
            color: white;
            font-size: 6em;
            font-weight: bold;
        }

        .card .card-title {
            font-weight: 700;
            font-size: 1.5em;
        }

        /*.card .btn {*/
        /*    border-radius: 2em;*/
        /*    background-color: teal;*/
        /*    color: #ffffff;*/
        /*    padding: 0.5em 1.5em;*/
        /*}*/

        .card .btn:hover {
            background-color: rgba(0, 128, 128, 0.7);
            color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
        .page-item {
            padding-left: 15px;
            padding-right: 15px;
            box-sizing: border-box;
        }

    </style>

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
        <div class="d-flex col-sm-12 justify-content-center align-items-center p-3">
            <nav aria-label="navigation text-center">
                <ul class="pagination">
                    @foreach($sedes as $sede)
                        <li class="page-item rounded {{ $sede === $sede_id ? 'active' : '' }} px-2">
                            <a class="page-link"
                               href="{{ route('libros_digitales.libro_digital.index_sede', ['sede_id' => $sede]) }}">
                                {{ $sede }}
                            </a>
                        </li>
                    @endforeach
                </ul>
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

                                            <a href="{{ route('libros_digitales.libro_digital.show', ['libroDigital' => $libroDigital->id]) }}"
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

