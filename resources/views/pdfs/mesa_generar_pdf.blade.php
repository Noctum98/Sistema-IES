@extends('layouts.pdf')
<style>
    table, tr, th, td {
        border: 1px solid black;
        border-collapse: collapse;
        font-size: 10pt;
    }

    th, td {
        padding-top: 10px;
        padding-bottom: 10px;
        padding-left: 5px;
    }
</style>

<div class="container alumno">
    <img src="{{ 'images/logo-dge-iesvu.png' }}" style="width: 100%" alt="DATA-IESVU">
    <h5><u> {{$carrera->nombre}} Res: {{$carrera->resolucion}}</u></h5>
    <h5><u>Turno: {{$instancia->nombre}}</u></h5>
    <h5><u>Mesas ordenadas por año</u> <span class="text-right">{{$carrera->sede()->first()->nombre}}</span></h5>

    <div class="col-md-12">
        <div class="table">
            <table class="table" border="0">
                <thead class="thead-dark">
                <tr>
                    <th rowspan="2" scope="col">Espacio Curricular</th>
                    <th colspan="2" scope="col">{{ $texto_llamado }}</th>
                    <th colspan="3" scope="col">Integrante</th>
                </tr>
                <tr>
                    <th scope="col">Fecha</th>
                    <th scope="col">Hora</th>
                    <th scope="col">Presidente</th>
                    <th scope="col">Primer Vocal</th>
                    <th scope="col">Segundo Vocal</th>
                </tr>

                </thead>
                <tbody>
                <tr>
                    <td colspan="6" align="center"><b>Espacios curriculares 1 <sup>er</sup> Año </b></td>
                </tr>
                @foreach($carrera->materias()->get() as $materia )
                    @if($materia->año == 1)
                        <tr>
                            <td>{{$materia->nombre}}</td>
                            <td align="center" @empty($materia->mesa($instancia->id))
                                colspan="5"
                                    @endempty
                            >
                                @if($materia->mesa($instancia->id))
                                    @if ($llamado == 1)
                                        {{ date_format(new DateTime($materia->mesa($instancia->id)->fecha), 'd-m-Y') }}
                                    @else
                                        {{ date_format(new DateTime($materia->mesa($instancia->id)->fecha_segundo), 'd-m-Y') }}
                                    @endif
                                @else
                                    No tiene mesa asignada
                                @endif
                            </td>
                            @if($materia->mesa($instancia->id))

                                <td align="center">{{ date_format(new DateTime($materia->mesa($instancia->id)->fecha), 'H:i') }}</td>
                                @if($llamado == 1)
                                    <td>{{$materia->mesa($instancia->id)->presidente}}</td>
                                    <td>{{$materia->mesa($instancia->id)->primer_vocal}}</td>
                                    <td>{{$materia->mesa($instancia->id)->segundo_vocal}}</td>
                                @else
                                    <td>{{$materia->mesa($instancia->id)->presidente_segundo}}</td>
                                    <td>{{$materia->mesa($instancia->id)->primer_vocal_segundo}}</td>
                                    <td>{{$materia->mesa($instancia->id)->segundo_vocal_segundo}}</td>
                                @endif

                            @endif
                        </tr>
                    @endif
                @endforeach
                <tr>
                    <td colspan="6" align="center"><b>Espacios curriculares 2 <sup>do</sup> Año </b></td>
                </tr>
                @foreach($carrera->materias()->get() as $materia )
                    @if($materia->año == 2)
                        <tr>
                            <td>{{$materia->nombre}}</td>
                            <td align="center" @empty($materia->mesa($instancia->id))
                                colspan="5"
                                    @endempty
                            >
                                @if($materia->mesa($instancia->id))
                                    @if ($llamado == 1)
                                        {{ date_format(new DateTime($materia->mesa($instancia->id)->fecha), 'd-m-Y') }}
                                    @else
                                        {{ date_format(new DateTime($materia->mesa($instancia->id)->fecha_segundo), 'd-m-Y') }}
                                    @endif
                                @else
                                    No tiene mesa asignada
                                @endif
                            </td>
                            @if($materia->mesa($instancia->id))

                                <td align="center">{{ date_format(new DateTime($materia->mesa($instancia->id)->fecha), 'H:i') }}</td>
                                @if($llamado == 1)
                                    <td>{{$materia->mesa($instancia->id)->presidente}}</td>
                                    <td>{{$materia->mesa($instancia->id)->primer_vocal}}</td>
                                    <td>{{$materia->mesa($instancia->id)->segundo_vocal}}</td>
                                @else
                                    <td>{{$materia->mesa($instancia->id)->presidente_segundo}}</td>
                                    <td>{{$materia->mesa($instancia->id)->primer_vocal_segundo}}</td>
                                    <td>{{$materia->mesa($instancia->id)->segundo_vocal_segundo}}</td>
                                @endif

                            @endif
                        </tr>
                    @endif
                @endforeach
                <tr>
                    <td colspan="6" align="center"><b>Espacios curriculares 3 <sup>er</sup> Año </b></td>
                </tr>
                @foreach($carrera->materias()->get() as $materia )
                    @if($materia->año == 3)
                        <tr>
                            <td>{{$materia->nombre}}</td>
                            <td align="center" @empty($materia->mesa($instancia->id))
                                colspan="5"
                                    @endempty
                            >
                                @if($materia->mesa($instancia->id))
                                    @if ($llamado == 1)
                                        {{ date_format(new DateTime($materia->mesa($instancia->id)->fecha), 'd-m-Y') }}
                                    @else
                                        {{ date_format(new DateTime($materia->mesa($instancia->id)->fecha_segundo), 'd-m-Y') }}
                                    @endif
                                @else
                                    No tiene mesa asignada
                                @endif
                            </td>
                            @if($materia->mesa($instancia->id))

                                <td align="center">{{ date_format(new DateTime($materia->mesa($instancia->id)->fecha), 'H:i') }}</td>
                                @if($llamado == 1)
                                    <td>{{$materia->mesa($instancia->id)->presidente}}</td>
                                    <td>{{$materia->mesa($instancia->id)->primer_vocal}}</td>
                                    <td>{{$materia->mesa($instancia->id)->segundo_vocal}}</td>
                                @else
                                    <td>{{$materia->mesa($instancia->id)->presidente_segundo}}</td>
                                    <td>{{$materia->mesa($instancia->id)->primer_vocal_segundo}}</td>
                                    <td>{{$materia->mesa($instancia->id)->segundo_vocal_segundo}}</td>
                                @endif

                            @endif
                            {{--                            <td>{{ $mesa['materia']['año'] }}</td>--}}
                            {{--                            <td>{{ date_format(new DateTime( $mesa['fecha'] ), 'd-m-Y') }}</td>--}}
                            {{--                            <td>{{date_format(new DateTime( $mesa['fecha'] ), 'H:i') }}</td>--}}
                            {{--                            <td>{{ $mesa['presidente'] }}</td>--}}
                            {{--                            <td>{{ $mesa['primer_vocal'] }}</td>--}}
                            {{--                            <td>{{ $mesa['segundo_vocal'] }}</td>--}}
                            {{--                            <td>{{ $mesa['fecha_segundo'] ? date_format(new DateTime( $mesa['fecha_segundo'] ), 'd-m-Y') : '' }}</td>--}}
                            {{--                            <td>{{ $mesa['fecha_segundo'] ? date_format(new DateTime( $mesa['fecha_segundo'] ), 'H:i') : ''}}</td>--}}
                            {{--                            <td>{{ $mesa['presidente_segundo'] }}</td>--}}
                            {{--                            <td>{{ $mesa['primer_vocal_segundo'] }}</td>--}}
                            {{--                            <td>{{ $mesa['segundo_vocal_segundo'] }}</td>--}}
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>