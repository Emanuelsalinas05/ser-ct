<x-adminlte-modal   id="finaliza" 
                    title="FINALIZAR REGISTRO DE ORDENAMIENTO JURÍDICO-ADMINISTRATIVO"
                    size="lg" 
                    theme="info"
                    icon="fa fa-file" 
                    v-centered static-backdrop >
    <div>
        <p style="text-align:justify; font-size: 14px;">
            <i>
                AL FINALIZAR EL REGISTRO DE ORDENAMIENTOS JURÍDICO-ADMINISTRATIVOS,
                NO PODRÁS MODIFICAR Y/O QUITAR ALGÚN ELEMENTO REGISTRADO.
            </i>
        </p>
        <form   name="FrmCartel" id="FrmCartel" method="post" 
                        action="{{ route('marco-juridico.update', Auth::user()->id ) }}" >
                        @method('PATCH')
                        @csrf
                    <input  type="hidden" 
                            name="action" 
                            id="action" 
                            value="9">

                    <button class="btn btn-success btn-sm btn-block"
                            style="font-size: 14px;">
                            &nbsp;
                        SÍ, FINALIZAR REGISTRO DE ORDENAMIENTOS JURÍDICO-ADMINISTRATIVOS
                        <i class="fas fa-check"></i>
                    </button>

                </form>
    </div>    
    <x-slot name="footerSlot">
        <x-adminlte-button  theme="secondary" 
                            label="CANCELAR ACCIÓN" 
                            data-dismiss="modal" 
                            class="btn-sm"/>
    </x-slot>
</x-adminlte-modal>