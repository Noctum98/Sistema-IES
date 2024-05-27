$(document).ready(function () {
    let $select = $('select');
    var carrerasSelected = [];
    var sedesEdit = [];
    var carrerasEdit = [];
    $parent = $select.parent();

    $(".select2-sedes").select2({
        dropdownParent: $('#exampleModal'),
        width: "100%",
        placeholder: 'Seleccione una opción',
    });

    $('#edit').on('hidden.bs.modal', function () {
        $(".select2-edit-sedes").empty();
        $(".select2-edit-carreras").empty();
        $("#editInstanciaForm").attr('action', '');
        $("#nombre-edit").val('');
        $("#mesaGeneralEdit").attr('checked', false);
        $("#sedes-edit").prop('disabled', false);
        $("#carreras-edit").prop('disabled', false);
        $("#limite-edit").val('');
        $("#año-edit").val('');
    });

    $(".open_modal").click(function (e) {
        let instancia_id = $(this).data('instancia_id');
        getInstancia(instancia_id);

    })

    $(".switchinstacierre").change(function () {
        var cierre = 0;

        if ($(this).is(':checked')) {
            cierre = 1
        }

        let instancia_id = $(this).data('instancia_id');

        updateInstancia(instancia_id, cierre);
    });

    $(".select2-sedes").change(function () {
        let sedes = $(this).val();
        getCarreras(sedes);
    });


    $("#mesaGeneral").change(function (e) {
        if ($(this).is(':checked')) {
            $("#sedes").attr('disabled', true);
            $("#carreras").attr('disabled', true);
            $(".select2-sedes").empty();
            $(".select2-carreras").empty();
        } else {
            $("#sedes").attr('disabled', false);
            $("#carreras").attr('disabled', false);
            getSedes();
        }
    });

    $("#mesaGeneralEdit").change(function (e) {
        if ($(this).is(':checked')) {
            $("#sedes-edit").attr('disabled', true);
            $("#carreras-edit").attr('disabled', true);
            $(".select2-edit-sedes").empty();
            $(".select2-edit-carreras").empty();
        } else {
            $("#sedes-edit").attr('disabled', false);
            $("#carreras-edit").attr('disabled', false);
            getSedes();
        }
    });

    $("#sedes-edit").change(function(){
        let sedesEdit = $(this).val();
        getCarreras(sedesEdit,true);
    });

    function getCarreras(sedes, edit = false) {
        let url = '/carreras/sedes';
        let data = {
            'sedes': sedes
        }

        $.ajax({
            method: "POST",
            url: url,
            data: data,
            success: function (response) {
                dataCarreras = [];
                response.data.forEach(element => {
                    data = {
                        'id': element.id,
                        'text': element.nombre + ' ' + element.resolucion + ' (' + element.sede.nombre + ')'
                    }

                    dataCarreras.push(data);
                });

                if (edit) {
                    $(".select2-edit-carreras").select2({
                        dropdownParent: $('#edit'),
                        width: "100%",
                        placeholder: 'Seleccione una opción',
                        data: dataCarreras
                    });
                    console.log(dataCarreras);
                    if (carrerasSelected.length > 0) {

                        $('.select2-edit-carreras option').each(function () {
                            for (let index = 0; index < carrerasSelected.length; index++) {
                                const element = carrerasSelected[index];
                                if ($(this).val() == element.id) {
                                    $(this).prop('selected', true);
                                }
                            }
                        });

                        $('.select2-edit-carreras').trigger('change');

                    }

                } else {
                    $(".select2-carreras").select2({
                        dropdownParent: $("#exampleModal"),
                        width: "100%",
                        placeholder: 'Seleccione una opción',
                        allowClear: true,
                        data: dataCarreras
                    });
                }
            }
        });

    }

    function getInstancia(instancia_id) {
        let url = '/mesas/instancia/' + instancia_id;

        $.get(url, function (response) {
            $("#editInstanciaForm").attr('action', '/mesas/editar_instancia/' + instancia_id);
            $("#nombre-edit").val(response.nombre);

            $('#tipo-edit option').each(function () {
                // Comparamos el valor de la opción con el valor de la respuesta
                if ($(this).val() == response.tipo) {
                    // Marcamos como seleccionada la opción correspondiente
                    $(this).prop('selected', true);
                }
            });

            console.log(response.general);
            if (response.general == 1) {
                $("#mesaGeneralEdit").prop('checked', true);
                $("#sedes-edit").prop('disabled', true);
                $("#carreras-edit").prop('disabled', true);
            } else {
                $("#mesaGeneralEdit").prop('checked', false);
                $("#sedes-edit").prop('disabled', false);
                $("#carreras-edit").prop('disabled', false);
                getSedes(response.sedes, response.carreras);
            }



            $("#limite-edit").val(response.limite);
            $("#año-edit").val(response.año);
            $('#year_nota-edit option').each(function () {
                // Comparamos el valor de la opción con el valor de la respuesta
                if ($(this).val() == response.year_nota) {
                    // Marcamos como seleccionada la opción correspondiente
                    $(this).prop('selected', true);
                }
            });
        });
    }

    function updateInstancia(instancia_id, cierre) {
        let url = '/mesas/cierre/' + cierre + '/' + instancia_id;
        $.get(url, function (response) {
        });
    }

    function getSedes(sedes = null, carreras = null) {
        let url = '/sedes/getSedes';

        $.get(url, function (response) {

            sedesEdit = [];

            response.forEach(element => {
                let data = {
                    'id': element.id,
                    'text': element.nombre
                }

                sedesEdit.push(data);
            });
            $(".select2-edit-sedes").select2({
                dropdownParent: $('#edit'),
                width: "100%",
                placeholder: 'Seleccione una opción',
                data: sedesEdit
            });

            if (sedes) {
                $('.select2-edit-sedes option').each(function () {
                    for (let index = 0; index < sedes.length; index++) {
                        const element = sedes[index];
                        if ($(this).val() == element.id) {
                            $(this).prop('selected', true);
                        }
                    }
                });

                // Actualizar la interfaz gráfica de Select2 después de seleccionar las opciones
                $('.select2-edit-sedes').trigger('change');

                if(carreras)
                {
                    carrerasSelected = carreras;
                }
            }




        });


    }
});