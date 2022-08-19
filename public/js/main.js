window.addEventListener("load", function () {

	urlActual = window.location;

	// BUSCADOR DE ALUMNOS

	if (document.getElementById('buscador-alumnos')) {
		let buscador_alumno = document.getElementById('buscador-alumnos');
		buscador_alumno.addEventListener('submit', function () {
			let busqueda = document.getElementById('busqueda');
			buscador_alumno.setAttribute('action', '/alumnos/' + busqueda.value);
			this.submit();
		});
	}

	// Buscador Preinscripciones
	if (document.getElementById('buscador')) {

		let buscador = document.getElementById('buscador');

		buscador.addEventListener('submit', function () {
			let busqueda = document.getElementById('busqueda');
			buscador.setAttribute('action', '/preinscripcion/carreras/' + busqueda.value);
			this.submit();
		});
	}

	// BOTON LOADING
	if (document.getElementById('loading')) {
		console.log('Hay un boton de loading');
		let boton = document.getElementById('loading');

		boton.addEventListener('click',function(){
			this.value = 'Espere por favor';
			this.style.color = 'black';
			this.style.border = '1px solid #ccc';
			this.style.boxShadow = 'none';
			this.style.background = '#ccc';
		});
	}

	// PETICION AJAX ASISTENCIAS Y EFECTOS

	if (document.getElementById('botones-asistencia')) {
		let botones = document.getElementsByClassName('bn-presente');
		let seccion_b = document.getElementById('botones-asistencia');


		for (var i = 0; i < botones.length; i++) {
			botones[i].addEventListener('click', function () {
				var urlpath = url + 'alumno/asis/' + this.id + '/';
				var boton = this;

				// Separo los parametros
				var id_split = this.id.split('/');
				var estado = id_split[2];

				// Realizo la petición
				const http = new XMLHttpRequest()

				http.open("GET", urlpath)
				http.onreadystatechange = function () {

					if (this.readyState == 4 && this.status == 200) {
						boton.style.color = 'white';
						if (estado == 'presente') {
							boton.classList.remove("btn-outline-success");
							boton.classList.add("btn-success");
							boton.style.color = 'white';
						} else {
							boton.classList.remove("btn-outline-danger");
							boton.classList.add("btn-danger");
							boton.style.color = 'white';
						}
					}
				}
				http.send()

				// Verifico los botones y localizo el que esta en la misma linea y le cambio la clase
				if (estado == 'presente') {
					for (var i = 0; i < botones.length; i++) {
						var split = botones[i].id.split('/');

						if (split[0] == id_split[0] && split[2] == 'ausente') {
							botones[i].classList.remove('btn-danger');
							botones[i].classList.add("btn-outline-danger");
							botones[i].style.color = '';
						}
					}
				} else {
					for (var i = 0; i < botones.length; i++) {
						var split = botones[i].id.split('/');
						if (split[0] == id_split[0] && split[2] == 'presente') {
							botones[i].classList.remove('btn-success');
							botones[i].classList.add("btn-outline-success");
							botones[i].style.color = '';

						}
					}
				}
			});
		}
	}

	//LISTA DE DIAS(ASISTENCIA)
	if (document.getElementsByClassName('fecha-titulo')) {
		const fecha = document.getElementsByClassName('fecha-titulo');

		for (let i = 0; i < fecha.length; i++) {
			let split = fecha[i].innerHTML.split('-').reverse();
			fecha[i].innerHTML = split[0] + '-' + split[1] + '-' + split[2];
		}
	}

	// ASIGNAR NOTAS(TRABAJOS)
	if (document.getElementsByClassName('asig-nota')) {
		var botones = document.getElementsByClassName('asig-nota');
		var notas = document.getElementsByClassName('nota');

		var nota_final = 0;

		for (i = 0; i < botones.length; i++) {
			botones[i].addEventListener('click', function (e) {
				e.preventDefault();
				var boton = this;
				let nota = notas[this.id].value;
				let nueva_nota = document.getElementsByClassName('nueva-nota')[this.id];


				if (nota > 0 && nota <= 19) {
					nota_final = 1;
				} else if (nota > 19 && nota <= 39) {
					nota_final = 2;
				} else if (nota > 39 && nota <= 59) {
					nota_final = 3;
				} else if (nota > 59 && nota <= 65) {
					nota_final = 4;
				} else if (nota > 65 && nota <= 71) {
					nota_final = 5;
				} else if (nota > 71 && nota <= 77) {
					nota_final = 6;
				} else if (nota > 77 && nota <= 83) {
					nota_final = 7;
				} else if (nota > 83 && nota <= 89) {
					nota_final = 8;
				} else if (nota > 89 && nota <= 95) {
					nota_final = 9;
				} else if (nota > 95 && nota <= 100) {
					nota_final = 10;
				}

				let params_split = notas[this.id].id.split('/');
				let alumno_id = params_split[0];
				let trabajo_id = params_split[1];
				let prefijo = params_split[2] + '/' + params_split[3];
				console.log(prefijo);

				urlpath = url + prefijo + '/' + alumno_id + '/' + trabajo_id + '/' + nota + '/' + nota_final;
				const http = new XMLHttpRequest();
				http.open("GET", urlpath);
				http.onreadystatechange = function () {
					if (this.readyState == 4 && this.status == 200) {
						boton.innerHTML = nota_final
						boton.classList.remove('btn-primary');
						boton.setAttribute('disabled', '');

						if (nueva_nota) nueva_nota.innerHTML = nota_final;

						if (nota_final >= 6) {
							boton.classList.add('btn-success');
							if (nueva_nota) {
								nueva_nota.classList.add('text-success');
								nueva_nota.classList.remove('text-danger');
							}
						} else {
							boton.classList.add('btn-danger');
							if (nueva_nota) {
								nueva_nota.classList.add('text-danger');
								nueva_nota.classList.remove('text-success');
							}
						}
					}
				}
				http.send();
			});
		}
	}
	// ARTICULO 7MO OCULTAR
	if (document.getElementById('articulo7mo')) {
		var septimo = document.getElementById('7mo');
		var check = document.getElementById('articulo7mo');
		if (check.checked) {
			septimo.style.display = "block";
		} else {
			septimo.style.display = "none";
		}
		check.addEventListener('click', function (e) {
			if (check.checked) {
				septimo.style.display = "block";
			} else {
				septimo.style.display = "none";
			}
		});
	}

	//OTRA RESIDENCIA PAIS
	if (document.getElementById('residencia')) {
		var residencia = document.getElementById('residencia');
		var otrap = document.getElementById('residencia-o');
		var otrainput = document.getElementById('residencia-ot');

		residencia.addEventListener('change', function (event) {
			if (event.target.value == 'otra provincia') {
				otrap.style.display = "block";
				if (otrainput && !otrainput.hasAttribute('value') && !otrainput.hasAttribute('name')) {
					otrainput.setAttribute('value', '');
					otrainput.setAttribute('name', 'residencia');
				}
			} else {
				otrap.style.display = "none";
				if (otrainput.hasAttribute('value')) {
					otrainput.removeAttribute('value');
					otrainput.removeAttribute('name');
				}
			}
		})
	}
	// Cambiar estado Mesas
	if (document.getElementsByClassName('switchinsta')) {
		console.log('Entreee');
		var iswitches = document.getElementsByClassName('switchinsta');

		for (let i = 0; i < iswitches.length; i++) {

			iswitches[i].addEventListener('click', function (e) {
				let nuevo_estado;
				if (this.value == 'inactiva') {
					nuevo_estado = 'activa';
					this.value = 'activa';
				} else {
					nuevo_estado = 'inactiva';
					this.value = 'inactiva';
				}
				urlpath = '/mesas/estado/' + nuevo_estado + '/' + this.id;
				const http = new XMLHttpRequest();
				http.open("GET", urlpath);
				http.onreadystatechange = function () {
					if (this.readyState == 4 && this.status == 200) {
						console.log('Estado cambiado');
					} else {
						console.log('No se cambio nada!');
					}
				}
				http.send();
			});
		}
	}
});