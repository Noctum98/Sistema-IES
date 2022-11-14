<div class="modal fade" id="cerrarActa{{$mesa->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-info" id="exampleModalLabel">Cerrar Acta Volante</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>¿Estas seguro de cerrar el acta volante? Posteriormente no va a poder ser modificado.</p>
            </div>
            <div class="modal-footer">
                <form action="{{route('mesa.cerrar_acta',['mesa_id'=>$mesa->id])}}" method="POST">
                    {{method_field('PUT')}}
                    <input type="submit" value="Cerrar Acta Volante" class="btn btn-sm btn-warning">
                </form>
            </div>
        </div>
    </div>
</div>
