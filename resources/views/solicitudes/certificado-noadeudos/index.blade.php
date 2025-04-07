@extends('layouts.app')

{{-- Customize layout sections --}}
@section('title', 'SOLICITUD DE CERTIFICADO DE NO ADEUDO')
@section('subtitle', 'Welcome')
@section('content_header_title', 'Home')
@section('content_header_subtitle', ' SOLICITUD DE CERTIFICADO DE NO ADEUDO')

{{-- Content body: main page content --}}

@section('content')
<div class="col-12 card card-secondary card-outline shadow" >
    <div class="card-header bg-light shadow-sm d-flex mb-2">
        <div class="d-flex justify-content-between">
            <b><i class="nav-icon fa fa-file-export"></i>&nbsp;
                SOLICITUD DE CERTIFICADO DE NO ADEUDO
            </b> 
        </div>
    </div>
    <div class="card-body table-responsive" style="font-size:14px;">


        @if($check==0)

            @include('solicitudes.certificado-noadeudos.select-type')
            

        @elseif($check==1)

            @if($solicitud->ogenerado==0)
                    
                    
                    @include('solicitudes.certificado-noadeudos.select-form')

            @elseif($solicitud->ogenerado==1)
                <div class="container">
                        <div class="row">
                            <div class="col-sm">
                                <p> 
                                    <a  class="btn btn-outline-success btn-xl"
                                        style="text-decoration: none; font-size:1.5rem;" 
                                        href="reportes/print-reportx.php?i1d3={{$solicitud->id}}&idr3p0rt=99&us={{$us}}&un1d={{ $datosacta->id_ct }}"
                                        target="_blank">
                                            VER MI OFICIO DE SOLICITUD DE CERTIFICADO DE NO ADEUDO&nbsp;
                                            <i class="fa fa-file-alt"></i>
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
            @endif
            
        @endif

        
    </div>
</div>
@stop



        

