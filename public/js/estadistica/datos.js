$(document).ready(function () {
  $('#accordionPreguntas').on('shown.bs.collapse', function () {
    // Renderizar la gráfica cada vez que se abre un elemento del acordeón
    renderizarGrafica();
});

  $("#datos-form").submit(function (e) {
    e.preventDefault();
    let sede_id = $("#sede_id").val() ? $("#sede_id").val() : 0;
    let carrera_id = $("#carrera_id").val() ? $("#carrera_id").val() : 0;
    let año = $("#año").val() ? $("#año").val() : 0;


    let url = '/estadistica/obtenerGraficos/' + sede_id + "/" + carrera_id + '/' + año;

    $.get(url, function (response) {  
      $("#graficos").removeClass('d-none');
    
      response.data.forEach(element => {
        renderizarGrafica(element)
      });
    });

  });

  renderizarGrafica = function (element) {
    const ctx = document.getElementById(element.identificador);
    new Chart(ctx, {
      type: 'pie',
      data: {
        labels: element.labels,
        datasets: [{
          label: 'Cantidad',
          data: element.data,
          borderWidth: 1,
          backgroundColor: ['#FF6384', '#36A2EB','#FFCE56']

        }]
      },
      options: {
        plugins: {
          labels: {
            render: 'percentage',
            fontColor: 'black',
            size:25
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