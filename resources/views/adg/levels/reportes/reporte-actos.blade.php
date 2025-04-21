@extends('layouts.app')

@section('title', 'REPORTE DE ACTOS DE ENTREGA-RECEPCION')
@section('content_header_title', 'Home')
@section('content_header_subtitle', ' REPORTE DE ACTOS DE ENTREGA-RECEPCION')

@section('content')
<div class="card card-secondary card-outline shadow">
    <div class="card-header bg-light d-flex justify-content-between">
        <h5 class="mb-0">ACTAS CONCLUIDAS - {{ $fecha }}</h5>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-bordered table-sm">
            <thead class="bg-lightblue text-center">
                <tr>
                    <th>#</th>
                    <th>C.T.</th>
                    <th>Nombre del que entrega</th>
                    <th>RFC</th>
                    <th>Fecha de cierre</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($actas as $i => $acta)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $acta->oct_a }}</td>
                    <td>{{ $acta->onombre_entrega_a }}</td>
                    <td>{{ $acta->orfc_entrega_a }}</td>
                    <td>{{ $acta->ofechafin }}</td>
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
