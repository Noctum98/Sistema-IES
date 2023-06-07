<div class="modal fade" id="libro_folio_{{$llamado.$mesa->comision_id ?? ''}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-secondary" id="exampleModalLabel">Libro Folio</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if(!$mesa->cierre_profesor)
                <p class="text-danger"><i>Para poder guardar libro y folio el profesor debe cerrar las notas.</i>
                </p>
                @endif

                <input type="hidden" name="mesa_id" id="mesa_id" value="{{$mesa->id}}">
                <input type="hidden" name="llamado" id="llamado" value="{{$llamado}}">
                <form method="POST" action="#" class="mt-3">
                <div class="form-group">
                    <label for="libro">Libro</label>
                    <input type="number" name="numero" id="libro-{{$llamado}}{{$mesa->comision_id?'_'.$mesa->comision_id:''}}" class="form-control" value="{{ $mesa->libro($llamado) ? $mesa->libro($llamado)->numero : '' }}">
                </div>

                @php
                $contador = 1;
                @endphp
                @while($contador <= $folios) 
                    <div class="form-group">
                        <label for="folio">Folio {{ $contador }}</label>
                        <input type="number" name="folios[]" class="form-control folios_{{$llamado}}{{$mesa->comision_id ? '_'.$mesa->comision_id : ''}} {{$contador > 1 ? 'readonly_'.$llamado : 'writeonly_'.$llamado}}" id="folio-{{$llamado.'-'.$contador}}" value="{{ $mesa->libro($llamado,$contador) ? $mesa->libro($llamado,$contador)->folio : '' }}">
                    </div>


                    @php
                    $contador++;
                    @endphp
                @endwhile
                    <input type="submit" class="btn btn-success btn-guardar" data-folio="{{ $llamado.'-'.$contador }}" data-comision_id="{{ $mesa->comision_id }}" data-mesa_id="{{$mesa->id}}" value="Guardar" {{ !$mesa->cierre_profesor ? 'disabled' : '' }}>
                    <span class="d-none" id="spin-{{$llamado}}">
                        <i class="fa fa-spinner fa-spin"></i>
                    </span>
                    <span class="d-none text-success" id="check-{{$llamado}}{{$mesa->comision_id?'_'.$mesa->comision_id:''}}">
                        <i class="fas fa-check"></i>
                    </span>
                    </form>
            </div>
        </div>
    </div>
</div>