$(document).ready(function () {
    let data = $("#buscador-alumnos").serializeArray();
    let filtros = [];

    $("#aplicar_filtros").click(function () {

        data.forEach(element => {
            if (element.value != '') {
                filtros.push(element);
            }
        });

        if (filtros.length != 0) {
            $("#filtros_button").html("<span class='text-info' id='filters_count'>(" + filtros.length + ")</span>")
        } else {
            $("#filtros_button").html("");
        }
    });

   
    let url = '/excel/descargarFiltro/?';

    data.forEach((element, key) => {
        if (data.length == (key + 1)) {
            url = url + element.name + '=' + element.value;
        } else {
            url = url + element.name + '=' + element.value + '&';
        }

    });

    let materia_id = $("#materia_selected").val();

    if (materia_id) {
        url = url + '&materia_id=' + materia_id;
    }

    $("#descargar_busqueda").attr('href', url);

});