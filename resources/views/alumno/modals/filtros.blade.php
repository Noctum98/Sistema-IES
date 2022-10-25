<div class="modal fade" id="filtrosAlumnos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-secondary" id="exampleModalLabel">
                    Filtros Alumnos
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="cohorte">Cohorte</label>
                    <input type="text" class="col-md-12 form-control" id="cohorte" name="cohorte" value="{{ $cohorte ?? '' }}">
                </div>
                <div class="form-group">
                    <label for="carreras">Carreras</label>
                    <select name="carrera_id" id="carreras" class="form-select carreras">
                        <option selected='selected' value=''> - Seleccione Carrera -</option>
                        @foreach($sedes as $sede)
                            @foreach($sede->carreras as $carrera)
                                <option value="{{ $carrera->id }}" {{ $carrera->id == $carrera_id ? 'selected' : ' ' }}>{{ $carrera->nombre.' ( '.$carrera->resolucion.' '.$carrera->turno.' ) '.' - '.$carrera->sede->nombre }}</option>
                            @endforeach
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="materias">Materias</label>
                    <select name="materia_id" id="materias" class="form-select materias">

                    </select>
                </div>
                <button type="button" class="btn btn-sm btn-success" id="aplicar_filtros" data-bs-dismiss="modal" aria-label="Close">Aplicar filtros</button>
            </div>

        </div>
    </div>
</div>