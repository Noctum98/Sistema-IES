$(document).ready(function () {
    function toggleElementDisplay(proceso_id, elementPrefix, initialClass, finalClass) {
        $(`#${elementPrefix}-${proceso_id}`).removeClass(initialClass);
        $(`#${elementPrefix}-${proceso_id}`).addClass(finalClass);
    }

    $(".form_nota_final").submit(function (event) {
        event.preventDefault();
        let proceso_id = $(this).attr('id');
        let nota_final = $('#nota-' + proceso_id).val();
        let ciclo_lectivo = $('#ciclo_lectivo').val();


        let url = '/proceso/cambia/nota_final';
        let data = {
            "proceso_id": proceso_id,
            "nota_final": nota_final,
        };
        $("#alerts").html("");
        toggleElementDisplay(proceso_id, 'span', 'd-block', 'd-none');
        toggleElementDisplay(proceso_id, 'spin', 'd-none', 'd-block');


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
                            console.log(element);
                            $("#alerts").append("<div class='alert alert-danger'>" + element[0] + "</div>");
                            $([document.documentElement, document.body]).animate({
                                scrollTop: $("#container-scroll").offset().top
                            }, 100);

                        }
                    }
                } else {
                    let notaElement = $('#nota-' + proceso_id);
                    notaElement.removeClass("text-danger");
                    notaElement.removeClass("text-success");
                    if (ciclo_lectivo < 2024) {
                        if (response.nota >= 4) {
                            notaElement.addClass("text-success");
                        } else if (response.nota >= 0 && response.nota < 4) {
                            notaElement.addClass("text-danger");
                        } else {
                            notaElement.removeClass("text-danger");
                            notaElement.removeClass("text-success");
                        }
                    } else {
                        if (response.nota >= 6) {
                            notaElement.addClass("text-success");
                        } else if (response.nota >= 0 && response.nota < 6) {
                            notaElement.addClass("text-danger");
                        } else {
                            notaElement.removeClass("text-danger");
                            notaElement.removeClass("text-success");
                        }
                    }
                    toggleElementDisplay(proceso_id, 'span', 'd-block', 'd-none');
                    toggleElementDisplay(proceso_id, 'spin', 'd-none', 'd-block');

                }
            }
        });
    });

    $(".form_nota_global").submit(function (event) {
        event.preventDefault();
        let proceso_id = $(this).attr('id');
        let nota_global = $('#global-' + proceso_id).val();
        let ciclo_lectivo = $('#ciclo_lectivo').val();

        console.log(proceso_id)

        let url = '/proceso/cambia/nota_global';
        let data = {
            "proceso_id": proceso_id,
            "nota_global": nota_global,
        };
        $("#alerts").html("");
        toggleElementDisplay(proceso_id, 'span', 'd-block', 'd-none');
        toggleElementDisplay(proceso_id, 'spin', 'd-none', 'd-block');

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
                            console.log(element);
                            $("#alerts").append("<div class='alert alert-danger'>" + element[0] + "</div>");
                            $([document.documentElement, document.body]).animate({
                                scrollTop: $("#container-scroll").offset().top
                            }, 100);

                        }
                    }
                } else {
                    let globalElement = $('#global-' + proceso_id);
                    globalElement.removeClass("text-danger");
                    globalElement.removeClass("text-success");
                    // if (response.nota >= 4) {
                    //     globalElement.addClass("text-success");
                    // } else {
                    //     globalElement.addClass("text-danger");
                    // }
                    if (ciclo_lectivo < 2024) {
                        console.log(ciclo_lectivo)
                        if (response.nota >= 4) {
                            globalElement.addClass("text-success");
                        } else if (response.nota >= 0 && response.nota < 4) {
                            globalElement.addClass("text-danger");
                        }
                    } else {
                        console.log(ciclo_lectivo)
                        if (response.nota >= 6) {
                            globalElement.addClass("text-success");
                        } else if (response.nota >= 0 && response.nota < 6) {
                            globalElement.addClass("text-danger");
                        }
                    }


                    $('#select_' + proceso_id).val(response.estado).change();


                    toggleElementDisplay(proceso_id, 'span', 'd-none', 'd-block');
                    toggleElementDisplay(proceso_id, 'spin', 'd-block', 'd-none');

                }
            }
        });
    });
});
