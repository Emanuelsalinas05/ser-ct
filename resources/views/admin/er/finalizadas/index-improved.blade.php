@extends('layouts.app')

{{-- Customize layout sections --}}
@section('title', 'ENTREGAS FINALIZADAS')
@section('content_header_title', 'Home')
@section('content_header_subtitle', ' ENTREGAS FINALIZADAS')

@push('js')
<script src="{{ asset('js/table-filters.js') }}"></script>
@endpush

{{-- Content body: main page content --}}
@section('content')
<div class="col-12 card card-secondary card-outline shadow">
    <div class="card-header bg-light shadow-sm d-flex mb-2">
        <div class="d-flex justify-content-between">
            <b><i class="nav-icon fa fa-check-circle"></i>&nbsp;
                ENTREGAS FINALIZADAS
            </b> 
        </div>
    </div>
    
    <!-- Filtros rápidos -->
    <div class="card-body bg-light">
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="tipo_acta" class="form-label">Tipo de Acta:</label>
                <select id="tipo_acta" name="tipo_acta" class="form-control form-control-sm">
                    <option value="">Todos los tipos</option>
                    <option value="ACTA DE ENTREGA Y RECEPCIÓN">ACTA DE ENTREGA Y RECEPCIÓN</option>
                    <option value="ACTA CIRCUNSTANCIADA">ACTA CIRCUNSTANCIADA</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="estado" class="form-label">Estado:</label>
                <select id="estado" name="estado" class="form-control form-control-sm">
                    <option value="">Todos los estados</option>
                    <option value="finalizada">Finalizada</option>
                    <option value="concluida">Concluida</option>
                    <option value="completada">Completada</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="fecha_desde" class="form-label">Fecha Desde:</label>
                <input type="date" id="fecha_desde" name="fecha_desde" class="form-control form-control-sm">
            </div>
            <div class="col-md-2">
                <label for="fecha_hasta" class="form-label">Fecha Hasta:</label>
                <input type="date" id="fecha_hasta" name="fecha_hasta" class="form-control form-control-sm">
            </div>
            <div class="col-md-2">
                <label class="form-label">&nbsp;</label>
                <button type="button" class="btn btn-outline-secondary btn-sm d-block" onclick="clearFilters()">
                    <i class="fas fa-times"></i> Limpiar
                </button>
            </div>
        </div>
    </div>
    
    <div class="card-body table-responsive">
        <x-adminlte-callout theme="light">
            <table class="table table-bordered table-striped table-sm" id="example13" style="font-size:12px;">
                <thead class="bg-lightblue" align="center">
                    <tr>
                        @if(Auth::user()->ocargo=='DIRECCIÓN')
                            <th>UNIDAD ADMINISTRATIVA</th>
                        @endif
                        <th>TIPO DE ACTA</th>
                        <th>CENTRO DE TRABAJO</th>
                        <th>SERVIDOR PÚBLICO RESPONSABLE</th>
                        <th>FECHA FINALIZACIÓN</th>
                        <th width="10%">ACCIÓN</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($datosacta as $acta)
                    <tr>
                        @if(Auth::user()->ocargo=='DIRECCIÓN')
                            <td>
                                <span class="badge badge-success">
                                    {{ $acta->unidad ?? 'N/A' }}
                                </span>
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
                                    <div><strong>FECHA:</strong> {{ $acta->ofecha_fin_a ?? 'N/A' }}</div>
                                    <div><strong>HORA:</strong> {{ $acta->ohora_fin_a ?? 'N/A' }}</div>
                                @else
                                    <div><strong>FECHA:</strong> {{ $acta->ofecha_fin_ac ?? 'N/A' }}</div>
                                    <div><strong>HORA:</strong> {{ $acta->ohora_fin_ac ?? 'N/A' }}</div>
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
    </div>
    
</div>

<script>
// Filtros rápidos con Bootstrap
document.addEventListener('DOMContentLoaded', function() {
    const filterInputs = document.querySelectorAll('#tipo_acta, #estado, #fecha_desde, #fecha_hasta');
    
    filterInputs.forEach(input => {
        input.addEventListener('change', applyFilters);
    });
    
    function applyFilters() {
        const table = document.querySelector('.table tbody');
        if (!table) return;
        
        const rows = table.querySelectorAll('tr');
        const filters = getFilterValues();
        
        rows.forEach(row => {
            let show = true;
            
            // Filtrar por tipo de acta
            if (filters.tipo_acta) {
                const tipoCell = row.querySelector('td:nth-child(2)');
                if (tipoCell && !tipoCell.textContent.includes(filters.tipo_acta)) {
                    show = false;
                }
            }
            
            // Filtrar por estado
            if (filters.estado) {
                const estadoCell = row.querySelector('td:nth-child(5)');
                if (estadoCell) {
                    const estadoText = estadoCell.textContent.toLowerCase();
                    if (filters.estado === 'finalizada' && !estadoText.includes('finalizada')) {
                        show = false;
                    } else if (filters.estado === 'concluida' && !estadoText.includes('conclu')) {
                        show = false;
                    } else if (filters.estado === 'completada' && !estadoText.includes('completada')) {
                        show = false;
                    }
                }
            }
            
            // Filtrar por fecha
            if (filters.fecha_desde || filters.fecha_hasta) {
                const fechaCell = row.querySelector('td:nth-child(5)');
                if (fechaCell) {
                    const fechaText = fechaCell.textContent;
                    const fechaMatch = fechaText.match(/(\d{4}-\d{2}-\d{2})/);
                    if (fechaMatch) {
                        const fecha = new Date(fechaMatch[1]);
                        
                        if (filters.fecha_desde) {
                            const fechaDesde = new Date(filters.fecha_desde);
                            if (fecha < fechaDesde) show = false;
                        }
                        
                        if (filters.fecha_hasta) {
                            const fechaHasta = new Date(filters.fecha_hasta);
                            if (fecha > fechaHasta) show = false;
                        }
                    }
                }
            }
            
            row.style.display = show ? '' : 'none';
        });
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
    };
});
</script>
@endsection
