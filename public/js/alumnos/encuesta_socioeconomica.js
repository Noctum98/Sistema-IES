$(document).ready(function () {


    $('input[name="empresa_telefono"]').change(function () {
        // Verifica si el radio seleccionado es el que tiene el valor "otros"
        if ($(this).val() === 'otra' && $(this).is(':checked')) {
            // Acción que quieres realizar cuando se selecciona "otros"
            $("#otra_telefono").removeClass('d-none');
            // Puedes agregar aquí la lógica o la acción que desees realizar
        }else{
            $("#otra_telefono").addClass('d-none');
            $("#empresa_telefonoOtra").val("");
        }
    });

    $("#acceso_internet7").change(function(e){
        if($(this).is(':checked'))
        {
            $("#otra_acceso").removeClass('d-none');
        }else{
            $("#otra_acceso").addClass('d-none');
            $("#acceso_otro").val("");
        }
    });

    $("#identidad_genero_4").change(function(e){
        if($(this).is(':checked'))
        {
            $("#otra_identidad_genero").removeClass('d-none');
        }else{
            $("#otra_identidad_genero").addClass('d-none');
            $("#identidad_genero_otra").val("");
        }
    });

    $('input[name="identidad_genero"]').change(function () {
        // Verifica si el radio seleccionado es el que tiene el valor "otros"
        if ($(this).val() === 'otro' && $(this).is(':checked')) {
            // Acción que quieres realizar cuando se selecciona "otros"
            $("#otra_identidad_genero").removeClass('d-none');
            // Puedes agregar aquí la lógica o la acción que desees realizar
        }else{
            $("#otra_identidad_genero").addClass('d-none');
            $("#identidad_genero_otra").val("");
        }
    });
});