<x-adminlte-modal   id="modalfinish{{ $datosacta->id }}" 
                    title="FINALIZAR  {{ $datosacta->tipoacta->otipoacta }}" 
                    size="lg" 
                    theme="teal"
                    icon="fas fa-unlock-alt" 
                    v-centered static-backdrop >

        <center style="font-size:16px;">
                ¿DESEAS FINALIZAR ESTA ENTREGA-RECEPCIÓN? <br>           
            
            
            <form   name="FrmCartel" id="FrmCartel" method="post" 
                action="{{ route('entregas-recepcion.update', $datosacta->id ) }}" >
                @method('PATCH')
                @csrf

                <input type="hidden" name="action" value="3">
                <input type="hidden" name="idacta" value="{{ $datosacta->id }}">

                <button type="submit" class="btn btn-outline-success btn-sm btn-block"
                        title="FINALIZAR  {{ $datosacta->tipoacta->otipoacta }}">
                    SÍ, FINALIZAR &nbsp;<i class="fa fa-check"></i>
                </button>

            </form>

        </center>

    <x-slot name="footerSlot">
        <x-adminlte-button  theme="secondary" 
                            label=" CANCELAR ACCIÓN " 
                            data-dismiss="modal" 
                            icon="fa fa-times"
                            class="btn-sm"/>
    </x-slot>
</x-adminlte-modal>