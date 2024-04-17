<div class="modal fade" id="carreraAño{{$inscripcion->carrera->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-secondary" id="exampleModalLabel">
                    Elegir Año
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" id="form-{{ $inscripcion->carrera->id }}">
            <div class="modal-body">
                <div class="form-check">
                    <input type="hidden" name="alumno_id" id="alumno_id" value="{{ $inscripcion->alumno_id }}">
                    <input class="form-check-input" type="radio" name="año-{{ $inscripcion->carrera->id }}" id="flexRadioDefault1{{ $inscripcion->carrera->id }}" data-carrera="{{ $inscripcion->carrera->id }}" value="1" {{ !$inscripcion->carrera->hasMaterias(1) ? 'disabled': '' }}>
                    <label class="form-check-label" for="flexRadioDefault1{{ $inscripcion->carrera->id }}">
                       1er Año
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="año-{{ $inscripcion->carrera->id }}" value="2" data-carrera="{{ $inscripcion->carrera->id }}"  id="flexRadioDefault2{{ $inscripcion->carrera->id }}" {{ !$inscripcion->carrera->hasMaterias(2) ? 'disabled': '' }}>
                    <label class="form-check-label" for="flexRadioDefault2{{ $inscripcion->carrera->id }}">
                        2do año
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="año-{{ $inscripcion->carrera->id }}" value="3" data-carrera="{{ $inscripcion->carrera->id }}" id="flexRadioDefault3{{ $inscripcion->carrera->id }}" {{ !$inscripcion->carrera->hasMaterias(3) ? 'disabled': '' }}>
                    <label class="form-check-label" for="flexRadioDefault3{{ $inscripcion->carrera->id }}">
                        3er año
                    </label>
                </div>


            </div>
            <div class="modal-footer">
            <button data-carrera="{{ $inscripcion->carrera->id }}" class="btn btn-primary link_matriculacion">Elegir</button>

            </div>
            </form>
        </div>
    </div>
</div>