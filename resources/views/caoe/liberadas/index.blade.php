@extends('layouts.app')
@php($dat=2)
{{-- Customize layout sections --}}
@section('title', 'CERTIFICADOS DE NO ADEUDO LIBERADOS')
@section('content_header_title', 'Home')
@section('content_header_subtitle', ' CERTIFICADOS DE NO ADEUDO LIBERADOS')

{{-- Content body: main page content --}}

@section('content')
<div class="col-12 card card-secondary card-outline shadow" >
    <div class="card-header bg-light shadow-sm d-flex mb-2">
        <div class="d-flex justify-content-between">
            <b><i class="nav-icon fa fa-copy"></i>&nbsp;
                CERTIFICADOS DE NO ADEUDO LIBERADOS
            </b> 
        </div>
    </div>
    <div class="card-body table-responsive" >
        
        <ul>
            <li>
                <i>Los registros mostrados a continuación han sido emitidos y liberados por la CAOE.</i>
            </li>
        </ul>
        
        @if( $solicitudesc>0 )
        <table class="table table-sm table-hover table-striped"
                style="font-size:12px;" id="example13">
            <thead class="bg-lightblue">
                <tr align="center">
                    <th> </th>
                    <th> DIRECCIÓN</th>
                    <th> ADG </th>
                    <th> CENTRO DE TRABAJO <br>QUE SE ENTREGA</th>
                    <th> SERVIDOR PÚBLICO <br>QUE SALE </th>
                    <th> OFICIO CAOE</th>   
                    <th>    </th>       
                </tr>
            </thead>
            <tbody>
                @foreach($solicitudes as $key => $solicitud)
                <tr>
                    <td width="3%" 
                        align="right">
                            {{ $key+1 }}
                    </td>

                    <td width="10%"
                        align="center">
                        {{  $solicitud->odir }}
                    </td>

                    <td width="20%">
                        {{  $solicitud->id_dep>0 ? $solicitud->titulardep->oclave.' - '.$solicitud->titulardep->onombre_ct : $solicitud->titularsub->oclave.' - '.$solicitud->titularsub->onombre_ct }}
                    </td>

                    <td width="20%">
                            <b>{{ $solicitud->acta->oct_a.' - '.$solicitud->acta->onombre_ct_a }}</b>
                    </td>

                    <td width="20%">
                            {{ $solicitud->acta->onombre_entrega_a }}
                            <br>
                            <b>RFC:</b> {{ $solicitud->acta->orfc_entrega_a }}
                    </td>

                    <td width="15%" 
                        align="center"> 
                        {{ $solicitud->oficio_adg.'/'.$solicitud->oconsecutivo_adg.'/'.$solicitud->oanio }}
                    </td>

                    <td width="10%" 
                        align="center">
                        
                        <a  href="https://entregasrecepcion.seiem.gob.mx/reportes/print-certificado-noadeudo.php?i1d3={{ $solicitud->id  }}" 
                            class="btn btn-success btn-sm"
                            target="_blank" style="font-size:12px;">
                            VER OFICIO <i class="fa fa-file-export"></i>
                        </a>
                       
                    </td>                 
                </tr>
                
                @endforeach
            </tbody>
        </table>
        @else
            <center>
                <h3><b class="text-warning">AÚN NO HAY REGISTROS DE CERTIFICADOS LIBERADOS</b></h3>
            </center>
        @endif


    </div>
</div>
@stop