@extends('layouts.app')

{{-- Customize layout sections --}}
@section('title', '14. Certificados de no adeudo')
@section('content_header_title', 'Home')
@section('content_header_subtitle', ' 14. Certificados de no adeudo')

{{-- Content body: main page content --}}

@section('content')
<div class="col-12 card card-secondary card-outline shadow" >
    <div class="card-header bg-light shadow-sm d-flex mb-2">
        <div class="d-flex justify-content-between">
            <b><i class="nav-icon fa fa-folder-open"></i>&nbsp;
                14. Certificados de no adeudo
            </b> 
        </div>
    </div>
    <div class="card-body table-responsive" >

        <li class=" d-flex justify-content-between align-items-center"
            style="border:none;">
            <a  href="{{ url('/entrega-recepcion') }}" 
                class="btn btn-outline-secondary tn-sm" style="font-size: 12px;">
                <i class="fas fa-backward"></i>&nbsp;
                VOLVER A &nbsp; <b>AVANCE DEL PROCESO DE ENTREGA-RECEPCIÓN</b>
            </a>&nbsp;
        </li>
        <br>
        <span style="font-size:14px;">Completa cada apartado por completo, y después podrás dar clic en el botón de "<b>FINALIZAR ANEXO</b>"</span>
        <br>
        <br>

    </div>
</div>
@stop