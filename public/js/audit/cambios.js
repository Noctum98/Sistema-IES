$(document).ready(function () {
    $(".modal_cambios").click(function(e){
        let cambios = $(this).data('changes');
        let texto = cambios.split('|');
        $("#body_cambios").html("");

        texto.forEach(element => {
            $("#body_cambios").append("<p>"+element.trim().toUpperCase()+"<p>");
        });

    });
});