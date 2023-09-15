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
            <th class="sticky-top text-center">Nota Proceso</th>
            <th class="sticky-top text-center">% Asist. Final</th>
            <th class="sticky-top text-center">TFI</th>
            <th class="sticky-top text-center">Nota Final</th>
            <th class="sticky-top col-sm-1">Nota Global</th>
        </tr>
    </thead>
    <tbody>
        @foreach($procesos as $proceso)
        @if($proceso->procesoModularOne)
        <tr>
            <td>
                {{ optional($proceso->alumno)->apellidos_nombres }}
            </td>
            <td class="text-center">
                {{ $proceso->procesoModularOne->promedio_final_nota }}
            </td>
            <td class="text-center">
                {{ $proceso->procesoModularOne->asistencia_final_porcentaje }} %
            </td>
            <td class="text-center">
                {{ $proceso->procesoModularOne->trabajo_final_nota ? $proceso->procesoModularOne->trabajo_final_nota : '-'}}
            </td>
            <td class="text-center">
                {{ $proceso->procesoModularOne->nota_final_nota ? $proceso->procesoModularOne->nota_final_nota : '-'}}
            </td>
            <td class="text-center">
                {{ $proceso->procesoModularOne->nota_global ? $proceso->procesoModularOne->nota_global : '-' }}
            </td>
        </tr>
        @endif
        @endforeach
    </tbody>
</table>