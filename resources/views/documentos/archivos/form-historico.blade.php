<p style="font-size:13px;">
    <i class="fa fa-info-circle"></i>&nbsp;
    <b class="text-info">INDICACIONES PARA EL REGISTRO:</b><br>
    {{ $documento->odescripcion }}.&nbsp;
    <br>
    AL TERMINAR CON EL REGISTRO DA CLIC EN "<B>FINALIZAR REGISTRO</B>" PARA CONCLUIR ESTE APARTADO.
</p>

<x-adminlte-button  label="REGISTRAR ARCHIVOS ENTRÁMITE" 
                        data-toggle="modal" 
                        icon="fa fa-file-alt"
                        data-target="#modalfilesH" 
                        class="btn bg-success btn-sm"/>



<x-adminlte-modal   id="modalfilesH" 
                    title="REGISTRO DE ARCHIVOS DE CONCENTRACIÓN O HISTÓRICO" 
                    size="lg" 
                    theme="teal"
                    icon="fa fa-copy" 
                    v-centered static-backdrop >
    
    <div>
    <form   name="FrmCartel" id="FrmCartel" method="post" 
            action="{{ route($documento->ourl_documentos.'.store') }}">
            @method('POST')
            @csrf

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
                                value="{{old('oclave_expediente')}}" required>
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
                                value="{{old('onombre_expediente')}}"
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
                                value="{{old('operiodo')}}" required>
                    </td>
                    <td width="3%">al</td>
                    <td width="25%">
                        <input  type="date" 
                                name="operiodo2"
                                id="operiodo2"
                                class="form-control form-control-sm"
                                value="{{old('operiodo2')}}" required>
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
                                value="{{old('onum_legajos')}}"
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
                                value="{{old('onum_documentos')}}"
                                required>
                    </td>
                </tr>
                <tr>
                    <td align="right" width="25%">
                        Tiempo conservación 
                    </td>
                    <td>
                        <input  type="text" 
                                name="anios"
                                id="anios"
                                class="form-control form-control-sm" 
                                onkeypress="if(event.keyCode<45 || event.keyCode>57) event.returnValue=false;"
                                value="{{old('anios')}}"
                                required>
                    </td>
                    <td>(AÑOS)</td>
                    <td>
                        <input  type="text" 
                                name="meses"
                                id="meses"
                                class="form-control form-control-sm" 
                                onkeypress="if(event.keyCode<45 || event.keyCode>57) event.returnValue=false;"
                                value="{{old('meses')}}"
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
                                    style="resize: none;"></textarea>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" align="right">
                        <button class="btn btn-success btn-sm">
                            AGREGAR INFORMACIÓN DEL ARCHIVO
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