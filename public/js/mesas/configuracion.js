$(document).ready(function () {

    $('.comision_id').change(function() {
        let materia_id = $(this).data('materia');
        let instancia_id = $(this).data('instancia_id');
        let comision_id = $(this).val();

        let url = '/mesas/mesaByComision/'+materia_id+'/'+comision_id+'/'+instancia_id;
        $("#spinner-comision-"+materia_id).removeClass('d-none');

        $.ajax({
            method: "GET",
            url: url,
            //dataType: "dataType",
            success: function (response) {

                $("#spinner-comision-"+materia_id).addClass('d-none');
                $("#form-config-"+materia_id).removeClass('d-none');

                if(response.status == 'success')
                {
                    setFormData(response.mesa,materia_id);
                }else{
                    emptyFormData(materia_id);
                }
             
            },
            error: function (error)
            {
                if(!$("#form-config-"+materia_id).hasClass('d-none'))
                {
                    $("#form-config-"+materia_id).addClass('d-none');
                    $("#spinner-comision-"+materia_id).addClass('d-none');

                }
            }
        });
    });

    function setFormData(mesa,materia_id)
    {
        $("#fecha-"+materia_id).val(mesa.fecha);
        $("#presidente-"+materia_id).val(mesa.presidente);
        $("#primer_vocal-"+materia_id).val(mesa.primer_vocal);
        $("#segundo_vocal-"+materia_id).val(mesa.segundo_vocal);
        $("#fecha_segundo-"+materia_id).val(mesa.fecha_segundo);
        $("#primer_vocal_segundo-"+materia_id).val(mesa.primer_vocal_segundo);
        $("#segundo_vocal_segundo"+materia_id).val(mesa.segundo_vocal_segundo);
    }

    function emptyFormData(materia_id)
    {
        $("#fecha-"+materia_id).val("");
        $("#presidente-"+materia_id).val("");
        $("#primer_vocal-"+materia_id).val("");
        $("#segundo_vocal-"+materia_id).val("");
        $("#fecha_segundo-"+materia_id).val("");
        $("#primer_vocal_segundo-"+materia_id).val("");
        $("#segundo_vocal_segundo"+materia_id).val("");
    }

    $(".inscripciones_comision").submit(function(e){
        e.preventDefault();
        let data = $(this).serializeArray();
        let comision_id = data[0].value;
        let materia_id = $(this).data('materia_id');
        let instancia_id = $(this).data('instancia_id');

        //window.location(`/mesas/inscriptos/${instancia_id}/${materia_id}/${comision_id}`);
        $(location).attr('href',`/mesas/inscriptos/${instancia_id}/${materia_id}/${comision_id}`);
    });
});