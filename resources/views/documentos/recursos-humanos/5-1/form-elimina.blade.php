<x-adminlte-modal   id="modaldelete{{ $plantilla->id }}" 
                    title="ELIMINAR REGISTRO DE PLANTILLA DE PERSONAL"
                    size="lg" 
                    theme="danger"
                    icon="fa fa-users" 
                    v-centered static-backdrop >
    <div>
        <form   name="FrmCartel" id="FrmCartel" method="post" 
                action="{{ route('plantilla-personal.update', $plantilla->id ) }}" >
                @method('PATCH')
                @csrf
            <input  type="hidden" 
                    name="acta" 
                    id="acta" 
                    value="{{ $datosacta->id }}">

            <input  type="hidden" 
                    name="actionplantilla" 
                    id="actionplantilla" 
                    value="1">

            <P style="font-size: 16px;">
                ¿DESEA ELIMINAR EL REGISTRO No. {{ $key+1 }} DE:&nbsp;
                {{ $plantilla->oclave_puesto.' '.$plantilla->onombre_puesto }}..?
            </P>
            <center>
                <button class="btn btn-outline-success btn-sm btn-block">
                    SÍ, ELIMINAR EL REGISTRO DE LA PLANTILLA
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