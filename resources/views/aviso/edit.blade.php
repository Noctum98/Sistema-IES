@extends('layouts.app-prueba')
<link href="{{ asset('css/font-awesome/6.5.2/css/all.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('css/font-awesome/6.5.2/css/v4-shims.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('css/font-awesome/6.5.2/css/v5-font-face.min.css') }}" rel="stylesheet"/>
@section('content')

    <div class="card text-bg-theme">

        <div class="card-header d-flex justify-content-between align-items-center p-3">
            <h4 class="m-0">{{ !empty($title) ? $title : 'Aviso' }}</h4>
            <div>
                <a href="{{ route('aviso.aviso.index') }}" class="btn btn-primary" title="Show All Aviso">
                    <span class="fa-solid fa-table-list" aria-hidden="true"></span>
                </a>

                <a href="{{ route('aviso.aviso.create') }}" class="btn btn-secondary" title="Create New Aviso">
                    <span class="fa-solid fa-plus" aria-hidden="true"></span>
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
                  action="{{ route('aviso.aviso.update', $aviso->id) }}" id="edit_aviso_form"
                  name="edit_aviso_form" accept-charset="UTF-8">
                {{ csrf_field() }}
                <input name="_method" type="hidden" value="PUT">
                @include ('aviso.form', [
                                            'aviso' => $aviso,
                                          ])

                <div class="col-lg-10 col-xl-9 offset-lg-2 offset-xl-3">
                    <input class="btn btn-primary" type="submit" value="Update">
                </div>
            </form>

        </div>
    </div>

@endsection
