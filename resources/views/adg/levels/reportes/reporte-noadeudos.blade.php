@extends('layouts.app')

@section('title', 'CERTIFICADOS DE NO ADEUDO')
@section('content_header_title', 'Home')
@section('content_header_subtitle', ' REPORTE DE CERTIFICADOS DE NO ADEUDO')

@section('content')
<div class="card card-secondary card-outline shadow">
    <div class="card-header bg-light d-flex justify-content-between">
        <h5 class="mb-0">CERTIFICADOS LIBERADOS - {{ $fecha }}</h5>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-bordered table-sm">
            <thead class="bg-lightblue text-center">
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
                    <td>{{ $solicitud->otitular_caf ?? 'N/D' }}</td>  <!-- Centro de trabajo -->
                    <td>{{ $solicitud->onombre_autoridadinmediata ?? 'N/D' }}</td>  <!-- Nombre del servidor -->
                    <td>{{ $solicitud->olugar_fecha ?? 'N/D' }}</td>  <!-- Fecha de liberación -->
                    <td>{{ \Carbon\Carbon::parse($solicitud->olugar_fecha)->format('d-m-Y') }}</td> <!-- Fecha de liberación -->
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
