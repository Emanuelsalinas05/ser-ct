@extends('layouts.app')

{{-- Customize layout sections --}}
@section('title', 'GESTIÓN DE SOLICITUDES PARA SOLICITAR A LA DEE')
@section('subtitle', 'Welcome')
@section('content_header_title', 'Home')
@section('content_header_subtitle', ' GESTIÓN DE SOLICITUDES CNA')

{{-- Content body: main page content --}}

@section('content')
<div class="col-12 card card-secondary card-outline shadow" >
    <div class="card-header bg-light shadow-sm d-flex mb-2">
        <div class="d-flex justify-content-between">
            <b><i class="nav-icon fa fa-file-export"></i>&nbsp;
                GESTIÓN DE SOLICITUDES PARA SOLICITAR A LA DEE
            </b> 
        </div>
    </div>
    <div class="card-body table-responsive" style="font-size:14px;">
        
            <!-- <li> Estas solicitudes se han aprobado, quedando en espera del Certificado de No Adeudo emitido por la Coordinación Académica y de Operación Educativa. </li>
            <li>Las siguientes solicitudes se han generado, para aprobar la gestión del Certificado de No Adeudo, vía estructura, ante la Coordinación Académica y de Operación Educativa.</li>   
            <a  class="btn btn-success btn-sm" 
                href="{{ route('file-export') }}">
                Exportar registros en excel 
                &nbsp;<i class="far fa-file-excel" style="font-size: 18px;"></i>&nbsp;
            </a>
             -->
        <ul>
            <li>
                <i>Los registros mostrados a continuación, son responsabilidad del nivel, y serán enviados via estructura 
                para que los reciba la DEE y ésta a su vez, realice la gestión correspondiente ante la CAOE.</i>
            </li>
        </ul>
                
        @if( $solicitudesc>0 )  

            @if($check==1)
                <p>
                    <i>Para emitir el formato de oficio para la gestión y enviarlo a la DEE, debes 
                    "<b>GENERAR EL REPORTE</b>" el cual <b>abarcará todos los registros que a continuación se muestran</b>.</i>
                    <x-adminlte-button  data-toggle="modal" 
                                        icon="fa fa-edit"
                                        label="GENERAR REPORTE"
                                        data-target="#modalgenera" 
                                        class="bg-success btn-sm"/>
                </p>
                
                @include('admin.solicitudes.certificado-noadeudos.0adg.modal-emitir-oficio')
                <br><br><br>
            @else
                
            @endif

            <table class="table table-sm table-hover table-striped"
                    style="font-size:12px;" id="example13">
                <thead class="bg-lightblue">
                    <tr align="center">
                        <th> </th>
                        <th> NOMBRE SOLICITANTE </th> 
                        <th> C.T A ENTREGAR</th> 
                        <th> ACTA</th>   
                        <th> FECHA DEL ACTA</th>
                        <th> AUTORIDAD INMEDIATA </th>                          
                    </tr>
                </thead>
                <tbody>
                    @foreach($solicitudes as $key => $solicitud)
                    <tr>
                        <td width="3%" align="right">
                                {{ $key+1 }}
                        </td>

                        <td width="20%">
                            {{ $solicitud->acta->onombre_entrega_a }}
                            <br>
                            RFC: {{ $solicitud->acta->orfc_entrega_a }}
                        </td>

                        <td width="20%">
                            {{ $solicitud->acta->oct_a.' - '.$solicitud->acta->onombre_ct_a }}
                        </td>

                        <td width="10%"
                            align="center">
                            {{ $solicitud->acta->tipoacta->oapodo }} 
                        </td>

                        <td width="20%">
                            {{ $solicitud->fechaacta }} a las&nbsp;
                            {{ $solicitud->ohora_acta }} HRS.
                        </td>

                        <td width="25%">
                            {{ $solicitud->onombre_autoridadinmediata }}
                            <br>
                            {{ $solicitud->ocargo_autoridadinmediata }}
                        </td>      
                    </tr>
                    @endforeach
                </tbody>
            </table>

        @else
                <center>
                    <h3>
                        <b class="text-warning"> AÚN NO HAY REGISTROS DE SOLICITUDES</b>
                    </h3>
                </center>
        @endif


        
    </div>
</div>
@stop



        

