@extends('layouts.app')

{{-- Customize layout sections --}}
@section('title', 'AUTENTICACIÓN Y VALIDACIÓN DE CÓDIGO QR')
@section('content_header_subtitle', ' AUTENTICACIÓN Y VALIDACIÓN DE CÓDIGO QR')

{{-- Content body: main page content --}}

@section('content')
<br>

<div class="col-12 card card-secondary card-outline shadow" >

    <div class="card-header bg-light shadow-sm d-flex mb-2">
        <div class="d-flex justify-content-between">
            <b><i class="nav-icon fas fa-shield-alt"></i>&nbsp;
                AUTENTICACIÓN Y VALIDACIÓN DE CÓDIGO QR
            </b> 
        </div>
    </div>

    <div class="card-body table-responsive" >
        <span style="text-align: justify;">
            LOS DATOS MOSTRADOS A CONTINUACIÓN AUTENTICAN Y VALIDAN LA INFORMACIÓN EXPRESADA POR EL SERVIDOR PÚBLICO RESPONSABLE DE GENERAR LA INFORMACIÓN DEL ACTO DE ENTREGA Y RECEPCIÓN.
        </span>
        
        <br>
        <br>


        <div class="container ">
            
            @if($datosacta->id_tipoacta==1)
                @include('admin.validation-qr.type1') 
            @elseif($datosacta->id_tipoacta==2)
                @include('admin.validation-qr.type2')
            @endif

        <div class="row">
            <div class="col-sm" style="text-align:center; color: gray;">
                <x-adminlte-callout theme="info" >

                            <ol>
                                <b class="text-info">CÓDIGO DE VERIFICACIÓN:</b>
                                <b>{{ $datosacta->ocodigo_verificacion }}</b>
                            </ol>

                            </i>
                            {!! QrCode::size(150)->generate(url()->current()) !!}
                            <br>
                            <br>
            
                            <h4> 
                                <b>SERVICIOS EDUCATIVOS INTEGRADOS AL ESTADO DE MÉXICO</b> 
                            </h4>

                            <h5>
                                <b>{{ $datosacta->dir }}</b>
                            </h5>

                            <span style="font-size: 14px;">
                                DEPARTAMENTO DE DESARROLLO DE SISTEMAS | DIRECCIÓN DE INFORMÁTICA Y TELECOMUNICACIONES&nbsp;<br>&nbsp;
                            </span>

                            <span style="font-size: 12px;">
                                TODOS LOS DERECHOS RESERVADOS {{ date('Y') }}&nbsp;
                                <i class="far fa-copyright"></i>
                            </span>

                </x-adminlte-callout>
            </div>
        </div>

        <br>

        </div>

    </div>
</div>
@stop