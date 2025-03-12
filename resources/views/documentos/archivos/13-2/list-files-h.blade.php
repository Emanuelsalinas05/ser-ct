<table  class="table table-striped table-sm"
        style="font-size:12px;">
    <thead class="bg-lightblue ">
        <tr align="center">
            <th scope="col">PROG.</th>
            <th scope="col">CLAVE DEL EXPEDIENTE</th>
            <th scope="col">NOMBRE DEL EXPEDIENTE</th>
            <th scope="col">PERIODO</th>
            <th scope="col">NÚM. DE LEGAJOS</th>
            <th scope="col">NÚM. DE DOCUMENTOS</th>
            <th scope="col">TIEMPO DE CONSERVACIÓN</th>
            <th scope="col">COMENTARIOS</th>
            <th scope="col" colspan="2"></th>
        </tr>
    </thead>
    <tbody>
        @foreach($iarchivosh as $key => $inventario)
        <tr>
            <th scope="row" width="5%">
                &nbsp;&nbsp;&nbsp;{{ $key+1 }}
            </th>
              
            <td width="10%" align="center">
                {{ $inventario->oclave_expediente }}
            </td>

            <td width="30%">
                {{ $inventario->onombre_expediente }}
            </td>

            <td width="15%">
                {{ $inventario->operiodo." a ".$inventario->operiodo2 }}
            </td>

            <td width="5%" align="center">
                {{ $inventario->onum_legajos }}
            </td>

            <td width="5%" align="center">
                {{ $inventario->onum_documentos }}
            </td>

            <td width="15%" align="center">
                {{ $inventario->otiempo_conservacion." AÑOS Y ".$inventario->otiempo_conservacion2." MESES " }}
            </td>

            <td width="20%">
                {{ $inventario->ocomentarios }}
            </td>
              
            <td width="5%">
            @if($avances->orelacion_archivos_historico_a==0)
                <x-adminlte-button  data-toggle="modal" 
                                    icon="fa fa-edit"
                                    data-target="#modalfilesupdate{{ $inventario->oclave_expediente }}" 
                                    class="btn bg-success btn-sm"/>
                @include('documentos.archivos.13-2.form-update')
            @endif
            </td>
                                    
            <td width="5%">
            @if($avances->orelacion_archivos_historico_a==0)
                <x-adminlte-button  data-toggle="modal" 
                                    icon="fas fa-minus"
                                    data-target="#modaldeleteh{{ $inventario->id }}" 
                                    class="bg-danger btn-sm"/>
                @include('documentos.archivos.13-2.form-elimina-h')
            @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>