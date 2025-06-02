@extends('layouts.app')

@section('title', 'REPORTE DE ACTOS DE ENTREGA-RECEPCIÓN')
@section('content_header_title', 'Home')
@section('content_header_subtitle', 'REPORTE DE ACTOS DE ENTREGA-RECEPCIÓN')

@section('content')
    <div class="card card-secondary card-outline shadow">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-file-alt text-secondary"></i>
                Actas concluidas - {{ \Carbon\Carbon::createFromFormat('m-Y', $fecha)->translatedFormat('F Y') }}
            </h5>
            <div>
                <a href="{{ route('reportes.index') }}" class="btn btn-outline-secondary btn-sm me-2">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
                <a href="{{ route('reporte.actos.export.excel', ['fecha' => $fecha]) }}" class="btn btn-outline-success btn-sm me-2">
                    <i class="fas fa-file-excel"></i> Excel
                </a>
                <a href="{{ route('reporte.actos.export.pdf', ['fecha' => $fecha]) }}" class="btn btn-outline-danger btn-sm">
                    <i class="fas fa-file-pdf"></i> PDF
                </a>
            </div>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-bordered table-sm table-hover text-center align-middle">
                <thead class="bg-lightblue">
                <tr>
                    <th>#</th>
                    <th>C.T.</th>
                    <th class="text-start">Nombre del que entrega</th>
                    <th>RFC</th>
                    <th>Fecha de cierre</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($actas as $i => $acta)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $acta->oct_a }}</td>
                        <td class="text-start">{{ $acta->onombre_entrega_a }}</td>
                        <td>{{ $acta->orfc_entrega_a }}</td>
                        <td>{{ \Carbon\Carbon::parse($acta->ofechafin)->format('d/m/Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">
                            <i class="fas fa-exclamation-circle"></i> No hay registros para esta fecha.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop
