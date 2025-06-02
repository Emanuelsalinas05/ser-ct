@extends('layouts.app')

@section('title', 'CERTIFICADOS DE NO ADEUDO')
@section('content_header_title', 'Home')
@section('content_header_subtitle', 'REPORTE DE CERTIFICADOS DE NO ADEUDO')

@section('content')
    <div class="card card-secondary card-outline shadow">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-certificate"></i> CERTIFICADOS LIBERADOS - {{ \Carbon\Carbon::createFromFormat('m-Y', $fecha)->translatedFormat('F Y') }}
            </h5>
            <div>
                <a href="{{ route('reportes.index') }}" class="btn btn-outline-secondary btn-sm me-2">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
                <a href="{{ route('reporte.noadeudos.export.excel', ['fecha' => $fecha]) }}" class="btn btn-outline-success btn-sm me-2">
                    <i class="fas fa-file-excel"></i> Excel
                </a>
                <a href="{{ route('reporte.noadeudos.export.pdf', ['fecha' => $fecha]) }}" class="btn btn-outline-danger btn-sm">
                    <i class="fas fa-file-pdf"></i> Descargar PDF
                </a>
            </div>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-bordered table-sm table-hover text-center align-middle">
                <thead class="bg-lightblue">
                <tr>
                    <th>#</th>
                    <th>Centro de trabajo</th>
                    <th>Nombre del servidor</th>
                    <th>RFC</th>
                    <th>Fecha de liberación</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($solicitudes as $i => $solicitud)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $solicitud->otitular_caf ?? 'N/D' }}</td>
                        <td>{{ $solicitud->onombre_autoridadinmediata ?? 'N/D' }}</td>
                        <td>{{ $solicitud->orfc ?? 'N/D' }}</td>
                        <td>{{ \Carbon\Carbon::parse($solicitud->olugar_fecha)->format('d-m-Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-warning">
                            <i class="fas fa-exclamation-circle"></i> No hay registros para esta fecha.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop
