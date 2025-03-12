@extends('layouts.app')
@php($dat=2)
{{-- Customize layout sections --}}
@section('title', 'APROBAR SOLICITUD DE GESTIÓN Y/O EMISIÓN DE CERTIFICADOS DE NO ADEUDO')
@section('content_header_title', 'Home')
@section('content_header_subtitle', ' APROBAR SOLICITUD DE GESTIÓN Y/O EMISIÓN DE CERTIFICADOS DE NO ADEUDO')

{{-- Content body: main page content --}}

@section('content')
<div class="col-12 card card-secondary card-outline shadow" >
    <div class="card-header bg-light shadow-sm d-flex mb-2">
        <div class="d-flex justify-content-between">
            <b><i class="nav-icon fa fa-copy"></i>&nbsp;
               APROBAR SOLICITUD DE GESTIÓN Y/O EMISIÓN DE CERTIFICADOS DE NO ADEUDO
            </b> 
        </div>
    </div>
    <div class="card-body table-responsive" >
        

        <table class="table table-sm table-hover"  >
            <tr class="bg-lightblue disabled">
                <td colspan="2">
                    <i>{{ $solicitud->tipoceradeudo->otipo }}</i>
                </td>
            </tr>
            <tr>
                <td class="text-info"
                    width="30%"
                    align="right">
                    <b>NOMBRE</b>:
                </td>
                <td width="70%">
                        {{ $solicitud->acta->onombre_entrega_a }} 
                </td>
            </tr>
            <tr>
                <td class="text-info"
                    width="30%"
                    align="right">
                    <b>FILIACIÓN</b>:
                </td>
                <td width="70%">
                    {{ $solicitud->acta->orfc_entrega_a }}
                </td>
            </tr>
            <tr>
                <td class="text-info"
                    width="30%"
                    align="right">                    
                    <b>C.T.</b>:
                </td>
                <td width="70%">
                    <b>{{ $solicitud->acta->oct_a.' - '.$solicitud->acta->elct->onombre_ct }}</b>
                </td>
            </tr>
            <tr>
                <td class="text-info"
                    width="30%"
                    align="right">
                    <b>FECHA Y HORA DEL ACTA:</b> 
                </td>
                <td width="70%">
                    {{ $solicitud->fechaacta.' '.$solicitud->ohora_acta.'HRS.' }}
                </td>
            </tr>
            <tr>
                <td class="text-info"
                    width="30%"
                    align="right">
                    <b>FECHA DE SOLICITUD:</b> 
                </td>
                <td width="70%">
                    {{ $solicitud->fecha }}
                </td>
            </tr>
            <tr>
                <td class="text-info"
                    width="30%"
                    align="right">
                    <b>DIRIGIDO A:</b> 
                </td>
                <td width="70%">
                        {{ $solicitud->id_tipocert==2 ? $solicitud->onombre_autoridadinmediata : $solicitud->otitular_caf }}
                        &nbsp;&nbsp;&nbsp;<b>CARGO</b>: {{ $solicitud->id_tipocert==2 ? $solicitud->ocargo_autoridadinmediata  : 'COORDINACION DE ADMINISTRACION Y FINANZAS' }}
                </td>  
            </tr>
            <tr>
                <td class="text-info"
                    width="30%"
                    align="right">
                    <b>INGRESA LA FECHA</b>:
                </td>
                <td>
                    <input  type="date" 
                            name="olugarfecha"
                            class="form-control form-control-sm"
                            value="{{ old('olugarfecha') }}">
                </td>
            </tr>
            <tr>
                <td class="text-info"
                    width="30%"
                    align="right">
                    <b>INGRESA EL NÚMERO DE OFICIO</b>:
                </td>
                <td>
                    <input  type="text" 
                            name="olugarfecha"
                            class="form-control form-control-sm"
                            value="{{ old('olugarfecha') }}">
                </td>
            </tr>
             <tr>
                <td class="text-info"
                    width="30%"
                    align="right">
                    <b>TITULAR CE CAOE</b>:
                </td>
                <td>
                    <input  type="text" 
                            name="olugarfecha"
                            class="form-control form-control-sm"
                            value="{{ old('olugarfecha') }}">
                </td>
            </tr>
            <tr>
                <td colspan="2"
                    align="right">
                    <button class="btn btn-success btn-sm">
                        GENERAR FORMATO PDF PARA IMPRESIÓN Y FIRMA&nbsp;
                        <i class="fa fa-file"></i>
                    </button>
                </td>                 
            </tr>
        </table>



    </div>
</div>
@stop