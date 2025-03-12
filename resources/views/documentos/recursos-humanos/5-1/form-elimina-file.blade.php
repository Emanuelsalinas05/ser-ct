<x-adminlte-modal   id="modaldeletefile{{ $inventario->id }}" 
                    title="ELININAR ARCHIVO DE PLANTILLA DE PERSONAL" 
                    size="lg" 
                    theme="danger"
                    icon="fa fa-users" 
                    v-centered static-backdrop >
    <div>
        <form   name="FrmCartel" id="FrmCartel" method="post" 
                action="{{ route($documento->ourl_documentos.'.update', $inventario->id ) }}" >
                @method('PATCH')
                @csrf
            <input  type="hidden" 
                    name="acta" 
                    id="acta" 
                    value="{{ $datosacta->id }}">

            <input  type="hidden" 
                    name="actionplantilla" 
                    id="actionplantilla" 
                    value="9">

            <P style="font-size: 16px;">
                ¿DESEA ELIMINAR EL ARCHIVO <b>{{ $inventario->onombre_documento }}</b>?
            </P>
            <center>
                <button class="btn btn-outline-success btn-sm btn-block">
                    SI, ELIMINAR EL REGISTRO
                </button>
            </center>

        </form>
    </div>    
    <x-slot name="footerSlot">
        <x-adminlte-button  theme="secondary" 
                            label="CANCELAR ACCIÓN" 
                            data-dismiss="modal" 
                            class="btn-sm"/>
    </x-slot>
</x-adminlte-modal>