@if($mesa)

<button class="mt-2 btn btn-sm btn-secondary button-modal" id="{{$llamado}}" data-bs-toggle="modal" data-bs-target="#libro_folio_{{$llamado}}">
    Libro/Folio
</button>
@include('mesa.modals.libro_folio_1',['llamado'=>$llamado,'folios'=>$folios])
@php
$contador_boton = 1;
@endphp
@while($contador_boton <= $folios ) <a href="{{ route('generar_pdf_acta_volante', ['instancia' => $mesa->instancia_id, 'carrera'=>$mesa->materia->carrera_id,'materia' => $mesa->materia_id ,'llamado' => $llamado, 'comision' => $mesa->comision_id ?? null,'orden'=>$contador_boton]) }}" class="btn btn-sm btn-success mt-2">
    <i>{{$llamado}} ° llamado: Orden {{$contador_boton}}</i>
    <small style="font-size: 0.6em">Descargar Acta Volante</small>
    </a>
    @php
    $contador_boton++;
    @endphp
    @endwhile
@endif
    <table class="table mt-4">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Apellido</th>
                <th scope="col">D.N.I</th>
                <th scope="col">Teléfono</th>
                @if(isset($instancia) && $instancia->tipo == 1)
                <th>Comisión</th>
                @endif
                <th scope="col"><i class="fa fa-cog" style="font-size:20px;"></i></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($inscripciones as $inscripcion)
            <tr style="cursor:pointer;">
                <td>{{ $inscripcion->alumno ? $inscripcion->alumno->nombres : $inscripcion->nombres }}</td>
                <td>{{ $inscripcion->alumno ? $inscripcion->alumno->apellidos : $inscripcion->apellidos }}</td>
                <td>{{ $inscripcion->alumno ? $inscripcion->alumno->dni : $inscripcion->dni }}</td>
                <td>{{ $inscripcion->alumno ? $inscripcion->alumno->telefono : $inscripcion->telefono }}</td>
                @if(isset($instancia) && $instancia->tipo == 1)
                <td>{{ $inscripcion->alumno->comisionPorAño($inscripcion->materia->carrera_id,$inscripcion->materia->año) ?? '-' }}</td>

                @endif

                <td>
                    @include('mesa.modals.dar_baja_mesa')
                    @include('mesa.modals.mover')

                    <a class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#baja{{$inscripcion->id}}">
                        <i class="fas fa-chevron-circle-down"></i> Dar baja
                    </a>
                    @if($mesa->materia->getTotalAttribute() > 0)
                    <a class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#mover{{$inscripcion->id}}">
                        Mover
                    </a>
                    @endif

                    <button class="{{$inscripcion->confirmado ? 'd-none' : '' }} inscripcion_id btn btn-sm btn-info" id="{{$inscripcion->id}}">Confirmar
                    </button>
                    <button class="{{ !$inscripcion->confirmado ? 'd-none' : '' }} btn btn-sm btn-success" id="confirmado-{{$inscripcion->id}}" disabled>Confirmado
                    </button>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>