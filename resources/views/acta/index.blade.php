@extends('layouts.app')

@section('title', 'ACTA DE ENTREGA Y RECEPCIÓN')
@section('subtitle', 'Welcome')
@section('content_header_title', 'Home')
@section('content_header_subtitle', 'ACTA DE ENTREGA Y RECEPCIÓN')

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

        @if($ban == 0)
        {{-- Verificar si tiene permiso para iniciar --}}
        @if(isset($intervencionPermitida) && !$intervencionPermitida)
        <x-adminlte-callout theme="danger" title="ACCESO RESTRINGIDO" icon="fas fa-ban">
            <p class="mb-3">
                No puedes iniciar el proceso de entrega-recepción. <br>
                Pide a tu autoridad inmediata superior que solicite una intervención.
            </p>

            <p class="mb-0">
                Una vez generada la intervención, podrás iniciar el acto de entrega-recepción.
            </p>
            
        </x-adminlte-callout>
        @else
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
                            <button class="btn btn-outline-success btn-sm btn-block shadow" type="submit" onclick="this.disabled=true; this.form.submit();">
                                <b>{{ $acta->otipoacta }}</b>
                            </button>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div>
        </x-adminlte-callout>
        @endif

        @elseif($ban == 1)

            @if($datosacta->ock == 0)
                <div class="row mb-3">
                    <div class="col-md-8">
                        <p class="text-info">
                            INGRESA LOS SIGUIENTES DATOS PARA COMENZAR CON EL REGISTRO DEL {{ optional($datosacta->tipoacta)->otipoacta }}
                        </p>
                    </div>
                    <div class="col-md-4 text-end">
                        <form method="post" action="{{ route('entrega-recepcion.cambiar-tipo') }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-warning btn-sm" onclick="return confirm('¿Estás seguro de que quieres cambiar el tipo de acta? Se perderá la información ingresada.')">
                                <i class="fas fa-exchange-alt"></i> CAMBIAR TIPO
                            </button>
                        </form>
                    </div>
                </div>

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
