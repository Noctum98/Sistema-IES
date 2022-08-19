$(document).ready(function () {
    $(".pondera-cargo").submit(function (event) {
        event.preventDefault();

        let id = $(this).attr('id');
        let cargo = $("input[id='cargo']",this).val();
        let materia = $("input[id='materia']",this).val();
        let ponderacion = $("input[id='ponderacion']",this).val();
        $('#loader-cargo-'+cargo+'-materia-'+materia).show();

        console.log(cargo + ' <br/>' + materia + ' <br/>' + ponderacion)

        let url = '/ponderarCargo';
        let data = {
            "cargo_id": cargo,
            "materia_id": materia,
            "porcentaje": ponderacion,
        };

        $.ajax({
            method: "POST",
            url: url,
            data: data,
            //dataType: "dataType",
            success: function (response) {

                if (response.errors) {
                    for (const key in response.errors) {
                        if (Object.hasOwnProperty.call(response.errors, key)) {
                            const element = response.errors[key];
                            $("#alerts").append("<div class='alert alert-danger'>" + element[0] + "</div>");
                        }
                    }
                }
                let clasePonderacion = 'text-warning'
                if(response[1] === 100){
                    clasePonderacion = 'text-success'
                }

                $('#cargo-'+cargo+'-materia-'+materia).text(response[1])
                $('#cargo-u-materia-'+materia).text(response[1])
                $('#cargo-u-materia-'+materia).removeClass().addClass(clasePonderacion)
                $('#loader-cargo-'+cargo+'-materia-'+materia).hide();
            },
            done:function (){
                $('#loader-cargo-'+cargo+'-materia-'+materia).hide();
            }
        });
    });
});