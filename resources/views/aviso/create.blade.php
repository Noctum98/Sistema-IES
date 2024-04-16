@extends('layouts.app-prueba')
<link href="{{ asset('css/font-awesome/6.5.2/css/all.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('css/font-awesome/6.5.2/css/v4-shims.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('css/font-awesome/6.5.2/css/v5-font-face.min.css') }}" rel="stylesheet"/>
@section('content')
    <link rel="stylesheet" type="text/css" href="{{asset('js/editor_web/styles/simditor.css')}}"/>
    <div class="card text-bg-theme">

        <div class="card-header d-flex justify-content-between align-items-center p-3">
            <h4 class="m-0">Create New Aviso</h4>
            <div>
                <a href="{{ route('aviso.aviso.index') }}" class="btn btn-primary" title="Show All Aviso">
                    <span class="fa-solid fa-table-list" aria-hidden="true"></span>
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

            <form method="POST" class="needs-validation" novalidate action="{{ route('aviso.aviso.store') }}"
                  accept-charset="UTF-8" id="create_aviso_form" name="create_aviso_form">
                {{ csrf_field() }}
                @include ('aviso.form', [
                                            'aviso' => null,
                                          ])

                <div class="col-lg-10 col-xl-9 offset-lg-2 offset-xl-3">
                    <input class="btn btn-primary" type="submit" value="Add">
                </div>

            </form>

        </div>
    </div>

@endsection
@section('scripts')
    <script src="{{asset('js/editor_web/scripts/module.js')}}"></script>
    <script src="{{asset('js/editor_web/scripts/hotkeys.js')}}"></script>
    <script src="{{asset('js/editor_web/scripts/simditor.js')}}"></script>

@endsection

