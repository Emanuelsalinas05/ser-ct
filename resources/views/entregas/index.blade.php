@extends('layouts.app')

{{-- Customize layout sections --}}
@section('title', 'ENTREGAS-RECEPCIÓN REALIZADAS')
@section('content_header_title', 'Home')
@section('content_header_subtitle', '  ENTREGAS-RECEPCIÓN REALIZADAS')

{{-- Content body: main page content --}}

@section('content')
<div class="col-12 card card-secondary card-outline shadow" >
    <div class="card-header bg-light shadow-sm d-flex mb-2">
        <div class="d-flex justify-content-between">
            <b><i class="nav-icon fa fa-file"></i>&nbsp;
                <b>INFORMACIÓN DEL ÚLTIMO REGISTRO 
                    @if($getHistor>0)
                        DE:</b> {{ $actas->tipoacta->otipoacta }} REALIZADA
                    @endif
            </b> 
        </div>
    </div>
    <div class="card-body table-responsive" >

        @if($getHistor==0)

            <center style="font-size: 25px;">
                <b class="text-warning"><i>AÚN NO SE HA REALIZADO NINGÚN ACTA DE ENTREGA-RECEPCIÓN</i></b><br><br>
            </center>
                
        @elseif($getHistor>0)

            <table  class="table table-bordered table-striped table-sm"
                    style="font-size:12px;">
            <thead class="bg-lightblue" align="center">
                <tr>
                    <th>TIPO DE ACTA </th>
                    <th>SERVIDOR PÚBLICO QUE RECIBE</th>
                    <th>SERVIDOR PÚBLICO QUE ENTREGA</th>
                    <th>FECHA DE REALIZACIÓN</th>
                    <th>ANEXOS</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td width="30%" align="center">
                        {{ $actas->tipoacta->otipoacta }}
                    </td>
                    
                    <td width="25%">
                        @if($actas->id_tipoacta==1)
                            <i class="text-info"><b>RFC:</b></i>
                            {{ $actas->orfc_recibe_a  }}
                            <br>
                            <i class="text-info"><b>NOMBRE:</b></i>
                            {{ $actas->onombre_recibe_a  }}
                            <br>
                            <i class="text-info"><b>CARGO:</b></i>
                            {{ $actas->ocargo_recibe_a }}
                        @elseif($actas->id_tipoacta==2)
                            <i class="text-info"><b>RFC:</b></i>
                            {{ $actas->orfc_recibe_ac  }}
                            <br>
                            <i class="text-info"><b>NOMBRE:</b></i>
                            {{ $actas->onombre_recibe_ac }}
                        @endif
                    </td>

                    <td width="25%">
                        @if($actas->id_tipoacta==1)
                            <i class="text-info"><b>RFC:</b></i>
                            {{ $actas->orfc_entrega_a }}
                            <br>
                            <i class="text-info"><b>NOMBRE:</b></i>
                            {{ $actas->onombre_entrega_a }}
                            <br>
                            <i class="text-info"><b>CARGO:</b></i>
                            {{ $actas->ocargo_entrega_a }}
                        @elseif($actas->id_tipoacta==2)
                            <b>N/A</b>
                        @endif
                    </td>                    
                    
                    <td width="15%" >
                         @if($actas->id_tipoacta==1)
                            <i class="text-info"><b>INICIO:</b></i>
                            {{ $actas->ofecha_inicio_a }}&nbsp;&nbsp;
                            {{ $actas->ohora_inicio_a }}hrs.
                            <br>
                            <i class="text-info"><b>FIN:</b></i>
                            {{ $actas->ofecha_fin_a }}&nbsp;&nbsp;
                            {{ $actas->ohora_fin_a }}hrs.
                        @elseif($actas->id_tipoacta==2)
                            <i class="text-info"><b>INICIO:</b></i>
                            {{ $actas->ofecha_inicio_ac }}&nbsp;&nbsp;
                            {{ $actas->ohora_inicio_ac }}hrs.
                            <br>
                            <i class="text-info"><b>FIN:</b></i>
                            {{ $actas->ofecha_fin_ac }}&nbsp;&nbsp;
                            {{ $actas->ohora_fin_ac }}hrs.
                        @endif
                    </td>
                    
                    <td width="10%" align="center">
                        <a  href="{{route('historico-entregas-recepcion.edit', $actas->id)}}" 
                            class="btn btn-outline-dark btn-sm"
                            title="VER ANEXOS Y AVANCE DE: {{ $actas->elct->oclave.' - '.$actas->elct->onombre_ct }}"
                            style="text-decoration: none; font-size:12px;">
                            <i class="  fas fa-folder-open"></i>
                        </a>
                    </td>
                </tr>
            </tbody>
            </table>

        @endif

        
    </div>
</div>
@stop