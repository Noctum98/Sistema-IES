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
                        <select name="tipo" class="form-select">
                            <option value="0">Común</option>
                            <option value="1">Especial</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="nombre">Tipo Instancia</label>
                        <select name="tipo_instancia_id" class="form-select">
                        @foreach($tipo_instancias as $tipo_instancia)
                            <option value="{{ $tipo_instancia->id }}">{{ $tipo_instancia->name }}</option>

                        @endforeach
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
                        <select name="sedes[]" id="sedes" class="form-control select2-sedes" multiple="multiple">
                            @foreach($sedes as $sede)
                            <option value="{{ $sede->id }}"> {{ $sede->nombre }} </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Carreras</label>
                        <select name="carreras[]" id="carreras" class="form-control select2-carreras" multiple="multiple">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="limite">Limite</label>
                        <input type="number" name="limite" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <label for="año">Año</label>
                        <input type="number" name="año" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <label for="sedes">Tipo de Notas</label>
                        <select name="year_nota" id="year_nota" class="form-select">
                            <option value="2024" selected> 2024 </option>
                            <option value="2021"> 2021 </option>
                        </select>
                    </div>
                    <input type="submit" class="btn btn-success" value="Crear">
                </form>
            </div>
        </div>
    </div>
</div>