@extends('layouts.app')

{{-- Customize layout sections --}}
@section('title', 'ENTREGAS-RECEPCIÓN FINALIZADAS')
@section('content_header_title', 'Home')
@section('content_header_subtitle', ' ENTREGAS-RECEPCIÓN FINALIZADAS')

{{-- Content body: main page content --}}

@section('content')
<div class="col-12 card card-secondary card-outline shadow" >
    <div class="card-header bg-light shadow-sm d-flex mb-2">
        <div class="d-flex justify-content-between">
            <b><i class="nav-icon fa fa-book"></i>&nbsp;
                ENTREGAS-RECEPCIÓN FINALIZADAS
            </b> 
        </div>
    </div>
    <div class="card-body table-responsive" >


        <x-adminlte-callout theme="light">

            <table  class="table table-bordered table-striped table-sm"
                    id=""
                    style="font-size:12px;">
            <thead class="bg-lightblue" align="center">
                <tr>
                    <th>TIPO DE ACTA</th>
                    <th>CENTRO DE TRABAJO</th>
                    <th>SERVIDOR PÚBLICO RESPONSABLE</th>
                    <th>FECHA</th>
                    <th> </th>
                </tr>
            </thead>
            <tbody>



                @foreach($datosacta2 as $key=> $acta2)
                <tr>
                    <td width="15%">
                        {{ $acta2->tipoacta->otipoacta }}
                    </td>
                    
                    <td width="30%">
                        {{ $acta2->elct->oclave.' - '.$acta2->elct->onombre_ct }}
                    </td>
                    
                    <td width="35%">
                        @if($acta2->id_tipoacta==1)
                                <b>RECIBE</b>: {{ $acta2->onombre_recibe_a }}
                                <br>
                                <b>ENTREGA</b>: {{ $acta2->onombre_entrega_a }}
                        @elseif($acta2->id_tipoacta==2)
                                <b>RECIBE</b>: {{ $acta2->onombre_recibe_ac }}
                        @endif
                    </td>
                    
                    
                    <td width="10%" style="font-size:11px;">
                        <b>FECHA</b>: {{ $acta2->id_tipoacta==1 ? $acta2->ofecha_fin_a : $acta2->ofecha_fin_ac }}
                        <br>
                        <b>HORA</b>:  {{ $acta2->id_tipoacta==1 ? $acta2->ohora_fin_a  : $acta2->ohora_fin_ac }}
                    </td>
                    
                    <td width="10%" align="center">
                        <a  href="{{route('entregas-finalizadas.edit', $acta2->idd)}}" 
                            class="btn btn-outline-dark btn-sm"
                            title="VER ANEXOS Y AVANCE DE: {{ $acta2->elct->oclave.' - '.$acta2->elct->onombre_ct }}"
                            style="text-decoration: none; font-size:12px;">
                            VER&nbsp;
                            <i class="  fas fa-folder-open"></i>
                        </a>
                    </td>
                </tr>
                @endforeach

                @foreach($datosacta3 as $key=> $acta3)
                <tr>                    
                    <td width="15%">
                        {{ $acta3->tipoacta->otipoacta }}
                    </td>
                    
                    <td width="30%">
                        {{ $acta3->elct->oclave.' - '.$acta3->elct->onombre_ct }}
                    </td>
                    
                    <td width="35%">
                        @if($acta3->id_tipoacta==1)
                                <b>RECIBE</b>: {{ $acta3->onombre_recibe_a }}
                                <br>
                                <b>ENTREGA</b>: {{ $acta3->onombre_entrega_a }}
                        @elseif($acta3->id_tipoacta==2)
                                <b>RECIBE</b>: {{ $acta3->onombre_recibe_ac }}
                        @endif
                    </td>
                    
                    
                    <td width="10%" style="font-size:11px;">
                        <b>FECHA</b>: {{ $acta3->id_tipoacta==1 ? $acta3->ofecha_fin_a : $acta3->ofecha_fin_ac }}
                        <br>
                        <b>HORA</b>:  {{ $acta3->id_tipoacta==1 ? $acta3->ohora_fin_a  : $acta3->ohora_fin_ac }}
                    </td>
                    
                    <td width="10%" align="center">
                        <a  href="{{route('entregas-finalizadas.edit', $acta3->idd)}}" 
                            class="btn btn-outline-dark btn-sm"
                            title="VER ANEXOS Y AVANCE DE: {{ $acta3->elct->oclave.' - '.$acta3->elct->onombre_ct }}"
                            style="text-decoration: none; font-size:12px;">
                            VER&nbsp;
                            <i class="  fas fa-folder-open"></i>
                        </a>
                    </td>
                </tr>
                @endforeach

            </tbody>
            </table>


        </x-adminlte-callout>
        
    </div>
</div>
@stop