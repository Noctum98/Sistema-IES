<div class="card mt-3">
    <h5 class="card-header">DATOS DOMICILIO</h5>
    <div class="card-body">
        <h5 class="card-title">
            Consignar los datos completos de su actual domicilio
        </h5>
        <div class="mt-4 row">
            <div class="form-group col-md-6">
                <label for="provincia">Provincia</label>
                <input type="text" name="provincia" id="provincia" value=" {{ isset($matriculacion) ? $matriculacion->provincia : old('provincia') }} " class="form-control" required />

                @error('provincia')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group col-md-6">
                <label for="localidad">Localidad</label>
                <input type="text" name="localidad" id="localidad" value=" {{ isset($matriculacion) ? $matriculacion->localidad : old('localidad') }} " class="form-control" required />

                @error('localidad')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group col-md-6">
                <label for="calle">Calle</label>
                <input type="text" name="calle" id="calle" value=" {{ isset($matriculacion) ? $matriculacion->calle : old('calle') }} " class="form-control" required />

                @error('calle')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group col-md-6">
                <label for="n_calle">Número</label>
                <input type="text" name="n_calle" id="n_calle" value=" {{ isset($matriculacion) ? $matriculacion->n_calle : old('n_calle') }} " class="form-control" required />

                @error('n_calle')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group col-md-6">
                <label for="barrio">Barrio</label>
                <input type="text" name="barrio" id="barrio" value=" {{ isset($matriculacion) ? $matriculacion->barrio : old('barrio') }} " class="form-control">

                @error('barrio')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group col-md-6">
                <label for="manzana">Manzana</label>
                <input type="text" name="manzana" id="manzana" value=" {{ isset($matriculacion) ? $matriculacion->manzana : old('manzana') }} " class="form-control">

                @error('manzana')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group col-md-6">
                <label for="casa">Casa</label>
                <input type="text" name="casa" id="casa" value=" {{ isset($matriculacion) ? $matriculacion->casa : old('casa') }} " class="form-control">

                @error('casa')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group col-md-6">
                <label for="codigo_postal">Código Postal</label>
                <input type="text" name="codigo_postal" id="codigo_postal" value=" {{ isset($matriculacion) ? $matriculacion->codigo_postal : old('codigo_postal') }} " class="form-control" required />

                @error('codigo_postal')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
    </div>
</div>