<x-adminlte-modal   id="modaldelete{{ $comisionado->id }}" 
                    title="ELIMINAR REGISTRO DE SERVIDOR PÚBLICO COMISIONADO"
                    size="lg" 
                    theme="danger"
                    icon="fa fa-users" 
                    v-centered static-backdrop >
    <div>
        <form   name="FrmCartel" id="FrmCartel" method="post" 
                action="{{ route('plantilla-comisionados.update', $comisionado->id ) }}" >
                @method('PATCH')
                @csrf
            <input  type="hidden" 
                    name="acta" 
                    id="acta" 
                    value="{{ $datosacta->id }}">

            <input  type="hidden" 
                    name="actioncomisionados" 
                    id="actioncomisionados" 
                    value="1">

            <P style="font-size: 16px;">
                ¿DESEA ELIMINAR AL SERVIDOR:&nbsp; <b>{{  $comisionado->onombre_servidor  }}</b>?
            </P>
            <center>
                <button class="btn btn-outline-success btn-sm btn-block">
                    SÍ, ELIMINAR EL REGISTRO
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