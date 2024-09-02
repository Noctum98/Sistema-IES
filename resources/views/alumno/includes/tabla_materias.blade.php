<div class="card border-info p-0 mt-2">
    <div class="card-header bg-info text-dark col-sm-12">
        <p class="card-text text-right m-1 p-1 me-5">{{$año}}° Año</p>
    </div>
    <div class="card-footer border-bottom col-sm-12 mx-auto">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Materia/Módulo</th>
                    <th scope="col">Régimen</th>
                    <th scope="col">Estado</th>
                    <th scope="col"><i class="fa fa-cog" style="font-size:20px;"></i></th>
                </tr>
            </thead>
            <tbody>
                @foreach($materias as $materia)
                @if($materia->año == $año)
                <tr>
                    <td>{{ ucwords($materia->nombre) }}</td>
                    <td>{{ $materia->regimen ?? 'No indicado' }}</td>
                    <td>
                        @if($alumno->hasProceso($materia->id,$ciclo_lectivo))
                        <span class="text-success">Inscripto</span>
                        @else
                        <span class="text-danger">No Inscripto</span>
                        @endif
                    </td>
                    <td>
                        @if($alumno->hasProceso($materia->id,$ciclo_lectivo))
                        <button class="btn btn-sm btn-danger btn-eliminar" data-bs-toggle="modal" data-bs-target="#eliminarProcesoModal" data-proceso_id="{{$alumno->procesoByMateria($materia->id,$ciclo_lectivo)->id}}" {{ isset($alumnoMod) ? 'disabled' : '' }}>
                            Eliminar <i class="fa fa-trash"></i>
                        </button>
                        @else
                        <a class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#condicion{{ $materia->id }}">Inscribir <i class="fas fa-pencil-alt"></i></a>
                        @include('proceso.modals.condiciones_materia')
                        @endif
                    </td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>