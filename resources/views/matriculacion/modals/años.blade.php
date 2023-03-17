<div class="modal fade" id="carreraAño{{$carrera->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-secondary" id="exampleModalLabel">
                    Elegir Año
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" id="form-{{ $carrera->id }}">
            <div class="modal-body">
                <div class="form-check">
                    <input type="hidden" name="alumno_id" id="alumno_id" value="{{ $carrera->alumnos[0]->id }}">
                    <input class="form-check-input" type="radio" name="año-{{ $carrera->id }}" id="flexRadioDefault1{{ $carrera->id }}" data-carrera="{{ $carrera->id }}" value="1" {{ !$carrera->hasMaterias(1) ? 'disabled': '' }}>
                    <label class="form-check-label" for="flexRadioDefault1{{ $carrera->id }}">
                       1er Año
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="año-{{ $carrera->id }}" value="2" data-carrera="{{ $carrera->id }}"  id="flexRadioDefault2{{ $carrera->id }}" {{ !$carrera->hasMaterias(2) ? 'disabled': '' }}>
                    <label class="form-check-label" for="flexRadioDefault2{{ $carrera->id }}">
                        2do año
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="año-{{ $carrera->id }}" value="3" data-carrera="{{ $carrera->id }}" id="flexRadioDefault3{{ $carrera->id }}" {{ !$carrera->hasMaterias(3) ? 'disabled': '' }}>
                    <label class="form-check-label" for="flexRadioDefault3{{ $carrera->id }}">
                        3er año
                    </label>
                </div>


            </div>
            <div class="modal-footer">
            <button id="link_matriculacion" data-carrera="{{ $carrera->id }}" class="btn btn-primary">Elegir</button>

            </div>
            </form>
        </div>
    </div>
</div>