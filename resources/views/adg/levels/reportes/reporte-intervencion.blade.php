@extends('layouts.app')

@section('title', 'SOLICITUDES DE INTERVENCIÓN')
@section('content_header_title', 'Home')
@section('content_header_subtitle', ' SOLICITUDES DE INTERVENCIÓN DE ENTREGA-RECEPCIÓN')

@section('content')
<div class="card card-secondary card-outline shadow">
    <div class="card-header bg-light d-flex justify-content-between">
        <h5 class="mb-0">INTERVENCIONES - {{ $fecha }}</h5>
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
                    <td>{{ $inter->oct_nivel ?? 'N/D' }}</td>  <!-- Centro de trabajo (oct_nivel o onivel_educativo) -->
                    <td>{{ $inter->onombrect ?? 'N/D' }}</td>  <!-- Nombre -->
                    <td>{{ $inter->orecibe ?? 'N/D' }}</td>  <!-- RFC oentrega o recibe (según corresponda) -->
                    <td>{{ \Carbon\Carbon::parse($inter->ofecha_realizacion)->format('d-m-Y') }}</td> <!-- Fecha de solicitud -->
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
