@extends('layouts.app')

{{-- Customize layout sections --}}
@section('title', 'ENTREGAS NOTIFICADAS A OIC')
@section('content_header_title', 'Home')
@section('content_header_subtitle', ' ENTREGAS NOTIFICADAS A OIC')

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
                    <i class="nav-icon fa fa-envelope-circle-check text-info"></i>&nbsp;
                    <strong>ENTREGAS NOTIFICADAS A OIC</strong>
                    <span class="badge badge-info ml-2">{{ $datosacta->total() ?? 0 }}</span>
                </h5>
            </div>
            <div>
                <a href="{{ url('entrega-recepcion') }}" 
                   class="btn btn-primary btn-sm"
                   title="Regresar a Entrega-Recepción">
                    <i class="fas fa-arrow-left"></i> REGRESAR A ENTREGA-RECEPCIÓN
                </a>
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
                <x-adminlte-callout theme="info" icon="fas fa-envelope-circle-check">
                    <strong><i class="fas fa-info-circle text-info"></i> Entregas Notificadas a OIC</strong><br>
                    <small>Este módulo muestra las entregas finalizadas que han sido notificadas al Órgano Interno de Control (OIC) mediante correo electrónico. Aquí puedes consultar los correos enviados por centro de trabajo y la información completa de cada entrega realizada.</small>
                </x-adminlte-callout>
            </div>
        </div>
    </div>
    
    <div class="card-body table-responsive">
        <x-adminlte-callout theme="light">
            <table class="table table-bordered table-striped table-sm" id="example13" style="font-size:12px;">
                <thead class="bg-lightblue" align="center">
                    <tr>
                        <th>TIPO DE ACTA</th>
                        <th>CENTRO DE TRABAJO</th>
                        <th>SERVIDOR PÚBLICO RESPONSABLE</th>
                        <th>FECHA FINALIZACIÓN</th>
                        <th>NOTIFICACIÓN OIC</th>
                        <th width="10%">ACCIÓN</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($datosacta as $acta)
                    <tr>
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
                                    <div><strong>FECHA:</strong> {{ $acta->ofecha_fin_a ?? 'N/A' }}</div>
                                    <div><strong>HORA:</strong> {{ $acta->ohora_fin_a ?? 'N/A' }}</div>
                                @else
                                    <div><strong>FECHA:</strong> {{ $acta->ofecha_fin_ac ?? 'N/A' }}</div>
                                    <div><strong>HORA:</strong> {{ $acta->ohora_fin_ac ?? 'N/A' }}</div>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div>
                                @if($acta->oenviocorreooic == 1)
                                    <span class="badge badge-success">
                                        <i class="fas fa-check-circle"></i> Notificado
                                    </span><br>
                                    <small class="text-muted">
                                        @if($acta->updated_at)
                                            {{ \Carbon\Carbon::parse($acta->updated_at)->format('d/m/Y H:i') }}
                                        @else
                                            Fecha no disponible
                                        @endif
                                    </small>
                                @else
                                    <span class="badge badge-warning">
                                        <i class="fas fa-exclamation-triangle"></i> Pendiente
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td align="center">
                            <a href="{{route('entregas-recepcion.edit', $acta->id ?? $acta->idd)}}" 
                               class="btn btn-outline-success btn-sm"
                               title="VER ANEXOS Y AVANCE DE: {{ $acta->elct->oclave ?? 'N/A' }} - {{ $acta->elct->onombre_ct ?? 'N/A' }}">
                                <i class="fas fa-eye"></i> VER
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <div class="text-muted">
                                <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                <strong>No hay entregas notificadas al OIC</strong><br>
                                <small>No se encontraron entregas finalizadas que hayan sido notificadas al Órgano Interno de Control.</small>
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
// Filtros rápidos con Bootstrap
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
        
        rows.forEach(row => {
            // Omitir filas de mensajes
            if (row.classList.contains('no-results-message')) {
                return;
            }
            
            let show = true;
            
            // Filtrar por tipo de acta
            if (filters.tipo_acta) {
                const tipoCell = row.querySelector('td:nth-child(1)');
                if (tipoCell && !tipoCell.textContent.includes(filters.tipo_acta)) {
                    show = false;
                }
            }
            
            // Filtrar por fecha
            if (filters.fecha_desde || filters.fecha_hasta) {
                const fechaCell = row.querySelector('td:nth-child(4)');
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
                        // Si no hay fecha en la celda (N/A), ocultar si hay filtros de fecha activos
                        if (filters.fecha_desde || filters.fecha_hasta) {
                            show = false;
                        }
                    }
                }
            }
            
            row.style.display = show ? '' : 'none';
        });
        
        // Mostrar mensaje si no hay resultados visibles
        updateNoResultsMessage();
    }
    
    function updateNoResultsMessage() {
        const table = document.querySelector('.table tbody');
        if (!table) return;
        
        const rows = table.querySelectorAll('tr:not(.no-results-message)');
        const visibleRows = Array.from(rows).filter(row => row.style.display !== 'none');
        
        // Buscar o crear mensaje de "no hay resultados"
        let noResultsMsg = table.querySelector('.no-results-message');
        if (visibleRows.length === 0 && rows.length > 0) {
            if (!noResultsMsg) {
                noResultsMsg = document.createElement('tr');
                noResultsMsg.className = 'no-results-message';
                noResultsMsg.innerHTML = '<td colspan="6" class="text-center py-4"><div class="text-muted"><i class="fas fa-filter fa-2x mb-2 text-warning"></i><br><strong>No hay registros que coincidan con los filtros seleccionados</strong><br><small>Intenta ajustar los filtros de fecha o tipo de acta, o limpiarlos para ver todos los registros.</small></div></td>';
                table.appendChild(noResultsMsg);
            }
        } else if (noResultsMsg) {
            noResultsMsg.remove();
        }
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
    
    window.clearFilters = function() {
        filterInputs.forEach(input => {
            input.value = '';
        });
        
        const rows = document.querySelectorAll('.table tbody tr');
        rows.forEach(row => {
            row.style.display = '';
        });
        
        updateNoResultsMessage();
    };
});
</script>
@endsection
