<div class="card mt-3">
    <h5 class="card-header">INFORMACIÓN DISCAPACIDAD</h5>
    <div class="card-body">
        <h5 class="card-title">Los datos que se solicitan están destinados a establecer mecanismos de acompañamiento y seguimiento Institucional. </h5>

        <div class="mt-4 row">
            <div class="form-group col-md-6">
                <label for="discapacidad_mental">Discapacidad Mental</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="discapacidad_mental" id="discapacidad_mental-si" value="1" {{ isset($matriculacion) && $matriculacion->discapacidad_mental == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="discapacidad_mental-si">
                        SI
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="discapacidad_mental" id="discapacidad_mental-no" value="0" {{ isset($matriculacion) && $matriculacion->discapacidad_mental == 0 ? 'checked' : '' }}>
                    <label class="form-check-label" for="discapacidad_mental-no">
                        NO
                    </label>
                </div>
            </div>
            <div class="form-group col-md-6">
                <label for="discapacidad_visual">Discapacidad Visual</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="discapacidad_visual" id="discapacidad_visual-si" value="1" {{ isset($matriculacion) && $matriculacion->discapacidad_visual == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="discapacidad_visual-si">
                        SI
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="discapacidad_visual" id="discapacidad_visual-no" value="0" {{ isset($matriculacion) && $matriculacion->discapacidad_visual == 0 ? 'checked' : '' }}>
                    <label class="form-check-label" for="discapacidad_visual-no">
                        NO
                    </label>
                </div>
            </div>
            <div class="form-group col-md-6">
                <label for="discapacidad_motriz">Discapacidad Motriz</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="discapacidad_motriz" id="discapacidad_motriz-si" value="1" {{ isset($matriculacion) && $matriculacion->discapacidad_motriz == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="discapacidad_motriz-si">
                        SI
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="discapacidad_motriz" id="discapacidad_motriz-no" value="0" {{ isset($matriculacion) && $matriculacion->discapacidad_motriz == 0 ? 'checked' : '' }}>
                    <label class="form-check-label" for="discapacidad_motriz-no">
                        NO
                    </label>
                </div>
            </div>
            <div class="form-group col-md-6">
                <label for="acompañamiento_motriz">Acompañamiento por discapacidad Motriz</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="acompañamiento_motriz" id="acompañamiento_motriz-si" value="0" {{ isset($matriculacion) && $matriculacion->acompañamiento_motriz == 0 ? 'checked' : '' }}>
                    <label class="form-check-label" for="acompañamiento_motriz-si">
                        SI
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="acompañamiento_motriz" id="acompañamiento_motriz-no" value="1" {{ isset($matriculacion) && $matriculacion->acompañamiento_motriz == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="acompañamiento_motriz-no">
                        NO
                    </label>
                </div>
            </div>
            <div class="form-group col-md-6">
                <label for="discapacidad_intelectual">Discapacidad Intelectual</label>
                <select name="discapacidad_intelectual" id="discapacidad_intelectual" class="form-select">
                    <option value="ninguna" {{ isset($matriculacion) && $matriculacion->discapacidad_intelectual == 'ninguna' ? 'selected="selected"' : '' }}>Ninguna</option>
                    <option value="nivel leve" {{ isset($matriculacion) && $matriculacion->discapacidad_intelectual == 'nivel leve' ? 'selected="selected"' : '' }}>Nivel Leve</option>
                    <option value="nivel moderado" {{ isset($matriculacion) && $matriculacion->discapacidad_intelectual == 'nivel moderado' ? 'selected="selected"' : '' }}>Nivel Moderado</option>
                    <option value="nivel profundo" {{ isset($matriculacion) && $matriculacion->discapacidad_intelectual == 'nivel profundo' ? 'selected="selected"' : '' }}>Nivel Profundo</option>
                </select>

                @error('discapacidad_intelectual')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group col-md-6">
                <label for="discapacidad_auditiva">Discapacidad Auditiva</label>
                <select name="discapacidad_auditiva" id="discapacidad_auditiva" class="form-select">
                    <option value="hipocausia leve" {{ isset($matriculacion) && $matriculacion->discapacidad_auditiva == 'hipocausia leve' ? 'selected="selected"' : '' }}>Hipocausia Leve</option>
                    <option value="hipocausia moderada" {{ isset($matriculacion) && $matriculacion->discapacidad_auditiva == 'hipocausia moderada' ? 'selected="selected"' : '' }}>Hipocausia Moderada</option>
                    <option value="hipocausia severa" {{ isset($matriculacion) && $matriculacion->discapacidad_auditiva == 'hipocausia severa' ? 'selected="selected"' : '' }}>Hipocausia Severa</option>
                    <option value="hipocausia profunda" {{ isset($matriculacion) && $matriculacion->discapacidad_auditiva == 'hipocausia profunda' ? 'selected="selected"' : '' }}>Hipocausia Profunda</option>
                    <option value="sordera" {{ isset($matriculacion) && $matriculacion->discapacidad_auditiva == 'sordera' ? 'selected="selected"' : '' }}>Sordera</option>
                    <option value="ninguna" {{ isset($matriculacion) && $matriculacion->discapacidad_auditiva == 'ninguna' ? 'selected="selected"' : '' }}>Ninguna</option>
                </select>

                @error('discapacidad_auditiva')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group col-md-12">
                <label for="pase">INGRESO POR PASE</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="pase" id="no" value="no" {{ isset($matriculacion) && $matriculacion->pase == 'no' ? 'checked' : '' }}>
                    <label class="form-check-label" for="no">
                       NO
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="pase" id="pase_interno" value="pase_interno" {{ isset($matriculacion) && $matriculacion->pase == 'pase_interno' ? 'checked' : '' }}>
                    <label class="form-check-label" for="pase_interno">
                        INGRESO POR PASE INTERNO
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="pase" id="pase_otra_institucion" value="pase_otra_institucion" {{ isset($matriculacion) && $matriculacion->pase == 'pase_otra_institucion' ? 'checked' : '' }}>
                    <label class="form-check-label" for="pase_otra_institucion">
                        INGRESO POR PASE DE OTRA INSTITUCIÓN
                    </label>
                </div>
            </div>
            <div class="form-group col-md-12">
                <label for="pase">SOLICITUD DE MATRICULACIÓN</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" id="matriculacion" name="matriculacion" {{ isset($matriculacion) && $matriculacion->matriculacion == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="matriculacion">
                        Acepto la matriculacion
                    </label>
                </div>
            </div>
        </div>

    </div>
</div>