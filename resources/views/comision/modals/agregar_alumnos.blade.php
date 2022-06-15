<div class="modal fade" id="agregarAlumno" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Administrar Módulos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    <input type="hidden" name="cargo_id" value="{{ $comision->id }}">
                    <div class="form-group">
                        <label for="carreras">Alumnos</label>
                            Primer Año

                            @foreach($alumnos as $alumno)
							
                            
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="alumnos[]" id="{{ $alumno->id }}" value="{{$alumno->id}}">
                                <label class="form-check-label" for="{{ $alumno->id }}">
                                    {{$alumno->apellidos.' '.$alumno->nombres}}
                                </label>
                            </div>
                           
                            
                            @endforeach
                    </div>
                    
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>