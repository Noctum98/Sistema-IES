@extends('layouts.app-prueba')
@section('content')
    <div class="container">
        <h2 class="h1">
            Mis procesos <br/>
            <small style="font-size: 0.5em">
                <i>
                    {{ ucwords($alumno->nombres.' '.$alumno->apellidos) }}
                </i>
            </small>
        </h2>
        <hr>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>
                        Materia
                    </th>
                    <th>
                        Estado
                    </th>
                    <th>
                        Nota final <br/> Parciales
                    </th>
                    <th>
                        Nota final <br/>
                        T. Prácticos
                    </th>
                    <th>
                        Asistencia final
                    </th>
                </tr>

                </thead>
                <tbody>
                @foreach($alumno->procesos as $proceso)

                    <tr>
                        <td>
                            {{ $proceso->materia->nombre }}
                        </td>
                        <td>
                            {{ ucwords($proceso->estado) }}
                        </td>
                        <td>
                            {{ $proceso->final_parciales ?  : 'Sin asignar'}}
                        </td>
                        <td>
                            {{ $proceso->final_trabajos ?  : 'Sin asignar'}}
                        </td>
                        <td>
                            @if($proceso->asistencia($proceso->id))
                            {{ $proceso->asistencia($proceso->id) ?  : 'Sin asignar'}}
                            @endif
                        </td>
                    </tr>

                @endforeach
                </tbody>
            </table>
        </div>
@endsection
