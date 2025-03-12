@extends('layouts.app')

{{-- Customize layout sections --}}
@section('title', 'REPORTES MENSUALES')
@section('content_header_title', 'Home')
@section('content_header_subtitle', ' REPORTES MENSUALES')

{{-- Content body: main page content --}}

@section('content')
<div class="col-12 card card-secondary card-outline shadow" >
    <div class="card-header bg-light shadow-sm d-flex mb-2">
        <div class="d-flex justify-content-between">
            <b><i class="nav-icon far fa-calendar"></i>&nbsp;
                REPORTES MENSUALES 
            </b> 
        </div>
    </div>
    <div class="card-body table-responsive" style="height: 500px;">

        <table  class="table table-sm table-hover"
                style="font-size:12px;">
            <thead class="bg-lightblue"
                    align="center">
                <tr>
                    <th>TIPO DE REPORTE</th>
                    <th colspan="2">MES DEL REPORTE</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td width="60%"
                        align="right">
                        REPORTE DE ACTOS DE ENTREGA-RECEPCIÓN
                    </td>
                    <td width="20%">
                        <select name="fecharep"
                                class="form-control form-control-sm">
                            <option value="0" selected disabled>-- SELECCIONA EL MES/AÑO --</option>
                            @foreach($getmacta as $key => $getacta)
                            <option value="{{ $getacta->fecha }}">{{ $getacta->fecha }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td width="20%"
                        align="center">
                        <button class="btn btn-success btn-sm">
                            OBTENER REPORTE
                        </button>
                    </td>
                </tr>
                <tr>
                    <td width="60%"
                        align="right">
                        SOLICITUDES DE INTERVENCIÓN DE ENTREGA-RECEPCIÓN
                    </td>
                    <td width="20%">
                        <select name="fecharep"
                                class="form-control form-control-sm">
                            <option value="0" selected disabled>-- SELECCIONA EL MES/AÑO --</option>
                            @foreach($getmacta as $key => $getacta)
                            <option value="{{ $getacta->fecha }}">{{ $getacta->fecha }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td width="20%"
                        align="center">
                        <button class="btn btn-success btn-sm">
                            OBTENER REPORTE
                        </button>
                    </td>
                </tr>
                <tr>
                    <td width="60%"
                        align="right">
                        REPORTE DE SOLICITUDES PARA CERTIFICADO DE NO ADEUDOS
                    </td>
                    <td width="20%">
                        <select name="fecharep"
                                class="form-control form-control-sm">
                            <option value="0" selected disabled>-- SELECCIONA EL MES/AÑO --</option>
                            @foreach($getmacta as $key => $getacta)
                            <option value="{{ $getacta->fecha }}">{{ $getacta->fecha }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td width="20%"
                        align="center">
                        <button class="btn btn-success btn-sm">
                            OBTENER REPORTE
                        </button>
                    </td>
                </tr>
            </tbody>
            <tr>
                
            </tr>
        </table>
        
        <br><br><br><br><br>


    </div>
</div>
@stop