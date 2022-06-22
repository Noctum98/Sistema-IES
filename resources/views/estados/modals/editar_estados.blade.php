<h3>
    Editar un Estado
</h3>
<form action="{{ route('estados.update', ['estado' => $estado->id]) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-row">
        <label for="title">Nombre
            <input type="text" id="nombre" name="nombre" class="form-control"
                   value="{{ old('nombre') ?? $estado->nombre }}" required>
        </label>
    </div>
    <div class="form-row mt-3">
        <button type="submit" class="btn btn-primary btn-lg "> Editar Estado</button>
    </div>
</form>
