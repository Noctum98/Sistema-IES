$(document).ready(function () {
  var elementos;

  // Botón Datos Generales
  $("#general").change(function(e){
    let checked = $(this).is(':checked');

    if(checked)
    {
      $("#sede_id").attr('disabled',true);
      $("#carrera_id").attr('disabled',true);
      $("#año").attr('disabled',true);
      $("#btn-submit").attr('disabled',false);
    }else{
      $("#sede_id").attr('disabled',false);
      $("#carrera_id").attr('disabled',false);
      $("#año").attr('disabled',false);
      $("#btn-submit").attr('disabled',true);
      let val = $("#año").val();
      if(val != '' && val != undefined && val > 0 && val < 4)
    {
      $("#btn-submit").attr('disabled',false);
    }
    }
  });

  // Cambiar de un gráfico a otro
  $(".btn-graph").click(function (param) { 
    var identificadorBoton = $(this).attr('id');
    var partes = identificadorBoton.split('-');
    var idElement = partes[0];
    var graph = partes[1];
    var elemento = elementos.find(function(elemento) {
      return elemento.identificador === idElement;
    });

    elemento.type = graph;
    renderizarGrafica(elemento);
  });

  // Deshabilitar botón de buscar
  $("#año").change(function(e){
    let val = $(this).val();
    console.log(val);
    $("#btn-submit").attr('disabled',true);
    if(val != '' && val != undefined && val >= -1 && val < 4)
    {
      $("#btn-submit").attr('disabled',false);
    }
  });

  // Procesar Formulario
  $("#datos-form").submit(function (e) {
    e.preventDefault();
    let sede_id = $("#sede_id").val() ? $("#sede_id").val() : 0;
    let carrera_id = $("#carrera_id").val() ? $("#carrera_id").val() : 0;
    let año = $("#año").val() ? $("#año").val() : 0;
    var url = '';
    var urlDescargar = '';


    if($("#general").is(':checked'))
    {
      url = '/estadistica/obtenerGraficos/0/0/0/1';
      urlDescargar = '/excel/encuesta/0/0';

    }else{
      url = '/estadistica/obtenerGraficos/' + sede_id + "/" + carrera_id + '/' + año;
      urlDescargar = '/excel/encuesta/'+carrera_id+'/'+año;
    }

    $("#btn-submit").val('Cargando datos..espere');
    $("#btn-submit").attr('disabled',true);


    $('#btn-descargar').attr('href',urlDescargar);

    $.get(url, function (response) {
      $("#graficos").removeClass('d-none');
      $("#total").html(response.total);
      elementos = response.data;
      $("#btn-submit").val('Buscar');
      $("#btn-submit").attr('disabled',false);
      response.data.forEach(element => {
        renderizarGrafica(element)
      });
    });

  });

  renderizarGrafica = function (element) {
    const ctx = document.getElementById(element.identificador);
    // Obtener el gráfico existente en el canvas
    var existingChart = Chart.getChart(ctx);

    // Destruir el gráfico existente si hay alguno
    if (existingChart) {
        existingChart.destroy();
    }

    ctx.innerHTML = '';
    new Chart(ctx, {
      type: element.type,
      data: {
        labels: element.labels,
        datasets: [{
          label: 'Cantidad',
          data: element.data,
          borderWidth: 1,
        }]
      },
      options: {
        plugins: {
          labels: {
            render: 'percentage',
            fontColor: 'black',
            size: 25
          }
        },
        scales: {
          y: {
            beginAtZero: true
          }
        },
        layout: {
          padding: {
            // Ajusta el espacio alrededor de la gráfica si es necesario
          }
        },
        responsive: true, // Permite que la gráfica sea responsive
        maintainAspectRatio: false, // Desactiva el mantenimiento del aspecto para ajustar el tamaño según el contenedor
        aspectRatio: 1, // Puedes definir un aspect ratio específico si lo deseas
      }
    });
  }

  
});