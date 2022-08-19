$(document).ready(function () {
    $("#todas-primero").change(function () {

        if ($(".materias-primero").is(":checked")) {
            $(".materias-primero").prop("checked", false);

        } else {

            $(".materias-primero").prop("checked", true);

        }
    });

    $("#todas-segundo").change(function () {

        if ($(".materias-segundo").is(":checked")) {
            $(".materias-segundo").prop("checked", false);

        } else {

            $(".materias-segundo").prop("checked", true);

        }
    });

    $("#todas-tercero").change(function () {

        if ($(".materias-tercero").is(":checked")) {
            $(".materias-tercero").prop("checked", false);

        } else {

            $(".materias-tercero").prop("checked", true);

        }
    });
});