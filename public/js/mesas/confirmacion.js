$(document).ready(function () {
    var inscripcion_id = 0;
    var materia_id = 0;

    $('.inscripcion_id').click(function(e){
        e.preventDefault();

        inscripcion_id = $(this).data('inscripcion_id');
        materia_id = $(this).data('materia_id');

        


        let url = 'mesas/verificarInscripcion/'+inscripcion_id+'/'+materia_id;

        console.log(url);
        /*
        let url = '/mesas/confirmar/'+inscripcion_id;

        console.log(inscripcion_id,url);
    
        $.ajax({
            method: "POST",
            url: url,
            data: {},
            //dataType: "dataType",
            success: function (response) {
                if(response.status == 'success')
                {
                    $("#confirmado-"+response.inscripcion.id).removeClass('d-none');
                    $('#'+response.inscripcion.id).addClass('d-none');
                    $("#asignar-"+response.inscripcion.id).attr('disabled',false);
                }
            }
        });*/
    });
    
});