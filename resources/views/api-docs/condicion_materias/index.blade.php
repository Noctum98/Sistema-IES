@extends('layouts.app-prueba')

@section('content')

<h2>Condicion Materias</h2>
Allows you to list, create, edit, show and delete condicion materias.
<hr>

<h2>Disponible Resources</h2>
<div class="card mb-3" id="index-documentation">

    <div class="card-header text-bg-primary d-flex justify-content-between align-items-center p-3">
        <div>
            <span class="">GET</span>
            <span><strong>/{{ Route::getRoutes()->getByName('api-docs.condicion_materias.condicion_materia.index')->uri }}</strong></span>

            <p class="mb-0">Retrieve existing condicion materias.</p>
        </div>
        <div>
            <button type="button" data-bs-toggle="collapse" data-bs-target="#index" aria-controls="index" class="btn btn-primary btn-sm" aria-expanded="false">
                <span class="fa fa-chevron-down"></span>
            </button>
        </div>
    </div>

    <div class="card-body collapse" id="index">
        <h3><strong>Request</strong></h3>
        No parameters.

        <hr>
        <h3><strong>Response</strong></h3>

        <p>The API's response will be JSON based data. The JSON object will be structured as follow</p>
        <p></p>

        <h4><strong class="text-success">200 - Ok</strong></h4>
        <p class="text-muted">Request was successfully.</p>
        <table class="table table-stripped">
            <tbody>
                <tr>
                    <td>success</td>
                    <td>Boolean</td>
                    <td>Was the request successful or not.</td>
                </tr>
                <tr>
                    <td>message</td>
                    <td>String</td>
                    <td>The success message</td>
                </tr>

                <tr>
                    <td>data</td>
                    <td>Array</td>
                    <td>
                        The array's key is the condicion materia property name where the value is the assigned value to the retrieved condicion materia.
                    </td>
                </tr>

                <tr>
                    <td>links</td>
                    <td>Array</td>
                    <td>
                        <table class="table table-stripped">
                            <thead>
                                <tr>
                                    <th class="col-md-2">Key</th>
                                    <th class="col-md-2">Data Type</th>
                                    <th class="col-md-8">Descripción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>first</td>
                                    <td>String</td>
                                    <td>Link to retrieve first page.</td>
                                </tr>

                                <tr>
                                    <td>last</td>
                                    <td>String</td>
                                    <td>Link to retrieve last page.</td>
                                </tr>

                                <tr>
                                    <td>prev</td>
                                    <td>String</td>
                                    <td>Link to retrieve previous page.</td>
                                </tr>

                                <tr>
                                    <td>next</td>
                                    <td>String</td>
                                    <td>Link to retrieve next page.</td>
                                </tr>
                            </tbody>
                        </table>

                    </td>
                </tr>


                <tr>
                    <td>meta</td>
                    <td>Array</td>
                    <td>
                        <table class="table table-stripped">
                            <thead>
                                <tr>
                                    <th class="col-md-2">Key</th>
                                    <th class="col-md-2">Data Type</th>
                                    <th class="col-md-8">Descripción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>current_page</td>
                                    <td>Integer</td>
                                    <td>The number of current page.</td>
                                </tr>

                                <tr>
                                    <td>from</td>
                                    <td>Integer</td>
                                    <td>The index of first retrieved condicion materia.</td>
                                </tr>

                                <tr>
                                    <td>last_page</td>
                                    <td>Integer</td>
                                    <td>The number of the last page.</td>
                                </tr>

                                <tr>
                                    <td>Path</td>
                                    <td>String</td>
                                    <td>The base link to the api resource.</td>
                                </tr>

                                <tr>
                                    <td>per_page</td>
                                    <td>Integer</td>
                                    <td>The number of condicion materias per page.</td>
                                </tr>

                                <tr>
                                    <td>to</td>
                                    <td>Integer</td>
                                    <td>The index of last retrieved condicion materia.</td>
                                </tr>

                                <tr>
                                    <td>total</td>
                                    <td>Integer</td>
                                    <td>The total of the Disponible pages.</td>
                                </tr>
                            </tbody>
                        </table>

                    </td>
                </tr>

            </tbody>
        </table>



    </div>
