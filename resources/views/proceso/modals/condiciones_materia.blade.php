<div class="modal fade" id="condicion{{ $materia->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-info" id="title_modal">Condición </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('proceso.inscribirAlumno') }}" method="POST">

                @foreach($materia->getCondicionesMateria() as $condicion)
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="condicion_materia_id" id="condicion_materia_id1" value="{{ $condicion->id }}">
                    <label class="form-check-label" for="condicion_materia_id1">
                        {{$condicion->nombre}}
                    </label>
                </div>
                @endforeach
                <input type="hidden" name="alumno_id" value="{{ $alumno->id }}">
                <input type="hidden" name="ciclo_lectivo" value="{{ $ciclo_lectivo }}">
                <input type="hidden" name="materia_id" value="{{ $materia->id }}">
            </div>
            <div class="modal-footer">
            <button type="submit" class="btn btn-sm btn-success">Inscribir</button>

            </div>
            </form>

        </div>
    </div>
</div>