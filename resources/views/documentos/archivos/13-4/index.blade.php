@extends('layouts.app')

@php
use Illuminate\Support\Facades\Storage;
@endphp

{{-- Customize layout sections --}}
@section('title', '13.4 RELACIÓN DE DOCUMENTOS NO CONVENCIONALES O BIBLIO-HEMEROGRÁFICOS')
@section('content_header_title', 'Home')
@section('content_header_subtitle', ' 13.4 RELACIÓN DE DOCUMENTOS NO CONVENCIONALES O BIBLIO-HEMEROGRÁFICOS')

{{-- Content body: main page content --}}

@section('content')
<div class="col-12 card card-secondary card-outline shadow" >
    <div class="card-header bg-light shadow-sm d-flex mb-2">
        <div class="d-flex justify-content-between">
            <b><i class="nav-icon fa fa-folder-open"></i>&nbsp;
            {{  $documento->onum_documento }} {{ $documento->odocumento }}
            </b> 
        </div>
    </div>
    <div class="card-body table-responsive" >

        <li class=" d-flex justify-content-between align-items-center"
            style="border:none;">
            <a  href="{{ url('/archivos') }}" 
                class="btn btn-outline-secondary tn-sm" style="font-size: 12px;">
                <i class="fas fa-backward"></i>&nbsp;
                VOLVER A &nbsp; <b>{{$anexo->onum_anexo.'. '.$anexo->oanexo}}</b>
            </a>&nbsp;
        </li>
        <br>

        @if($avances->orelacion_documentos_noconvencionles_a==0)
        <x-adminlte-callout>
            <p style="font-size:13px; text-align: justify;">
                <i class="fa fa-info-circle"></i>&nbsp;
                <b class="text-info">INDICACIONES PARA EL REGISTRO:</b><br>
                {{ $documento->odescripcion }}.
                <br><b>DEBERÁS SUBIR UN ARCHIVO EN FORMATO EXCEL</b> CON LA INFORMACIÓN DE TODO EL ACERVO BIBLIO-HEMEROGRÁFICO.<br>
                <x-adminlte-button  label="(CLIC PARA CONSULTAR EL INSTRUCTIVO DE LLENADO) " 
                                    data-toggle="modal" 
                                    data-target="#modalCustomHelp" 
                                    class="btn btn-outline-secondary btn-sm"/>
                AL TERMINAR CON EL REGISTRO DA CLIC EN "<B>FINALIZAR REGISTRO</B>" PARA CONCLUIR ESTE APARTADO.
                <br>
                <a  href="filesDownload/excel_acervo.xlsx"
                    class="btn btn-info btn-sm" 
                    download 
                    style="color:white; font-size: 14px;" 
                    title="DESCARGAR ARCHIVO DE EXCEL PARA CAPTURAR LA RELACIÓN DE DOCUMENTOS NO CONVENCIONALES O BIBLIO-HEMEROGRÁFICOS">
                    <i class="far fa-hand-point-right"></i>&nbsp;
                    <b>DESCARGA AQUÍ EL ARCHIVO DE EXCEL PARA CAPTURAR LA RELACIÓN DE DOCUMENTOS NO CONVENCIONALES O BIBLIO-HEMEROGRÁFICOS</b>
                    &nbsp;<i class="far fa-hand-point-left"></i>
                </a>

                @include('documentos.archivos.13-4.modal-help')
            </p>
                @include('documentos.archivos.13-4.form-carga')
        </x-adminlte-callout>
        @endif


         @if($ihemec>0)

        <table  class="table table-striped table-sm"
                style="font-size:12px;">
            <thead class="bg-lightblue ">
                <tr>
                    <th scope="col">PROG.</th>
                    <th scope="col">NOMBRE DEL DOCUMENTO</th>
                    <th scope="col">ADJUNTAR ARCHIVO</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($iheme as $key => $inventario)
                <tr>
                    <th scope="row" width="5%">
                        {{ $key+1 }}
                    </th>
                      
                    <td width="50%">
                        {{ $inventario->onombre_documento }}
                    </td>
                      
                    <td width="40%">
                        @if($inventario->ourl && $inventario->oarchivo_adjunto && $inventario->ourl != 'N/A' && $inventario->oarchivo_adjunto != 'N/A')
                            <a  href="{{ Storage::url($inventario->ourl.$inventario->oarchivo_adjunto) }}"
                                target="_blank"
                                download 
                                title="{{ $inventario->oarchivo_adjunto }}">
                                <i class="fa fa-file-pdf text-danger"></i> {{ $inventario->oarchivo_adjunto }}
                            </a>
                        @else
                            <span class="text-muted">Sin archivo</span>
                        @endif
                    </td>
                      
                    <td width="5%">
                    @if($avances->orelacion_documentos_noconvencionles_a==0)
                        <x-adminlte-button  data-toggle="modal" 
                                            icon="fas fa-minus"
                                            data-target="#modaldelete{{ $inventario->id }}" 
                                            class="bg-danger btn-sm"/>
                        @include('documentos.situacion-recursos-materiales.form-delete')
                    @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
            <br>

            @if($avances->orelacion_documentos_noconvencionles_a==0)
            <li class="list-group-item d-flex justify-content-between align-items-center"
                style="border:none;">
                &nbsp;
                <form   name="FrmCartel" id="FrmCartel" method="post" 
                        action="{{ route('documentos-noconvencionles.update', $datosacta->id ) }}" >
                        @method('PATCH')
                        @csrf
                    <input  type="hidden" 
                            name="acta" 
                            id="acta" 
                            value="{{ $datosacta->id }}">
                        
                    <input  type="hidden" 
                            name="actionplantilla" 
                            id="actionplantilla" 
                            value="2">

                    <button class="btn btn-success btn-sm"
                            style="font-size: 14px;">
                            FINALIZAR REGISTRO DE DOCUMENTOS&nbsp;
                        <i class="fas fa-user-check"></i>
                    </button>

                </form>
            </li>
            @endif
        @endif



        
    </div>
</div>
@stop