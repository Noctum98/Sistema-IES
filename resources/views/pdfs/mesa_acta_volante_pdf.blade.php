@extends('layouts.pdf')
<style>
    table, tr, th, td {
        border: 1px solid black;
        border-collapse: collapse;
        font-size: 10pt;
    }

    th, td {
        margin: 0;
        padding-top: 2px;
        padding-bottom: 2px;
        padding-left: 5px;
    }

    table.outborder {
        border: 0.01rem solid white !important;
        border-collapse: collapse !important;
        font-size: 10pt;
    }

    table.outborder > tr > td {
        border-style: hidden !important;
        /*border: none !important;*/
        color: #0a53be;
        padding-top: 1px;
        padding-bottom: 1px;
        margin: 0;
        padding-left: 5px;
    }
</style>

<div class="container alumno">
    <img src="{{ 'images/logo-dge-iesvu.png' }}" style="width: 70%; align-items: center;  margin: 0 15% 3px 15%; padding-bottom: 0" alt="DATA-IESVU">
    <table class="outborder m-0 py-0" border="0" cellpadding="0" cellspacing="0"
           style="width: 100%; border-spacing: 0; border-collapse: collapse; border-style: outset; border-color: #ffffff;
           margin: 0; padding: 0 "
    >
        <tr style="margin: 0; padding: 0">
            <td style="width: 100%;
             border: 0.01rem solid white !important;
        border-collapse: collapse !important; margin: 0; padding: 0"
                colspan="3"
            >
                <h5 style="margin: 0; padding: 0; text-align: center" >ACTA VOLANTE DE EXÁMENES</h5>
            </td>

        </tr>
        <tr style="margin: 0;">
            <td style="width: 50%; border: 0.01rem solid white !important;
        border-collapse: collapse !important; margin: 0; padding: 0">
                <h5 style="margin: 0; padding: 0; text-align: center" ><u>CARRERA:</u> {{$carrera->nombre}}</h5>
            </td>
            <td style="width: 50%; border: 0.01rem solid white !important;
        border-collapse: collapse !important; margin: 0; padding: 0">
            </td>
            <td style="width: 50%; border: 0.01rem solid white !important;
        border-collapse: collapse !important; margin: 0; padding: 5px">
                <h5 style="margin: 0; padding: 0; text-align: center" ><u>UNIDAD ACADÉMICA:</u> {{$carrera->sede()->first()->nombre}}</span></h5>
            </td>
        </tr>
        <tr style="margin: 0;">
            <td style="width: 50%; border:none !important; border: 0.01rem solid white !important;
        border-collapse: collapse !important; margin: 0; padding: 5px">
                <h5 style="margin: 0; padding: 0; text-align: center" ><u>Resol. No</u> {{$carrera->resolucion}}</h5>
            </td>
            <td style="width: 50%; border:none !important; border: 0.01rem solid white !important;
        border-collapse: collapse !important; margin: 0; padding: 5px">

            </td>
            <td style="width: 50%; border:none !important; border: 0.01rem solid white !important;
        border-collapse: collapse !important; margin: 0; padding: 5px">Libro No:
            </td>
        </tr>
        <tr style="margin: 0;">
            <td colspan="3" style="width: 50%; border:none !important; border: 0.01rem solid white !important;
        border-collapse: collapse !important; margin: 0; padding: 5px">
                Espacio / Módulo: <b>{{$materia->nombre}}</b>
            </td>
        </tr>
        <tr style="margin: 0;">
            <td style="width: 50%; border:none !important; border: 0.01rem solid white !important;
        border-collapse: collapse !important; margin: 0; padding: 5px">
                <h5 style="margin: 0; padding: 0; text-align: center" ><u>Año: </u> {{$materia->año}}° año</h5>
            </td>
            <td style="width: 50%; border:none !important; border: 0.01rem solid white !important;
        border-collapse: collapse !important; margin: 0; padding: 5px">
                <h5 style="margin: 0; padding: 0; text-align: center" ><u>Turno: </u> {{ucfirst($carrera->turno)}}</h5>
            </td>
            <td style="width: 50%; border:none !important; border: 0.01rem solid white !important;
        border-collapse: collapse !important; margin: 0; padding: 5px">Folio No:
            </td>

        </tr>
    </table>
</div>


