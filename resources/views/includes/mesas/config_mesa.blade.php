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
                    @if($materia->getTotalAttribute() > 0)
                    <div class="form-group">
                        <label for="comision_id">Comisión</label>
                        <select name="comision_id" id="comision_id-{{ $materia->id }}" data-materia="{{$materia->id}}" data-instancia_id="{{$instancia->id}}" class="form-select comision_id">
                            <option value="">-- Seleccionar comisión --</option>
                            @foreach($materia->comisiones as $comision)
                                <option value="{{ $comision->id }}">{{ $comision->nombre }}</option>
                            @endforeach
                        </select>
                        <div id="spinner-comision-{{$materia->id}}" class="d-none m-1">
                            <i class="fa fa-spinner fa-spin"></i>
                        </div>
                    </div>
                    @endif
                    <div id="form-config-{{$materia->id}}" class="{{$materia->getTotalAttribute() > 0 ? 'd-none' : ''}}">
                        <div class="form-group">
                            <label for="fecha">Fecha y Hora (Primer llamado):</label>
                            <input type="datetime-local" id="fecha-{{$materia->id}}" name="fecha" class="form-control" value="{{ $materia->mesa($instancia->id) ? $materia->mesa($instancia->id)->fecha : '' }}" required />
                        </div>
                        <div class="form-group">
                            <label for="presidente">Presidente (Primer llamado):</label>
                            <input type="text" id="presidente-{{$materia->id}}" name="presidente" class="form-control" value="{{ $materia->mesa($instancia->id) ? $materia->mesa($instancia->id)->presidente : '' }}" required />
                        </div>
                        <div class="form-group">
                            <label for="primer_vocal">Primer Vocal (Primer llamado):</label>
                            <input type="text" id="primer_vocal-{{$materia->id}}" name="primer_vocal" class="form-control" value="{{ $materia->mesa($instancia->id) ? $materia->mesa($instancia->id)->primer_vocal : '' }}" required />
                        </div>
                        <div class="form-group">
                            <label for="segundo_vocal">Segundo Vocal (Primer llamado):</label>
                            <input type="text" id="segundo_vocal-{{$materia->id}}" name="segundo_vocal" class="form-control" value="{{ $materia->mesa($instancia->id) ? $materia->mesa($instancia->id)->segundo_vocal : '' }}" required />
                        </div>
                        <div class="form-group">
                            <label for="fecha_segundo">Fecha y Hora (Segundo llamado):</label>
                            <input type="datetime-local" id="fecha_segundo-{{$materia->id}}" name="fecha_segundo" value="{{ $materia->mesa($instancia->id) ? $materia->mesa($instancia->id)->fecha_segundo : '' }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="presidente">Presidente (Segundo llamado):</label>
                            <input type="text" id="presidente_segundo-{{$materia->id}}" name="presidente_segundo" value="{{ $materia->mesa($instancia->id) ? $materia->mesa($instancia->id)->presidente_segundo : '' }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="primer_vocal">Primer Vocal (Segundo llamado):</label>
                            <input type="text" id="primer_vocal_segundo-{{$materia->id}}" name="primer_vocal_segundo" value="{{ $materia->mesa($instancia->id) ? $materia->mesa($instancia->id)->primer_vocal_segundo : '' }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="segundo_vocal">Segundo Vocal (Segundo llamado):</label>
                            <input type="text" id="segundo_vocal_segundo-{{$materia->id}}" name="segundo_vocal_segundo" value="{{ $materia->mesa($instancia->id) ? $materia->mesa($instancia->id)->segundo_vocal_segundo : '' }}" class="form-control">
                        </div>
                        <select class="js-data-example-ajax" id="{{$materia->carrera}}"></select>

                        <input type="submit" value="Configurar" class="btn btn-success mt-2" id="loading">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
