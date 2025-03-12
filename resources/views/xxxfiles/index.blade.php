@extends('layouts.app')

{{-- Customize layout sections --}}
@section('title', 'DOCUMENTOS/FORMATOS PARA LLENADO DE ANEXOS')
@section('content_header_title', 'Home')
@section('content_header_subtitle', ' DOCUMENTOS/FORMATOS PARA LLENADO DE ANEXOS')

{{-- Content body: main page content --}}

@section('content')
<div class="col-12 card card-secondary card-outline shadow" >
    <div class="card-header bg-light shadow-sm d-flex mb-2">
        <div class="d-flex justify-content-between">
            <b><i class="nav-icon fa fa-copy"></i>&nbsp;
                DOCUMENTOS/FORMATOS PARA LLENADO DE ANEXOS
            </b> 
        </div>
    </div>
    <div class="card-body table-responsive" >

        <p>
            <i>
                AQUÍ PUEDES DESCARGAR LOS DOCUMENTOS/ARCHIVOS/FORMATOS
            </i>
        </p>
        <table  class="table table-sm table-hover table-striped"
                style="font-size:12px;">
            <tbody>
                <tr class="bg-lightblue disabled">
                    <td>
                        ANEXO <b>13. ARCHIVOS</b>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a  href="formatos/13_1_Formato_Relacion_de_archivos_de_tramite.doc"
                            target="_blank"
                            download 
                            class="btn btn-outline-secondary btn-xs btn-block"
                            title="13.1 RELACIÓN DE ARCHIVOS EN TRÁMITE" 
                            style="text-decoration:none; font-size: 14px; text-align: left;">
                            13.1 RELACIÓN DE ARCHIVOS EN TRÁMITE &nbsp;
                            <i class="fa fa-file-alt"></i>&nbsp;&nbsp;
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a  href="formatos/13_2_Formato_Relacion_de_Archivos_de_concentracion_o_historico.doc"
                            target="_blank"
                            download 
                            class="btn btn-outline-secondary btn-xs btn-block"
                            title="13.2 RELACIÓN DE ARCHIVOS DE CONCENTRACIÓN O HISTÓRICO" 
                            style="text-decoration:none; font-size: 14px; text-align: left;">
                            13.2 RELACIÓN DE ARCHIVOS DE CONCENTRACIÓN O HISTÓRICO &nbsp;
                            <i class="fa fa-file-alt"></i>&nbsp;&nbsp;
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a  href="formatos/13_4_Relacion_de_documentos_no_convencionales_o_biblo_hemerograficos.doc"
                            target="_blank"
                            download 
                            class="btn btn-outline-secondary btn-xs btn-block"
                            title="13.4 RELACIÓN DE DOCUMENTOS NO CONVENCIONALES BIBLO-HEMEROGRÁFICOS" 
                            style="text-decoration:none; font-size: 14px; text-align: left;">
                            13.4 RELACIÓN DE DOCUMENTOS NO CONVENCIONALES BIBLO-HEMEROGRÁFICOS &nbsp;
                            <i class="fa fa-file-alt"></i>&nbsp;&nbsp;
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
       
        
    </div>
</div>
@stop
