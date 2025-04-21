@extends('layouts.app')

@section('title', 'REPORTES MENSUALES')
@section('content_header_title', 'Home')
@section('content_header_subtitle', ' REPORTES MENSUALES')

@section('content')
<div class="col-12 card card-secondary card-outline shadow">
    <div class="card-header bg-light shadow-sm d-flex mb-2">
        <div class="d-flex justify-content-between">
            <b><i class="nav-icon far fa-calendar"></i>&nbsp; REPORTES MENSUALES</b> 
        </div>
    </div>
    <div class="card-body table-responsive" style="height: 500px;">
        <table class="table table-sm table-hover" style="font-size:12px;">
            <thead class="bg-lightblue" align="center">
                <tr>
                    <th>TIPO DE REPORTE</th>
                    <th>MES DEL REPORTE</th>
                    <th>ACCIÓN</th>
                </tr>
            </thead>
            <tbody>

                {{-- REPORTE DE ACTOS --}}
                <tr>
                    <td align="right">
                        REPORTE DE ACTOS DE ENTREGA-RECEPCIÓN
                    </td>
                    <td>
                        <form method="GET" action="{{ route('reporte.actos') }}">
                            <select name="fecha_actos" class="form-control form-control-sm w-100" required>
                                <option value="" disabled selected>-- SELECCIONA EL MES/AÑO --</option>
                                @foreach($getmacta as $getacta)
                                    <option value="{{ $getacta->fecha }}">{{ $getacta->fecha }}</option>
                                @endforeach
                            </select>
                    </td>
                    <td align="center">
                            <button class="btn btn-success btn-sm" type="submit">OBTENER REPORTE</button>
                        </form>
                    </td>
                </tr>

                {{-- INTERVENCIÓN --}}
                <tr>
                    <td align="right">
                        SOLICITUDES DE INTERVENCIÓN DE ENTREGA-RECEPCIÓN
                    </td>
                    <td>
                    <form method="GET" action="{{ route('reporte.intervencion') }}">
                    <select name="fecha_intervencion" class="form-control form-control-sm w-100" required>
                        <option value="" disabled selected>-- SELECCIONA EL MES/AÑO --</option>
                        @foreach($getmacta as $getacta)
                            <option value="{{ $getacta->fecha }}">{{ $getacta->fecha }}</option>
                        @endforeach
                    </select>
                    </td>
                    <td align="center">
                            <button class="btn btn-success btn-sm" type="submit">OBTENER REPORTE</button>
                        </form>
                    </td>
                </tr>

                {{-- FORMULARIO DE NO ADEUDOS --}}
                <tr>
                    <td align="right">
                        REPORTE DE SOLICITUDES PARA CERTIFICADO DE NO ADEUDOS
                    </td>
                    <td>
                        <form method="GET" action="{{ route('reporte.noadeudos') }}">
                            <select name="fecha_noadeudos" class="form-control form-control-sm w-100" required>
                                <option value="" disabled selected>-- SELECCIONA EL MES/AÑO --</option>
                                @foreach($getmacta as $getacta)
                                    <option value="{{ $getacta->fecha }}">{{ $getacta->fecha }}</option>
                                @endforeach
                            </select>
                    </td>
                    <td align="center">
                        <button class="btn btn-success btn-sm" type="submit">OBTENER REPORTE</button>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@stop
