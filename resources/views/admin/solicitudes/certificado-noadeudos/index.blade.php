@extends('layouts.app')

{{-- Customize layout sections --}}
@section('title', 'SOLICITUDES PARA CERTIFICADOS DE NO ADEUDO')
@section('subtitle', 'Welcome')
@section('content_header_title', 'Home')
@section('content_header_subtitle', ' SOLICITUDES PARA CERTIFICADOS DE NO ADEUDO')

{{-- Content body: main page content --}}

@section('content')
<div class="col-12 card card-secondary card-outline shadow" >
    <div class="card-header bg-light shadow-sm d-flex mb-2">
        <div class="d-flex justify-content-between">
            <b><i class="nav-icon fa fa-file-export"></i>&nbsp;
                SOLICITUDES GENERADAS PARA SOLICITUD CERTIFCIADO DE NO ADEUDO
            </b> 
        </div>
    </div>
    <div class="card-body table-responsive" style="font-size:14px;">

        <ul>
            <li>
               Las siguientes solicitudes se han generado, para aprobar la gestión del Certificado de No Adeudo, vía estructura, ante la Coordinación Académica y de Operación Educativa.
               <br>
               {{ Auth::user()->orol==1 ? 'Las solicitudes serán aprobadas por la estructura correspondiente.' : '' }}
                </li>
        </ul>



        @if( $solicitudesc>0 )
        <table class="table table-sm table-hover table-striped"
                style="font-size:12px;" id="example13">
            <thead class="bg-lightblue">
                <tr align="center">
                    <th> </th>
                    <th> SOLICITA </th>
                    <th> CENTRO DE TRABAJO A ENTREGAR</th>
                    <th> DATOS DEL ACTA</th>
                    <th> DATOS DE LA SOLICITUD</th>                    
                    <th> DIRIGIDO A </th>                    
                    <th> APROBAR</th>
                </tr>
            </thead>
            <tbody>
                @foreach($solicitudes as $key => $solicitud)
                <tr>
                    <td width="2%" align="right">
                            {{ $key+1 }}
                    </td>

                    <td width="15%">
                            @if($solicitud->acta)
                                {{ $solicitud->acta->onombre_entrega_a ?? 'N/A' }}
                                <br>
                                <b>RFC:</b> {{ $solicitud->acta->orfc_entrega_a ?? 'N/A' }}
                            @else
                                <span class="text-danger">Sin información de acta</span>
                            @endif
                    </td>

                    <td width="20%">
                            @if($solicitud->acta && $solicitud->acta->elct)
                                <b>{{ ($solicitud->acta->oct_a ?? '') .' - '.($solicitud->acta->elct->onombre_ct ?? 'N/A') }}</b>
                            @else
                                <span class="text-danger">Sin información de centro de trabajo</span>
                            @endif
                    </td>

                    <td width="10%">
                            <b>FECHA:</b> {{ $solicitud->fechaacta ?? 'N/A' }}
                            <br>
                            <b>HORA:</b> {{ $solicitud->ohora_acta ?? 'N/A' }} HRS.
                    </td>


                    <td width="25%">
                            <b>FECHA DE SOLICITUD:</b> {{ $solicitud->fecha ?? 'N/A' }}
                            <br>
                            @if($solicitud->tipoceradeudo)
                                <i>{{ '('.$solicitud->tipoceradeudo->otipo.')' }}</i>
                            @else
                                <i class="text-warning">(Tipo no especificado)</i>
                            @endif
                    </td>

                    

                    

                    <td width="20%">
                    @if($solicitud->ogenerado==1)
                        {{ $solicitud->id_tipocert==2 ? $solicitud->onombre_autoridadinmediata : $solicitud->otitular_caf }}
                        <br>
                        CARGO: {{ $solicitud->id_tipocert==2 ? $solicitud->ocargo_autoridadinmediata  : 'COORDINACION DE ADMINISTRACION Y FINANZAS' }}
                        {{-- Código comentado usando comentarios de Blade para evitar ejecución
                            @if($solicitud->acta && $solicitud->acta->elct)
                                {{ $solicitud->acta->elct->omodalidad=='DPB' ? $solicitud->acta->elct->omodalidad : $solicitud->acta->elct->cct_depto}} 
                                <a  class="btn btn-outline-success btn-xl"
                                    style="text-decoration: none; font-size:10px;" 
                                    target="_blank"> 
                                        <i class="fa fa-file-alt"></i>
                                </a>
                            @endif
                        --}}
                    @else
                        <b class="text-warning"> EN PROCESO/CAPTURA DE INFORMACIÓN </b>
                    @endif
                    </td>

                    
                    <td width="5%" align="center">
                        @if( Auth::user()->orol>1 && $solicitud->ogenerado==1)
                            <x-adminlte-button  data-toggle="modal" 
                                                icon="far fa-thumbs-up"
                                                data-target="#modalaprob{{ $solicitud->id }}" 
                                                class="bg-teal btn-sm"/>
                
                            @include('admin.solicitudes.certificado-noadeudos.modal-aprobar')
                        @else
                            <span class="btn btn-warning btn-sm">
                                <i class="fas fa-hourglass-half"></i>
                            </span>
                        @endif
                    </td>
                    

                </tr>
                @endforeach
            </tbody>
        </table>
        @else
            <center>
                <h3><b class="text-warning">AÚN NO HAY REGISTROS DE SOLICITUDES</b></h3>
            </center>
        @endif


        
    </div>
</div>
@stop



        

