$(document).ready(function () {

    $("#username").change(function(e){
        let dni_val = $(this).val();
        $("#password").val(dni_val);
        $("#password-confirm").val(dni_val);
    });

    $("#username").blur(function (event) {
        //$("#submit").addClass('disabled');

        $(".aviso").empty();
        var username = event.target.value;
        if (username !=='') {
            $(".spin").removeClass("d-none")
            var rutaBusquedaUsuario = "/buscaUsuarioByUsername/" + username;

            $.get(rutaBusquedaUsuario, function (response, state) {

                if (response.length <= 0) {
                    $("#submit").removeClass('disabled');
                    $('.card-body').removeClass('disabled')
                    $(".spin").addClass("d-none")
                    $("form :input").prop("disabled", false);
                    $(".aviso").append("<span class='ms-5 text-right alert alert-success py-2'>Registro posible. Usuario no existente <i class='fa fa-check'></i></span>");
                } else {
                    // $("form :input").prop("disabled", true);
                    $("#user_id").prop("disabled",false);
                    $("#user_id").val(response[0].id);
                    $("#nombre").prop("disabled", true);
                    $("#apellido").prop("disabled", true);
                    $("#telefono").prop("disabled", true);
                    $("#email").prop("disabled", true);
                    $('#username').prop("disabled", false);
                    $(".aviso").append("<alert class='text-danger alert alert-danger py-2'> El Usuario ya existe. <i class='fa fa-times'></i> </alert>");
                    $(".spin").addClass("d-none")

                    if(response[0].alumno_one)
                    {
                        if($("#register_alumno").length)
                        {
                            $(".aviso").append("<a class='ml-2' href='/alumnos/alumno/" + response[0].alumno_one.id + "'> <i class='fa fa-edit'></i>" + response[0].nombre + " " + response[0].apellido + "</a>")
                        }else{
                            $(".aviso").append("<a class='ml-2' href='usuarios/detalle/" + response[0].id + "'> <i class='fa fa-edit'></i>" + response[0].nombre + " " + response[0].apellido + "</a>")
                        }
                    }
                    
                }
            });
        }

    });
});