<div class="container" style="width: 100%">
    <table class="m-0 py-0" border="0" cellpadding="0" cellspacing="0"
           style="width: 100%; margin: 0;"
    >
        <thead class="thead-dark">
        <tr >
            <th rowspan="2" scope="col">N° de<br/> orden</th>
            <th rowspan="2" scope="col">Apellidos y Nombres</th>
            <th rowspan="2" scope="col">Documento de <br/> identidad</th>
            <th rowspan="2" scope="col">Correo electrónico</th>
            <th rowspan="2" scope="col">Teléfono</th>
            <th colspan="3" scope="col">Calificación</th>
        </tr>
        <tr>
            <th scope="col">Escrito</th>
            <th scope="col">Oral</th>
            <th scope="col">Promedio</th>
        </tr>

        </thead>
        <tbody>
        @php
        $cant_file = count($mesa->mesa_inscriptos);
        $faltan_file = 26 - $cant_file;
        @endphp
        @foreach($mesa->mesa_inscriptos as $mesa_inscripto)
            <tr>
                <td>{{ $loop->index }}</td>
                <td>{{$mesa_inscripto->apellidos}}, {{$mesa_inscripto->nombres}}</td>
                <td>{{$mesa_inscripto->dni}}</td>
                <td>{{$mesa_inscripto->correo}}</td>
                <td>{{$mesa_inscripto->telefono}}</td>
                <td>{{$mesa_inscripto->acta_volante->nota_escrito}}</td>
                <td>{{$mesa_inscripto->acta_volante->nota_oral}}</td>
                <td> {{$mesa_inscripto->acta_volante->promedio}}</td>
            </tr>

        @endforeach
        @if($faltan_file > 0)
            @for($i = 0 ; $i < $faltan_file; $i++)
                <tr>
                    <td>{{$i + $cant_file + 1 }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @endfor
        @endif

        </tbody>
    </table>
    <div class="container" style="width: 100%;   margin: 0 0 1px 0; padding: 0 5px">
        <div class="col-12 text-left" style="margin: 0 5px; padding: 0 5px">
            Observaciones - Situaciones
        </div>
        <div class="col-12 text-left" style="height: 30%; border: 1px solid black;margin: 0; padding: 0 5px">
        </div>
    </div>

    @if($llamado == 1)
        @php
            $presidente = $materia->mesa($instancia->id)->presidente;
            $presidente_id = $materia->mesa($instancia->id)->presidente_id;
            $primer_vocal = $materia->mesa($instancia->id)->primer_vocal;
            $primer_vocal_id = $materia->mesa($instancia->id)->primer_vocal_id;
            $segundo_vocal = $materia->mesa($instancia->id)->segundo_vocal;
            $segundo_vocal_id = $materia->mesa($instancia->id)->segundo_vocal_id;
        @endphp

    @else
        @php
            $presidente = $materia->mesa($instancia->id)->presidente;
            $presidente_id = $materia->mesa($instancia->id)->presidente_segundo_id;
            $primer_vocal = $materia->mesa($instancia->id)->primer_vocal;
            $primer_vocal_id = $materia->mesa($instancia->id)->primer_vocal_segundo_id;
            $segundo_vocal = $materia->mesa($instancia->id)->segundo_vocal;
            $segundo_vocal_id = $materia->mesa($instancia->id)->segundo_vocal_segundo_id;
        @endphp
    @endif
    <div class="container" style="width: 100%; margin: 0 5px; padding: 0 5px">
        <table class="m-0 py-0" border="0" cellpadding="0" cellspacing="0"
               style="width: 100%; margin: 0;"
        >
            <tbody class="thead-dark">
            <tr>
                <th scope="col" width="25%">
                    Presidente de mesa
                </th>
                <th scope="col" width="50%" style="text-align: left">
                    {{$presidente}}
                    @if($presidente_id)
                        @inject('userService', 'App\Services\UserService')
                        @php
                            $user = $userService->getUserById($presidente_id);
                        @endphp
                        <small><br/>{{$user->email}}</small>
                    @endif
                </th>
                <th scope="col" width="15%">
                    Aprobados
                </th>
                <th scope="col" width="10%">

                </th>
            </tr>
            <tr>
                <th scope="col" width="25%">
                    Vocal 1
                </th>
                <th scope="col" width="50%" style="text-align: left">
                    {{$primer_vocal}}
                    @if($primer_vocal_id)
                        @inject('userService', 'App\Services\UserService')
                        @php
                            $user = $userService->getUserById($primer_vocal_id);
                        @endphp
                        <small><br/>{{$user->email}}</small>
                    @endif

                </th>
                <th scope="col" width="15%">
                    Aplazados
                </th>
                <th scope="col" width="10%">

                </th>
            </tr>
            <tr>
                <th scope="col" width="25%">
                    Vocal 2
                </th>
                <th scope="col" width="50%" style="text-align: left">
                    {{$segundo_vocal}}
                    @if($segundo_vocal_id)
                        @inject('userService', 'App\Services\UserService')
                        @php
                            $user = $userService->getUserById($segundo_vocal_id);
                        @endphp
                        <small><br/>{{$user->email}}</small>
                    @endif
                </th>
                <th scope="col" width="15%">
                    Ausentes
                </th>
                <th scope="col" width="10%">

                </th>
            </tr>
            <tr>
                <th scope="col" width="25%">
                    Coordinador
                </th>
                <th scope="col" width="50%" style="text-align: left">
                    @if($carrera->coordinador)
                        @inject('userService', 'App\Services\UserService')
                        @php
                            $user = $userService->getUserById($carrera->coordinador);
                        @endphp
                        {{$user->apellido}}, {{$user->nombre}}
                        <small><br/>{{$user->email}}</small>
                    @endif

                </th>
                <th scope="col" width="15%">
                    Total
                </th>
                <th scope="col" width="10%">

                </th>
            </tr>

            </tbody>
        </table>
    </div>
</div>