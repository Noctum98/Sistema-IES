$(document).ready(function () {
console.log("hola");
    $(".change-cohorte").blur(function (e) {
        let id = $(this).attr('data-alumno-id');
        console.log(id)

        const newCohorte = $(this).val();
        console.log(newCohorte)
        const url = "/alumnos/modifica/" + id + "/cohorte";

        $.ajax({
            url: url,
            type: 'PATCH',
            data: {cohorte: newCohorte},
            success: function (data) {
                $("#cohorte").text(data.new_cohorte);
                $("#success-"+id).removeClass('d-none');
            }
        });
    })
})
