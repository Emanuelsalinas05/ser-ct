
<li class=" d-flex justify-content-between align-items-center"
    style="border:none;">
    &nbsp;
    <p style="color:gray; font-size: 13px;">
        <i><b>DA CLIC EN EL SÍMBOLO DE 
        <span class="btn btn-xs bg-light" disabled><i class="fas fa-plus"></i></span> 
        PARA VER LA INFORMACIÓN COMPLETA</b></i>
    </p>
</li>

<x-adminlte-card    title="18.1 OTROS HECHOS (GENERALES)"
                    theme="lightblue" 
                    theme-mode="outline"
                    icon="fas fa-icon fa-file-alt" 
                    header-class="text-uppercase rounded-bottom border-info"
                    collapsible="collapsed">

        <table  class="table table-striped table-sm"
                style="font-size:14px;">
            <thead class="bg-lightblue disabled">
                <tr>
                    <th scope="col">PROG.</th>
                    <th scope="col">NOMBRE DEL DOCUMENTO</th>
                    <th scope="col">ARCHIVO ADJUNTO</th>
                </tr>
            </thead>
            <tbody>
                @foreach($iotroshechos as $key => $inventario)
                <tr>
                    <th scope="row" width="5%">
                        {{ $key+1 }}
                    </th>
                      
                    <td width="50%">
                        {{ $inventario->onombre_documento }}
                    </td>
                      
                    <td width="40%">
                        <a  href="../../storage/{{ $inventario->ourl.$inventario->oarchivo_adjunto }}"
                            target="_blank"
                            download 
                            title="{{ $inventario->oarchivo_adjunto }}">
                            {{ $inventario->oarchivo_adjunto }}
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>  

</x-adminlte-card>