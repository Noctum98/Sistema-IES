$(document).ready(function () {

  $("#datos-form").submit(function (e) {
    e.preventDefault();
    let sede_id = $("#sede_id").val() ? $("#sede_id").val() : 0;
    let carrera_id = $("#carrera_id").val() ? $("#carrera_id").val() : 0;
    let año = $("#año").val() ? $("#año").val() : 0;


    let url = '/estadistica/obtenerGraficos/' + sede_id + "/" + carrera_id + '/' + año;

    $.get(url, function (response) {
      var data = response.data;
      response.data.forEach(element => {
        $("#" + element.identificador).removeClass('d-none');
        const ctx = document.getElementById(element.identificador);

        new Chart(ctx, {
          type: 'doughnut',
          data: {
            labels: response.labels,
            datasets: [{
              label: '# of Votes',
              data: response.data,
              borderWidth: 1
            }]
          },
          options: {
            scales: {
              y: {
                beginAtZero: true
              }
            }
          }
        });
      });
    });

  });

});