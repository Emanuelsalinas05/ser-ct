@extends('layouts.app')

{{-- Customize layout sections --}}
@section('title', 'CONSULTA DE ENTREGA-RECEPCIÓN')
@section('content_header_title', 'Home')
@section('content_header_subtitle', ' CONSULTA DE ENTREGA-RECEPCIÓN')

{{-- Content body: main page content --}}

@section('content')
<div class="col-12 card card-secondary card-outline shadow" >
    <div class="card-header bg-light shadow-sm d-flex mb-2">
            <div class="d-flex justify-content-between">
                    <i class="nav-icon fa fa-book"></i>&nbsp;
                    {{$datosacta->tipoacta->otipoacta}} DE &nbsp;&nbsp;
                    <b>{{$datosacta->elct->oclave}} - {{$datosacta->elct->onombre_ct}}</b>
            </div>
    </div>
    <div class="card-body table-responsive" >

            <li class=" d-flex justify-content-between align-items-center"
                style="border:none;">
                    <a  href="{{ url('/historico-entregas-recepcion') }}" 
                        class="btn btn-outline-secondary tn-sm" style="font-size: 12px;">
                            <i class="fas fa-backward"></i>&nbsp;
                            VOLVER A &nbsp; <b>E-R FINALIZADAS</b>
                    </a>&nbsp;
            </li>
            <br>

            <x-adminlte-callout theme="light">

                    @include('entregas.acta-content.acta.01-anexos-avance')
                        
                    <li class=" d-flex justify-content-between align-items-center"
                        style="border:none;">
                        <a  href="{{ url('/historico-entregas-recepcion') }}" 
                                class="btn btn-outline-secondary btn-sm" 
                                style="font-size: 12px; text-decoration: none;">
                                    <i class="fas fa-backward"></i>&nbsp;
                                    VOLVER A &nbsp; <b>E-R FINALIZADAS</b>
                        </a>&nbsp;
                    </li>   

            </x-adminlte-callout>

    </div>
</div>
@stop