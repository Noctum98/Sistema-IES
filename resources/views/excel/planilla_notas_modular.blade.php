<table class="table table-striped f30">
    <thead>
        <tr>
            <th><b>UNIDAD ACADEMICA:</b></th>
            <th><b>{{$materia->carrera->sede->nombre}} </b></th>
        </tr>
        <tr>
            <th><b>CARRERA:</b></th>
            <th> <b> {{ $materia->carrera->nombre.' ( '.ucwords($materia->carrera->turno).' )' }}</b></th>
        </tr>
        <tr>
            <th><b>RESOLUCION: </b></th>
            <th style="text-align: left;"><b> {{ $materia->carrera->resolucion }} </b></th>
        </tr>
        <tr>
            <th scope="col">Apeliido y Nombre</th>
            {{-- <th class="sticky-top">Proc. Final %</th>--}}
            <th class="sticky-top text-center">N Proceso</th>
            <th class="sticky-top text-center">% Asist. Final</th>
            {{-- <th class="sticky-top">TFI %</th>--}}
            <th class="sticky-top text-center">N TFI</th>
            {{-- <th class="sticky-top">Nota Final %</th>--}}
            <th class="sticky-top text-center">N Final</th>
            <th class="sticky-top col-sm-1">N Global</th>
        </tr>
    </thead>
    <tbody>
        @foreach($procesos as $proceso)
        <tr>
            <td>
                {{optional($proceso->alumno)->apellidos_nombres}}
            </td>
            <td class="text-center">
                @colorAprobado($proceso->promedio_final_nota)
            </td>
            <td class="text-center">
                {{$proceso->asistencia_final_porcentaje}} %
            </td>
            <td class="text-center">
                @colorAprobado($proceso->trabajo_final_nota)
            </td>
            <td class="text-center">
                @colorAprobado($proceso->nota_final_nota)
            </td>
            <td class="text-center">
                @colorAprobado($proceso->nota_global)
            </td>
        </tr>
        @endforeach
    </tbody>
</table>