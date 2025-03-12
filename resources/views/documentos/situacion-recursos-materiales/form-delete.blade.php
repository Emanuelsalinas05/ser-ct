<x-adminlte-modal   id="modaldelete{{ $inventario->id }}" 
                    title="ELININAR DOCUMENTO REGISTRADO" 
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
                    name="id" 
                    id="id" 
                    value="{{ $inventario->id }}">
                    
            <input  type="hidden" 
                    name="actionplantilla" 
                    id="actionplantilla" 
                    value="1">

            <P style="font-size: 16px;">
                ¿DESEA ELIMINAR EL DOCUMENTO:&nbsp;
                <b>{{ $inventario->oarchivo_adjunto }}</b>?
            </P>
            <center>
                <button class="btn btn-outline-success btn-sm btn-block">
                    SI, ELIMINAR EL DOCUMENTO REGISTRADO
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