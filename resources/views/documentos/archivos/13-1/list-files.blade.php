<table  class="table table-striped table-sm"
        style="font-size:12px;">
    <thead class="bg-lightblue ">
        <tr align="center">
            <th scope="col">PROG.</th>
            <th scope="col">NOMBRE DEL DOCUMENTO</th>
            <th scope="col">ADJUNTAR ARCHIVO</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        @foreach($iarchivos as $key => $inventario)
        <tr>
            <th scope="row" width="5%">
                {{ $key+1 }}
            </th>
              
            <td width="50%">
                {{ $inventario->onombre_documento }}
            </td>
              
            <td width="40%">
                <a  href="storage/{{ $inventario->ourl.$inventario->oarchivo_adjunto }}"
                    target="_blank"
                    download 
                    title="{{ $inventario->oarchivo_adjunto }}">
                    {{ $inventario->oarchivo_adjunto }}
                </a>
            </td>
     
            <td width="5%">
            @if($avances->orelacion_archivos_a==0)
                <x-adminlte-button  data-toggle="modal" 
                                    icon="fas fa-minus"
                                    data-target="#modaldelete{{ $inventario->id }}" 
                                    class="bg-danger btn-sm"/>
                @include('documentos.archivos.form-elimina')
            @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>