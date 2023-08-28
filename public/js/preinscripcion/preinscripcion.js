$(document).ready(function () {

    let secundario = $("#condicion_s").val();
    let trabajo_relacionado = $("#trabajo_relacionado1").is(":checked")
    let edad = $("#edad").val();
    var trelacionado = false;


    if (edad >= 25 && secundario == 'secundario incompleto' && trabajo_relacionado) {
        $("#7mo").removeClass('d-none');
    } else {
        if (!$("#7mo").hasClass('d-none')) {
            $("#7mo").addClass('d-none');
        }
    }
    
    $("#edad").change(function (e) {
        let secundario = $("#condicion_s").val();
        let trabajo_relacionado = $("#trabajo_relacionado1").is('checked');
        let edad = $(this).val();

        if (edad >= 25 && secundario == 'secundario incompleto' && trelacionado) {
            $("#7mo").removeClass('d-none');
        } else {
            if (!$("#7mo").hasClass('d-none')) {
                $("#7mo").addClass('d-none');
            }
        }
    });

    $("#condicion_s").change(function (e) {
        let secundario = $(this).val();
        let trabajo_relacionado = $("#trabajo_relacionado1").is('checked');
        let edad = $("#edad").val();

        if (edad >= 25 && secundario == 'secundario incompleto' && trelacionado) {
            $("#7mo").removeClass('d-none');
        } else {
            if (!$("#7mo").hasClass('d-none')) {
                $("#7mo").addClass('d-none');
            }
        }
    });


    $("#trabajo_relacionado1").change(function (e) {
        let secundario = $("#condicion_s").val();
        let edad = $("#edad").val();
        trelacionado = true;
        if (edad >= 25 && secundario == 'secundario incompleto') {
            $("#7mo").removeClass('d-none');
        }
    });

    $("#trabajo_relacionado2").change(function (e) {
        if (!$("#7mo").hasClass('d-none')) {
            $("#7mo").addClass('d-none');
            trelacionado = false;

        }
    });

    $("#articulo_septimo").change(function (e){
        let checked = $(this).is(":checked");

        if(checked)
        {
            $("#archivos_articulo_septimo").removeClass('d-none');
        }else{
            $("#archivos_articulo_septimo").addClass('d-none');
        }
    });

    $("#materia_s1").change(function(e){
        let checked = $(this).is(":checked");

        if(checked)
        {
            $("#cantidad_materias_s").attr('disabled',false);
        }
    });

    $("#materia_s2").change(function(e){
        let checked = $(this).is(":checked");

        if(checked)
        {
            $("#cantidad_materias_s").attr('disabled',true);
            $("#cantidad_materias_s").val("");
        }
    });
});