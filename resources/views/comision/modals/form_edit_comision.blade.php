<form action="{{ route('comision.update', ['comision_id' => $comision->id]) }}" method="POST">
    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
    <input type="hidden" name="carrera_id" value="{{ $comision->carrera->id }}">
    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="unica" name="unica" value="1" {{ $comision->unica  ? 'checked' : ''}}>
        <label class="form-check-label" for="unica">
            Única
        </label>
    </div>
    <div class="form-group">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ $comision->nombre }}" required />
        @error('nombre')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="form-group">
        <label for="año">Año:</label>
        <input type="number" id="año" name="año" min="1" step="1" max="3" class="form-control @error('año') is-invalid @enderror" value="{{ $comision->año }}" required />
        @error('año')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror

    </div>

    <div class="form-group">
        <label for="ciclo_lectivo">Ciclo Lectivo:</label>
        <select id="ciclo_lectivo" name="ciclo_lectivo" class="form-select @error('ciclo_lectivo') is-invalid @enderror" required>
            @foreach($ciclos_lectivos as $ciclo_lectivo)
            <option value="{{$ciclo_lectivo}}" {{ $ciclo_lectivo == $comision->ciclo_lectivo ? 'selected' : '' }}>{{ $ciclo_lectivo }}</option>
            @endforeach
        </select>
        @error('ciclo_lectivo')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </div>
</form>