</div>


<div class="card mb-3" id="store-documentation">

    <div class="card-header text-bg-success d-flex justify-content-between align-items-center p-3">
        <div>
            <span>POST</span>
{{--             <span><strong>/{{ Route::getRoutes()->getByName('api.condicion_materias.condicion_materia.store')->uri() }}</strong></span>--}}
            <p class="mb-0">Crear  condicion materia.</p>
        </div>
        <div>
            <button type="button" data-bs-toggle="collapse" data-bs-target="#store" aria-controls="store" class="btn btn-success btn-sm" aria-expanded="false">
                <span class="fa fa-chevron-down"></span>
            </button>
        </div>
    </div>

    <div class="card-body collapse" id="store">
        <h3><strong>Request</strong></h3>

        @include('api-docs.condicion_materias.fields-list', [
            'withValidation' => true
        ])

        <hr>
        <h3><strong>Response</strong></h3>
        <p>The API's response will be JSON based data. The JSON object will be structured as follow</p>
        <p></p>

        @include('api-docs.condicion_materias.retrieved')
        @include('api-docs.condicion_materias.failed-to-retrieve')
        @include('api-docs.condicion_materias.failed-validation')


    </div>
</div>



<div class="card mb-3" id="update-documentation">

    <div class="card-header text-bg-warning d-flex justify-content-between align-items-center p-3">
        <div>
            <span class="">POST</span>
{{--            <span><strong>/{{ Route::getRoutes()->getByName('api.condicion_materias.condicion_materia.update')->uri() }}</strong></span>--}}
            <p class="mb-0">Actualiza una condicion materia.</p>
        </div>
        <div>
            <button type="button" data-bs-toggle="collapse" data-bs-target="#update" aria-controls="update" class="btn btn-warning btn-sm" aria-expanded="false">
                <span class="fa fa-chevron-down"></span>
            </button>
        </div>
    </div>

    <div class="card-collapse collapse" id="update">
        <div class="card-body">

            <h3><strong>Request</strong></h3>

            @include('api-docs.condicion_materias.fields-list', [
                'withValidation' => true,
                'withPathId' => true,
            ])

            <hr>
            <h3><strong>Response</strong></h3>
            <p>The API's response will be JSON based data. The JSON object will be structured as follow</p>
            <p></p>

            @include('api-docs.condicion_materias.retrieved')
            @include('api-docs.condicion_materias.failed-to-retrieve')
            @include('api-docs.condicion_materias.failed-validation')


        </div>
    </div>
</div>



<div class="card mb-3" id="show-documentation">

    <div class="card-header text-bg-info d-flex justify-content-between align-items-center p-3">
        <div>
            <span class="">GET</span>
{{--            <span><strong>/{{ Route::getRoutes()->getByName('api.condicion_materias.condicion_materia.show')->uri() }}</strong></span>--}}
            <p class="mb-0">Retrieve existing condicion materia.</p>
        </div>
        <div>
            <button type="button" data-bs-toggle="collapse" data-bs-target="#show" aria-controls="show" class="btn btn-info btn-sm" aria-expanded="false">
                <span class="fa fa-chevron-down"></span>
            </button>
        </div>
    </div>

    <div class="card-body collapse" id="show">

        <h3><strong>Request</strong></h3>

        <table class="table table-stripped">
            <thead>
                <tr>
                    <th class="col-md-2">Nombre parámetro</th>
                    <th class="col-md-2">Tipo Dato</th>
                    <th class="col-md-2">Tipo Parámetro</th>
                    <th class="col-md-6">Descripción</th>
                </tr>
            </thead>
            <tbody>

                <tr>
                    <td>condicion materia</td>
                    <td>Integer</td>
                    <td><span class="label label-info" title="This parameter is part of the url">Path</span></td>
                    <td>The unique id of the condicion materia to retrieve</td>
                </tr>
            </tbody>
        </table>


        <hr>
        <h3><strong>Response</strong></h3>
        <p>The API's response will be JSON based data. The JSON object will be structured as follow </p>
        <p></p>

        @include('api-docs.condicion_materias.retrieved')
        @include('api-docs.condicion_materias.failed-to-retrieve')


    </div>
