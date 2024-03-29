@extends('layouts.app-prueba')
@section('content')
    <div class="container p-3">
        <a href="{{route('carrera.admin')}}">
            <button class="btn btn-outline-info mb-2"><i class="fas fa-angle-left"></i> Ir Carrera</button>
        </a>
        <a href="{{url()->previous()}}">
            <button class="btn btn-outline-info mb-2"><i class="fas fa-angle-left"></i> Volver</button>
        </a>
        <h4 class="text-info">
            Detalle de {{ $modulo->nombre }}
            <small>
                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#agregarCargo">
                    Agregar cargo
                </button>
            </small>
        </h4>
        @include('modulos.modals.agregar_cargo')
        <div class="row">
        <h5 class="col-sm-4">

            Ponderación total: <span class="
				@if($modulo->totalModulo() === 100)
				text-success
				@else
				text-warning
					@endif
					"
                                     id="cargo-u-materia-{{$modulo->id}}">{{$modulo->totalModulo()}} %</span>

        </h5>
        <small class="col-sm-8">Tenga en cuenta que solo un cargo puede ser marcado para la carga de la nota del TFI</small>
        </div>
        <hr/>

        {{--	Crear la lógica de esta acción separando el concepto de materia de modulo - cargo --}}
        {{--	@if(Session::has('admin') || Session::has('coordinador') || Session::has('seccionAlumnos'))--}}
        {{--	<a href="{{ route('modulos.agregarCargo',['modulo'=>$modulo->id]) }}" class="btn btn-success mb-4">--}}
        {{--		Agregar cargo--}}
        {{--	</a>--}}
        {{--	@endif--}}

        @if(@session('error_modulos'))
            {{ @session('error_modulos') }}
        @endif
        <div class="col-md-12">

            <table class="table table-hover">
                <thead class="thead-dark">
                <tr>
                    <th scope="col" class="col-sm-1">
                    @if(Auth::user()->hasRole('admin'))
                            <small>#</small>
                    @endif
                    </th>
                    <th scope="col" class="col-sm-4">Cargo</th>
                    <th scope="col" class="col-sm-2">Ponderación</th>
                    <th scope="col" class="col-sm-2">
                        <small>TFI Responsable</small>


                </th>

                <th colspan="2" scope="col" class="col-sm-3">Profesor</th>
                {{--                    <th scope="col" class="text-center"><i class="fa fa-cog" style="font-size:20px;"></i>--}}
                {{--                    </th>--}}

                </tr>
                </thead>
                <tbody>
                @foreach($modulo->cargos as $cargo)

                    <tr>
                        <td>
                        @if(Auth::user()->hasRole('admin'))
                            {{$cargo->id}}
                        @endif
                        </td>
                        <td>
                            <small>
                                <a href="{{ route('cargo.show',$cargo->id) }}"
                                   class="btn btn-sm btn-primary block-inline ">Configurar cargo</a>
                                {{ $cargo->nombre }}
                            </small>
                        </td>
                        <td>
                            <i class="fa fa-spinner fa-spin" style="display: none"
                               id="loader-cargo-{{$cargo->id}}-materia-{{$modulo->id}}"></i>

                            {{--						{{$cargo->ponderacion($modulo->id)}}--}}
                            @if(!$cargo->ponderacion($modulo->id) or Auth::user()->hasRole('admin'))

                                <form action="" id="pondera-cargo-materia" class="pondera-cargo">
                                    <div class="input-group">
                                        <input type="number" class="form-control ponderacion_cargo_materia col-sm-6
{{--                        @if($proceso->cierre || !$proceso->estado_id) disabled @endif--}}
                        "
                                               id="ponderacion" value="{{$cargo->ponderacion($modulo->id)??'0' }}"/>
                                        <input type="hidden" id="cargo" value="{{$cargo->id}}"/>
                                        <input type="hidden" id="materia" value="{{$modulo->id}}"/>
                                        <button type="submit" class="btn btn-info btn-sm input-group-text
                        @if(!Session::has('coordinador') && !Session::has('admin') ) disabled @endif
                        ">
                                            <i class="fa fa-save"></i></button>
                                    </div>
                                </form>
                            @else
                                {{$cargo->ponderacion($modulo->id)}}
                            @endif

                        </td>
                        <td class="text-center">
                            <i class="fa fa-spinner fa-spin" style="display: none"
                               id="loader-tfi-{{$cargo->relacionCargoModulo($modulo->id)->id}}"></i>
                            <select class="selection-tfi change-state" name="icon"
                                    id="{{$cargo->relacionCargoModulo($modulo->id)->id}}"
                                    data-loader="{{$cargo->relacionCargoModulo($modulo->id)->id}}"
                                    @if($cargo->relacionCargoModulo($modulo->id)->carga_tfi !== 1 and $tieneTfi ==1)
                                        disabled = "disabled"
                                @endif
                            >
                                <option value="1" data-icon="fa-check" data-state="text-success"
                                        @if ($cargo->relacionCargoModulo($modulo->id)->carga_tfi === 1) selected @endif ></option>
                                <option value="0" data-icon="fa-times" data-state="text-danger"
                                        @if ($cargo->relacionCargoModulo($modulo->id)->carga_tfi !== 1 ) selected @endif></option>
                            </select>


                            {{--                            <i class="{{$cargo->carga_tfi?'fas fa-check text-success':'fas fa-times text-danger'}}"></i>--}}
                        </td>
                        <td>
                            @foreach ($cargo->users as $usuario)
                                {{ $usuario->nombre.' '.$usuario->apellido }}<br/>
                            @endforeach
                        </td>

                    </tr>

                @endforeach
                </tbody>
            </table>

        </div>
        <a href="{{url()->previous()}}">
            <button class="btn btn-outline-info mb-2"><i class="fas fa-angle-left"></i> Volver</button>
        </a>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/cargos/pondera.js') }}"></script>
    <script src="{{ asset('vendors/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            function formatText(icon) {
                return $('<span><i class="fas ' + $(icon.element).data('icon') + ' ' + $(icon.element).data('state') + '"></i> ' + icon.text + '</span>');
            }

            $('.selection-tfi').select2({
                width: "100%",
                templateSelection: formatText,
                templateResult: formatText
            });

        });

        $(document).on('click', '#formAgregar', function (event) {
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
                    $('#agregarCargoModulo').modal("show");
                    $('#agregarCargoModuloBody').html(result).show();
                },
                complete: function () {
                    $laoder.hide();
                },
                error: function (jqXHR, testStatus, error) {
                    console.log(error);

                    $laoder.hide();
                },
                timeout: 8000
            })
        });

        $(document).on('change', '.change-state', function (event) {
            event.preventDefault();
            let cargo_modulo = $(this);
            let url = '/asignaRelacionCargoModulo';
            let data = {
                "cargo_modulo_id": cargo_modulo.attr('id'),
                "valor": cargo_modulo.val(),
            };
            let referencia = $(this).attr('data-loader');
            const $laoder = $('#loader-tfi-' + referencia);
            $.ajax({
                method: "POST",
                url: url,
                data: data,
                // return the result
                beforeSend: function () {
                    $laoder.show();
                },
                success: function (result) {
                    // $('#agregarCargoModulo').modal("show");
                    // $('#agregarCargoModuloBody').html(result).show();
                    if (result.tieneTfi === false) {
                        document.querySelectorAll(".selection-tfi").forEach(b => b.removeAttribute('disabled'));
                    } else {
                        document.querySelectorAll(".selection-tfi").forEach(b => {
                                if (b.value === '0') {
                                    b.setAttribute('disabled', 'disabled')
                                } else {
                                    b.removeAttribute('disabled')
                                }
                            }
                        )
                    }
                },
                complete: function () {
                    $laoder.hide();
                },
                error: function (jqXHR, testStatus, error) {
                    console.log(error);

                    $laoder.hide();
                },
                timeout: 8000
            })
        });
    </script>
@endsection
