$(document).ready(function () {
    $('.comision_id').change(function (event) {
        var alumnocomision = $(this).attr('id');
        alumnocomision = alumnocomision.split("-");
        let detach = false;

        if(!$(this).is(':checked')){
            detach = true;
        }
        
        let data = {
            "alumno_id":alumnocomision[0],
            "comision_id":alumnocomision[1],
            "detach":detach,
            "todos":false
        };
        agregar_alumno(data,url);
     });

    $('.comision_todos').change(function(event){
        let data = $(this).val();
        let comision_id = data.split("-")[1];

        let url = '/comision/alumno/agregar';

        if($(this).is(':checked'))
        {
            let data = {
                "detach":false,
                "comision_id":comision_id,
                "todos":true,
            };
            $('input[type="checkbox"][value*="'+comision_id+'"]').prop('checked',true);
            agregar_alumno(data,url);
        }else{
            let data = {
                "detach":true,
                "comision_id":comision_id,
                "todos":true,
            };
            agregar_alumno(data,url);
            $('input[type="checkbox"][id*="'+comision_id+'"]').prop('checked',false);
        }

        console.log(comision_id);
    });


    $('form').on('change', function() {
        var form = $(this);
        var alumno_id = form.attr("id");
        var comision_id = $('input[name=comision_id]:checked', "#"+alumno_id).val();
        var checkbox = $('input[name=comision_id]', "#"+alumno_id).val();
        let url = '/comision/alumno/agregar';
        let data = {
            "alumno_id":alumno_id,
            "comision_id":comision_id,
        };
        /*
        agregar_alumno(data,url);
        */
        
     });


     var agregar_alumno = function(data,url){
        $.ajax({
            method: "POST",
            url: url,
            data: data,
            //dataType: "dataType",
            success: function (response) {
                if (response.errors) {
                    for (const key in response.errors) {
                        if (Object.hasOwnProperty.call(response.errors, key)) {
                            const element = response.errors[key];
                            $("#alerts").append("<div class='alert alert-danger'>" + element[0] + "</div>");
                        }
                    }
                } else {
                    $("#alerts").html("");
                    console.log(response);
                }
            }
        });
     }
});