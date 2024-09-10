@extends('layouts.app')

@section('content')
    <x-style_libro_digital/>
    <div class="card text-bg-theme">
        <div class="card-header d-flex justify-content-between align-items-center p-3">
            <h4 class="m-0 alert alert-info mx-auto">
                <small> <i class="fa fa-book"></i> </small> <i>{{ $libroDigital->romanos ?? 'Libro Digital' }}</i>
                -
                <a href="{{ route('libros_digitales.libro_digital.index_carrera',
                    ['sede' => $libroDigital->sede->id, 'resolution' => $libroDigital->resoluciones->id]) }}"
                   class="alert alert-info" data-bs-toggle="tooltip" data-bs-placement="top"
                   title="Clic para ver todos los libros de la sede {{$libroDigital->resoluciones->name??'Resolució́n'}}"
                >
                    <small><i class="fas fa-book-open"></i> </small> <i>{{$libroDigital->resoluciones->name??''}}</i>
                </a>

                -
                <a href="{{ route('libros_digitales.libro_digital.index_sede', ['sede_id' => $libroDigital->sede->nombre]) }}"
                   class="alert alert-info"
                   data-bs-toggle="tooltip"
                   data-bs-placement="top"
                   title="Clic para ver todos los libros de la sede {{$libroDigital->sede->nombre??'Sede'}}"
                >
                    <small><i class="fas fa-building"></i></small>
                    <i>{{$libroDigital->sede->nombre??'Sede'}}</i>
                </a>
            </h4>
        </div>
        @forelse($folios as $folio)
            <div class="card-body col-sm-12">

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center   ">
                        <h5 class="card-title alert alert-primary mx-auto">
                            Folio {{ $folio->folio }}
                            <i class="fas fa-calendar-alt ms-5"></i> {{ date_format(new DateTime($folio->fecha ), 'd-m-Y') }}
                            <i class="far fa-bookmark ms-5"></i> {{ $folio->masterMateria->name }}
                            <span class="info" data-bs-toggle="tooltip"
                                  data-bs-placement="top"
                                  title="{{ $folio->llamado }}° Llamado">
                            <i class="fas fa-user-clock ms-5"></i> {{ $folio->llamado }}
                            </span>
                            @if($folio->mesa && $folio->llamado && $folio->folio)
                                <a href="{{route('mostrar_pdf_acta_volante',
['mesa' => $folio->mesa_id, 'llamado'=>$folio->llamado, 'folio' => $folio->folio])}}"
                                   target="_blank" class="btn btn-sm btn-primary">
                                    <i class="fas fa-file-pdf"></i> Ver acta volante
                                </a>
                            @endif

                        </h5>
                        <span class="ms-4">
                <a href="{{ route('mesa_folios.mesa_folio.create_by_libro_from_libro', ['libroDigital'=>$libroDigital->id] ) }}"
                   class="btn btn-primary" title="Agregar folio"
                   data-bs-toggle="tooltip" data-bs-placement="top"
                >
                    <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span>
                    Agregar folio
                </a>
                </span>
                    </div>
                    <div class="card-body row">
                        <h5 class="card-text col-sm-3 ml-5 pl-5">
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

                        <h6 class="card-text col-sm-5 ml-5">
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
                </div>

            </div>
        @empty
            <div class="card-body col-sm-12 d-flex justify-content-end align-items-center">
                <span class="ms-4">
                <a href="{{ route('mesa_folios.mesa_folio.create_by_libro', $libroDigital->id ) }}"
                   class="btn btn-primary" title="Agregar folio"
                   data-bs-toggle="tooltip" data-bs-placement="top"
                >
                    <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span>
                    Agregar folio
                </a>
                </span>
            </div>
        @endforelse


        <div class="d-flex justify-content-center gutter mt-3" style="font-size: 0.8em">
            {{ $folios->withQueryString()->links() }}
        </div>
    </div>

@endsection
