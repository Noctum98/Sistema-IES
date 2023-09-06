<div class="modal fade" id="equivalenciasModal{{$alumno->id}}" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-secondary" id="exampleModalLabel">Administrar Equivalencias</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('equivalencias_store') }}" method="POST">
                    <div class="form-group">
                        <label for="carreras">Carreras</label>
                        <select name="carrera" id="carreras" class="form-select carreras" data-alumno="{{$alumno->id}}"
                                data-lectivo="{{$ciclo_lectivo}}">

                            <option selected='selected' value=''> - Seleccione Carrera -</option>
                            @foreach($alumno->carreras()->get() as $carrera)

                                <option
                                    value="{{ $carrera->id }}">{{ $carrera->nombre.' ( '.$carrera->resolucion.' '.$carrera->turno.' ) '.' - '.$carrera->sede->nombre }}</option>

                            @endforeach

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="materia_id">Materias</label>
                        <select name="materia_id" id="materia_id" required class="form-select materias">

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nota">Nota</label>
                        <input type="number" id="nota" name="nota" class="form-control" required/>
                    </div>
                    <div class="form-group">
                        <label for="resolution">N° Resolución</label>
                        <input type="text" id="resolution" name="resolution" class="form-control" required/>
                    </div>
                    <div class="form-group">
                        <label for="fecha">Fecha Resolución</label>
                        <input type="date" id="fecha" name="fecha" class="form-control" required/>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="true" name="flexCheckCohorte" id="flexCheckCohorte">
                        <label class="form-check-label" for="flexCheckCohorte">
                            Cambia cohorte
                        </label>
                    </div>

                    <input type="hidden" name="alumno_id" value="{{$alumno->id}}" id="alumno_id-{{$alumno->id}}">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
