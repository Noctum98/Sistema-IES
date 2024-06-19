@extends('layouts.app-prueba')

@section('content')

    @if(Session::has('success_message'))
        <div class="alert alert-success alert-dismissible" role="alert">
            {!! session('success_message') !!}

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="text-bg-theme p-5">



        @if(count($adminManagers) == 0)
            <div class="card-body text-center">
                <h4>No se encontraron managers.</h4>
            </div>
        @else
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach($adminManagers as $managers)
                    <div class="card col--sm-4 mx-auto border-2 border-primary border-left-0 shadow" >
                        <div class="card-body d-flex">
                            <div class="flex-grow-1 d-flex align-items-center justify-content-center" style="width: 30%;">
                                <i class="{{$managers->icon}} fa-3x text-primary"></i>
                            </div>
                            <div style="width: 70%;">
                                <h5 class="card-title">{{$managers->name}} / {{$managers->model}}</h5>
                                <p class="card-text">
                                    <a href="{{route($managers->link)}}" class="btn btn-outline-primary" >Administrar</a>
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach

                {!! $adminManagers->links('pagination') !!}
            </div>

        @endif

    </div>
@endsection

