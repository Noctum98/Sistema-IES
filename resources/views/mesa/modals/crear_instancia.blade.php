<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-secondary" id="exampleModalLabel">Crear Instancia</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('crear_instancia')}}">
                    @csrf
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <label for="nombre">Tipo</label>
                        <select name="tipo" class="form-control">
                            <option value="0">Común</option>
                            <option value="1">Especial</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="limite">Limite</label>
                        <input type="number" name="limite" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <label for="limite">Segundo llamado</label>
                        <select name="segundo_llamado" id="segundo_llamado">
                            <option value="1">Habilitado</option>
                            <option value="0">Deshabilitado</option>
                        </select>
                    </div>
                    <input type="submit" class="btn btn-success" value="Crear">
                </form>
            </div>
        </div>
    </div>
</div>
