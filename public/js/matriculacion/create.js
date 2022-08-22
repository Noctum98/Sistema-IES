$(document).ready(function () {

    $("#primer_año").hide();
    $("#segundo_año").hide();
    $("#tercer_año").hide();



    $("#regular_segundo").change(function (e) {
        $("#primer_año").hide();
        $("#segundo_año").show();
        $("#tercer_año").hide();
    });
    $("#regular_tercero").change(function (e) {
        $("#primer_año").hide();
        $("#segundo_año").hide();
        $("#tercer_año").show();
    });


    // PRIMER AÑO
    $("#regular_primero").change(function (e) {
        $("#primer_año").show();
        $("#segundo_año").hide();
        $("#tercer_año").hide();
    });

    $("#condicional_primero").change(function (e) {
        $("#primer_año").show();
        $("#segundo_año").hide();
        $("#tercer_año").hide();
    });

    $("#recursante_primero").change(function (e) {
        $("#primer_año").show();
        $("#segundo_año").hide();
        $("#tercer_año").hide();
    });

    $("#recursante_diferenciado_primero").change(function (e) {
        $("#primer_año").show();
        $("#segundo_año").show();
        $("#tercer_año").hide();
    });

    // SEGUNDO AÑO
    $("#regular_segundo").change(function (e) {
        $("#primer_año").hide();
        $("#segundo_año").show();
        $("#tercer_año").hide();
    });

    $("#condicional_segundo").change(function (e) {
        $("#primer_año").hide();
        $("#segundo_año").show();
        $("#tercer_año").hide();
    });

    $("#recursante_segundo").change(function (e) {
        $("#segundo_año").show();
        $("#tercer_año").hide();
        $("#primer_año").hide();
    });

    $("#recursante_diferenciado_segundo").change(function (e) {
        $("#segundo_año").show();
        $("#tercer_año").show();
        $("#primer_año").hide();
    });
    // TERCER AÑO
    $("#regular_tercero").change(function (e) {
        $("#primer_año").hide();
        $("#segundo_año").hide();
        $("#tercer_año").show();
    });

    $("#condicional_tercero").change(function (e) {
        $("#primer_año").hide();
        $("#segundo_año").hide();
        $("#tercer_año").show();
    });

    $("#recursante_tercero").change(function (e) {
        $("#segundo_año").hide();
        $("#tercer_año").show();
        $("#primer_año").hide();
    });
    //===========================================================//
    $("#otra").keyup(function (e) {
        $("#nacionalidad").prop("disabled", true);
        if ($(this).val() == '') {
            $("#nacionalidad").prop("disabled", false);
        } else {
            $("#nacionalidad").prop("disabled", true);
        }
    });
    $("#nacionalidad option").each(function () {

        if ($(this).is(':selected')) {
            $("#otra").prop("disabled", true);
        }
    });



});