<div class="card mt-3">
    <h5 class="card-header">DATOS PERSONALES</h5>
    <div class="card-body">
        <div class="mt-4 row">
            <div class="form-group col-md-6">
                <label for="estado_civil">Estado Civil</label>
                <select name="estado_civil" id="estado_civil" class="form-select">
                    <option value="casado" {{ isset($matriculacion) && $matriculacion->estado_civil == 'casado' ? 'selected="selected"':'' }}>Casado/a</option>
                    <option value="casado2da" {{ isset($matriculacion) && $matriculacion->estado_civil == 'casado2da' ? 'selected="selected"':'' }}>Casado/a 2da Nupcias</option>
                    <option value="casado3ra" {{ isset($matriculacion) && $matriculacion->estado_civil == 'casado3ra' ? 'selected="selected"':'' }}>Casado/a 3ra Nupcias</option>
                    <option value="concubinato" {{ isset($matriculacion) && $matriculacion->estado_civil == 'concubinato' ? 'selected="selected"':'' }}>Concubinato</option>
                    <option value="divorciado" {{ isset($matriculacion) && $matriculacion->estado_civil == 'divorciado' ? 'selected="selected"':'' }}>Divorciado/a</option>
                    <option value="soltero" {{ isset($matriculacion) && $matriculacion->estado_civil == 'soltero' ? 'selected="selected"':'' }}>Soltero/a</option>
                    <option value="viudo" {{ isset($matriculacion) && $matriculacion->estado_civil == 'viudo' ? 'selected="selected"':'' }}>Viudo/a</option>
                </select>
                @error('estado_civil')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group col-md-6">
                <label for="telefono">Teléfono Celular</label>
                <input type="text" name="telefono" id="telefono" value=" {{ isset($matriculacion) ? $matriculacion->telefono : old('telefono') }} " class="form-control"  required>

                @error('telefono')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group col-md-6">
                <label for="telefono_fijo">Teléfono Fijo</label>
                <input type="text" name="telefono_fijo" id="telefono_fijo" value=" {{ isset($matriculacion) ? $matriculacion->telefono_fijo : old('telefono') }} " class="form-control"  >

                @error('telefono_fijo')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group col-md-6">
                <label for="ocupacion">Ocupación</label>
                <select name="ocupacion" id="ocupacion" class="form-select">
                    <option value="ama de casa" {{ isset($matriculacion) && $matriculacion->ocupacion == 'ama de casa' }}>Ama de Casa</option>
                    <option value="empleado" {{ isset($matriculacion) && $matriculacion->ocupacion == 'empleado' }}>Empleado público / privado</option>
                    <option value="estudiante" {{ isset($matriculacion) && $matriculacion->ocupacion == 'estudiante' }}>Estudiante</option>
                    <option value="jubilado" {{ isset($matriculacion) && $matriculacion->ocupacion == 'jubilado' }}>Jubilado / a</option>
                    <option value="obrero" {{ isset($matriculacion) && $matriculacion->ocupacion == 'obrero' }}>Obrero Rural</option>
                    <option value="patron" {{ isset($matriculacion) && $matriculacion->ocupacion == 'patron' }}>Patrón</option>
                    <option value="pensionado" {{ isset($matriculacion) && $matriculacion->ocupacion == 'pensionado' }}>Pensionado / a</option>
                    <option value="profesional" {{ isset($matriculacion) && $matriculacion->ocupacion == 'profesional' }}>Profesional</option>
                    <option value="por su cuenta" {{ isset($matriculacion) && $matriculacion->ocupacion == 'por su cuenta' }}>Trabaja por su cuenta</option>
                    <option value="voluntario" {{ isset($matriculacion) && $matriculacion->ocupacion == 'voluntario' }}>Voluntario</option>
                </select>

                @error('ocupacion')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group col-md-6">
                <label for="g_sanguineo">Grupo Sanguíneo</label>
                <select name="g_sanguineo" id="g_sanguineo" class="form-select">
                    <option value="ab+" {{ isset($matriculacion) && $matriculacion->g_sanguineo == 'ab+' }}>AB +</option>
                    <option value="ab-" {{ isset($matriculacion) && $matriculacion->g_sanguineo == 'ab-' }}>AB -</option>
                    <option value="a+" {{ isset($matriculacion) && $matriculacion->g_sanguineo == 'a+' }}>A +</option>
                    <option value="a-" {{ isset($matriculacion) && $matriculacion->g_sanguineo == 'a-' }}>A -</option>
                    <option value="b+" {{ isset($matriculacion) && $matriculacion->g_sanguineo == 'b+' }}>B +</option>
                    <option value="b-" {{ isset($matriculacion) && $matriculacion->g_sanguineo == 'b-' }}>B -</option>
                    <option value="o+" {{ isset($matriculacion) && $matriculacion->g_sanguineo == 'o+' }}>O +</option>
                    <option value="o-" {{ isset($matriculacion) && $matriculacion->g_sanguineo == 'o-' }}>O -</option>
                </select>

                @error('g_sanguineo')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            @if($año == 1)
            <div class="form-group col-md-6">
                <label for="escuela_s">Escuela Secundaria</label>
                <input type="text" name="escuela_s" id="escuela_s" value=" {{ isset($matriculacion) ? $matriculacion->escuela_s : old('escuela_s') }} " class="form-control" required>

            </div>
            <div class="form-group col-md-6">
                <label for="articulo_septimo">Ingreso por Artículo 7mo</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="articulo_septimo" id="articulo_septimo-si" value="1" {{ isset($matriculacion) && $matriculacion->articulo_septimo == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="articulo_septimo-si">
                        SÍ
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="articulo_septimo" id="articulo_septimo-no" value="0" {{ isset($matriculacion) && $matriculacion->articulo_septimo == 0 ? 'checked' : '' }}>
                    <label class="form-check-label" for="articulo_septimo-no">
                        NO
                    </label>
                </div>
            </div>
            <div class="form-group col-md-6">
                <label for="escolaridad">Finalizó los estudios de Escuela Media</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="escolaridad" id="escolaridad-si" value="1" {{ isset($matriculacion) && $matriculacion->escolaridad == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="escolaridad-si">
                        SÍ
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="escolaridad" id="escolaridad-no" value="0" {{ isset($matriculacion) && $matriculacion->escolaridad == 0 ? 'checked' : '' }}>
                    <label class="form-check-label" for="escolaridad-no">
                        NO
                    </label>
                </div>
            </div>
            <div class="form-group col-md-12">
                <label for="materias_s">Materias que adeuda de Escuela Media (separadas por punto y coma)</label>
                <input type="text" name="materias_s" id="materias_s" value=" {{ isset($matriculacion) ? $matriculacion->materias_s : old('materias_s') }} " class="form-control">

            </div>
            @endif
            <div class="form-group col-md-12">
                <label for="titulo_s">Presentó título definitivo de Escuela Media</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="titulo_s" id="titulo_s-si" value="1" {{ isset($matriculacion) && $matriculacion->titulo_s == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="titulo_s-si">
                        SÍ
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="titulo_s" id="titulo_s-no" value="0" {{ isset($matriculacion) && $matriculacion->titulo_s == 0 ? 'checked' : '' }}>
                    <label class="form-check-label" for="titulo_s-no">
                        NO
                    </label>
                </div>
            </div>
            <div class="form-group col-md-12">
                <label for="privacidad">Estudiante en contextos de privación de libertad o en regímenes semi-abiertos</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="privacidad" id="privacidad-si" value="1" {{ isset($matriculacion) && $matriculacion->privacidad == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="privacidad-si">
                        SÍ
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="privacidad" id="privacidad-no" value="0" {{ isset($matriculacion) && $matriculacion->privacidad == 0 ? 'checked' : '' }}>
                    <label class="form-check-label" for="privacidad-no">
                        NO
                    </label>
                </div>
            </div>

            <div class="form-group col-md-12">
                <label for="poblacion_indigena">Estudiante de Población Indígena</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="poblacion_indigena" id="poblacion_indigena-si" value="1" {{ isset($matriculacion) && $matriculacion->poblacion_indigena == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="poblacion_indigena-si">
                        SÍ
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="poblacion_indigena" id="poblacion_indigena-no" value="0" {{ isset($matriculacion) && $matriculacion->poblacion_indigena == 0 ? 'checked' : '' }}>
                    <label class="form-check-label" for="poblacion_indigena-no">
                        NO
                    </label>
                </div>
            </div>

        </div>
    </div>
</div>