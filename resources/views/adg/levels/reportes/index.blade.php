@extends('layouts.app')

@section('title', 'REPORTES MENSUALES')
@section('content_header_title', 'Home')
@section('content_header_subtitle', 'REPORTES MENSUALES')

@section('content')
<div class="col-12 card card-secondary card-outline shadow">
    <div class="card-header bg-light shadow-sm mb-2">
        <b><i class="nav-icon far fa-calendar"></i>&nbsp; REPORTES MENSUALES</b>
    </div>

    <div class="card-body table-responsive" style="height: 500px;">
        <table class="table table-sm table-hover text-center align-middle" style="font-size:12px;">
            <thead class="bg-lightblue">
            <tr>
                <th>TIPO DE REPORTE</th>
                <th>MES DEL REPORTE</th>
                <th>ACCIÓN</th>
            </tr>
            </thead>
            <tbody>

            {{-- REPORTE DE ACTOS --}}
            <tr>
                <td class="text-end">REPORTE DE ACTOS DE ENTREGA-RECEPCIÓN</td>
                <td>
                    <form method="GET" action="{{ route('reporte.actos') }}" class="d-flex justify-content-center">
                        <input type="month" name="fecha_actos" class="form-control form-control-sm w-75" required>
                </td>
                <td>
                    <button class="btn btn-success btn-sm ms-2" type="submit">OBTENER REPORTE</button>
                    </form>
                </td>
            </tr>

            {{-- INTERVENCIÓN --}}
            <tr>
                <td class="text-end">SOLICITUDES DE INTERVENCIÓN DE ENTREGA-RECEPCIÓN</td>
                <td>
                    <form method="GET" action="{{ route('reporte.intervencion') }}" class="d-flex justify-content-center">
                        <input type="month" name="fecha_intervencion" class="form-control form-control-sm w-75" required>
                </td>
                <td>
                    <button class="btn btn-success btn-sm ms-2" type="submit">OBTENER REPORTE</button>
                    </form>
                </td>
            </tr>

            {{-- NO ADEUDOS --}}
            <tr>
                <td class="text-end">REPORTE DE SOLICITUDES PARA CERTIFICADO DE NO ADEUDOS</td>
                <td>
                    <form method="GET" action="{{ route('reporte.noadeudos') }}" class="d-flex justify-content-center">
                        <input type="month" name="fecha_noadeudos" class="form-control form-control-sm w-75" required>
                </td>
                <td>
                    <button class="btn btn-success btn-sm ms-2" type="submit">OBTENER REPORTE</button>
                    </form>
                </td>
            </tr>

            </tbody>
        </table>
    </div>
</div>
@stop
