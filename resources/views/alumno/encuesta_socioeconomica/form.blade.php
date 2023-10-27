@extends('layouts.app-prueba')
@section('content')
<div class="container col-md-8 p-3">
    <div class="card text-white bg-primary mb-3">
        <div class="card-header">
            <h2>{{$carrera->sede->nombre.' - '.$carrera->nombre}} - Encuesta Socioeconómica y Motivacional {{ date('Y') }}</h2>
        </div>
        <div class="card-body">
            <p class="card-text">Teniendo en cuenta que nuestra institución trabaja siempre centrando sus acciones en el/la estudiante, es que la siguiente encuesta ha sido confeccionada desde el Área Social y de Políticas Estudiantiles (ASyPE) con el objetivo de elaborar un diagnóstico socioeconómico y motivacional de estudiantes de nuestra oferta educativa.</p>
            <p class="card-text">Los datos que nos aportes al contestar la encuesta, nos permitirán conocer e interpretar tu realidad y la de tus pares; y de esta forma identificar situaciones especiales a tener en cuenta para futuros proyectos y para la planificación de acciones, logrando así la educación integral, que no sólo abarque lo académico, sino también, aspectos que hacen a TU PERSONA.-</p>
            <p class="card-text"> Es por lo mismo que solicitamos completes las siguientes encuestas, dando veracidad a los datos, y siendo consciente que de esta forma puedes PARTICIPAR en la construcción de TU CARRERA PROFESIONAL.-</p>
            <p class="card-text">Los datos aportados, serán reservados solo para el personal Directivo, además del Área Social y de Políticas Estudiantiles (ASyPE), los cuales mantendrán la debida confidencialidad.</b></p>
            <p class="card-text"><b>Muchas gracias por tu colaboración y participación. Equipo de Área Social y de Políticas Estudiantiles.</p>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="form-group">
                <label for="nombre_preferido" class="text-primary">
                    <h4>¿Cómo te gusta que te llamen?</h4>
                </label>
                <input type="text" class="form-control mt-2" id="nombre_preferido" name="nombre_preferido" required>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="form-group">
                <label for="nombre_preferido" class="text-primary">
                    <h4>Identidad de género</h4>
                </label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="identidad_genero" id="exampleRadios1" value="femenino">
                    <label class="form-check-label" for="exampleRadios1">
                        Femenino
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="identidad_genero" id="exampleRadios2" value="masculino">
                    <label class="form-check-label" for="exampleRadios2">
                        Masculino
                    </label>
                </div>
                <div class="form-check disabled">
                    <input class="form-check-input" type="radio" name="identidad_genero" id="exampleRadios3" value="transgénero">
                    <label class="form-check-label" for="exampleRadios3">
                        Trangénero
                    </label>
                </div>
                <div class="form-check disabled">
                    <input class="form-check-input" type="radio" name="identidad_genero" id="exampleRadios3" value="otro">
                    <label class="form-check-label" for="exampleRadios3">
                        Otros
                    </label>
                </div>
                <input type="text" class="form-control mt-2" id="identidad_genero_otra" name="identidad_genero_otra" disabled>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="form-group">
                <label for="nombre_preferido" class="text-primary">
                    <h4>Empresa de servicio de telefonía de tu celular</h4>
                </label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="empresa_telefono" id="empresa_telefono1" value="claro">
                    <label class="form-check-label" for="empresa_telefono1">
                        Claro
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="empresa_telefono" id="empresa_telefono2" value="movistar">
                    <label class="form-check-label" for="empresa_telefono2">
                        Movistar
                    </label>
                </div>
                <div class="form-check disabled">
                    <input class="form-check-input" type="radio" name="empresa_telefono" id="empresa_telefono3" value="personal">
                    <label class="form-check-label" for="empresa_telefono3">
                        Personal
                    </label>
                </div>
                <div class="form-check disabled">
                    <input class="form-check-input" type="radio" name="empresa_telefono" id="empresa_telefono3" value="twneti">
                    <label class="form-check-label" for="empresa_telefono3">
                        Twenti
                    </label>
                </div>
                <div class="form-check disabled">
                    <input class="form-check-input" type="radio" id="empresa_telefono3" value="otra">
                    <label class="form-check-label" for="empresa_telefono3">
                        Otra
                    </label>
                </div>
                <input type="text" class="form-control mt-2" id="empresa_telefono" name="empresa_telefono" disabled>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="form-group">
                <label for="nombre_preferido" class="text-primary">
                    <h4>¿Tenes acceso a internet?</h4>
                </label>
                <div class="form-check">
                    <input class="form-check-input" name="acceso_internet[]" type="checkbox" value="desde celular con datos" id="defaultCheck1">
                    <label class="form-check-label" for="defaultCheck1">
                        Desde tu celular, con datos móviles
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="acceso_internet[]" type="checkbox" value="desde casa en red" id="defaultCheck1">
                    <label class="form-check-label" for="defaultCheck1">
                        Desde tu casa, en red
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="acceso_internet[]" type="checkbox" value="desde casa de conocido" id="defaultCheck1">
                    <label class="form-check-label" for="defaultCheck1">
                        Desde la casa de un conocido o familiar
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="acceso_internet[]" type="checkbox" value="desde celular familiar" id="defaultCheck1">
                    <label class="form-check-label" for="defaultCheck1">
                        Desde el celular familiar
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="acceso_internet[]" type="checkbox" value="no tiene" id="defaultCheck1">
                    <label class="form-check-label" for="defaultCheck1">
                        No tengo acceso a internet
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="acceso_internet[]" type="checkbox" value="desde red publica o wifi" id="defaultCheck1">
                    <label class="form-check-label" for="defaultCheck1">
                        Desde alguna red publica de WIFI
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="acceso_internet[]" type="checkbox" value="" id="defaultCheck1">
                    <label class="form-check-label" for="defaultCheck1">
                        Otros
                    </label>
                </div>
                <input type="text" class="form-control mt-2" id="empresa_telefono" name="acceso_internet[]" disabled>
            </div>
        </div>
    </div>

</div>
@endsection