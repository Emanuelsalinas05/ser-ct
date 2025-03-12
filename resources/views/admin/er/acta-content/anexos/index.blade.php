@extends('layouts.app')

{{-- Customize layout sections --}}
@section('title', 'REVISION DE ANEXOS DEL ACTA')
@section('content_header_title', 'Home')
@section('content_header_subtitle', ' REVISION DE ANEXOS DEL ACTA')

{{-- Content body: main page content --}}

@section('content')
<div class="col-12 card card-secondary card-outline shadow" >
    <div class="card-header bg-light shadow-sm d-flex mb-2">
        <div class="d-flex justify-content-between">
            <b><i class="nav-icon fa fa-folder-open"></i>&nbsp;
                {{ $anexo->onum_anexo.'. '.$anexo->oanexo }}
            </b> 
        </div>
    </div>
    <div class="card-body table-responsive" >
        
        <li class=" d-flex justify-content-between align-items-center"
            style="border:none;">
            <a  href="{{ url()->previous() }}" 
                class="btn btn-outline-secondary tn-sm" style="font-size: 12px;">
                <i class="fas fa-backward"></i>&nbsp;
                VOLVER A &nbsp; <b>CONSULTA DE ENTREGA-RECEPCIÓN</b>
            </a>&nbsp;
        </li>

        <br>

        @if($anexo->id==1)
                @include('admin.er.acta-content.anexos.01-marco-juridico')
        @elseif($anexo->id==2)
                @include('admin.er.acta-content.anexos.05-recursos-humanos')
        @elseif($anexo->id==3)
                @include('admin.er.acta-content.anexos.08-recursos-materiales')
        @elseif($anexo->id==4)
                @include('admin.er.acta-content.anexos.09-situacion-tics')
        @elseif($anexo->id==5)
                @include('admin.er.acta-content.anexos.13-archivos')
        @elseif($anexo->id==6)
                @include('admin.er.acta-content.anexos.14-certificados-noadeudos')
        @elseif($anexo->id==7)
                @include('admin.er.acta-content.anexos.15-informe-gestion')
        @elseif($anexo->id==8)
                @include('admin.er.acta-content.anexos.18-otro-hechos')
        @endif

    </div>
</div>
@stop