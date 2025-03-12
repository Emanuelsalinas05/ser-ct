<x-adminlte-modal   id="modalfilesupdate{{ $inventario->oclave_expediente }}" 
                    title="ACTUALIZAR INFORMACIÓN DE ARCHIVO" 
                    size="lg" 
                    theme="teal"
                    icon="fa fa-copy" 
                    v-centered static-backdrop >
    
    <div>
    <form   name="FrmCartel" id="FrmCartel" method="post" 
            action="{{ route($documento->ourl_documentos.'.update', $inventario->id ) }}" >
            @method('PATCH')
            @csrf

            <input  type="hidden" 
                    name="actionarchivos" 
                    id="actionarchivos" 
                    value="3">

            <input  type="hidden" 
                    name="action" 
                    id="action"
                    value="1">

            <input  type="hidden" 
                    name="iddoc" 
                    id="iddoc"
                    value="{{ $documento->id }}">
                    
            <input  type="hidden" 
                    name="idacta" 
                    id="idacta"
                    value="{{ $datosacta->id }}">

            <table class="table table-sm"
                    style="font-size:14px;">
            <tbody>
                <tr>
                    <td align="right" width="20%">Clave del expediente</td>
                    <td width="25%">
                        <input  type="text" 
                                name="oclave_expediente"
                                id="oclave_expediente"
                                class="form-control form-control-sm" 
                                value="{{old('oclave_expediente', $inventario->oclave_expediente)}}" required>
                    </td>
                    <td colspan="3"></td>
                </tr>
                <tr>
                    <td align="right" width="25%">Nombre del expediente</td>
                    <td colspan="3">
                        <input  type="text" 
                                name="onombre_expediente"
                                id="onombre_expediente"
                                class="form-control form-control-sm" 
                                value="{{old('onombre_expediente', $inventario->onombre_expediente)}}"
                                required>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td align="right" width="20%">Período</td>
                    <td width="25%">
                        <input  type="date" 
                                name="operiodo"
                                id="operiodo"
                                class="form-control form-control-sm" 
                                value="{{old('operiodo', $inventario->operiodo)}}" required>
                    </td>
                    <td width="3%">al</td>
                    <td width="25%">
                        <input  type="date" 
                                name="operiodo2"
                                id="operiodo2"
                                class="form-control form-control-sm"
                                value="{{old('operiodo2', $inventario->operiodo2)}}" required>
                    </td>
                    <td width="25%"></td>
                </tr>
                <tr>
                    <td align="right">Núm de legajos</td>
                    <td>
                        <input  type="text" 
                                name="onum_legajos"
                                id="onum_legajos"
                                class="form-control form-control-sm" 
                                onkeypress="if(event.keyCode<45 || event.keyCode>57) event.returnValue=false;"
                                value="{{old('onum_legajos', $inventario->onum_legajos)}}"
                                required>
                    </td>
                    <td></td>
                    <td align="right">Núm de documentos </td>
                    <td>
                        <input  type="text" 
                                name="onum_documentos"
                                id="onum_documentos"
                                class="form-control form-control-sm" 
                                onkeypress="if(event.keyCode<45 || event.keyCode>57) event.returnValue=false;"
                                value="{{old('onum_documentos', $inventario->onum_documentos)}}"
                                required>
                    </td>
                </tr>
                <tr>
                    <td align="right" width="25%">
                        Tiempo conservación
                    </td>
                    <td>
                        <input  type="text" 
                                name="anios" id="anios"
                                class="form-control form-control-sm" 
                                onkeypress="if(event.keyCode<45 || event.keyCode>57) event.returnValue=false;"
                                value="{{old('anios', $inventario->otiempo_conservacion)}}"
                                required>
                    </td>
                    <td>(AÑOS)</td>
                    <td>
                        <input  type="text" 
                                name="meses" id="meses"
                                class="form-control form-control-sm" 
                                onkeypress="if(event.keyCode<45 || event.keyCode>57) event.returnValue=false;"
                                value="{{old('meses', $inventario->otiempo_conservacion2)}}"
                                required>
                    </td>
                    <td>(MESES)</td>
                </tr>
                <tr>
                    <td align="right" width="25%">Comentarios</td>
                    <td colspan="4">
                        <textarea   name="ocomentarios" 
                                    id="ocomentarios"
                                    class="form-control "
                                    style="resize: none;">{{old('ocomentarios', $inventario->ocomentarios)}}</textarea>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" align="right">
                        <button class="btn btn-success btn-sm">
                            ACTUALIZAR INFORMACIÓN DEL ARCHIVO
                            <i class="fas fa-check"></i>
                        </button>
                    </td>
                </tr>
            </tfoot>
            </table>
    </form>
    </div>
    
    <x-slot name="footerSlot">
        <x-adminlte-button  theme="secondary" 
                            label=" CANCELAR ACCIÓN " 
                            data-dismiss="modal" 
                            icon="fa fa-times"
                            class="btn-sm"/>
    </x-slot>
</x-adminlte-modal>