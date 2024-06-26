@extends('layouts.pdf')
<style>
    table,
    tr,
    th,
    td {
        border: 1px solid black;
        border-collapse: collapse;
        font-size: 10pt;
    }

    th,
    td {
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
                    <th rowspan="2" scope="col">{{$etiqueta}}</th>
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
                    <td colspan="6" align="center"><b>{{$etiquetas}} 1 <sup>er</sup> Año </b></td>
                </tr>
                @foreach($carrera->materias()->get() as $materia )
                    @if($materia->año == 1)
                        @if(count($materia->mesas_instancias($instancia->id)) === 0)
                            <tr>
                                <td>{{$materia->nombre}}</td>
                                <td align="center" colspan="5">
                                    No tiene mesa asignada
                                </td>
                            </tr>
                        @else
                            @foreach($materia->mesas_instancias($instancia->id) as $mesa)
                                <tr>
                                    <td>{{$materia->nombre}}
                                        @if($mesa->comision()->first())
                                        (<small>{{$mesa->comision()->first()->nombre}}</small>)
                                        @endif
                                    </td>
                                    @if ($llamado == 1)
                                        <td align="center">
                                            {{ date_format(new DateTime($mesa->fecha), 'd-m-Y') }}
                                        </td>
                                        <td align="center">{{ date_format(new DateTime($mesa->fecha), 'H:i') }}</td>
                                        <td>
                                            {{$mesa->presidente_mesa ? mb_convert_case($mesa->presidente_mesa->nombre,MB_CASE_TITLE, "UTF-8").' '.mb_convert_case($mesa->presidente_mesa->apellido,MB_CASE_TITLE, "UTF-8") : ''}}
                                        </td>
                                        <td>{{$mesa->primer_vocal_mesa ? mb_convert_case($mesa->primer_vocal_mesa->nombre,MB_CASE_TITLE, "UTF-8").' '.ucwords($mesa->primer_vocal_mesa->apellido ): ''}}</td>
                                        <td>{{$mesa->segundo_vocal_mesa ? mb_convert_case($mesa->segundo_vocal_mesa->nombre,MB_CASE_TITLE, "UTF-8").' '.mb_convert_case($mesa->segundo_vocal_mesa->apellido,MB_CASE_TITLE, "UTF-8") : ''}}</td>
                                    @else
                                        <td align="center">
                                            {{ date_format(new DateTime($mesa->fecha_segundo), 'd-m-Y') }}
                                        </td>
                                        <td align="center">{{ date_format(new DateTime($mesa->fecha_segundo), 'H:i') }}</td>
                                        <td>{{$mesa->presidente_segundo_mesa ? mb_convert_case($mesa->presidente_segundo_mesa->nombre,MB_CASE_TITLE, "UTF-8").' '.mb_convert_case($mesa->presidente_segundo_mesa->apellido,MB_CASE_TITLE, "UTF-8"):''}}</td>
                                        <td>{{$mesa->primer_vocal_segundo_mesa ? mb_convert_case($mesa->primer_vocal_segundo_mesa->nombre,MB_CASE_TITLE, "UTF-8").' '.mb_convert_case($mesa->primer_vocal_segundo_mesa->apellido,MB_CASE_TITLE, "UTF-8"):''}}</td>
                                        <td>{{$mesa->segundo_vocal_segundo_mesa ? mb_convert_case($mesa->segundo_vocal_segundo_mesa->nombre,MB_CASE_TITLE, "UTF-8").' '.mb_convert_case($mesa->segundo_vocal_segundo_mesa->apellido,MB_CASE_TITLE, "UTF-8"):''}}</td>
                                    @endif
                                </tr>
                            @endforeach
                        @endif
                    @endif
                @endforeach
                <tr>
                    <td colspan="6" align="center"><b>Espacios curriculares 2 <sup>do</sup> Año </b></td>
                </tr>
                @foreach($carrera->materias()->get() as $materia )
                    @if($materia->año == 2)
                        @if(count($materia->mesas_instancias($instancia->id)) === 0)
                            <tr>
                                <td>{{$materia->nombre}}</td>
                                <td align="center" colspan="5">
                                    No tiene mesa asignada
                                </td>
                            </tr>
                        @else
                            @foreach($materia->mesas_instancias($instancia->id) as $mesa)
                                <tr>
                                    <td>{{$materia->nombre}}
                                        @if($mesa->comision()->first())
                                            (<small>{{$mesa->comision()->first()->nombre}}</small>)
                                        @endif
                                    </td>
                                    @if ($llamado == 1)
                                        <td align="center">
                                            {{ date_format(new DateTime($mesa->fecha), 'd-m-Y') }}
                                        </td>
                                        <td align="center">{{ date_format(new DateTime($mesa->fecha), 'H:i') }}</td>
                                        <td>
                                            {{$mesa->presidente_mesa ? mb_convert_case($mesa->presidente_mesa->nombre,MB_CASE_TITLE, "UTF-8").' '.mb_convert_case($mesa->presidente_mesa->apellido,MB_CASE_TITLE, "UTF-8") : ''}}
                                        </td>
                                        <td>{{$mesa->primer_vocal_mesa ? mb_convert_case($mesa->primer_vocal_mesa->nombre,MB_CASE_TITLE, "UTF-8").' '.mb_convert_case($mesa->primer_vocal_mesa->apellido,MB_CASE_TITLE, "UTF-8") : ''}}</td>
                                        <td>{{$mesa->segundo_vocal_mesa ? mb_convert_case($mesa->segundo_vocal_mesa->nombre,MB_CASE_TITLE, "UTF-8").' '.mb_convert_case($mesa->segundo_vocal_mesa->apellido,MB_CASE_TITLE, "UTF-8") : ''}}</td>
                                    @else
                                        <td align="center">
                                            {{ date_format(new DateTime($mesa->fecha_segundo), 'd-m-Y') }}
                                        </td>
                                        <td align="center">{{ date_format(new DateTime($mesa->fecha_segundo), 'H:i') }}</td>
                                        <td>{{$mesa->presidente_segundo_mesa ? mb_convert_case($mesa->presidente_segundo_mesa->nombre,MB_CASE_TITLE, "UTF-8").' '.mb_convert_case($mesa->presidente_segundo_mesa->apellido,MB_CASE_TITLE, "UTF-8"):''}}</td>
                                        <td>{{$mesa->primer_vocal_segundo_mesa ? mb_convert_case($mesa->primer_vocal_segundo_mesa->nombre,MB_CASE_TITLE, "UTF-8").' '.mb_convert_case($mesa->primer_vocal_segundo_mesa->apellido,MB_CASE_TITLE, "UTF-8"):''}}</td>
                                        <td>{{$mesa->segundo_vocal_segundo_mesa ? mb_convert_case($mesa->segundo_vocal_segundo_mesa->nombre,MB_CASE_TITLE, "UTF-8").' '.mb_convert_case($mesa->segundo_vocal_segundo_mesa->apellido,MB_CASE_TITLE, "UTF-8"):''}}</td>
                                    @endif
                                </tr>
                            @endforeach
                        @endif
                    @endif
                @endforeach
                <tr>
                    <td colspan="6" align="center"><b>Espacios curriculares 3 <sup>er</sup> Año </b></td>
                </tr>
                @foreach($carrera->materias()->get() as $materia )
                    @if($materia->año == 3)

                        @if(count($materia->mesas_instancias($instancia->id)) === 0)
                            <tr>
                                <td>{{$materia->nombre}}</td>
                                <td align="center" colspan="5">
                                    No tiene mesa asignada
                                </td>
                            </tr>
                        @else
                            @foreach($materia->mesas_instancias($instancia->id) as $mesa)
                                <tr>
                                    <td>{{$materia->nombre}}
                                        @if($mesa->comision()->first())
                                            (<small>{{$mesa->comision()->first()->nombre}}</small>)
                                        @endif
                                    </td>
                                    @if ($llamado == 1)
                                        <td align="center">
                                            {{ date_format(new DateTime($mesa->fecha), 'd-m-Y') }}
                                        </td>
                                        <td align="center">{{ date_format(new DateTime($mesa->fecha), 'H:i') }}</td>
                                        <td>
                                            {{$mesa->presidente_mesa ? mb_convert_case($mesa->presidente_mesa->nombre,MB_CASE_TITLE, "UTF-8").' '.mb_convert_case($mesa->presidente_mesa->apellido,MB_CASE_TITLE, "UTF-8") : ''}}
                                        </td>
                                        <td>{{$mesa->primer_vocal_mesa ? mb_convert_case($mesa->primer_vocal_mesa->nombre,MB_CASE_TITLE, "UTF-8").' '.mb_convert_case($mesa->primer_vocal_mesa->apellido,MB_CASE_TITLE, "UTF-8") : ''}}</td>
                                        <td>{{$mesa->segundo_vocal_mesa ? mb_convert_case($mesa->segundo_vocal_mesa->nombre,MB_CASE_TITLE, "UTF-8").' '.mb_convert_case($mesa->segundo_vocal_mesa->apellido,MB_CASE_TITLE, "UTF-8") : ''}}</td>
                                    @else
                                        <td align="center">
                                            {{ date_format(new DateTime($mesa->fecha_segundo), 'd-m-Y') }}
                                        </td>
                                        <td align="center">{{ date_format(new DateTime($mesa->fecha_segundo), 'H:i') }}</td>
                                        <td>{{$mesa->presidente_segundo_mesa ? mb_convert_case($mesa->presidente_segundo_mesa->nombre,MB_CASE_TITLE, "UTF-8").' '.mb_convert_case($mesa->presidente_segundo_mesa->apellido,MB_CASE_TITLE, "UTF-8"):''}}</td>
                                        <td>{{$mesa->primer_vocal_segundo_mesa ? mb_convert_case($mesa->primer_vocal_segundo_mesa->nombre,MB_CASE_TITLE, "UTF-8").' '.mb_convert_case($mesa->primer_vocal_segundo_mesa->apellido,MB_CASE_TITLE, "UTF-8"):''}}</td>
                                        <td>{{$mesa->segundo_vocal_segundo_mesa ? mb_convert_case($mesa->segundo_vocal_segundo_mesa->nombre,MB_CASE_TITLE, "UTF-8").' '.mb_convert_case($mesa->segundo_vocal_segundo_mesa->apellido,MB_CASE_TITLE, "UTF-8"):''}}</td>
                                    @endif
                                </tr>
                            @endforeach
                        @endif
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
