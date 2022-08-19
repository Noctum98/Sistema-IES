$(document).ready(function () {

    // Asistencia Tradicional

    $("form").submit(function (e) {

        e.preventDefault();
        var theForm = $(this);


        // console.log(theForm.hasClass("form-tradicional"));
        if (theForm.hasClass('form-tradicional')) {
            tradicional(theForm);
            $(this).trigger("reset");
        } else if (theForm.hasClass('form-tradicional_7030')) {
            tradicional_7030(theForm);
        }else if(theForm.hasClass('form-modular'))
        {
            modular(theForm);
        }
        if(theForm.hasClass('form-modular_7030'))
        {
            modular_7030(theForm);
        }


    });

    var tradicional = function (form) {
        var proceso_id = form.attr("id");
        var porcentaje = $('#asis-procentaje-' + proceso_id).val();
        let url = "/asistencias/crear_asistencia";
        let data = {
            "porcentaje_final": porcentaje,
            "proceso_id": proceso_id
        }

        $.ajax({
            method: "POST",
            url: url,
            data: data,
            //dataType: "dataType",
            success: function (response) {
                $(".porcentaje-" + proceso_id).html("<p>% " + porcentaje + "</p>");

            }
        });
    }

    var tradicional_7030 = function (form) {

        var proceso_id = form.attr("id");
        var porcentaje_presencial = $("#asis-presencial-" + proceso_id).val();
        var porcentaje_virtual = $("#asis-virtual-" + proceso_id).val();
        let url = "/asistencias/crearAsistenciaSetentaTreinta";

        let data = {
            "porcentaje_presencial": porcentaje_presencial,
            "porcentaje_virtual": porcentaje_virtual,
            "proceso_id": proceso_id
        };

        $.ajax({
            method: "POST",
            url: url,
            data: data,
            //dataType: "dataType",
            success: function (response) {
                console.log(response.asistencia);
                if (response.asistencia) {
                    $(".porcentaje-" + proceso_id).html("<p>% " + response.asistencia.porcentaje_final + "</p>");
                    $("#alerts").html("");
                } else {
                    for (const key in response.errors) {
                        if (Object.hasOwnProperty.call(response.errors, key)) {
                            const element = response.errors[key];
                            $("#alerts").append("<div class='alert alert-danger'>" + element[0] + "</div>");
                        }
                    }
                }
            }
        });
    }

    var modular = function (form) {
        var proceso_id = form.attr("id");
        var cargo_id = $('input[name=cargo_id]')[0].value;
        var porcentaje = $('#asis-procentaje-' + proceso_id).val();
        let url = "/asistencias/crearAsistenciaModular";
        let data = {
            "porcentaje": porcentaje,
            "proceso_id": proceso_id,
            'cargo_id': cargo_id,
        }


        $.ajax({
            method: "POST",
            url: url,
            data: data,
            //dataType: "dataType",
            success: function (response) {
                $(".porcentaje-" + proceso_id).html("<p>% " + porcentaje + "</p>");

            }
        });
    }

    // Asistencia modular 70_30
    const modular_7030 = function (form) {

        const proceso_id = form.attr("id");
        const cargo_id = $('input[name=cargo_id]')[0].value;
        const porcentaje_presencial = $("#asis-presencial-" + proceso_id).val();
        const porcentaje_virtual = $("#asis-virtual-" + proceso_id).val();
        let url = "/asistencias/crearAsistenciaModularSetentaTreinta";
        let data = {
            "porcentaje_presencial": porcentaje_presencial,
            "porcentaje_virtual": porcentaje_virtual,
            'cargo_id': cargo_id,
            'proceso_id': proceso_id,
        }

        $.ajax({
            method: "POST",
            url: url,
            data: data,
            //dataType: "dataType",
            success: function (response) {

                if (response.asistencia) {
                    $(".porcentaje-" + proceso_id).html("<p>% " + response.asistencia.porcentaje + "</p>");
                }else{
                    for (const key in response.errors) {
                        if (Object.hasOwnProperty.call(response.errors, key)) {
                            const element = response.errors[key];
                            $("#alerts").append("<div class='alert alert-danger'>" + element[0] + "</div>");
                        }
                    }
                }

            }
        });
    }
});