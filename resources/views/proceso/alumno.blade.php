@extends('layouts.app-prueba')
@section('content')
    <div class="container">
        <h2 class="h1 text-info">
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
                <thead class="thead-dark">
                <tr>
                    <th>
                        Materia
                    </th>
                    <th>
                        Estado
                    </th>
                    <th>
                        <small>
                        Nota final <br/> Parciales
                        </small>
                    </th>
                    <th>
                        <small>
                        Nota final <br/>
                        T. Prácticos
                        </small>
                    </th>
                    <th class="text-right pr-3">
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
                        <td class="text-right pr-3">
                            {{ $proceso->asistencia($proceso->id) ? $proceso->asistencia($proceso->id)->porcentaje_final : 'Sin asignar'}} %
                        </td>
                    </tr>

                @endforeach
                </tbody>
            </table>
        </div>
@endsection
