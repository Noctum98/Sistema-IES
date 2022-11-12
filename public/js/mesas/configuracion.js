$(document).ready(function () {


    $(".open_modal").click(function () {
        let materia_id = $(this).data('materia_id');
        let instancia_id = $(this).data('instancia_id');

        $(".select2").select2({
            dropdownParent: $('#exampleModal' + materia_id),
            width: "100%"
        });

        let url = '/mesas/mesaByComision/' + materia_id + '/' + instancia_id;
        $.ajax({
            method: "GET",
            url: url,
            //dataType: "dataType",
            success: function (response) {
                console.log(response);
                if (response.status == 'success') {
                    setFormData(response.mesa, materia_id);
                } else {
                    emptyFormData(materia_id);
                }

            },
            error: function (error) {
                if (!$("#form-config-" + materia_id).hasClass('d-none')) {
                    $("#form-config-" + materia_id).addClass('d-none');
                    $("#spinner-comision-" + materia_id).addClass('d-none');

                }
            }
        });
    });

        $('.comision_id').change(function () {
            let materia_id = $(this).data('materia');
            let instancia_id = $(this).data('instancia_id');
            let comision_id = $(this).val();

            let url = '/mesas/mesaByComision/' + materia_id + '/' + instancia_id + '/' + comision_id;
            $("#spinner-comision-" + materia_id).removeClass('d-none');

            $.ajax({
                method: "GET",
                url: url,
                //dataType: "dataType",
                success: function (response) {

                    $("#spinner-comision-" + materia_id).addClass('d-none');
                    $("#form-config-" + materia_id).removeClass('d-none');

                    if (response.status == 'success') {
                        setFormData(response.mesa, materia_id);
                    } else {
                        emptyFormData(materia_id);
                    }

                },
                error: function (error) {
                    if (!$("#form-config-" + materia_id).hasClass('d-none')) {
                        $("#form-config-" + materia_id).addClass('d-none');
                        $("#spinner-comision-" + materia_id).addClass('d-none');

                    }
                }
            });
        });

        function setFormData(mesa, materia_id) {
            
            if (mesa.presidente) {
                $('#presidente-' + materia_id).append('<option selected="selected" value="' + mesa.presidente.id + '">' + mesa.presidente.apellido.toUpperCase() + ' ' + mesa.presidente.nombre + '</option>').trigger('change');
            }

            if (mesa.primer_vocal) {
                $('#primer_vocal-' + materia_id).append('<option selected="selected" value=' + mesa.primer_vocal.id + '>' + mesa.primer_vocal.apellido.toUpperCase() + ' ' + mesa.primer_vocal.nombre + '</option>').trigger('change');

            }

            if (mesa.segundo_vocal) {
                $('#segundo_vocal-' + materia_id).append('<option selected="selected" value=' + mesa.segundo_vocal.id + '>' + mesa.segundo_vocal.apellido.toUpperCase() + ' ' + mesa.segundo_vocal.nombre + '</option>').trigger('change');
            }

            if (mesa.segundo_vocal_segundo) {
                $('#segundo_vocal_segundo-' + materia_id).append('<option selected="selected" value=' + mesa.segundo_vocal_segundo.id + '>' + mesa.segundo_vocal_segundo.apellido.toUpperCase() + ' ' + mesa.segundo_vocal_segundo.nombre + '</option>').trigger('change');

            }

            if (mesa.presidente_segundo) {
                $('#presidente_segundo-' + materia_id).append('<option selected="selected" value=' + mesa.presidente_segundo.id + '>' + mesa.presidente_segundo.apellido.toUpperCase() + ' ' + mesa.presidente_segundo.nombre + '</option>').trigger('change');

            }

            if (mesa.primer_vocal_segundo) {
                $('#primer_vocal_segundo-' + materia_id).append('<option selected="selected" value=' + mesa.primer_vocal_segundo.id + '>' + mesa.primer_vocal_segundo.apellido.toUpperCase() + ' ' + mesa.primer_vocal_segundo.nombre + '</option>').trigger('change');

            }


            $("#fecha-" + materia_id).val(mesa.fecha);
            $("#fecha_segundo-" + materia_id).val(mesa.fecha_segundo);
        }

        function emptyFormData(materia_id) {
            $("#fecha-" + materia_id).val("");
            $("#presidente-" + materia_id).val("").trigger('change');
            $("#primer_vocal-" + materia_id).val("").trigger('change');
            $("#segundo_vocal-" + materia_id).val("").trigger('change');
            $("#fecha_segundo-" + materia_id).val("");
            $("#presidente_segundo-" + materia_id).val("").trigger('change');
            $("#primer_vocal_segundo-" + materia_id).val("").trigger('change');
            $("#segundo_vocal_segundo-" + materia_id).val("").trigger('change');
        }

        $(".inscripciones_comision").submit(function (e) {
            e.preventDefault();
            let data = $(this).serializeArray();
            let comision_id = data[0].value;
            let materia_id = $(this).data('materia_id');
            let instancia_id = $(this).data('instancia_id');

            //window.location(`/mesas/inscriptos/${instancia_id}/${materia_id}/${comision_id}`);
            $(location).attr('href', `/mesas/inscriptos/${instancia_id}/${materia_id}/${comision_id}`);
        });
    });