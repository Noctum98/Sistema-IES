@extends('layouts.app')

@section('content')
    <x-style_libro_digital/>
    <style>

        .select2 .select2-selection {
            padding: 6px 12px; /* Ajusta estos valores como sea necesario */
            height: 38px; /* Asegúrate de que esto coincide con la altura de tus otros campos de entrada */
        }
    </style>
    @if(Session::has('success_message'))
        <div class="alert alert-success alert-dismissible" role="alert">
            {!! session('success_message') !!}

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="card text-bg-theme">
        <div class="card-header d-flex justify-content-between align-items-center p-3 row  alert alert-info m-0">

            <div class="col-sm-2 text-center">
                <h4
                    data-bs-toggle="tooltip" data-bs-placement="top"
                    title="Libro {{$libroDigital->romanos??'Libro Digital'}}"
                >
                    <small> <i class="fa fa-book"></i> </small> <i>{{ $libroDigital->romanos ?? 'Libro Digital' }}</i>
                </h4>
            </div>
            <div class="col-sm-6 text-center">
                <a href="{{ route('libros_digitales.libro_digital.index_carrera',
                    ['sede' => $libroDigital->sede->id, 'resolution' => $libroDigital->resoluciones->id]) }}"
                   data-bs-toggle="tooltip" data-bs-placement="top"
                   title="Clic para ver todos los libros de la sede {{$libroDigital->resoluciones->name??'Resolució́n'}}"
                >
                    <small style="font-size: 0.75em"><i class="fas fa-book-open"></i> </small>
                    <i>{{$libroDigital->resoluciones->name??''}}</i>

                </a><br/>
                <small style="font-size: 0.75em"> {{$libroDigital->resoluciones->resolution}}</small>
            </div>
            <div class="col-sm-4 text-center">

                <a href="{{ route('libros_digitales.libro_digital.index_sede', ['sede_id' => $libroDigital->sede->nombre]) }}"
                   data-bs-toggle="tooltip"
                   data-bs-placement="top"
                   title="Clic para ver todos los libros de la sede {{$libroDigital->sede->nombre??'Sede'}}"
                >
                    <small><i class="fas fa-building"></i></small>
                    <i>{{$libroDigital->sede->nombre??'Sede'}}</i>
                </a>
            </div>

        </div>
        @forelse($folios as $folio)
            <div id="addFolioNotaForm" style="display: none;" class="row">
                <form method="POST" class="col-sm-12 mb-3">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-sm-2">
                            <label for="orden">Orden:</label>
                            <input type="number" class="form-control" id="orden" name="orden" required>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="alumno">Alumno:</label><br/>
                            <select class="form-control select2" id="alumno" name="alumno" required>
                                <!-- Aquí puedes iterar sobre un conjunto de alumnos -->
                                <!-- <option value="id_del_alumno">Nombre del alumno</option> -->
                            </select>
                        </div>
                        <div class="form-group col-sm-2">
                            <label for="escrito">Escrito:</label>
                            <input type="number" class="form-control" id="escrito" name="escrito" required>
                        </div>
                        <div class="form-group col-sm-2">
                            <label for="oral">Oral:</label>
                            <input type="number" class="form-control" id="oral" name="oral" required>
                        </div>
                        <div class="form-group col-sm-2">
                            <label for="definitiva">Definitiva:</label>
                            <input type="number" class="form-control" id="definitiva" name="definitiva" required>
                        </div>
                    </div>
                    <input type="hidden" id="folioId" name="folioId" value="{{ $folio->id }}">
                    <button id="submitFolioNota" type="button" class="btn btn-primary mt-3">Guardar</button>
                </form>
            </div>
            <div class="card-body col-sm-12">

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center   ">
                        <h5 class="card-title alert alert-primary mx-auto">
                            Folio {{ $folio->folio }}
                            <i class="fas fa-calendar-alt ms-4"></i> {{ date_format(new DateTime($folio->fecha ), 'd-m-Y') }}
                            @if(session()->has('admin'))
                                <small style="font-size: 0.50em">
                                    <sub>{{ $folio->mesa_id }}</sub>
                                </small>
                            @endif

                            <i class="far fa-bookmark ms-4"></i> {{ $folio->masterMateria->name }}
                            <small style="font-size: 0.75em"><sup>{{ $folio->masterMateria->year }}° año</sup></small>

                            <span class="info" data-bs-toggle="tooltip"
                                  data-bs-placement="top"
                                  title="{{ $folio->llamado }}° Llamado">
                            <i class="fas fa-user-clock ms-4"></i> {{ $folio->llamado }}
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
                        <h6 class="card-text col-sm-2 ml-5">
                            <button id="showAddFolioNota" type="button" class="btn btn-primary">
                                Agregar Alumno
                            </button>
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
                                    {{$folioNota->alumno()->withTrashed()->first()->getApellidosNombresAttribute()}}
                                    <span style="font-size: 0.75em">
                                        {{$folioNota->alumno()->withTrashed()->first()->dni}}
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

    <!-- Modal para agregar folioNota -->

@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            $('.select2').select2({
                width: '100%',
                theme: "classic",
                minimumInputLength: 4,  // Se realizará una búsqueda AJAX después de que el usuario haya escrito 4 caracteres
                ajax: {
                    data: function (params) {
                        return {
                            q: params.term, // Valor ingresado en el campo de selección
                            libroId: '{{ $libroDigital->id }}'
                        };
                    },
                    url: '/alumnos/searchAlumnos/documento',
                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {
                        return {
                            results: data.results
                        };
                    },
                    cache: false
                }

            });

            $('#showAddFolioNota').click(function () {
                $('#addFolioNotaForm').show();  // Muestra el formulario
            });

            $('#submitFolioNota').click(function (e) {
                e.preventDefault();
                console.log('click');

                // Recuperar datos del formulario
                var data = {
                    // Asegúrate de cambiar esto para que coincida con tus campos de formulario
                    // Ejemplo: 'campo': $('#id_del_campo').val()
                };

                $.ajax({
                    type: 'POST',
                    url: '/folio_notas',  // Asegúrate de cambiar esto a tu ruta de Laravel
                    data: data,
                    success: function (response) {
                        // Manejar respuesta aquí. Puedes actualizar la vista sin recargar la página.
                        $('#addFolioNotaForm').hide();  // Oculta el formulario
                    },
                    error: function (error) {
                        // Manejar error aquí. Podría ser útil mostrar un mensaje de error.
                    }
                });
            });
        });
    </script>
@endsection
