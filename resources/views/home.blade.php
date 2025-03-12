@extends('layouts.app')

{{-- Customize layout sections --}}
@section('title', 'Realizar procedimiento de Entrega-Recepción')
@section('subtitle', 'Welcome')
@section('content_header_title', 'Home')
@section('content_header_subtitle', ' Realizar procedimiento de Entrega - Recepción')

{{-- Content body: main page content --}}

@section('content')
<div class="col-12 card card-secondary card-outline shadow" >
    <div class="card-header bg-light shadow-sm d-flex mb-2">
        <div class="d-flex justify-content-between">
            <b><i class="nav-icon fa fa-paste"></i>&nbsp;
                Realizar procedimiento de Entrega - Recepción
            </b> 
        </div>
    </div>
    <div class="card-body table-responsive " >

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
@stop