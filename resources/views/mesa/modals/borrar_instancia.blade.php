<div class="modal fade" id="delete{{$instancia->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Borrar datos</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>¿Desea borrar solo las inscripciones o borrar toda la configuración?</p>
            </div>
            <div class="modal-footer">
                <a href="{{route('borrar_datos',['id'=>$instancia->id])}}" class="btn btn-danger">
                    Borrar Todo
                </a>
                <a href="{{route('borrar_datos',['id'=>$instancia->id,'solo'=>'1'])}}" class="btn btn-warning">
                    Borrar solo incripciones
                </a>
            </div>
        </div>
    </div>
</div>