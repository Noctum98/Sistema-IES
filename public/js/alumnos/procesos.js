$(document).ready(function () {
    $(".btn-eliminar").click(function(e){
        let proceso_id = $(this).data('proceso_id');
        let url = '/proceso/'+proceso_id;
        $("#alert-eliminar").html('Procesando información...');
        $("#button-eliminar").html("");

        $.get(url, function (response) {
            var proceso = response;
            if(proceso)
            {
                if (
                    (!proceso.final_asistencia || proceso.final_asistencia == 0) &&
                    (!proceso.final_calificaciones || proceso.final_calificaciones == 0) &&
                    (!proceso.final_parciales || proceso.final_parciales == 0) &&
                    (!proceso.final_trabajos || proceso.final_trabajos == 0)
                ) {
                    $("#alert-eliminar").html('<div class="alert alert-warning">Al eliminar el proceso, ya no aparecerá en las planillas del ciclo lectivo correspondiente.</div>');
                    $("#button-eliminar").html('<a class="btn btn-sm btn-danger" href="/proceso/delete/'+proceso.id+'">Eliminar Proceso</a>');
                } else {
                    $("#alert-eliminar").html('<div class="alert alert-danger">El proceso no se puede eliminar, ya que posee notas o asistencia, debes comunicarte con los directivos para informarlo.</div>');
                }
            }
        });
    });
});
