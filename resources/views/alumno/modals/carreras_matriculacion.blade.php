<div class="modal fade" id="carrerasMatriculacionModal{{$carrera->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-secondary" id="exampleModalLabel">
                    Materias Inscriptas
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('proceso.administrar',$alumno->id) }}" method="POST">
                    @csrf
                    @foreach($carrera->materias as $materia)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="materias[]" id="materia-{{$materia->id}}" value="{{ $materia->id }}" {{ $alumno->hasProceso($materia->id) ? 'checked':null }}>
                        <label class="form-check-label" for="exampleRadios{{$materia->id}}" >
                            {{$materia->nombre}}
                        </label>
                    </div>
                    @endforeach
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                <input type="submit" class="btn btn-primary" value="Guardar cambios" {{Session::has('areaSocial')  ? 'disabled' : ''}}>
            </div>
            </form>
        </div>
    </div>
</div>
