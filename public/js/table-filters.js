// Filtros rápidos para las tablas de entregas-recepción

document.addEventListener('DOMContentLoaded', function() {
    // Inicializar filtros rápidos
    initQuickFilters();
    
    // Inicializar búsqueda global
    initGlobalSearch();
    
    // Inicializar ordenamiento
    initSorting();
});

function initQuickFilters() {
    const filterContainer = document.querySelector('.quick-filters');
    if (!filterContainer) return;
    
    // Crear filtros dinámicos
    const filters = [
        {
            name: 'tipo_acta',
            label: 'Tipo de Acta',
            type: 'select',
            options: [
                { value: '', text: 'Todos los tipos' },
                { value: 'ACTA DE ENTREGA Y RECEPCIÓN', text: 'ACTA DE ENTREGA Y RECEPCIÓN' },
                { value: 'ACTA CIRCUNSTANCIADA', text: 'ACTA CIRCUNSTANCIADA' }
            ]
        },
        {
            name: 'estado',
            label: 'Estado',
            type: 'select',
            options: [
                { value: '', text: 'Todos los estados' },
                { value: 'en_proceso', text: 'En Proceso' },
                { value: 'concluida', text: 'Concluida' },
                { value: 'pendiente', text: 'Pendiente' }
            ]
        },
        {
            name: 'fecha_desde',
            label: 'Fecha Desde',
            type: 'date'
        },
        {
            name: 'fecha_hasta',
            label: 'Fecha Hasta',
            type: 'date'
        }
    ];
    
    filters.forEach(filter => {
        const filterGroup = createFilterGroup(filter);
        filterContainer.appendChild(filterGroup);
    });
    
    // Aplicar filtros
    filterContainer.addEventListener('change', applyFilters);
}

function createFilterGroup(filter) {
    const group = document.createElement('div');
    group.className = 'filter-group';
    
    const label = document.createElement('label');
    label.textContent = filter.label;
    label.setAttribute('for', filter.name);
    
    let input;
    if (filter.type === 'select') {
        input = document.createElement('select');
        input.id = filter.name;
        input.name = filter.name;
        input.className = 'form-control';
        
        filter.options.forEach(option => {
            const optionElement = document.createElement('option');
            optionElement.value = option.value;
            optionElement.textContent = option.text;
            input.appendChild(optionElement);
        });
    } else {
        input = document.createElement('input');
        input.type = filter.type;
        input.id = filter.name;
        input.name = filter.name;
        input.className = 'form-control';
    }
    
    group.appendChild(label);
    group.appendChild(input);
    
    return group;
}

function applyFilters() {
    const table = document.querySelector('.table tbody');
    if (!table) return;
    
    const rows = table.querySelectorAll('tr');
    const filters = getFilterValues();
    
    rows.forEach(row => {
        let show = true;
        
        // Filtrar por tipo de acta
        if (filters.tipo_acta) {
            const tipoCell = row.querySelector('td:nth-child(2)'); // Columna TIPO DE ACTA
            if (tipoCell && !tipoCell.textContent.includes(filters.tipo_acta)) {
                show = false;
            }
        }
        
        // Filtrar por estado
        if (filters.estado) {
            const estadoCell = row.querySelector('td:nth-child(5)'); // Columna ESTADO
            if (estadoCell) {
                const estadoText = estadoCell.textContent.toLowerCase();
                if (filters.estado === 'en_proceso' && !estadoText.includes('proceso')) {
                    show = false;
                } else if (filters.estado === 'concluida' && !estadoText.includes('conclu')) {
                    show = false;
                } else if (filters.estado === 'pendiente' && !estadoText.includes('pendiente')) {
                    show = false;
                }
            }
        }
        
        // Filtrar por fecha
        if (filters.fecha_desde || filters.fecha_hasta) {
            const fechaCell = row.querySelector('td:nth-child(5)'); // Columna FECHA
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
        
        // Mostrar/ocultar fila
        row.style.display = show ? '' : 'none';
    });
    
    updateVisibleCount();
}

function getFilterValues() {
    const filters = {};
    const filterInputs = document.querySelectorAll('.quick-filters input, .quick-filters select');
    
    filterInputs.forEach(input => {
        if (input.value) {
            filters[input.name] = input.value;
        }
    });
    
    return filters;
}

function initGlobalSearch() {
    const searchInput = document.querySelector('input[type="search"]');
    if (!searchInput) return;
    
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const table = document.querySelector('.table tbody');
        if (!table) return;
        
        const rows = table.querySelectorAll('tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
        
        updateVisibleCount();
    });
}

function initSorting() {
    const headers = document.querySelectorAll('.table thead th');
    
    headers.forEach((header, index) => {
        if (index === headers.length - 1) return; // Skip action column
        
        header.style.cursor = 'pointer';
        header.addEventListener('click', function() {
            sortTable(index);
        });
        
        // Add sort indicator
        const indicator = document.createElement('span');
        indicator.className = 'sort-indicator';
        indicator.innerHTML = ' ↕';
        header.appendChild(indicator);
    });
}

function sortTable(columnIndex) {
    const table = document.querySelector('.table tbody');
    if (!table) return;
    
    const rows = Array.from(table.querySelectorAll('tr'));
    const isAscending = !table.dataset.sortDirection || table.dataset.sortDirection === 'desc';
    
    rows.sort((a, b) => {
        const aText = a.cells[columnIndex].textContent.trim();
        const bText = b.cells[columnIndex].textContent.trim();
        
        if (isAscending) {
            return aText.localeCompare(bText);
        } else {
            return bText.localeCompare(aText);
        }
    });
    
    // Reorder rows
    rows.forEach(row => table.appendChild(row));
    
    // Update sort direction
    table.dataset.sortDirection = isAscending ? 'asc' : 'desc';
    
    // Update indicators
    updateSortIndicators(columnIndex, isAscending);
}

function updateSortIndicators(activeColumn, isAscending) {
    const headers = document.querySelectorAll('.table thead th');
    
    headers.forEach((header, index) => {
        const indicator = header.querySelector('.sort-indicator');
        if (index === activeColumn) {
            indicator.textContent = isAscending ? ' ↑' : ' ↓';
        } else {
            indicator.textContent = ' ↕';
        }
    });
}

function updateVisibleCount() {
    const table = document.querySelector('.table tbody');
    if (!table) return;
    
    const visibleRows = table.querySelectorAll('tr[style=""], tr:not([style])');
    const totalRows = table.querySelectorAll('tr').length;
    
    // Update pagination info if exists
    const paginationInfo = document.querySelector('.pagination-info');
    if (paginationInfo) {
        paginationInfo.textContent = `Mostrando ${visibleRows.length} de ${totalRows} registros`;
    }
}

// Función para limpiar filtros
function clearFilters() {
    const filterInputs = document.querySelectorAll('.quick-filters input, .quick-filters select');
    filterInputs.forEach(input => {
        input.value = '';
    });
    
    const searchInput = document.querySelector('input[type="search"]');
    if (searchInput) {
        searchInput.value = '';
    }
    
    // Mostrar todas las filas
    const table = document.querySelector('.table tbody');
    if (table) {
        const rows = table.querySelectorAll('tr');
        rows.forEach(row => {
            row.style.display = '';
        });
    }
    
    updateVisibleCount();
}

// Exportar funciones globalmente
window.clearFilters = clearFilters;
