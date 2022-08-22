$(document).ready(function () {
    $("form").submit(function (e) {
        e.preventDefault();
        var theForm = $(this);
        var proceso_id = theForm.attr("id");
        var calificacion_id = $('#calificacion_id').val();

        if(theForm.hasClass('form-recuperatorio')){
            var porcentaje = $('#calificacion-procentaje-recuperatorio-' + proceso_id).val();
            let url = "/procesoCalificacion/recuperatorio";
            let data = {
                "porcentaje": porcentaje,
                "proceso_id": proceso_id,
                "calificacion_id": calificacion_id
            }
    
            if(porcentaje.trim() == ""){
                url = "/procesoCalificacion/delete"
                data = {
                    "proceso_id": proceso_id,
                    "calificacion_id": calificacion_id,
                    "recuperatorio":"Si"
                }
            }

            $("#spinner-recuperatorio-" + proceso_id).html("<div class='spinner-border text-primary mt-2' role='status' id='spinner-rec-info'><span class='sr-only'>Loading...</span></div>")

            $.ajax({
                method: "POST",
                url: url,
                data: data,
                //dataType: "dataType",
                success: function (response) {
                    $("#spinner-rec-info").remove();
                    if (response.errors) {
                        for (const key in response.errors) {
                            if (Object.hasOwnProperty.call(response.errors, key)) {
                                const element = response.errors[key];
                                $("#alerts").append("<div class='alert alert-danger'>" + element[0] + "</div>");
                            }
                        }
                    } else {   
                        if (response.nota_recuperatorio >= 4) {
                            $(".nota-recuperatorio-" + proceso_id).html("<p class='text-success font-weight-bold'>" + response.nota_recuperatorio + "</p>");
                        } else if(response.nota_recuperatorio < 4 && response.nota_recuperatorio >= 0) {
                            $(".nota-recuperatorio-" + proceso_id).html("<p class='text-danger font-weight-bold'>" + response.nota_recuperatorio + "</p>");
                        }else if (response.nota_recuperatorio === "A" || response.nota_recuperatorio === "a"){
                            $(".nota-recuperatorio-" + proceso_id).html("<p class='text-danger font-weight-bold'>A</p>");
                        }else{
                            $(".nota-recuperatorio-" + proceso_id).html("<p class='text-danger font-weight-bold'></p>");
                        }
                    }
                }
            });
            
            
        }else{
            var porcentaje = $('#calificacion-procentaje-' + proceso_id).val();
            let url = "/procesoCalificacion";
            let data = {
                "porcentaje": porcentaje,
                "proceso_id": proceso_id,
                "calificacion_id": calificacion_id
            }

            if(porcentaje.trim() == ""){
                url = "/procesoCalificacion/delete"
                data = {
                    "proceso_id": proceso_id,
                    "calificacion_id": calificacion_id,
                }
            }
    
            $("#spinner-" + proceso_id).html("<div class='spinner-border text-primary mt-2' role='status' id='spinner-info'><span class='sr-only'>Loading...</span></div>")
            $.ajax({
                method: "POST",
                url: url,
                data: data,
                //dataType: "dataType",
                success: function (response) {
                    $("#spinner-info").remove();
    
                    if (response.errors) {
                        for (const key in response.errors) {
                            if (Object.hasOwnProperty.call(response.errors, key)) {
                                const element = response.errors[key];
                                $("#alerts").append("<div class='alert alert-danger'>" + element[0] + "</div>");
                            }
                        }
                    } else {

                        if (response.nota >= 4) {
                            $(".nota-" + proceso_id).html("<p class='text-success font-weight-bold'>" + response.nota + "</p>");
                        } else if(response.nota < 4 && response.nota >= 0) {
                            $("#calificacion-procentaje-recuperatorio-"+proceso_id).prop('disabled', false);

                            $(".nota-" + proceso_id).html("<p class='text-danger font-weight-bold'>" + response.nota + "</p>");
                        }else if(response.nota === -1){
                            $("#calificacion-procentaje-recuperatorio-"+proceso_id).prop('disabled', false);

                            $(".nota-" + proceso_id).html("<p class='text-danger font-weight-bold'>A</p>");
                        }else{
                            $(".nota-" + proceso_id).html("<p class='text-danger font-weight-bold'></p>");
                        }
                    }

                }
            });
        }
    });

});