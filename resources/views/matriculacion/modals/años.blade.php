<div class="modal fade" id="carreraAño{{$carrera->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-secondary" id="exampleModalLabel">
                    Elegir Año
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="año" id="flexRadioDefault1{{ $carrera->id }}" data-carrera="{{ $carrera->id }}" value="1" {{ !$carrera->hasMaterias(1) ? 'disabled': '' }}>
                    <label class="form-check-label" for="flexRadioDefault1{{ $carrera->id }}">
                       1er Año
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="año" value="2" data-carrera="{{ $carrera->id }}"  id="flexRadioDefault2{{ $carrera->id }}" {{ !$carrera->hasMaterias(2) ? 'disabled': '' }}>
                    <label class="form-check-label" for="flexRadioDefault2{{ $carrera->id }}">
                        2do año
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="año" value="3" data-carrera="{{ $carrera->id }}" id="flexRadioDefault3{{ $carrera->id }}" {{ !$carrera->hasMaterias(3) ? 'disabled': '' }}>
                    <label class="form-check-label" for="flexRadioDefault3{{ $carrera->id }}">
                        3er año
                    </label>
                </div>


            </div>
            <div class="modal-footer">
            <button id="link_matriculacion" class="btn btn-primary">Elegir</button>

            </div>
        </div>
    </div>
</div>