<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
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

                    <div class="form-check">
                        <input class="form-check-input" name="general" type="checkbox" value="1" id="mesaGeneral">
                        <label class="form-check-label" for="flexCheckChecked">
                            Mesa General
                        </label>
                    </div>

                    <div class="form-group">
                        <label for="sedes">Sedes</label>
                        <select name="sedes[]" id="sedes" class="form-control select2" multiple="multiple">
                            @foreach($sedes as $sede)
                            <option value="{{ $sede->id }}"> {{ $sede->nombre }} </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Carreras</label>
                        <select name="carreras[]" id="carreras" class="form-control" multiple="multiple">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="limite">Limite</label>
                        <input type="number" name="limite" class="form-control" required />
                    </div>
                    <input type="submit" class="btn btn-success" value="Crear">
                </form>
            </div>
        </div>
    </div>
</div>