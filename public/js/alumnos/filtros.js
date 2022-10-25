$(document).ready(function () {
    let data = $("#buscador-alumnos").serializeArray();
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