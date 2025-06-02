<table>
    <thead>
    <tr>
        <th>#</th>
        <th>C.T.</th>
        <th>Nombre del que entrega</th>
        <th>RFC</th>
        <th>Fecha de cierre</th>
    </tr>
    </thead>
    <tbody>
    @foreach($actas as $i => $acta)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $acta->oct_a }}</td>
            <td>{{ $acta->onombre_entrega_a }}</td>
            <td>{{ $acta->orfc_entrega_a }}</td>
            <td>{{ \Carbon\Carbon::parse($acta->ofechafin)->format('d/m/Y') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
