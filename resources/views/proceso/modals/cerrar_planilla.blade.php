<div class="modal fade" id="cerrarPlanilla" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-info" id="title_modal">Cerrar Planilla</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                <p><b><i>AVISO</i></b></p>
                <p>Una vez cerrada la planilla no podrán modificarse las regularidades y las notas</p>
                </div>

                @if(isset($comision))
                <a href="{{ route('materia.cierre',['materia_id'=>$materia->id,'ciclo_lectivo'=>$ciclo_lectivo,'comision_id'=>$comision->id]) }}" class="btn btn-sm btn-warning"> Cerrar Planilla</a>
                @else
                <a href="{{ route('materia.cierre',['materia_id'=>$materia->id,'ciclo_lectivo'=>$ciclo_lectivo]) }}" class="btn btn-sm btn-warning"> Cerrar Planilla</a>
                @endif
        </div>
    </div>
</div>