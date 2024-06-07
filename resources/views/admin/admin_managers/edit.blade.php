@extends('layouts.app-prueba')

@section('content')

    <div class="card text-bg-theme">

        <div class="card-header d-flex justify-content-between align-items-center p-3">
            <h4 class="m-0">{{ !empty($adminManager->name) ? $adminManager->name : 'Admin Manager' }}</h4>
            <div>
                <a href="{{ route('admin_managers.admin_manager.index') }}" class="btn btn-primary"
                   title="Listar">
                    <span class="fa-solid fa-table-list" aria-hidden="true"></span>
                </a>

                <a href="{{ route('admin_managers.admin_manager.create') }}" class="btn btn-secondary"
                   title="Agregar Admin Manager">
                    <span class="fa-solid fa-plus" aria-hidden="true"></span> Agregar
                </a>
            </div>
        </div>

        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <ul class="list-unstyled mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" class="needs-validation" novalidate
                  action="{{ route('admin_managers.admin_manager.update', $adminManager->id) }}"
                  id="edit_admin_manager_form" name="edit_admin_manager_form" accept-charset="UTF-8">
                {{ csrf_field() }}
                <input name="_method" type="hidden" value="PUT">
                @include ('admin.admin_managers.form', [
                                            'adminManager' => $adminManager,
                                          ])

                <div class="col-lg-10 col-xl-9 offset-lg-2 offset-xl-3">
                    <input class="btn btn-primary" type="submit" value="Actualizar">
                </div>
            </form>

        </div>
    </div>

@endsection
