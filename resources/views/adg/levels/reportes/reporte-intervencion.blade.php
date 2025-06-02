@extends('layouts.app')

@section('title', 'SOLICITUDES DE INTERVENCIÓN')
@section('content_header_title', 'Home')
@section('content_header_subtitle', ' SOLICITUDES DE INTERVENCIÓN DE ENTREGA-RECEPCIÓN')

@section('content')
    <div class="card card-secondary card-outline shadow">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-file-signature"></i> INTERVENCIONES - {{ $fecha }}
            </h5>
            <div>
                <a href="{{ route('reportes.index') }}" class="btn btn-outline-secondary btn-sm me-2">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
                <a href="{{ route('reporte.intervencion.export.excel', ['fecha' => $fecha]) }}" class="btn btn-outline-success btn-sm me-2">
                    <i class="fas fa-file-excel"></i> Excel
                </a>
                <a href="{{ route('reporte.intervencion.export.pdf', ['fecha' => $fecha]) }}" class="btn btn-outline-danger btn-sm">
                    <i class="fas fa-file-pdf"></i> Descargar PDF
                </a>
            </div>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-bordered table-sm">
                <thead class="bg-lightblue text-center">
                <tr>
                    <th>#</th>
                    <th>Centro de trabajo</th>
                    <th>Nombre CT</th>
                    <th>Recibe</th>
                    <th>Fecha de solicitud</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($intervenciones as $i => $inter)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $inter->oct_nivel ?? 'N/D' }}</td>
                        <td>{{ $inter->onombrect ?? 'N/D' }}</td>
                        <td>{{ $inter->orecibe ?? 'N/D' }}</td>
                        <td>{{ \Carbon\Carbon::parse($inter->ofecha_realizacion)->format('d-m-Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-warning">No hay registros para esta fecha.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop
