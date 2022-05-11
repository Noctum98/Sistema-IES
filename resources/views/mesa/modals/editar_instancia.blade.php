<div class="modal fade" id="edit{{$instancia->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-secondary" id="exampleModalLabel">Editar instancia</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('editar_instancia',['id'=>$instancia->id])}}">
                    @csrf
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" class="form-control" value="{{$instancia->nombre}}" required />
                    </div>
                    <div class="form-group">
                        <label for="nombre">Tipo</label>
                        <select name="tipo" class="form-control">
                            <option value="0" {{$instancia->tipo == 0 ? 'selected="selected"' : ''}}>Común</option>
                            <option value="1" {{$instancia->tipo == 1 ? 'selected="selected"' : ''}}>Especial</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="limite">Limite</label>
                        <input type="number" name="limite" class="form-control" value="{{$instancia->limite}}" required />
                    </div>
                    <div class="form-group">
                        <label for="limite">Segundo llamado</label>
                        <input type="date" name="segundo_llamado" class="form-control" value="{{$instancia->segundo_llamado}}">
                    </div>
                    <input type="submit" class="btn btn-success" value="Editar">
                </form>
            </div>
        </div>
    </div>
</div>
