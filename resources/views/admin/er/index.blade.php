@extends('layouts.app')

{{-- Customize layout sections --}}
@section('title', 'REGISTROS DE ENTREGAS-RECEPCIÓN')
@section('content_header_title', 'Home')
@section('content_header_subtitle', ' REGISTROS DE ENTREGAS-RECEPCIÓN')

{{-- Content body: main page content --}}

@section('content')
<div class="col-12 card card-secondary card-outline shadow" >
    <div class="card-header bg-light shadow-sm d-flex mb-2">
        <div class="d-flex justify-content-between">
            <b><i class="nav-icon fa fa-book"></i>&nbsp;
                REGISTROS DE ACTOS ENTREGAS-RECEPCIÓN
            </b> 
        </div>
    </div>
    <div class="card-body table-responsive" >


        <x-adminlte-callout theme="light">

            <table  class="table table-bordered table-striped table-sm"
                    id="example13"
                    style="font-size:12px;">
            <thead class="bg-lightblue" align="center">
                <tr>
                    @if(Auth::user()->ocargo=='DIRECCIÓN')
                        <th>UNIDAD ADMINISTRATIVA</th>
                    @endif
                    <th>TIPO DE ACTA</th>
                    <th>CENTRO DE TRABAJO</th>
                    <th>SERVIDOR PÚBLICO RESPONSABLE</th>
                    <th>ESTADO</th>
                    <th> </th>
                </tr>
            </thead>
            <tbody>
                @if($datosacta)
                @foreach($datosacta as $key=> $acta)
                <tr>
                    @if(Auth::user()->ocargo=='DIRECCIÓN')
                    <td width="20%">
                        {{ $acta->unidad }}
                    </td>
                    @endif

                    <td width="10%">
                        {{ $acta->tipoacta->oapodo }}
                    </td>
                    
                    <td width="20%">
                        {{ $acta->elct->oclave.' - '.$acta->elct->onombre_ct }}
                    </td>
                    
                    <td width="25%">
                        @if($acta->ock==1)
                            @if($acta->id_tipoacta==1)
                               <b>RECIBE</b>: {{ $acta->onombre_recibe_a }}
                               <br>
                               <b>ENTREGA</b>: {{ $acta->onombre_entrega_a }}
                            @elseif($acta->id_tipoacta==2)
                                <b>RECIBE</b>: {{ $acta->onombre_recibe_ac }}
                            @endif
                        @elseif($acta->ock==0)
                            ESPERANDO REGISTROS
                        @endif
                    </td>
                    
                    
                    <td width="15%" style="font-size:11px;">
                        {{ $acta->estadoacta }}
                    </td>
                    
                    <td width="10%" align="center">
                        @if(Auth::user()->orol<99)
                        <a  href="{{route('entregas-recepcion.edit', $acta->id)}}" 
                            class="btn btn-outline-dark btn-sm"
                            title="VER ANEXOS Y AVANCE DE: {{ $acta->elct->oclave.' - '.$acta->elct->onombre_ct }}"
                            style="text-decoration: none; font-size:12px;">
                            VER&nbsp;
                            <i class="  fas fa-folder-open"></i>
                        </a>
                        @endif
                    </td>
                </tr> 
                @endforeach
                @endif

                @if($datosacta2)
                @foreach($datosacta2 as $key=> $acta2)
                <tr>
                    @if(Auth::user()->ocargo=='DIRECCIÓN')
                    <td width="20%">
                        {{ $acta2->unidad }}
                    </td>
                    @endif

                    <td width="10%">
                        {{ $acta2->tipoacta->oapodo }}
                    </td>
                    
                    <td width="25%">
                        {{ $acta2->elct->oclave.' - '.$acta2->elct->onombre_ct }}
                    </td>
                    
                    <td width="25%">
                        @if($acta2->ock==1)
                            @if($acta2->id_tipoacta==1)
                               <b>RECIBE</b>: {{ $acta2->onombre_recibe_a }}
                               <br>
                               <b>ENTREGA</b>: {{ $acta2->onombre_entrega_a }}
                            @elseif($acta2->id_tipoacta==2)
                                <b>RECIBE</b>: {{ $acta2->onombre_recibe_ac }}
                            @endif
                        @elseif($acta2->ock==0)
                            ESPERANDO REGISTROS
                        @endif
                    </td>
                    
                    
                    <td width="15%" style="font-size:11px;">
                        {{ $acta2->estadoacta }}
                    </td>
                    
                    <td width="10%" align="center">
                        @if(Auth::user()->orol<99)
                        <a  href="{{route('entregas-recepcion.edit', $acta2->id)}}" 
                            class="btn btn-outline-dark btn-sm"
                            title="VER ANEXOS Y AVANCE DE: {{ $acta2->elct->oclave.' - '.$acta2->elct->onombre_ct }}"
                            style="text-decoration: none; font-size:12px;">
                            VER&nbsp;
                            <i class="  fas fa-folder-open"></i>
                        </a>
                        @endif
                    </td>
                </tr>
                @endforeach
                @endif

                @if($datosacta3)
                @foreach($datosacta3 as $key=> $acta3)
                <tr>
                    @if(Auth::user()->ocargo=='DIRECCIÓN')
                    <td width="20%">
                        {{ $acta3->unidad }}
                    </td>
                    @endif

                    <td width="10%">
                        {{ $acta3->tipoacta->oapodo }}
                    </td>
                    
                    <td width="25%">
                        {{ $acta3->elct->oclave.' - '.$acta3->elct->onombre_ct }}
                    </td>
                    
                    <td width="25%">
                        @if($acta3->ock==1)
                            @if($acta3->id_tipoacta==1)
                               <b>RECIBE</b>: {{ $acta3->onombre_recibe_a }}
                               <br>
                               <b>ENTREGA</b>: {{ $acta3->onombre_entrega_a }}
                            @elseif($acta3->id_tipoacta==2)
                                <b>RECIBE</b>: {{ $acta3->onombre_recibe_ac }}
                            @endif
                        @elseif($acta3->ock==0)
                            ESPERANDO REGISTROS
                        @endif
                    </td>
                    
                    
                    <td width="15%" style="font-size:11px;">
                        {{ $acta3->estadoacta }}
                    </td>
                    
                    <td width="10%" align="center">
                        @if(Auth::user()->orol<99)
                        <a  href="{{route('entregas-recepcion.edit', $acta3->id)}}" 
                            class="btn btn-outline-dark btn-sm"
                            title="VER ANEXOS Y AVANCE DE: {{ $acta3->elct->oclave.' - '.$acta3->elct->onombre_ct }}"
                            style="text-decoration: none; font-size:12px;">
                            VER&nbsp;
                            <i class="  fas fa-folder-open"></i>
                        </a>
                        @endif
                    </td>
                </tr>
                @endforeach
                @endif

            </tbody>
            </table>

        </x-adminlte-callout>
        
    </div>
</div>
@stop