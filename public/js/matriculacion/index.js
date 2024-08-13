$(document).ready(function () {
    $(".link_matriculacion").click(function(e){
        e.preventDefault();
        let carrera_id = $(this).data('carrera');
        let alumno_id = $("#alumno_id").val();
        let año = $('input[name="link_matriculacion-año-'+carrera_id+'"]:checked').val();

        let url = "/matriculacion/editar/"+alumno_id+'/'+carrera_id+'/'+año;
        window.location.href = (url);
    });

    $(".link_materias").click(function(e){
        e.preventDefault();
        let carrera_id = $(this).data('carrera');
        let alumno_id = $("#alumno_id").val();
        let año = $('input[name="link_materias-año-'+carrera_id+'"]:checked').val();

        let url = "/proceso/admin-alumno/"+carrera_id+'/'+año;
        window.location.href = (url);
    });
});