@extends('layouts.app-prueba')
@section('content')
    <div class="container">

        @if($mesa)
            <a href="{{ route('mesa.mesas',['id'=>$mesa->materia->carrera->id,'instancia_id'=>$instancia->id]) }}">
                <button class="btn btn-outline-info mb-2">
                    <i class="fas fa-angle-left"></i>
                    Volver
                </button>
            </a>
            <h2 class="h1 text-info">
                Inscripciones en {{$mesa->materia->nombre}}
            </h2>
            <hr>
            @if(@session('baja_exitosa'))
                <div class="alert alert-warning">
                    {{@session('baja_exitosa')}}
                </div>
            @endif
            @if(@session('alumno_success'))
                <div class="alert alert-success">
                    {{@session('alumno_success')}}
                </div>
            @endif
            @if(@session('alumno_error'))
                <div class="alert alert-danger">
                    {{@session('alumno_error')}}
                </div>
            @endif

            <div class="mb-3">
                <button class="btn btn-sm btn-primary " data-bs-toggle="modal" data-bs-target="#inscribirAlumno">
                    Inscribir alumno
                </button>
                @include('mesa.modals.inscribir_alumno')

                @if($mesa)
                    <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#libro_folio_1">
                        Libro/Folio
                    </button>
                    <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#libro_folio_2">
                        Libro/Folio 2do Llamado
                    </button>

                    @include('mesa.modals.libro_folio_2',['llamado'=>1])
                    @include('mesa.modals.libro_folio_1',['llamado'=>2])

                    <a href="{{ route('generar_pdf_acta_volante', ['instancia' => $mesa->instancia_id, 'carrera'=>$mesa->materia->carrera_id,'materia' => $mesa->materia_id ,'llamado' => 1, 'comision' => $mesa->comision_id ?? null]) }}"
                       class="btn btn-sm btn-success">
                        <i>1° llamado</i>
                        <small style="font-size: 0.6em">Descargar Acta Volante</small>
                    </a>
                    <a href="{{ route('generar_pdf_acta_volante', ['instancia' => $mesa->instancia_id, 'carrera'=>$mesa->materia($mesa->materia_id)->first()->carrera()->first()->id,'materia' => $mesa->materia_id ,'llamado' => 2, 'comision' => optional($mesa->comision()->first())->id]) }}"
                       class="btn btn-sm btn-success">
                        <i>2° llamado</i>
                        <small style="font-size: 0.6em">Descargar Acta Volante</small>
                    </a>

                    @if($mesa->cierre_profesor)
                    <form action="{{route('mesa.abrir_acta',['mesa_id'=>$mesa->id])}}" method="POST" class="mt-2">
                    {{method_field('PUT')}}
                    <input type="hidden" name="llamado" value="1" id="llamado">
                    <input type="submit" value="Abrir 1er llamado" class="btn btn-sm btn-warning">
                    @endif

                    @if($mesa->cierre_profesor_segundo)
                    <form action="{{route('mesa.abrir_acta',['mesa_id'=>$mesa->id])}}" method="POST" class="mt-2">
                    {{method_field('PUT')}}
                    <input type="hidden" name="llamado" value="2" id="llamado">
                    <input type="submit" value="Abrir 2do llamado" class="btn btn-sm btn-warning">
                </form>
                @endif
                @endif
            </div>


            <h2 class="text-info">Primer llamado</h2>
            @if( count($primer_llamado) > 0)
                <table class="table mt-4">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellido</th>
                        <th scope="col">D.N.I</th>
                        <th scope="col">Teléfono</th>
                        <th scope="col"><i class="fa fa-cog" style="font-size:20px;"></i></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($primer_llamado as $inscripcion)
                        <tr style="cursor:pointer;">
                            <td>{{ $inscripcion->alumno ? $inscripcion->alumno->nombres : $inscripcion->nombres }}</td>
                            <td>{{ $inscripcion->alumno ? $inscripcion->alumno->apellidos : $inscripcion->apellidos }}</td>
                            <td>{{ $inscripcion->alumno ? $inscripcion->alumno->dni : $inscripcion->dni }}</td>
                            <td>{{ $inscripcion->alumno ? $inscripcion->alumno->telefono : $inscripcion->telefono }}</td>

                            <td>
                                @include('mesa.modals.dar_baja_mesa')
                                @include('mesa.modals.mover')

                                <a class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                   data-bs-target="#baja{{$inscripcion->id}}">
                                   <i class="fas fa-chevron-circle-down"></i> Dar baja
                                </a>
                                @if($mesa->materia->getTotalAttribute() > 0)
                                    <a class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                       data-bs-target="#mover{{$inscripcion->id}}">
                                        Mover
                                    </a>
                                @endif

                                <button class="{{$inscripcion->confirmado ? 'd-none' : '' }} inscripcion_id btn btn-sm btn-info"
                                        id="{{$inscripcion->id}}">Confirmar
                                </button>
                                <button class="{{ !$inscripcion->confirmado ? 'd-none' : '' }} btn btn-sm btn-success"
                                        id="confirmado-{{$inscripcion->id}}" disabled>Confirmado
                                </button>
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p>No existen inscripciones para este llamado.</p>
            @endif

            @if(count($primer_llamado_bajas) > 0)
                <h2 class="text-info">Primer llamado bajas</h2>

                <table class="table mt-4">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellido</th>
                        <th scope="col">D.N.I</th>
                        <th scope="col">Teléfono</th>
                        <th>Responsable</th>
                        <th>Fecha de baja</th>
                        <th scope="col">Motivos</th>
                        <th><i class="fa fa-cog" style="font-size:20px;"></i></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($primer_llamado_bajas as $inscripcion)
                        <tr style="cursor:pointer;">
                            <td>{{ $inscripcion->alumno ? $inscripcion->alumno->nombres : $inscripcion->nombres }}</td>
                            <td>{{ $inscripcion->alumno ? $inscripcion->alumno->apellidos : $inscripcion->apellidos  }}</td>
                            <td>{{ $inscripcion->alumno ? $inscripcion->alumno->dni : $inscripcion->dni }}</td>
                            <td>{{ $inscripcion->alumno ? $inscripcion->alumno->telefono : $inscripcion->telefono }}</td>
                            <td>{{ $inscripcion->user ? ucwords($inscripcion->user->nombre).' '.ucwords($inscripcion->user->apellido) : '' }}</td>
                            <td>{{ date_format(new DateTime($inscripcion->updated_at ), 'd-m-Y H:i') }}</td>
                            <td>
                                {{ $inscripcion->motivo_baja }}
                            </td>
                            <td><a href="{{ route('alta.mesa',$inscripcion->id) }}" class="btn btn-sm btn-info"><i class="fas fa-chevron-circle-up"></i> Dar Alta</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif

            @if( count($segundo_llamado) > 0)
                <h2 class="text-info">Segundo llamado</h2>
                <table class="table mt-4">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellido</th>
                        <th scope="col">D.N.I</th>
                        <th scope="col">Teléfono</th>

                        <th scope="col"><i class="fa fa-cog" style="font-size:20px;"></i></th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($segundo_llamado as $inscripcion)
                        <tr style="cursor:pointer;">
                            <td>{{ $inscripcion->alumno ? $inscripcion->alumno->nombres : $inscripcion->nombres }}</td>
                            <td>{{ $inscripcion->alumno ? $inscripcion->alumno->apellidos : $inscripcion->apellidos }}</td>
                            <td>{{ $inscripcion->alumno ? $inscripcion->alumno->dni : $inscripcion->dni }}</td>
                            <td>{{ $inscripcion->alumno ? $inscripcion->alumno->telefono : $inscripcion->telefono }}</td>

                            <td>
                                <a class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                   data-bs-target="#baja{{$inscripcion->id}}">
                                   <i class="fas fa-chevron-circle-down"></i> Dar baja
                                </a>
                                @if($mesa->materia->getTotalAttribute() > 0)
                                    <a class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                       data-bs-target="#mover{{$inscripcion->id}}">
                                        Mover
                                    </a>
                                @endif

                                <button class="{{$inscripcion->confirmado ? 'd-none' : '' }} inscripcion_id btn btn-sm btn-info"
                                        id="{{$inscripcion->id}}">Confirmar
                                </button>
                                <button class="{{ !$inscripcion->confirmado ? 'd-none' : '' }} btn btn-sm btn-success"
                                        id="confirmado-{{$inscripcion->id}}" disabled>Confirmado
                                </button>

                                @include('mesa.modals.dar_baja_mesa')
                                @include('mesa.modals.mover')
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
            @if(count($segundo_llamado_bajas) > 0)
                <h2 class="text-info">Segundo llamado bajas</h2>

                <table class="table mt-4">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellido</th>
                        <th scope="col">D.N.I</th>
                        <th scope="col">Teléfono</th>
                        <th>Responsable</th>
                        <th>Fecha de baja</th>
                        <th scope="col">Motivos</th>
                        <th><i class="fa fa-cog" style="font-size:20px;"></i></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($segundo_llamado_bajas as $inscripcion)
                        <tr style="cursor:pointer;">
                            <td>{{ $inscripcion->alumno ? $inscripcion->alumno->nombres : $inscripcion->nombres }}</td>
                            <td>{{ $inscripcion->alumno ? $inscripcion->alumno->apellidos : $inscripcion->apellidos }}</td>
                            <td>{{ $inscripcion->alumno ? $inscripcion->alumno->dni : $inscripcion->dni }}</td>
                            <td>{{ $inscripcion->alumno ? $inscripcion->alumno->telefono : $inscripcion->telefono }}</td>
                            <td>{{ $inscripcion->user ? ucwords($inscripcion->user->nombre).' '.ucwords($inscripcion->user->apellido) : '' }}</td>
                            <td>{{ date_format(new DateTime($inscripcion->updated_at ), 'd-m-Y H:i') }}</td>

                            <td>
                                {{ $inscripcion->motivo_baja }}
                            </td>
                            <td><a href="{{ route('alta.mesa',$inscripcion->id) }}" class="btn btn-sm btn-info"><i class="fas fa-chevron-circle-up"></i> Dar Alta</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        @else
            <h2 class="h1 text-info">
                La mesa no esta configurada.
            </h2>
        @endif
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/mesas/inscripcion.js') }}"></script>
    <script src="{{ asset('js/mesas/confirmacion.js') }}"></script>
@endsection