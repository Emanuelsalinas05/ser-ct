@extends('layouts.app')

{{-- Customize layout sections --}}
@section('title', '13.2 RELACIÓN DE ARCHIVOS DE CONCENTRACIÓN O HISTÓRICO')
@section('content_header_title', 'Home')
@section('content_header_subtitle', ' 13.2 RELACIÓN DE ARCHIVOS DE CONCENTRACIÓN O HISTÓRICO')

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
        
        @if($avances->orelacion_archivos_historico_a==0)
            <x-adminlte-callout>
                    @include('documentos.archivos.13-2.form-carga')
            </x-adminlte-callout>
        
        @endif

        @if($iarchivoshc>0)

            @include('documentos.archivos.13-2.list-files')
            <br>
            @if($avances->orelacion_archivos_historico_a==0)
                <li class="list-group-item d-flex justify-content-between align-items-center"
                    style="border:none;">
                    &nbsp;
                    <form   name="FrmCartel" id="FrmCartel" method="post" 
                            action="{{ route($documento->ourl_documentos.'.update', $datosacta->id ) }}" >
                            @method('PATCH')
                            @csrf
                        <input  type="hidden" 
                                name="acta" 
                                id="acta" 
                                value="{{ $datosacta->id }}">
                        
                        <input  type="hidden" 
                                name="actionarchivos" 
                                id="actionarchivos" 
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