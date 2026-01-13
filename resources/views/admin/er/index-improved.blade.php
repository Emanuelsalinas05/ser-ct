@extends('layouts.app')

{{-- Customize layout sections --}}
@section('title', 'REGISTROS DE ENTREGAS-RECEPCIÓN')
@section('content_header_title', 'Home')
@section('content_header_subtitle', ' REGISTROS DE ENTREGAS-RECEPCIÓN')

@push('js')
<script src="{{ asset('js/table-filters.js') }}"></script>
@endpush

{{-- Content body: main page content --}}
@section('content')
<div class="col-12 card card-secondary card-outline shadow">
    <div class="card-header bg-light shadow-sm d-flex mb-2">
        <div class="d-flex justify-content-between w-100 align-items-center">
            <div>
                <h5 class="mb-0">
                    <i class="nav-icon fa fa-hourglass-half text-warning"></i>&nbsp;
                    <strong>REGISTROS DE ACTOS ENTREGAS-RECEPCIÓN</strong>
                    <span class="badge badge-warning ml-2">{{ $datosacta->total() ?? 0 }}</span>
                </h5>
            </div>
        </div>
    </div>
    
    <!-- Filtros rápidos -->
    <div class="card-body bg-light">
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="tipo_acta" class="form-label">
                    <i class="fas fa-file-alt text-primary"></i> Tipo de Acta:
                </label>
                <select id="tipo_acta" name="tipo_acta" class="form-control form-control-sm">
                    <option value="">Todos los tipos</option>
                    <option value="ACTA DE ENTREGA Y RECEPCIÓN">ACTA DE ENTREGA Y RECEPCIÓN</option>
                    <option value="ACTA CIRCUNSTANCIADA">ACTA CIRCUNSTANCIADA</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="fecha_desde" class="form-label">
                    <i class="fas fa-calendar-alt text-info"></i> Fecha Desde:
                </label>
                <input type="date" id="fecha_desde" name="fecha_desde" class="form-control form-control-sm">
            </div>
            <div class="col-md-3">
                <label for="fecha_hasta" class="form-label">
                    <i class="fas fa-calendar-check text-info"></i> Fecha Hasta:
                </label>
                <input type="date" id="fecha_hasta" name="fecha_hasta" class="form-control form-control-sm">
            </div>
            <div class="col-md-2">
                <label class="form-label">&nbsp;</label>
                <button type="button" class="btn btn-outline-secondary btn-sm d-block" onclick="clearFilters()" title="Limpiar todos los filtros">
                    <i class="fas fa-times"></i> Limpiar
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <x-adminlte-callout theme="warning" icon="fas fa-hourglass-half">
                    <strong><i class="fas fa-info-circle text-warning"></i> Entregas en Curso</strong><br>
                    <small>Este módulo muestra las entregas-recepción <strong>en curso</strong> (actas no finalizadas). Para ver entregas finalizadas, consulta el módulo "Finalizadas" o "Notificadas a OIC" desde el menú.</small>
                </x-adminlte-callout>
            </div>
        </div>
    </div>
    
    <div class="card-body table-responsive">
        <x-adminlte-callout theme="light">
            <table class="table table-bordered table-striped table-sm" id="example13" style="font-size:12px;">
                <thead class="bg-lightblue" align="center">
                    <tr>
                        @if(Auth::user()->ocargo=='DIRECCIÓN')
                            <th width="20%">
                                <i class="fas fa-building"></i> UNIDAD ADMINISTRATIVA
                            </th>
                        @endif
                        <th>TIPO DE ACTA</th>
                        <th>CENTRO DE TRABAJO</th>
                        <th>SERVIDOR PÚBLICO RESPONSABLE</th>
                        <th>FECHA</th>
                        <th width="10%">ACCIÓN</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($datosacta as $acta)
                    <tr>
                        @if(Auth::user()->ocargo=='DIRECCIÓN')
                            <td>
                                @if($acta->unidad && $acta->unidad != 'N/A')
                                    <div class="d-flex align-items-start">
                                        <i class="fas fa-building text-primary mr-2 mt-1" style="font-size: 14px;"></i>
                                        <div class="flex-grow-1">
                                            <div class="text-dark font-weight-bold" style="font-size: 11px; line-height: 1.4; word-wrap: break-word;">
                                                {{ $acta->unidad }}
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-muted small">
                                        <i class="fas fa-minus-circle"></i> N/A
                                    </span>
                                @endif
                            </td>
                        @endif
                        <td>
                            <strong>{{ $acta->tipoacta->otipoacta ?? 'N/A' }}</strong>
                        </td>
                        <td>
                            <div>
                                <strong>{{ $acta->elct->oclave ?? 'N/A' }}</strong><br>
                                <small class="text-muted">{{ $acta->elct->onombre_ct ?? 'N/A' }}</small>
                            </div>
                        </td>
                        <td>
                            <div>
                                @if($acta->id_tipoacta == 1)
                                    <div><strong>RECIBE:</strong> {{ $acta->onombre_recibe_a ?? 'N/A' }}</div>
                                    <div><strong>ENTREGA:</strong> {{ $acta->onombre_entrega_a ?? 'N/A' }}</div>
                                @else
                                    <div><strong>RECIBE:</strong> {{ $acta->onombre_recibe_ac ?? 'N/A' }}</div>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div>
                                @if($acta->id_tipoacta == 1)
                                    <div><strong>FECHA:</strong> {{ $acta->ofecha_inicio_a ?? 'N/A' }}</div>
                                    <div><strong>HORA:</strong> {{ $acta->ohora_inicio_a ?? 'N/A' }}</div>
                                @else
                                    <div><strong>FECHA:</strong> {{ $acta->ofecha_inicio_ac ?? 'N/A' }}</div>
                                    <div><strong>HORA:</strong> {{ $acta->ohora_inicio_ac ?? 'N/A' }}</div>
                                @endif
                            </div>
                        </td>
                        <td align="center">
                            <a href="{{route('entregas-recepcion.edit', $acta->id ?? $acta->idd)}}" 
                               class="btn btn-outline-dark btn-sm"
                               title="VER ANEXOS Y AVANCE DE: {{ $acta->elct->oclave ?? 'N/A' }} - {{ $acta->elct->onombre_ct ?? 'N/A' }}">
                                <i class="fas fa-eye"></i> VER
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ Auth::user()->ocargo=='DIRECCIÓN' ? '6' : '5' }}" class="text-center py-4">
                            <div class="text-muted">
                                <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                No se encontraron registros
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </x-adminlte-callout>
        
        {{-- Paginación --}}
        @if(isset($datosacta) && method_exists($datosacta, 'hasPages') && $datosacta->hasPages())
            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="text-muted small">
                        <i class="fas fa-info-circle"></i> 
                        Mostrando <strong>{{ $datosacta->firstItem() ?? 0 }}</strong> a 
                        <strong>{{ $datosacta->lastItem() ?? 0 }}</strong> de 
                        <strong>{{ $datosacta->total() }}</strong> registros
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-end">
                        {{ $datosacta->links('vendor.pagination.bootstrap-4') }}
                    </div>
                </div>
            </div>
        @endif
    </div>
    
