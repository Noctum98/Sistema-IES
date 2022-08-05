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
                <label for="dni">DNI Alumno</label><br>

               

                <div class="input-group mb-3">
                    <input type="hidden" name="carrera_id" id="carrera_id" value="{{$mesa->materia->carrera_id}}">
                    <input class="form-control mx-auto" type="number" id="dni" name="dni" placeholder="Buscar alumno por dni" aria-label="Search">
                    <button class="btn btn-outline-primary me-2" type="submit" id="buscarDNI"><i class="fa fa-search"></i></button>
                    <span class="d-block invalid-feedback" id="span-error"></span>
                </div>
               

                <form method="POST" action="{{ route('mesa.inscribir_alumno') }}">

                    <input type="hidden" name="mesa_id" value="{{ $mesa->id }}">
                    <label for="alumno_id">Alumno</label>

                    <div class="input-group">
                        <input type="hidden" id="materia_id" value="{{$mesa->materia_id}}">
                        <select name="alumno_id" id="alumno_id" class="form-select" required>
                            @foreach($procesos as $proceso)
                            <option value="{{ $proceso->alumno_id }}">{{mb_strtoupper($proceso->alumno->apellidos).' '.ucwords($proceso->alumno->nombres)}}</option>
                            @endforeach
                        </select>
                        <button class="btn btn-outline-warning me-2" type="submit" id="recargar"><i class="fas fa-sync"></i></button>
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
                    <br>
                    <input type="submit" class="btn btn-success" value="Inscribir">
                </form>
            </div>
        </div>
    </div>
</div>