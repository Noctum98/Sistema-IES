$(document).ready(function () {

    let secundario = $("#condicion_s").val();
    let trabajo_relacionado = $("#trabajo_relacionado1").is(":checked")
    let edad = $("#edad").val();
    var trelacionado = false;
    var nacionalidad = $("#nacionalidad").val();
    var articulo_septimo = $("#articulo_septimo").is(":checked");

    verificarDNI(nacionalidad);


    


    if (edad >= 25 && (secundario == 'secundario incompleto' || secundario == 'primario incompleto' || 'primario completo') && trabajo_relacionado) {
        $("#7mo").removeClass('d-none');
    } else {
        if (!$("#7mo").hasClass('d-none')) {
            $("#7mo").addClass('d-none');
        }
    }

    if(articulo_septimo)
    {
        $("#archivos_articulo_septimo").removeClass('d-none');
    }
    
    $("#edad").change(function (e) {
        let secundario = $("#condicion_s").val();
        let trabajo_relacionado = $("#trabajo_relacionado1").is('checked');
        let edad = $(this).val();

        if (edad >= 25 && (secundario == 'secundario incompleto' || secundario == 'primario incompleto' || 'primario completo') && trelacionado) {
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

        if (edad >= 25 && (secundario == 'secundario incompleto' || secundario == 'primario incompleto' || 'primario completo') && trelacionado) {
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
        if (edad >= 25 && (secundario == 'secundario incompleto' || secundario == 'primario incompleto' || 'primario completo')) {
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

    $("#formPreenroll").submit(function(event) {
        $("#submitPre").prop("disabled", true);
        $("#submitPre").val("Espere por favor..");
    });

    $("#nacionalidad").change(function(e){
        let value = $(this).val();
        verificarDNI(value);
    });

    $('#dni').on('input', function() {
        var maxLength = $(this).attr('maxlength');
        console.log(maxLength);
        if ($(this).val().length > maxLength) {
          $(this).val($(this).val().slice(0, maxLength));
        }
      });

    function verificarDNI(nacionalidad)
    {
        if(nacionalidad == 'argentina')
        {
            $("#dni").attr('type','number');
            $("#label_dni").html(" y solo 8 números");
            $("#dni").attr('maxlength',8);
        }else{
            $("#dni").attr('type','text');
            $("#label_dni").html("");
            $("#dni").attr('maxlength',20);
        }
    }
});