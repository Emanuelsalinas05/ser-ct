@extends('layouts.log')

@section('title')
    SISTEMA DE ENTREGA Y RECEPCIÓN PARA CENTROS DE TRABAJO
@endsection

@section('header_img')
    <div class="row w-100 align-items-center px-4 mt-3 mb-4">

        <!-- Logo Izquierdo (Edomex) -->
        <div class="col-6 d-flex justify-content-start align-items-center">
            <img src="img/log_edomex_inicio_.png" class="anch img-fluid" >
        </div>

        <!-- Logo Derecho (SEIEM) -->
        <div class="col-6 d-flex flex-column align-items-end justify-content-center">
            <p class="m-0" style="color:#424040; font-family: Italic;">
                <b><i style="font-size:40px;">SEIEM</i></b>
            </p>
        </div>

    </div>
@endsection


@section('content')

    @if (Route::has('login'))
        @auth
            @section('content_img')
                <a class="nav-link" href="{{ route('home') }}" >
                    <img class="img-fluid" src="img/ircursos.png" width="70%">
                </a>
            @endsection
        @else
            @section('content_img')
                <div class="d-none d-md-flex justify-content-start justify-content-center-sm align-items-start" style="margin-top: 80px; padding-left: 30px;">
                    <img class="img-fluid custom-img" src="img/e-r.png">
                </div>

            @endsection

            @section('login')

                @include('layouts.form-log')


            @endsection
        @endauth
    @endif

@endsection

