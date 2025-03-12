<table  class="table table-striped table-sm"
        style="font-size:12px;">
    <thead class="bg-lightblue disabled">
        <tr align="center">
            <th scope="col">PROG.</th>
            <th scope="col">CLAVE DEL EXPEDIENTE</th>
            <th scope="col">NOMBRE DEL EXPEDIENTE</th>
            <th scope="col">NÚM DE LEGAJOS</th>
            <th scope="col">NÚM DE DOCUMENTOS</th>
            <th scope="col">FECHA INICIAL</th>
            <th scope="col">FECHA FINAL</th>
            <th scope="col" colspan="2"></th>
        </tr>
    </thead>
    <tbody>
        @foreach($iarchivos as $key => $inventario)
        <tr>
            <th scope="row" width="5%" align="center">
                {{ $key+1 }}
            </th>
              
            <td width="15%" align="center">
                {{ $inventario->oclave_expediente }}
            </td>
              
            <td width="45%">
                {{ $inventario->onombre_expediente }}
            </td>

            <td width="5%" align="center">
                {{ $inventario->onum_legajos }}
            </td>

            <td width="5%" align="center">
                {{ $inventario->onum_documentos }}
            </td>

            <td width="10%" align="center">
                {{ $inventario->ofecha_primero }}
            </td>

            <td width="10%" align="center">
                {{ $inventario->ofecha_ultimo }}
            </td>
        
            <td width="5%">
            @if($avances->orelacion_archivos_historico_a==0)
                <x-adminlte-button  data-toggle="modal" 
                                    icon="fa fa-edit"
                                    data-target="#modalfilesupdate{{ $inventario->id }}" 
                                    class="btn bg-success btn-sm"/>
                @include('documentos.archivos.13-1.form-update')
            @endif
            </td>

            <td width="5%">
            @if($avances->orelacion_archivos_a==0)
                <x-adminlte-button  data-toggle="modal" 
                                    icon="fas fa-minus"
                                    data-target="#modaldeletex{{ $inventario->id }}" 
                                    class="bg-danger btn-sm"/>
                @include('documentos.archivos.form-elimina-r')
            @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>