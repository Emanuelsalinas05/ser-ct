@extends('layouts.app')

{{-- Customize layout sections --}}
@section('title', 'SOLICITUD DE INTERVENCIÓN PARA E-R')
@section('content_header_title', 'Home')
@section('content_header_subtitle', ' SOLICITUD DE INTERVENCIÓN PARA E-R')

{{-- Content body: main page content --}}

@section('content')
<div class="col-12 card card-secondary card-outline shadow" >
    <div class="card-header bg-light shadow-sm d-flex mb-2">
        <div class="d-flex justify-content-between">
            <b><i class="nav-icon fa fa-file-alt"></i>&nbsp;
                SOLICITUD DE INTERVENCIÓN PARA E-R 
            </b> 
        </div>
    </div>
    <div class="card-body table-responsive" >


        <form   name="FrmCartel" id="FrmCartel" method="post" 
                action="{{ route('informacion-niveles.update', $getitular->id ) }}" >
                @method('PATCH')
                @csrf
            <input  type="hidden" 
                    name="action" 
                    id="action" 
                    value="9">

            <table  class="table table-sm table-hover col-sm-10"
                    style="font-size:14px;">
                <tr class="bg-lightblue disabled"
                    align="center">
                    <th colspan="2">
                        {{ $getitular->onivel }} 
                    </th>
                </tr>
                <tr>
                    <td colspan="2" 
                        align="center">
                        <b>{{ $getitular->oclave.' - '.$getitular->onombre_ct }}</b>
                    </td>
                </tr>
                <tr>
                    <td align="right"
                        width="35%"><b>No. PARA OFICIOS</b>:</td>
                    <td width="65%">
                        <input  type="text" 
                                name="ooficio"
                                class="form-control form-control-sm"
                                required 
                                value="{{ old('ooficio', $getitular->ooficio ) }}"> 
                    </td>
                </tr>
                <tr>
                    <td align="right"
                        width="35%">
                        <b>CARGO DEL TITULAR </b>: 
                    </td>
                    <td width="65%">
                        <input  type="text" 
                                name="ocargo"
                                class="form-control form-control-sm"
                                required 
                                value="{{ old('ocargo', $getitular->ocargo ) }}">
                    </td>
                </tr>
                <tr>
                    <td align="right"
                        width="35%">
                        <b>NOMBRE DEL TITULAR </b>: 
                    </td>
                    <td width="65%">
                        <input  type="text" 
                                name="otitular"
                                class="form-control form-control-sm"
                                required 
                                value="{{ old('otitular', $getitular->otitular ) }}">
                    </td>
                </tr>
                <tr>
                    <td align="right"
                        width="35%">
                        <b>CORREO OFICIAL </b>: 
                    </td>
                    <td width="65%">
                        <input  type="text" 
                                name="ocorreo"
                                class="form-control form-control-sm"
                                required 
                                value="{{ old('ocorreo', $getitular->ocorreo ) }}">
                    </td>
                </tr>
                <tr>
                    <td align="right"
                        width="35%">
                        <b>DIRECCIÓN </b>: 
                    </td>
                    <td width="65%">
                        <input  type="text" 
                                name="odireccion"
                                class="form-control form-control-sm"
                                required 
                                value="{{ old('odireccion', $getitular->odireccion ) }}">
                    </td>
                </tr>
                <tr>
                    <td align="right"
                        width="35%">
                        <b>DATOS </b>: 
                    </td>
                    <td width="65%">
                        <input  type="text" 
                                name="oinformes"
                                class="form-control form-control-sm"
                                required 
                                value="{{ old('oinformes', $getitular->oinformes ) }}">
                    </td>
                </tr>
                <tr>
                    <td>
                         <a  href="{{ url('/informacion-niveles') }}" 
                            class="btn btn-outline-secondary tn-sm" style="font-size: 12px;">
                            <i class="fas fa-backward"></i>&nbsp;
                            VOLVER 
                        </a>&nbsp;
                    </td>
                    <td align="right">
                        <button class="btn btn-success btn-sm"
                                style="font-size:12px;">
                            ACTUALIZAR INFORMACIÓN
                            <i class="fa fa-check"></i>
                        </button>
                    </td>
                </tr>
            </table>
        </form>


    </div>
</div>
@stop