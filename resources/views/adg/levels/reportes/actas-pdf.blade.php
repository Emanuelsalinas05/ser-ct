<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Actas</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 4px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
<h2>Reporte de Actas Concluidas ({{ $fecha }})</h2>
<table>
    <thead>
    <tr>
        <th>Nombre</th>
        <th>RFC</th>
        <th>Centro de Trabajo</th>
        <th>Fecha de Conclusión</th>
    </tr>
    </thead>
    <tbody>
    @forelse($actas as $acta)
        <tr>
            <td>{{ $acta->onombre_entrega_a }}</td>
            <td>{{ $acta->orfc_entrega_a }}</td>
            <td>{{ $acta->onombre_ct_a }}</td>
            <td>{{ \Carbon\Carbon::parse($acta->ofechafin)->format('d/m/Y') }}</td>
        </tr>
    @empty
        <tr><td colspan="4">No hay actas concluidas en este periodo.</td></tr>
    @endforelse
    </tbody>
</table>
</body>
</html>
