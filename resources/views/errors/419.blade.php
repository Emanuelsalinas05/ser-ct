@extends('layouts.log')

@section('title')
    SISTEMA DE ENTREGA Y RECEPCIÓN PARA CENTROS DE TRABAJO
@endsection

@section('header_img')
<div class="row">
    <div class="col-7" style="text-align: right;">
        <img src="img/log_edomex_inicio_.png" class="anch img-fluid" >
    </div>
    <div class="col-5" style="text-align: left;" >
        <ul style="color:#802434; font-family: Italic;">  
            <b><i style=" font-size:40px;">SEIEM</i> 
            <p>
            <i style="font-size: 16px;">Sistema de Entrega y Recepción para Centros de Trabajo</i></p>
            </b>
        </ul>
    </div>
</div>
@endsection

@section('header_text')
    <i style=" font-family: Italic; font-size:25px;">
        <b class="guinda">  Sistema de Entrega y Recepción  para Centros de Trabajo
        </b>
        <br>
    </i>
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
                    <img class="img-fluid " src="img/e-r.png" width="50%">
                @endsection

                @section('login')

                    @include('layouts.form-log')


                @endsection
            @endauth
        @endif

@endsection

