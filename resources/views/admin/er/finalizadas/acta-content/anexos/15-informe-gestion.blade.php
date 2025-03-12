
<li class=" d-flex justify-content-between align-items-center"
    style="border:none;">
    &nbsp;
    <p style="color:gray; font-size: 13px;">
        <i><b>DA CLIC EN EL SÍMBOLO DE 
        <span class="btn btn-xs bg-light" disabled><i class="fas fa-plus"></i></span> 
        PARA VER LA INFORMACIÓN COMPLETA</b></i>
    </p>
</li>

<x-adminlte-card    title="15.1 INFORME DE GESTIÓN"             
                    theme="lightblue" 
                    theme-mode="outline"
                    icon="fas fa-icon fa-file-alt" 
                    header-class="text-uppercase rounded-bottom border-info"
                    collapsible="collapsed">

        <table  class="table table-striped table-sm"
                    style="font-size:14px;">
            <thead>
                <tr class="bg-lightblue disabled">
                    <th>REGISTRO DE INFORME DE GESTIÓN</th>
                </tr>
            </thead>
            <tbody>
                <tr class="text-secondary" style="text-align: justify;">
                    <td scope="row">
                        <b>{{ $igestion->roi }}</b>
                        <p>{{ $igestion->oi }}</p>
                    </td>
                </tr>
                <tr class="text-secondary" style="text-align: justify;">
                    <td scope="row">
                        <b>{{ $igestion->roii }}</b>
                        <p>{{ $igestion->oii }}</p>
                    </td>
                </tr>
                <tr class="text-secondary" style="text-align: justify;">
                    <td scope="row">
                        <b>{{ $igestion->roiii }}</b>
                        <p>{{ $igestion->oiii }}</p>
                    </td>
                </tr>
                <tr class="text-secondary" style="text-align: justify;">
                    <td scope="row">
                        <b>{{ $igestion->roiv }}</b>
                        <p>{{ $igestion->oiv }}</p>
                    </td>
                </tr>
            </tbody>
            </table>

</x-adminlte-card>


<x-adminlte-card    title="15.2 INFORME DE COMPROMISOS EN LOS 90 DÍAS POSTERIORES A LA ENTREGA Y RECEPCIÓN"             
                    theme="lightblue" 
                    theme-mode="outline"
                    icon="fas fa-icon fa-file-alt" 
                    header-class="text-uppercase rounded-bottom border-info"
                    collapsible="collapsed">

        <table  class="table table-sm"
                    style="font-size:13px;">
            <thead>
                <tr class="bg-lightblue disabled">
                    <th>PROG.</th>
                    <th>INFORMACIÓN DEL COMPROMISO</th>
                </tr>
            </thead>
            <tbody>
                @foreach($icompromisos as $key => $inventario )
                <tr>
                    <td>
                        {{$key+1}}
                    </td>

                    <td>
                        <table class="table table-sm">
                            <tr>
                                <td colspan="3">
                                    <b>RESPONSABLE</b>: {{$inventario->oresponsable}}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align:justify;">
                                    <b>DESCRIPCIÓN DEL ASUNTO</b>:<br>
                                    {{$inventario->odescripcion_asunto}}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align:justify;">
                                    <b>ACCIONES A REALIZAR</b>:<br>
                                    {{$inventario->oacciones_realizar}}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <b>LUGAR</b>: {{$inventario->olugar}}
                                </td>
                                <td>
                                    <b>FECHA Y HORA</b>: 
                                    {{$inventario->ofecha}} &nbsp;&nbsp;&nbsp;
                                    {{$inventario->ohora.'HRS.'}}
                                </td>
                            </tr>       
                        </table>
                    </td>                    
                </tr>
                @endforeach
            </tbody>
        </table>

</x-adminlte-card>