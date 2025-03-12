@extends('layouts.app')

{{-- Customize layout sections --}}
@section('title', 'REPORTE DE SOLICITUDES DE INTERVENCION REALIZADAS')
@section('content_header_title', 'Home')
@section('content_header_subtitle', ' REPORTE DE SOLICITUDES DE INTERVENCION REALIZADAS')

{{-- Content body: main page content --}}

@section('content')
<div class="col-12 card card-secondary card-outline shadow" >
    <div class="card-header bg-light shadow-sm d-flex mb-2">
        <div class="d-flex justify-content-between">
            <b><i class="nav-icon fa fa-file-alt"></i>&nbsp;
                REPORTE DE SOLICITUDES DE INTERVENCION REALIZADAS
            </b> 
        </div>
    </div>
    <div class="card-body table-responsive" >


        <li class=" d-flex justify-content-between align-items-center"
            style="border:none;">

                <x-adminlte-button  data-toggle="modal" 
                                    icon="fa fa-edit"
                                    label="SOLICITAR INTERVENCIÓN"
                                    data-target="#modaldeletefile" 
                                    class="bg-success btn-sm"/>

                 <a  href="reportes/intervencion.php"
                    class="btn btn-outline-info "
                    target="_blank"
                    style="font-size:12px;">
                    VER REPORTE    &nbsp;
                    <i class="fa fa-file-alt"></i>
                </a>

        </li>


    </div>
</div>
@stop