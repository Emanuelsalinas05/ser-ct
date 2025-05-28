@extends('layouts.app')

@section('title', 'Inicio')
@section('content_header_title', 'Panel principal')
@section('content_header_subtitle', 'Bienvenido(a) al sistema')

@section('content')

@php
$user = Auth::user();
$intervencionGenerada = \App\Models\Intervencion::where('idct_escuela', $user->id_ct)
->where('ogenerada', 1)
->exists();
@endphp

{{-- Mensajes flash --}}
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
</div>
@endif

{{-- Advertencia solo para entregadores sin intervención --}}
@if($user->orol == 3 && !$intervencionGenerada)
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>¡Atención!</strong> No se ha generado aún una intervención para tu centro de trabajo.
    <br>Debes solicitarla antes de poder realizar el procedimiento de Entrega - Recepción.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
</div>
@endif

{{-- Panel principal --}}
<div class="card card-outline card-primary shadow">
    <div class="card-header bg-white">
        <h5 class="mb-0"><i class="fas fa-home"></i> Inicio</h5>
    </div>
    <div class="card-body">
        <p>Bienvenido(a), <strong>{{ $user->name }}</strong>. Selecciona una opción del menú lateral para comenzar.</p>

        <div class="row mt-4">
            <div class="col-md-4">
                <x-adminlte-callout theme="info" title="Entrega-Recepción">
                    Accede al procedimiento de entrega-recepción si ya has solicitado la intervención correspondiente.
                </x-adminlte-callout>
            </div>
            <div class="col-md-4">
                <x-adminlte-callout theme="teal" title="Solicitudes">
                    Puedes realizar solicitudes como el Certificado de No Adeudo desde el menú.
                </x-adminlte-callout>
            </div>
        </div>
    </div>
</div>

{{-- Si el usuario es entregador y ya hay intervención, mostrar botones --}}
@if($user->orol == 3 && $intervencionGenerada)
<div class="col-12 mt-4 card card-secondary card-outline shadow">
    <div class="card-header bg-light shadow-sm d-flex mb-2">
        <div class="d-flex justify-content-between">
            <b><i class="nav-icon fa fa-paste"></i>&nbsp;
                Realizar procedimiento de Entrega - Recepción
            </b>
        </div>
    </div>

    <div class="card-body table-responsive">
        <li>Selecciona el tipo de Entrega-Recepción a realizar</li>
        <br>

        <div class="container">
            <div class="row text-center">
                <div class="col-sm">
                    <x-adminlte-callout>
                        <button class="btn btn-outline-info btn-sm btn-block">
                            <b>ACTA DE ENTREGA Y RECEPCIÓN</b>
                        </button>
                    </x-adminlte-callout>
                </div>

                <div class="col-sm">
                    <x-adminlte-callout>
                        <button class="btn btn-outline-info btn-sm btn-block">
                            <b>ACTA CIRCUNSTANCIADA DE ENTREGA Y RECEPCIÓN</b>
                        </button>
                    </x-adminlte-callout>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
