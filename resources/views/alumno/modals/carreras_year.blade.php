<div class="modal fade" id="carrerasAñoModal{{$inscripcion->carrera_id}}" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-secondary" id="exampleModalLabel">
                    Cambiar año
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('alumnoCarrera.year',['alumno_id'=>$alumno->id,'carrera_id'=>$inscripcion->carrera_id]) }}"
                      method="POST">
                    @csrf

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="year" id="flexRadioDefault1"
                               value="1" {{ $alumno->lastProcesoCarrera($inscripcion->carrera_id)->año == 1 ? 'checked' : ''}}>
                        <label class="form-check-label" for="flexRadioDefault1">
                            PRIMER AÑO
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="year" id="flexRadioDefault2"
                               value="2" {{ $alumno->lastProcesoCarrera($inscripcion->carrera_id)->año == 2 ? 'checked' : ''}}>
                        <label class="form-check-label" for="flexRadioDefault2">
                            SEGUNDO AÑO
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="year" id="flexRadioDefault3"
                               value="3" {{ $alumno->lastProcesoCarrera($inscripcion->carrera_id)->año == 3 ? 'checked' : ''}}>
                        <label class="form-check-label" for="flexRadioDefault3">
                            TERCER AÑO
                        </label>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                        <input type="submit" class="btn btn-primary" value="Guardar cambios">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
