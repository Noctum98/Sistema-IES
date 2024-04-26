<div class="modal fade" id="edit{{$instancia->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
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
                        <label for="tipo">Tipo</label>
                        <select name="tipo" class="form-control">
                            <option value="0" {{$instancia->tipo == 0 ? 'selected="selected"' : ''}}>Común</option>
                            <option value="1" {{$instancia->tipo == 1 ? 'selected="selected"' : ''}}>Especial</option>
                        </select>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="general" type="checkbox" value="1" id="mesaGeneralEdit" {{ $instancia->general ? 'checked' : '' }}>
                        <label class="form-check-label" for="flexCheckChecked">
                            Mesa General
                        </label>
                    </div>

                    <div class="form-group">
                        <label for="sedes">Sedes</label>
                        <select name="sedes[]" id="sedes-edit" class="form-control select2" multiple="multiple" {{ $instancia->general ? 'disabled' : '' }}>
                            @foreach($sedes as $sede)
                            <option value="{{ $sede->id }}" {{ $instancia->hasSede($sede->id) ? 'selected' : '' }}> {{ $sede->nombre }} </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Carreras</label>
                        <select name="carreras[]" id="carreras-edit" class="form-control" multiple="multiple" {{ $instancia->general ? 'disabled' : '' }}>
                            @foreach($instancia->carreras as $carrera)
                                <option value="{{ $carrera->id }}" selected>{{ $carrera->nombre.' - '.$carrera->resolucion.': '.$carrera->sede->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="limite">Limite</label>
                        <input type="number" name="limite" class="form-control" value="{{$instancia->limite}}" required />
                    </div>
                    <div class="form-group">
                        <label for="año">Año</label>
                        <input type="number" name="año" class="form-control" value="{{ $instancia->año }}" required />
                    </div>
                    <div class="form-group">
                        <label for="sedes">Tipo de Notas</label>
                        <select name="year_nota" id="year_nota" class="form-select">
                            <option value="2024" {{ $instancia->year_nota == 2024 ? 'selected' : '' }}> 2024 </option>
                            <option value="2021" {{ $instancia->year_nota == 2021 ? 'selected' : '' }}> 2021 </option>
                        </select>
                    </div>
                    <input type="submit" class="btn btn-success" value="Editar">
                </form>
            </div>
        </div>
    </div>
</div>