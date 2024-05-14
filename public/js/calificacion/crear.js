$(document).ready(function () {

    $(".datablur").blur(function () {

        const $form = $(this).closest("form");
        $form.submit();
    });


    $("form").submit(function (e) {
        let porcentaje;
        e.preventDefault();

        const theForm = $(this);
        const proceso_id = theForm.attr("id");
        const calificacion_id = $('#calificacion_id').val();
        let ciclo_lectivo = $('#ciclo_lectivo').val();

        if (theForm.hasClass('form-recuperatorio')) {
            porcentaje = $('#calificacion-procentaje-recuperatorio-' + proceso_id).val();
            let url = "/procesoCalificacion/recuperatorio";
            let data = {
                "porcentaje": porcentaje,
                "proceso_id": proceso_id,
                "calificacion_id": calificacion_id
            }

            if (porcentaje.trim() == "") {
                url = "/procesoCalificacion/delete"
                data = {
                    "proceso_id": proceso_id,
                    "calificacion_id": calificacion_id,
                    "recuperatorio": "Si"
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
                    }
                    else {
                        if (ciclo_lectivo < 2024) {
                            if (response.nota_recuperatorio >= 4) {
                                $(".nota-recuperatorio-" + proceso_id).html("<p class='text-success font-weight-bold'>" + response.nota_recuperatorio + "</p>");
                            } else if (response.nota_recuperatorio < 4 && response.nota_recuperatorio >= 0) {
                                $(".nota-recuperatorio-" + proceso_id).html("<p class='text-danger font-weight-bold'>" + response.nota_recuperatorio + "</p>");
                            } else if (response.nota_recuperatorio === "A" || response.nota_recuperatorio === "a") {
                                $(".nota-recuperatorio-" + proceso_id).html("<p class='text-danger font-weight-bold'>A</p>");
                            } else {
                                $(".nota-recuperatorio-" + proceso_id).html("<p class='text-danger font-weight-bold'></p>");
                            }
                        }
                        else {
                            if (response.nota_recuperatorio >= 6) {
                                $(".nota-recuperatorio-" + proceso_id).html("<p class='text-success font-weight-bold'>" + response.nota_recuperatorio + "</p>");
                            } else if (response.nota_recuperatorio < 6 && response.nota_recuperatorio >= 0) {
                                $(".nota-recuperatorio-" + proceso_id).html("<p class='text-danger font-weight-bold'>" + response.nota_recuperatorio + "</p>");
                            } else if (response.nota_recuperatorio === "A" || response.nota_recuperatorio === "a") {
                                $(".nota-recuperatorio-" + proceso_id).html("<p class='text-danger font-weight-bold'>A</p>");
                            } else {
                                $(".nota-recuperatorio-" + proceso_id).html("<p class='text-danger font-weight-bold'></p>");
                            }
                        }
                    }
                }


        })
        }
        else
            {
                porcentaje = $('#calificacion-procentaje-' + proceso_id).val();
                let url = "/procesoCalificacion";
                let data = {
                    "porcentaje": porcentaje,
                    "proceso_id": proceso_id,
                    "calificacion_id": calificacion_id
                }

                if (porcentaje.trim() == "") {
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

                            if (ciclo_lectivo < 2024) {
                                if (response.nota >= 4) {
                                    $(".nota-" + proceso_id).html("<p class='text-success font-weight-bold'>" + response.nota + "</p>");
                                    $("#calificacion-procentaje-recuperatorio-" + proceso_id).prop('disabled', true);

                                } else if (response.nota < 4 && response.nota >= 0) {
                                    $("#calificacion-procentaje-recuperatorio-" + proceso_id).prop('disabled', false);

                                    $(".nota-" + proceso_id).html("<p class='text-danger font-weight-bold'>" + response.nota + "</p>");
                                } else if (response.nota === -1) {
                                    $("#calificacion-procentaje-recuperatorio-" + proceso_id).prop('disabled', false);

                                    $(".nota-" + proceso_id).html("<p class='text-danger font-weight-bold'>A</p>");
                                } else {
                                    $(".nota-" + proceso_id).html("<p class='text-danger font-weight-bold'></p>");
                                }
                            } else {
                                if (response.nota >= 6) {
                                    $(".nota-" + proceso_id).html("<p class='text-success font-weight-bold'>" + response.nota + "</p>");
                                    $("#calificacion-procentaje-recuperatorio-" + proceso_id).prop('disabled', true);

                                } else if (response.nota < 6 && response.nota >= 0) {
                                    $("#calificacion-procentaje-recuperatorio-" + proceso_id).prop('disabled', false);

                                    $(".nota-" + proceso_id).html("<p class='text-danger font-weight-bold'>" + response.nota + "</p>");
                                } else if (response.nota === -1) {
                                    $("#calificacion-procentaje-recuperatorio-" + proceso_id).prop('disabled', false);

                                    $(".nota-" + proceso_id).html("<p class='text-danger font-weight-bold'>A</p>");
                                } else {
                                    $(".nota-" + proceso_id).html("<p class='text-danger font-weight-bold'></p>");
                                }
                            }
                        }
                    }


                });
            }
        }
    )
        ;

    });
