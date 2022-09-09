@extends('layouts.app-prueba')
@section('content')
    <style>
        .col-xl-3:hover img {
            -webkit-transform: scale(4) translateX(-40%);
            transform: scale(4) translate(-40%, -30%);
            transition: all .9s ease-in-out;
            z-index: 100 !important;
            position: relative;
        }

        img.img-fluid {
            z-index: 100 !important;
            background-color: #1a202c;
            position: relative;
        }

        .accordion-header, .accordion-button, .accordion-item {
            z-index: 1 !important;
            position: relative;

        }

        .col-xl-3 {
            overflow: visible;
        }
    </style>
    <section class="py-2">
        <div class="container px-5 my-2">
            <div class="text-center mb-5">
                <h1 class="fw-bolder">Agregar cargos desde un módulo</h1>
                <p class="lead fw-normal text-muted mb-0"> <b>Data</b> <i>IESVU</i></p>
            </div>

        </div>
    </section>
@endsection
