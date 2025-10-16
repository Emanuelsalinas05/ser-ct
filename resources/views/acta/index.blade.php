@extends('layouts.app')

@section('title', 'ACTO DE ENTREGA-RECEPCIÓN')
@section('subtitle', 'Welcome')
@section('content_header_title', 'Home')
@section('content_header_subtitle', 'ACTO DE ENTREGA - RECEPCIÓN')

@section('content')
<div class="col-12 card card-secondary card-outline shadow">
    <div class="card-header bg-light shadow-sm d-flex mb-2 justify-content-between">
        <b><i class="nav-icon fa fa-paste"></i>&nbsp;
            {{ $ban == 0 ? '' : optional($datosacta->tipoacta)->otipoacta . '.' }}
        </b>
    </div>

    <div class="card-body table-responsive">

        {{-- NUEVO: mensajes flash --}}
        @if(session('success'))
            <x-adminlte-callout theme="success" title="Listo" icon="fas fa-check">
                {{ session('success') }}
            </x-adminlte-callout>
        @endif
        @if(session('error'))
            <x-adminlte-callout theme="danger" title="Error" icon="fas fa-times">
                {{ session('error') }}
            </x-adminlte-callout>
        @endif

        {{-- Si no se ha generado la intervención, advertencia --}}
        @if(isset($intervencionPermitida) && !$intervencionPermitida)
        <x-adminlte-callout theme="danger" title="ACCESO RESTRINGIDO" icon="fas fa-ban">
            <p class="mb-3">
                Aún no puedes iniciar el acto de entrega-recepción. <br>
                Solicita a tu autoridad inmediata superior que genere la solicitud de intervención
                correspondiente.
            </p>

            <p class="mb-0">
                Una vez generada la intervención, podrás iniciar el acto de entrega-recepción.
            </p>
            
        </x-adminlte-callout>

        @elseif($ban == 0)
        <x-adminlte-callout theme="info"
                            title="SELECCIONA EL TIPO DE ENTREGA - RECEPCIÓN A REALIZAR"
                            class="text-info"
                            icon="fa fa-file">
            <br>
            <div class="container">
                <div class="row text-center">
                    @foreach($tipoacta as $acta)
                    <div class="col-sm">
                        <form method="post" action="{{ route('entrega-recepcion.store') }}">
                            @csrf
                            <input type="hidden" name="tipoacta" value="{{ $acta->id }}">
                            <button class="btn btn-outline-success btn-sm btn-block shadow" type="submit">
                                <b>{{ $acta->otipoacta }}</b>
                            </button>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div>
        </x-adminlte-callout>

        @elseif($ban == 1)

            @if($datosacta->ock == 0)
                <p class="text-info">
                    INGRESA LOS SIGUIENTES DATOS PARA COMENZAR CON EL REGISTRO DEL {{ optional($datosacta->tipoacta)->otipoacta }}
                </p>

                @if($datosacta->id_tipoacta == 1)
                    @include('acta.00-form-acta')
                @elseif($datosacta->id_tipoacta == 2)
                    @include('acta.00-form-actac')
                @endif
            @else
                @include('acta.01-avances')
            @endif

        @endif
    </div>
</div>
@stop