</div>

<script>
// Filtros rápidos mejorados (sin filtro de estado)
document.addEventListener('DOMContentLoaded', function() {
    const filterInputs = document.querySelectorAll('#tipo_acta, #fecha_desde, #fecha_hasta');
    
    filterInputs.forEach(input => {
        input.addEventListener('change', applyFilters);
    });
    
    function applyFilters() {
        const table = document.querySelector('.table tbody');
        if (!table) return;
        
        const rows = table.querySelectorAll('tr');
        const filters = getFilterValues();
        let visibleCount = 0;
        
        rows.forEach(row => {
            // Saltar fila vacía si existe
            if (row.querySelector('td[colspan]')) {
                return;
            }
            
            let show = true;
            
            // Determinar índices de columnas según el rol
            const isDireccion = {{ Auth::user()->ocargo=='DIRECCIÓN' ? 'true' : 'false' }};
            // Tipo de acta: columna 2 si es DIRECCIÓN, columna 1 si no
            const tipoColIndex = isDireccion ? 2 : 1;
            // Fecha: columna 5 si es DIRECCIÓN, columna 4 si no
            const fechaColIndex = isDireccion ? 5 : 4;
            
            // Filtrar por tipo de acta
            if (filters.tipo_acta) {
                const tipoCell = row.querySelector('td:nth-child(' + tipoColIndex + ')');
                if (tipoCell && !tipoCell.textContent.includes(filters.tipo_acta)) {
                    show = false;
                }
            }
            
            // Filtrar por fecha
            if (filters.fecha_desde || filters.fecha_hasta) {
                const fechaCell = row.querySelector('td:nth-child(' + fechaColIndex + ')');
                if (fechaCell) {
                    const fechaText = fechaCell.textContent;
                    const fechaMatch = fechaText.match(/(\d{4}-\d{2}-\d{2})/);
                    if (fechaMatch) {
                        const fecha = new Date(fechaMatch[1]);
                        
                        if (filters.fecha_desde) {
                            const fechaDesde = new Date(filters.fecha_desde);
                            fechaDesde.setHours(0, 0, 0, 0);
                            if (fecha < fechaDesde) show = false;
                        }
                        
                        if (filters.fecha_hasta) {
                            const fechaHasta = new Date(filters.fecha_hasta);
                            fechaHasta.setHours(23, 59, 59, 999);
                            if (fecha > fechaHasta) show = false;
                        }
                    } else {
                        // Si no hay fecha (N/A), ocultar si hay filtros de fecha activos
                        if (filters.fecha_desde || filters.fecha_hasta) {
                            show = false;
                        }
                    }
                }
            }
            
            row.style.display = show ? '' : 'none';
            if (show) visibleCount++;
        });
        
        // Mostrar mensaje si no hay resultados
        updateNoResultsMessage(visibleCount);
    }
    
    function getFilterValues() {
        const filters = {};
        filterInputs.forEach(input => {
            if (input.value) {
                filters[input.name] = input.value;
            }
        });
        return filters;
    }
    
    function updateNoResultsMessage(visibleCount) {
        // Remover mensaje anterior si existe
        const existingMsg = document.querySelector('.no-results-message');
        if (existingMsg) {
            existingMsg.remove();
        }
        
        if (visibleCount === 0) {
            const table = document.querySelector('.table tbody');
            if (table && table.querySelectorAll('tr:not(.no-results-message)').length > 0) {
                const msg = document.createElement('tr');
                msg.className = 'no-results-message';
                const colspan = {{ Auth::user()->ocargo=='DIRECCIÓN' ? '6' : '5' }};
                msg.innerHTML = '<td colspan="' + colspan + '" class="text-center py-4"><div class="text-muted"><i class="fas fa-filter fa-2x mb-2 text-warning"></i><br><strong>No hay registros que coincidan con los filtros seleccionados</strong><br><small>Intenta ajustar los filtros de fecha o tipo de acta, o limpiarlos para ver todos los registros.</small></div></td>';
                table.appendChild(msg);
            }
        }
    }
    
    window.clearFilters = function() {
        filterInputs.forEach(input => {
            input.value = '';
        });
        
        const rows = document.querySelectorAll('.table tbody tr');
        rows.forEach(row => {
            row.style.display = '';
        });
        
        // Remover mensaje de no resultados
        const existingMsg = document.querySelector('.no-results-message');
        if (existingMsg) {
            existingMsg.remove();
        }
    };
});
</script>
@endsection
