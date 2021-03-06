<div class="modal fade" id="exampleModal{{$materia->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-secondary" id="exampleModalLabel">
                    Mesa de {{$materia->nombre}}
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('crear_mesa',['materia_id'=>$materia->id,'instancia_id'=>$instancia->id])}}">
                    @csrf
                    <div class="form-group">
                        <label for="fecha">Fecha y Hora (Primer llamado):</label>
                        <input type="datetime-local" name="fecha" class="form-control" value="{{ $materia->mesa($instancia->id) ? $materia->mesa($instancia->id)->fecha : '' }}" required />
                    </div>
                    <div class="form-group">
                        <label for="presidente">Presidente (Primer llamado):</label>
                        <input type="text" name="presidente" class="form-control" value="{{ $materia->mesa($instancia->id) ? $materia->mesa($instancia->id)->presidente : '' }}" required />
                    </div>
                    <div class="form-group">
                        <label for="primer_vocal">Primer Vocal (Primer llamado):</label>
                        <input type="text" name="primer_vocal" class="form-control" value="{{ $materia->mesa($instancia->id) ? $materia->mesa($instancia->id)->primer_vocal : '' }}"  required />
                    </div>
                    <div class="form-group">
                        <label for="segundo_vocal">Segundo Vocal (Primer llamado):</label>
                        <input type="text" name="segundo_vocal" class="form-control" value="{{ $materia->mesa($instancia->id) ? $materia->mesa($instancia->id)->segundo_vocal : '' }}" required />
                    </div>
                    <div class="form-group">
                        <label for="fecha_segundo">Fecha y Hora (Segundo llamado):</label>
                        <input type="datetime-local" name="fecha_segundo" value="{{ $materia->mesa($instancia->id) ? $materia->mesa($instancia->id)->fecha_segundo : '' }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="presidente">Presidente (Segundo llamado):</label>
                        <input type="text" name="presidente_segundo" value="{{ $materia->mesa($instancia->id) ? $materia->mesa($instancia->id)->presidente_segundo : '' }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="primer_vocal">Primer Vocal (Segundo llamado):</label>
                        <input type="text" name="primer_vocal_segundo" value="{{ $materia->mesa($instancia->id) ? $materia->mesa($instancia->id)->primer_vocal_segundo : '' }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="segundo_vocal">Segundo Vocal (Segundo llamado):</label>
                        <input type="text" name="segundo_vocal_segundo" value="{{ $materia->mesa($instancia->id) ? $materia->mesa($instancia->id)->segundo_vocal_segundo : '' }}" class="form-control">
                    </div>
                   
                    <input type="submit" value="Configurar" class="btn btn-success mt-2" id="loading">
                    
                </form>
            </div>
        </div>
    </div>
</div>
