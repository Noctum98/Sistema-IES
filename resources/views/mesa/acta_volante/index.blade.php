@extends('layouts.app-prueba')
@section('content')
<div class="container">
    <h2 class="h1 text-info">
        Mesas de Examen asignadas
    </h2>
    <b><i>Selecciona la mesa y coloca notas a tus alumnos.</i></b><br />
    <b><i>Solo aparecerán las mesas en las cuales eres presidente.</i></b>
    <hr>
    <div class="table-responsive">
        <table class="table mt-2">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Mesa</th>
                    <th>UA</th>
                    <th scope="col">Carrera</th>
                    <th scope="col">Materia</th>
                    <th scope="col">Fecha</th>
                    <th scope="col"><i class="fa fa-cog" style="font-size:20px;"></i></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($mesas as $mesa)
                <tr style="cursor:pointer;">
                    <td>{{ $mesa->instancia->nombre.' ('.$mesa->instancia->año.')' }}</td>

                    <td>{{ $mesa->materia->carrera->sede->nombre }}</td>
                    <td>{{ $mesa->materia->carrera->nombre.' ('.mb_strtoupper($mesa->materia->carrera->turno).')' }}</td>
                    <td>{{ $mesa->materia->nombre}}</td>
                    <td>
                        @if($mesa->fecha)
                        <div class="d-block" style="font-size:0.9em">
                            <span>Primer llamado:</span>
                            <small class="text-primary" style="font-size:0.9em">
                                {{date_format(new DateTime($mesa->fecha),'d-m-Y H:i')}}
                            </small>
                        </div>
                        @endif

                        @if($mesa->fecha_segundo)
                        <div class="d-block" style="font-size:0.9em">
                            <span>Segundo llamado:</span>
                            <small class="text-primary" style="font-size:0.9em">
                                {{date_format(new DateTime($mesa->fecha_segundo),'d-m-Y H:i')}}
                            </small>
                        </div>
                        @endif

                        @if(!$mesa->fecha && !$mesa->fecha_segundo)
                        -
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('actasVolantes.show',$mesa->id) }}" class="btn btn-sm btn-secondary">
                            Ver                            <i class="fa fa-eye"></i>

                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-center" style="font-size: 0.8em">
            {{ $mesas->links() }}
        </div>
    </div>

</div>
@endsection