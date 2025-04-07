<li class=" d-flex justify-content-between align-items-center"
    style="border:none;">
    &nbsp;
    <p style="color:gray; font-size: 13px;">
        <i><b>DA CLIC EN EL SÍMBOLO DE 
        <span class="btn btn-xs bg-light" disabled><i class="fas fa-plus"></i></span> 
        PARA VER LA INFORMACIÓN COMPLETA</b></i>
    </p>
</li>


<x-adminlte-card    title="8.1 INVENTARIO DE BIENES MUEBLES, INMUEBLES Y SEMOVIENTES. (INFORMACIÓN CONCENTRADA Y GLOBAL)"             
                    theme="lightblue" 
                    theme-mode="outline"
                    icon="fas fa-icon fa-file-alt" 
                    header-class="text-uppercase rounded-bottom border-info"
                    collapsible="collapsed">

        <table  class="table table-striped table-sm"
                style="font-size:12px;">
            <thead class="bg-lightblue disabled ">
                <tr>
                    <th scope="col">PROG.</th>
                    <th scope="col">NOMBRE DEL DOCUMENTO</th>
                    <th scope="col">ARCHIVO ADJUNTO</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ibienes as $key => $inventario)
                <tr>
                    <th scope="row" width="5%">
                        {{ $key+1 }}
                    </th>
                      
                    <td width="50%">
                        {{ $inventario->onombre_documento }}
                    </td>
                      
                    <td width="40%">
                        <a  href="https://entregasrecepcion.seiem.gob.mx/storage/{{ $inventario->ourl.$inventario->oarchivo_adjunto }}"
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

<x-adminlte-card    title=" 8.3 INVENTARIO DE EXISTENCIAS EN ALMACENES"             
                    theme="lightblue disabled" 
                    theme-mode="outline"
                    icon="fas fa-icon fa-file-alt" 
                    header-class="text-uppercase rounded-bottom border-info"
                    collapsible="collapsed">
        <table  class="table table-striped table-sm"
                style="font-size:12px;">
            <thead class="bg-lightblue disabled">
                <tr>
                    <th scope="col">PROG.</th>
                    <th scope="col">NOMBRE DEL DOCUMENTO</th>
                    <th scope="col">ARCHIVO ADJUNTO</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ialmacen as $key => $inventario)
                <tr>
                    <th scope="row" width="5%">
                        {{ $key+1 }}
                    </th>
                      
                    <td width="50%">
                        {{ $inventario->onombre_documento }}
                    </td>
                      
                    <td width="40%">
                        <a  href="https://entregasrecepcion.seiem.gob.mx/storage/{{ $inventario->ourl.$inventario->oarchivo_adjunto }}"
                            target="_blank" 
                            title="{{ $inventario->oarchivo_adjunto }}">
                            {{ $inventario->oarchivo_adjunto }}
                        </a>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
</x-adminlte-card>


<x-adminlte-card    title="8.5 RELACIÓN DE LOS BIENES BAJO CUSTODÍA DEL TITULAR. (INFORMACIÓN CONCENTRADA Y GLOBAL)"             
                    theme="lightblue" 
                    theme-mode="outline"
                    icon="fas fa-icon fa-file-alt" 
                    header-class="text-uppercase rounded-bottom border-info"
                    collapsible="collapsed">

        <table  class="table table-striped table-sm"
                style="font-size:12px;">
            <thead class="bg-lightblue disabled ">
                <tr>
                    <th scope="col">PROG.</th>
                    <th scope="col">NOMBRE DEL DOCUMENTO</th>
                    <th scope="col">ARCHIVO ADJUNTO</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ibienes as $key => $inventario)
                <tr>
                    <th scope="row" width="5%">
                        {{ $key+1 }}
                    </th>
                      
                    <td width="50%">
                        {{ $inventario->onombre_documento }}
                    </td>
                      
                    <td width="40%">
                        <a  href="https://entregasrecepcion.seiem.gob.mx/storage/{{ $inventario->ourl.$inventario->oarchivo_adjunto }}"
                            target="_blank" 
                            title="{{ $inventario->oarchivo_adjunto }}">
                            {{ $inventario->oarchivo_adjunto }}
                        </a>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>

</x-adminlte-card>