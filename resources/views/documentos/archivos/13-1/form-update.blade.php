<x-adminlte-modal   id="modalfilesupdate{{ $inventario->id }}" 
                    title="REGISTRO DE ARCHIVOS EN TRÁMITE" 
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
                            value="2">

                    <input  type="hidden" 
                            name="idacta" 
                            id="idacta"
                            value="{{ $datosacta->id }}">

                    <table class="table table-sm"
                            style="font-size:14px;">
                    <tbody>
                        <tr>
                            <td align="right" width="25%">Clave del expediente</td>
                            <td>
                                <input  type="text" 
                                        name="oclave_expediente"
                                        id="oclave_expediente"
                                        class="form-control form-control-sm" 
                                        value="{{old('oclave_expediente', $inventario->oclave_expediente)}}" required>
                            </td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td align="right" width="25%">Nombre del expediente</td>
                            <td colspan="2">
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
                            <td width="25%" align="right">Fecha inicial del documento</td>
                            <td>
                                <input  type="date" 
                                        name="ofecha_primero"
                                        id="ofecha_primero"
                                        class="form-control form-control-sm"
                                        value="{{old('ofecha_primero', $inventario->ofecha_primero)}}" 
                                        required>
                            </td>
                            <td width="25%" align="right">Fecha final del documento</td>
                            <td>
                                <input  type="date" 
                                        name="ofecha_ultimo"
                                        id="ofecha_ultimo"
                                        class="form-control input-sm"
                                        value="{{old('ofecha_ultimo', $inventario->ofecha_ultimo)}}" required>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" align="right">
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