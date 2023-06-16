@extends('layouts.app-prueba')
@section('content')
    <div class="container">
        <div class="row d-flex justify-content-between">
            <div class="col-md-4 ">
                <a href="{{url()->previous()}}">
                    <button class="btn btn-sm btn-outline-info mb-2"><i class="fas fa-angle-left"></i> Volver</button>
                </a>
            </div>
            <div class="col-md-4 ">
                <form method="GET" action="{{ route('trianual.listar') }}"
                      id="buscador-alumnos-trianual">
                    <div class="form-inline">
                        <div class="input-group">
                            <label for="busqueda"></label>
                            <input type="text" id="busqueda" name="busqueda" class="form-control"
                                   placeholder="Buscar alumno" aria-describedby="inputGroupPrepend2"
                                   value="{{ $busqueda && $busqueda != 1 ?$busqueda: '' }}">

                            <button class="input-group-text" id="inputGroupPrepend2" type="submit">
                                <i class="fa fa-search text-info"></i>
                            </button>
                        </div>
                    </div>
                    {{--                    @include('alumno.modals.filtros_equivalencias')--}}

                </form>
            </div>
        </div>
        <div class="col-8 mx-auto text-center">
            <h1 class="text-dark">
                <i>Trianual <span id="datos-trianual">{{ucfirst($busqueda)}}</span></i>
            </h1>
        </div>

        <hr>


        @if(@session('error_trianual'))
            {{ @session('error_trianual') }}
        @endif
        <div class="col-md-10">

            @if($alumnos)
                @foreach($alumnos as $alumno)
                    <div class="row border-bottom pb-2">
                        <div class="col-5">
                            {{$alumno->getApellidosNombresAttribute()}}
                            <small class="ml-5">D.N.I.:{{$alumno->dni}}</small>
                            <small class="ml-5">Cohorte:{{$alumno->cohorte}}</small>
                        </div>
                        <div class="col-6">
                            @if(Session::has('admin') || Session::has('coordinador') || Session::has('seccionAlumnos'))
                                <a
                                   class="btn btn-sm btn-primary agregarButton"
                                   data-bs-toggle="modal"
                                   data-bs-target="#agregarModal"
                                   data-loader="{{$alumno->id}}"
                                   data-attr="{{ route('trianual.crear', ['alumno'=>$alumno->id]) }}">
                                    <i class="fas fa-plus-square text-gray-300"></i>
                                    <i class="fa fa-spinner fa-spin" style="display: none"
                                       id="loader{{$alumno->id}}"></i>

                                    Cargar trianual
                                </a>
                            @endif
                            @if(!$alumno->cohorte)
                                <a href="{{ route('alumno.admin',['busqueda' => $alumno->dni]) }}"
                                   class="btn btn-sm btn-warning" title="Completar desde aquí">
                                    <small>Los datos del alumno están incompletos</small>
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12">
                    No se encontraron alumnos con los datos solicitados: {{$busqueda}}
                </div>
            @endif
        </div>
        <a href="{{url()->previous()}}">
            <button class="btn btn-outline-info mb-2"><i class="fas fa-angle-left"></i> Volver</button>
        </a>
    </div>
    @include('trianual.trianual.components.form_modal_trianual')

@endsection
@section('scripts')
    <script>

        $(document).on('click', '.agregarButton', function (event) {
            event.preventDefault();
            let href = $(this).attr('data-attr');
            let referencia = $(this).attr('data-loader');
            const $laoder = $('#loader' + referencia);

            $.ajax({
                url: href,
                beforeSend: function () {
                    $laoder.show();
                },
                // return the result
                success: function (result) {
                    $('#agregaModal').modal("show");
                    $('#agregarBody').html(result).show();
                },
                complete: function () {
                    $laoder.hide();
                },
                error: function (jqXHR, testStatus, error) {
                    console.log(error);

                    $laoder.hide();
                },
                timeout: 2000
            })
        });
    </script>
@endsection
