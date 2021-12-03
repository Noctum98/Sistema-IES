<!---
<div class="modal fade" id="editModal{{$materia->id}}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Mesa de {{$materia->nombre}}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('editar_mesa',['id'=>$materia->id])}}">
                    @csrf
                    <div class="form-group">
                        <label for="fecha">Fecha y Hora (Primer llamado):</label>
                        <input type="datetime-local" name="fecha" class="form-control" value="{{ $mesa->fecha }}" required>
                    </div>
                    <div class="form-group">
                        <label for="presidente">Presidente (Primer llamado):</label>
                        <input type="text" name="presidente" class="form-control" value="{{ $mesa->presidente }}" required>
                    </div>
                    <div class="form-group">
                        <label for="primer_vocal">Primer Vocal (Primer llamado):</label>
                        <input type="text" name="primer_vocal" class="form-control" value="{{ $mesa->primer_vocal }}" required>
                    </div>
                    <div class="form-group">
                        <label for="segundo_vocal">Segundo Vocal (Primer llamado):</label>
                        <input type="text" name="segundo_vocal" class="form-control" value="{{ $mesa->segundo_vocal }}" required>
                    </div>
                    <div class="form-group">
                        <label for="fecha_segundo">Fecha y Hora (Segundo llamado):</label>
                        <input type="datetime-local" name="fecha_segundo" class="form-control" value="{{ $mesa->fecha_segundo }}">
                    </div>
                    <div class="form-group">
                        <label for="presidente">Presidente (Segundo llamado):</label>
                        <input type="text" name="presidente_segundo" class="form-control" value="{{ $mesa->presidente_segundo }}">
                    </div>
                    <div class="form-group">
                        <label for="primer_vocal">Primer Vocal (Segundo llamado):</label>
                        <input type="text" name="primer_vocal_segundo" class="form-control" value="{{ $mesa->primer_vocal_segundo }}">
                    </div>
                    <div class="form-group">
                        <label for="segundo_vocal">Segundo Vocal (Segundo llamado):</label>
                        <input type="text" name="segundo_vocal_segundo" class="form-control" value="{{ $mesa->segundo_vocal_segundo }}">
                    </div>
                    <input type="submit" value="Editar Mesa" class="btn btn-success mt-2" id="loading">
                </form>
            </div>
        </div>
    </div>
</div>
--->
<div class="modal fade" id="editModal{{$materia->id}}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Mesa de {{$materia->nombre}}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('editar_mesa',['id'=>$materia->id])}}">
                    @csrf
                    <div class="form-group">
                        <label for="fecha">Fecha y Hora (Primer llamado):</label>
                        <input type="datetime-local" name="fecha" class="form-control" value="{{ $materia->mesa($instancia->id,$materia->id)->fecha }}" required>
                    </div>
                    <div class="form-group">
                        <label for="presidente">Presidente (Primer llamado):</label>
                        <input type="text" name="presidente" class="form-control" value="{{ $materia->mesa($instancia->id,$materia->id)->presidente }}" required>
                    </div>
                    <div class="form-group">
                        <label for="primer_vocal">Primer Vocal (Primer llamado):</label>
                        <input type="text" name="primer_vocal" class="form-control" value="{{ $materia->mesa($instancia->id,$materia->id)->primer_vocal }}" required>
                    </div>
                    <div class="form-group">
                        <label for="segundo_vocal">Segundo Vocal (Primer llamado):</label>
                        <input type="text" name="segundo_vocal" class="form-control" value="{{ $materia->mesa($instancia->id,$materia->id)->segundo_vocal }}" required>
                    </div>
                    <div class="form-group">
                        <label for="fecha_segundo">Fecha y Hora (Segundo llamado):</label>
                        <input type="datetime-local" name="fecha_segundo" class="form-control" value="{{ $materia->mesa($instancia->id,$materia->id)->fecha_segundo }}">
                    </div>
                    <div class="form-group">
                        <label for="presidente">Presidente (Segundo llamado):</label>
                        <input type="text" name="presidente_segundo" class="form-control" value="{{ $materia->mesa($instancia->id,$materia->id)->presidente_segundo }}">
                    </div>
                    <div class="form-group">
                        <label for="primer_vocal">Primer Vocal (Segundo llamado):</label>
                        <input type="text" name="primer_vocal_segundo" class="form-control" value="{{ $materia->mesa($instancia->id,$materia->id)->primer_vocal_segundo }}">
                    </div>
                    <div class="form-group">
                        <label for="segundo_vocal">Segundo Vocal (Segundo llamado):</label>
                        <input type="text" name="segundo_vocal_segundo" class="form-control" value="{{ $materia->mesa($instancia->id,$materia->id)->segundo_vocal_segundo }}">
                    </div>
                    <input type="submit" value="Editar Mesa" class="btn btn-success mt-2" id="loading">
                </form>
            </div>
        </div>
    </div>
</div>