$(document).ready(function () {

    $("#rol_id").change(function (e) {
        e.preventDefault();
        var selectedOption = $(this).find('option:selected');

        // Obtener la descripción del data attribute
        var descripcion = selectedOption.data('descripcion');
        console.log(descripcion);
        if (descripcion != 'Administrador' && descripcion != 'Regente') {
            $("#form_carrera_roles").removeClass('d-none');
            $("#carrera_id_roles").prop('disabled', false);
        } else {
            $("#form_carrera_roles").addClass('d-none');
            $("#carrera_id_roles").prop('disabled', true);
        }


        if (descripcion == 'Profesor') {
            $("#form_materia_roles").removeClass('d-none');
            $("#materia_id_roles").prop('disabled', false);
        } else {
            $("#form_materia_roles").addClass('d-none');
            $("#materia_id_roles").prop('disabled', true);
        }
    });

});