</div>


<div class="card card-danger mb-3" id="destroy-documentation">

    <div class="card-header text-bg-danger d-flex justify-content-between align-items-center p-3">
        <div>
            <span class="">DELETE</span>
{{--            <span><strong>/{{ Route::getRoutes()->getByName('api.condicion_materias.condicion_materia.destroy')->uri() }}</strong></span>--}}
            <p class="mb-0">Delete existing condicion materia.</p>
        </div>
        <div>
            <button type="button" data-bs-toggle="collapse" data-bs-target="#destroy" aria-controls="destroy" class="btn btn-danger btn-sm" aria-expanded="false">
                <span class="fa fa-chevron-down"></span>
            </button>
        </div>
    </div>

    <div class="card-body collapse" id="destroy">

        <h3><strong>Request</strong></h3>

        <table class="table table-stripped">
            <thead>
                <tr>
                    <th class="col-md-2">Parameter Nombre</th>
                    <th class="col-md-2">Data Type</th>
                    <th class="col-md-2">Parameter Type</th>
                    <th class="col-md-6">Descripción</th>
                </tr>
            </thead>
            <tbody>

                <tr>
                    <td>condicion materia</td>
                    <td>Integer</td>
                    <td><span class="label label-info" title="This parameter is part of the url">Path</span></td>
                    <td>The id of the condicion materia to delete.</td>
                </tr>
            </tbody>
        </table>


        <hr>
        <h3><strong>Response</strong></h3>
        <p>The API's response will be JSON based data. The JSON object will be structured as follow</p>
        <p></p>

        @include('api-docs.condicion_materias.retrieved')
        @include('api-docs.condicion_materias.failed-to-retrieve')


    </div>

</div>

<hr>

<h2>Model Definition</h2>
<div class="card" id="condicion materia-model-documentation">

    <div class="card-header text-bg-secondary d-flex justify-content-between align-items-center p-3">
        <div>
            <span class="">Condicion Materia</span>
        </div>
        <div>
            <button type="button" data-bs-toggle="collapse" data-bs-target="#model-definitions" aria-controls="model-definitions" class="btn btn-secondary btn-sm" aria-expanded="false">
                <span class="fa fa-chevron-down"></span>
            </button>
        </div>
    </div>

    <div class="card-body collapse" id="model-definitions">
        <table class="table table-stripped">
            <thead>
                <tr>
                    <th>Field Nombre</th>
                    <th>Field Type</th>
                    <th>Descripción</th>
                </tr>
            </thead>
            <tbody>
                    <tr>
            <td>id</td>
            <td>String</td>
            <td>The id of the model.</td>
        </tr>

        <tr>
            <td>nombre</td>
            <td>String</td>
            <td>The nombre of the model.</td>
        </tr>

        <tr>
            <td>identificador</td>
            <td>String</td>
            <td>The identificador of the model.</td>
        </tr>

        <tr>
            <td>habilitado</td>
            <td>Boolean</td>
            <td>The habilitado of the model.</td>
        </tr>

        <tr>
            <td>operador id</td>
            <td>String</td>
            <td>The operador of the model.</td>
        </tr>

        <tr>
            <td>Borrado</td>
            <td>DateTime</td>
            <td>The Borrado of the model.</td>
        </tr>

        <tr>
            <td>created at</td>
            <td>DateTime</td>
            <td>The created at of the model.</td>
        </tr>

        <tr>
            <td>Actualizado</td>
            <td>DateTime</td>
            <td>Actualizado el modelo.</td>
        </tr>

            </tbody>
        </table>
    </div>
</div>

@endsection
