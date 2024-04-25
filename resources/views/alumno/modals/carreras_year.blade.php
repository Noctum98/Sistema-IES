<div class="modal fade" id="carrerasAñoModal{{$inscripcion->carrera_id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-secondary" id="exampleModalLabel">
                    Editar Datos
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('alumnoCarrera.year',['inscripcion_id'=>$inscripcion->id]) }}" method="POST">
                    @csrf

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="year" id="flexRadioDefault1" value="1" {{ $alumno->lastProcesoCarrera($inscripcion->carrera_id)->año == 1 ? 'checked' : ''}}>
                        <label class="form-check-label" for="flexRadioDefault1">
                            PRIMER AÑO
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="year" id="flexRadioDefault2" value="2" {{ $alumno->lastProcesoCarrera($inscripcion->carrera_id)->año == 2 ? 'checked' : ''}}>
                        <label class="form-check-label" for="flexRadioDefault2">
                            SEGUNDO AÑO
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="year" id="flexRadioDefault3" value="3" {{ $alumno->lastProcesoCarrera($inscripcion->carrera_id)->año == 3 ? 'checked' : ''}}>
                        <label class="form-check-label" for="flexRadioDefault3">
                            TERCER AÑO
                        </label>
                    </div>
                    <hr>

                    @if(Session::has('admin') || Session::has('regente') || Session::has('coordinador') || Session::has('seccionAlumnos'))
                    <div class="form-group">
                        <label for="cohorte">Cohorte:</label>
                        <input type="number" class="form-control" name="cohorte" id="cohorte" value="{{ $inscripcion->cohorte ?? null }}">
                    </div>
                    @else
                    <div class="form-group">
                        <label for="cohorte">Cohorte:</label>
                        <input type="number" class="form-control" name="cohorte" id="cohorte" value="{{ $inscripcion->cohorte ?? null }}" disabled>
                    </div>
                    @endif
                    @if($inscripcion->año == 1)
                    <div class="form-group">
                        <label for="regularidad">Condición:</label>
                        <select name="regularidad" id="regularidad" class="form-select">
                            <option value="regular_primero" {{ isset($inscripcion) && $inscripcion->regularidad == 'regular_primero' ? "selected='selected'":'' }}>REGULAR</option>
                            <option value="condicional_primero" {{ isset($inscripcion) && $inscripcion->regularidad == 'condicional_primero' ? "selected='selected'":'' }}>CONDICIONAL</option>
                            <option value="recursante_primero" {{ isset($inscripcion) && $inscripcion->regularidad == 'recursante_primero' ? "selected='selected'":'' }}>RECURSANTE</option>
                            <option value="recursante_diferenciado_primero" {{ isset($inscripcion) && $inscripcion->regularidad == 'recursante_diferenciado_primero' ? "selected='selected'":'' }}>RECURSANTE CON TRAYECTORIA DIFERENCIADA</option>
                            <option value="reinscripto_primero" {{ isset($inscripcion) && $inscripcion->regularidad == 'reinscripto_primero' ? "selected='selected'":'' }}>REINSCRIPTO</option>

                        </select>
                    </div>
                    @elseif($inscripcion->año == 2)
                    <div class="form-group">
                        <label for="regularidad">Condición</label>
                        <select name="regularidad" id="regularidad" class="form-select">
                            <option value="regular_segundo" {{ isset($inscripcion) && $inscripcion->regularidad == 'regular_segundo' ? "selected='selected'":'' }}>REGULAR</option>
                            <option value="condicional_segundo" {{ isset($inscripcion) && $inscripcion->regularidad == 'condicional_segundoo' ? "selected='selected'":'' }}>CONDICIONAL</option>
                            <option value="recursante_segundo" {{ isset($inscripcion) && $inscripcion->regularidad == 'recursante_segundo' ? "selected='selected'":'' }}>RECURSANTE</option>
                            <option value="recursante_diferenciado_segundo" {{ isset($inscripcion) && $inscripcion->regularidad == 'recursante_diferenciado_segundo' ? "selected='selected'":'' }}>RECURSANTE CON TRAYECTORIA DIFERENCIADA</option>
                        </select>
                    </div>
                    @elseif($inscripcion->año == 3)
                    <div class="form-group">
                        <label for="regularidad">Condición</label>
                        <select name="regularidad" id="regularidad" class="form-select">
                            <option value="regular_tercero" {{ isset($inscripcion) && $inscripcion->regularidad == 'regular_tercero' ? "selected='selected'":'' }}>REGULAR</option>
                            <option value="condicional_tercero" {{ isset($inscripcion) && $inscripcion->regularidad == 'condicional_tercero' ? "selected='selected'":'' }}>CONDICIONAL</option>
                            <option value="recursante_tercero" {{ isset($inscripcion) && $inscripcion->regularidad == 'recursante_tercero' ? "selected='selected'":'' }}>RECURSANTE</option>
                            <option value="recursante_diferenciado_tercero" {{ isset($inscripcion) && $inscripcion->regularidad == 'recursante_diferenciado_tercero' ? "selected='selected'":'' }}>RECURSANTE CON TRAYECTORIA DIFERENCIADA</option>
                        </select>
                    </div>
                    @endif

                    <div class="form-group">
                        <div class="form-group col-md-12">
                            <label for="legajo_completo">Legajo Completo: </label>
                            <div class="form-check-inline">
                                <input class="form-check-input" type="radio" name="legajo_completo" id="legajo_completo-si" value="1" {{ isset($inscripcion) && $inscripcion->legajo_completo == 1 || old('legajo_completo') ? 'checked' : '' }}>
                                <label class="form-check-label" for="legajo_completo-si">
                                    Si
                                </label>
                            </div>
                            <div class="form-check-inline">
                                <input class="form-check-input" type="radio" name="legajo_completo" id="legajo_completo-no" value="0" {{ isset($inscripcion) && $inscripcion->legajo_completo == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="legajo_completo-no">
                                    No
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="fecha_primera_acreditacion">Fecha Primera Acreditación:</label>
                        <input type="date" id="fecha_primera_acreditacion" name="fecha_primera_acreditacion" class="form-control @error('fecha_primera_acreditacion') is-invalid @enderror" value="{{ $inscripcion->fecha_primera_acreditacion ?? '' }}" />

                        @error('fecha_primera_acreditacion')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="fecha_ultima_acreditacion">Fecha Última Acreditación:</label>
                        <input type="date" id="fecha_ultima_acreditacion" name="fecha_ultima_acreditacion" class="form-control @error('fecha_ultima_acreditacion') is-invalid @enderror" value="{{ $inscripcion->fecha_ultima_acreditacion ?? '' }}" />

                        @error('fecha_ultima_acreditacion')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
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