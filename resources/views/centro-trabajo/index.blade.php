@extends('layouts.app')

{{-- Customize layout sections --}}
@section('title', 'Datos del Centro de Trabajo')
@section('subtitle', 'Welcome')
@section('content_header_title', 'Home')
@section('content_header_subtitle', ' Datos del Centro de Trabajo')

{{-- Content body: main page content --}}

@section('content')
<div class="col-12 card card-secondary card-outline shadow" >
    <div class="card-header bg-light shadow-sm d-flex mb-2">
        <div class="d-flex justify-content-between">
            <b><i class="nav-icon fa fa-home"></i>&nbsp;
                {{$datas_ct->oclave.' | '.$datas_ct->onombre_ct}}
            </b> 
        </div>
    </div>
    <div class="card-body table-responsive" style="font-size:14px;">

        <li class=" d-flex justify-content-between align-items-center"
            style="border:none;">
            <a  href="{{ url('/entrega-recepcion') }}" 
                class="btn btn-outline-secondary tn-sm" style="font-size: 12px;">
                <i class="fas fa-backward"></i>&nbsp;
                IR A &nbsp; <b>ACTA DE ENTREGA-RECEPCIÓN</b>
            </a>&nbsp;
        </li>
        <br>

        <x-adminlte-callout title="INFORMACIÓN DEL CENTRO DE TRABAJO"
                            icon="fa fa-home"
                            class="text-info">
            <table class="table table-hover table-sm" 
                    style="color:black;">
                <tbody>
                    <tr>
                        <td align="right"><b>DIRECCIÓN</b></td>
                        <td>
                            @if($datas_ct->odireccion=='ELEMENTAL')
                                DIRECCIÓN DE EDUCACIÓN ELEMENTAL 
                            @elseif($datas_ct->odireccion=='SECUNDARIA')
                                DIRECCION DE EDUCACION SECUNDARIA Y SERVICIOS DE APOYO
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td align="right"><b>MODALIDAD</b></td>
                        <td>{{$datas_ct->desc_modal}} &nbsp;&nbsp;|&nbsp;&nbsp; {{$datas_ct->omodalidad}} </td>
                    </tr>
                    <tr>
                        <td align="right"><b>C.T.</b></td>
                        <td>{{$datas_ct->oclave}}</td>
                    </tr>
                    <tr>
                        <td align="right"><b>NOMBRE</b></td>
                        <td>{{$datas_ct->onombre_ct}}</td>
                    </tr>
                    <tr>
                        <td align="right"><b>CALLE Y NÚMERO</b></td>
                        <td>{{$datas_ct->odomicilio}}</td>
                    </tr>
                    <tr>
                        <td align="right"><b>COLONIA</b></td>
                        <td>
                            {{ ($datas_ct->onombre_col==null) ? '---' : $datas_ct->onombre_col}}
                        </td>
                    </tr>
                    <tr>
                        <td align="right"><b>C.P</b></td>
                        <td>
                            {{ ($datas_ct->ocodigopostal==null) ? '---' : $datas_ct->ocodigopostal}}
                        </td>
                    </tr>
                    <tr>
                        <td align="right"><b>MUNICIPIO</b></td>
                        <td>
                            {{ ($datas_ct->nombre_mun==null) ? '---' : $datas_ct->nombre_mun}}
                        </td>
                    </tr>
                    <tr>
                        <td align="right"><b>LOCALIDAD</b></td>
                        <td>
                            {{ ($datas_ct->nombre_loc==null) ? '---' : $datas_ct->nombre_loc}}
                        </td>
                    </tr>
                    <tr>
                        <td align="right"><b>Tel.</b></td>
                        <td>
                            {{($datas_ct->otelefono==0||$datas_ct->otelefono==null) ? '---' : $datas_ct->otelefono}}
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" align="right">
                            <a  href="{{ route('centro-trabajo.edit', $datas_ct->kcvect) }}"
                                class="btn btn-success btn-sm"
                                style="text-decoration: none; color:white;">
                                ACTUALIZAR INFORMACIÓN DEL CENTRO DE TRABAJO&nbsp;
                                <i class="far fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </x-adminlte-callout>

                

        
    </div>
</div>
@stop