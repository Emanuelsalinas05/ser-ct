@extends('layouts.app')

{{-- Customize layout sections --}}
@section('title', 'DATOS DEL ACTA')
@section('content_header_title', 'Home')
@section('content_header_subtitle', ' DATOS DEL ACTA')

{{-- Content body: main page content --}}

@section('content')
<div class="col-12 card card-secondary card-outline shadow" >
    <div class="card-header bg-light shadow-sm d-flex mb-2">
        <div class="d-flex justify-content-between">
            <b><i class="nav-icon fa fa-folder-open"></i>&nbsp;
                DATOS DEL ACTA {{$datosacta->tipoacta->otipoacta}}
            </b> 
        </div>
    </div>
    <div class="card-body table-responsive">
        
        <li class=" d-flex justify-content-between align-items-center"
            style="border:none;">
            <a  href="{{ url('/entrega-recepcion') }}" 
                class="btn btn-outline-secondary tn-sm" style="font-size: 12px;">
                <i class="fas fa-backward"></i>&nbsp;
                VOLVER A &nbsp; <b>AVANCE DEL PROCESO DE ENTREGA-RECEPCIÓN</b>
            </a>&nbsp;
        </li>
        <br>
      
        @if($datosacta->id_tipoacta==1)
            @include('documentos.acta-datos.form-acta')
        @elseif($datosacta->id_tipoacta==2)
            @include('documentos.acta-datos.form-actac')
        @endif
        
    </div>
</div>
@stop