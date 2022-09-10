$(document).ready(function () {

    $('.inscripcion_id').click(function(e){
        e.preventDefault();

        let inscripcion_id = $(".inscripcion_id").attr('id');
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
                    $("#nota-"+response.inscripcion.id).removeClass('d-none');
                    $('#'+response.inscripcion.id).addClass('d-none');
                }
            }
        });
    });
    
});