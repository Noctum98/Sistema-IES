<div class="modal fade" id="inscribirAlumno" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-secondary" id="exampleModalLabel">Editar instancia</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('mesa.inscribir_alumno') }}">
                    
                    <input type="hidden" name="mesa_id" value="{{ $mesa->id }}">
                    <div class="form-group">
                        <label for="alumno_id">Alumno</label>
                        <select name="alumno_id" id="alumno_id" class="form-select" required>
                            @foreach($procesos as $proceso)
                                <option value="{{ $proceso->alumno_id }}">{{mb_strtoupper($proceso->alumno->apellidos).' '.ucwords($proceso->alumno->nombres)}}</option>
                            @endforeach
                        </select>
                    </div>
                    @if($mesa->fecha_segundo)
                    <div class="form-group">
                        <label for="llamado">Llamado</label>
                        <select name="llamado" id="llamado" class="form-select" required>
                            <option value="0">Primer llamado</option>
                            <option value="1">Segundo llamado</option>
                        </select>
                    </div>
                    @else
                    <input type="hidden" name="llamado" value="0">
                    @endif
                    
                    <input type="submit" class="btn btn-success" value="Inscribir">
                </form>
            </div>
        </div>
    </div>
</div>
