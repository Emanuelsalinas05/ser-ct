<x-adminlte-modal   id="deletemj{{ $juridico->id }}" 
                    title="ELIMINAR ORDENAMIENTO JURÍDICO"
                    size="lg" 
                    theme="danger"
                    icon="fas fa-minus" 
                    v-centered static-backdrop >
    <div>
        <form   name="FrmCartel" id="FrmCartel" method="post" 
                action="{{ route('marco-juridico.update', $juridico->id ) }}" >
                @method('PATCH')
                @csrf

            <input  type="hidden" 
                    name="action" 
                    id="action" 
                    value="2">

            <P style="font-size: 16px;">
                ¿DESEA ELIMINAR :&nbsp;  <br>
                <b style="text-align: justify;">
                    {{ $juridico->odenominacion_juridica }}
                </b>
                ?
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