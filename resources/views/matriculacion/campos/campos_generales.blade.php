<div class="card mt-3">
    <h5 class="card-header text-secondary">DATOS GENERALES</h5>
    <div class="card-body">
        <h5 class="card-title text-secondary">
            Le recordamos que es necesario que realice la inscripción brindando los datos sin errores y de acuerdo a la documentación que presenta y adjunta en su legajo.
        </h5>
        <div class="mt-4 row">
            <div class="form-group col-md-6">
                <label for="nombre">Nombres</label>
                <input type="text" name="nombres" id="nombres" value="{{ isset($matriculacion) ? $matriculacion->nombres : old('nombres') }}" class="form-control" required />

                @error('nombres')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group col-md-6">
                <label for="apellidos">Apellidos</label>
                <input type="text" name="apellidos" id="apellidos" value="{{ isset($matriculacion) ? $matriculacion->apellidos : old('apellidos') }}" class="form-control" required />

                @error('apellidos')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group col-md-6">
                <label for="dni">D.N.I o Pasaporte</label>
                <input type="number" name="dni" id="dni" value="{{ isset($matriculacion) ? $matriculacion->dni : old('dni') }}" class="form-control" required />

                @error('dni')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group col-md-6">
                <label for="cuil">CUIL</label>
                <input type="text" name="cuil" id="cuil" value="{{ isset($matriculacion) ? $matriculacion->cuil : old('cuil') }}" class="form-control" required />

                @error('cuil')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group col-md-6">
                <label for="fecha">Fecha de Nacimiento</label>
                <input type="date" name="fecha" id="fecha" class="form-control" value="{{ isset($matriculacion) ? $matriculacion->fecha : old('fecha') }}" required />

                @error('fecha')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group col-md-6">
                <label for="edad">Edad</label>
                <input type="text" name="edad" id="edad" value=" {{ isset($matriculacion) ? $matriculacion->edad : old('edad') }} " class="form-control" required />

                @error('edad')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group col-md-6">
                <label for="nacionalidad">Nacionalidad</label>
                <select name="nacionalidad" id="nacionalidad" class="form-select">
                    <option value="argentina" {{ isset($matriculacion) && $matriculacion->nacionalidad == 'argentina' ? 'selected="selected"' : '' }}>Argentina</option>
                    <option value="bolivia" {{ isset($matriculacion) && $matriculacion->nacionalidad == 'bolivia' ? 'selected="selected"' : '' }}>Bolivia</option>
                    <option value="brasil" {{ isset($matriculacion) && $matriculacion->nacionalidad == 'brasil' ? 'selected="selected"' : '' }}>Brasil</option>
                    <option value="chile" {{ isset($matriculacion) && $matriculacion->nacionalidad == 'chile' ? 'selected="selected"' : '' }}>Chile</option>
                    <option value="colombia" {{ isset($matriculacion) && $matriculacion->nacionalidad == 'colombia' ? 'selected="selected"' : '' }}>Colombia</option>
                    <option value="ecuador" {{ isset($matriculacion) && $matriculacion->nacionalidad == 'ecuador' ? 'selected="selected"' : '' }}>Ecuador</option>
                    <option value="paraguay" {{ isset($matriculacion) && $matriculacion->nacionalidad == 'paraguay' ? 'selected="selected"' : '' }}>Paraguay</option>
                    <option value="perú" {{ isset($matriculacion) && $matriculacion->nacionalidad == 'perú' ? 'selected="selected"' : '' }}>Perú</option>
                    <option value="uruguay" {{ isset($matriculacion) && $matriculacion->nacionalidad == 'uruguay' ? 'selected="selected"' : '' }}>Uruguay</option>
                    <option value="venezuela" {{ isset($matriculacion) && $matriculacion->nacionalidad == 'venezuela' ? 'selected="selected"' : '' }}>Venezuela</option>
                    <option value="otro" {{ isset($matriculacion) && $matriculacion->nacionalidad == 'otro' ? 'selected="selected"' : '' }}>Otro país de America</option>
                    <option value="europa" {{ isset($matriculacion) && $matriculacion->nacionalidad == 'europa' ? 'selected="selected"' : '' }}>Europa</option>
                    <option value="asia" {{ isset($matriculacion) && $matriculacion->nacionalidad == 'asia' ? 'selected="selected"' : '' }}>Asia</option>
                </select>
            </div>
            <!-------
            <div class="form-group col-md-6">
                <label for="otra">Otra nacionalidad</label>
                <input type="text" name="nacionalidad_otra" id="otra" value=" {{ isset($matriculacion) ? $matriculacion->nacionalidad_otra : old('nacionalidad_otra') }} " class="form-control">
            </div>
            ---------->
            <div class="form-group col-md-6">
                <label for="genero">Género</label>
                <select name="genero" id="genero" class="form-select">
                    <option value="masculino" {{ isset($matriculacion) && $matriculacion->genero == 'masculino' ? 'selected="selected"' : '' }}>Masculino</option>
                    <option value="femenino" {{ isset($matriculacion) && $matriculacion->genero == 'femenino' ? 'selected="selected"' : '' }}>Femenino</option>
                    <option value="no_binario" {{ isset($matriculacion) && $matriculacion->genero == 'no_binario' ? 'selected="selected"' : '' }}>No binario</option>
                </select>
            </div>
        </div>
    </div>
</div>
