<x-adminlte-modal   id="modalOpenanexo{{ $documento->id }}" 
                    title="APERTURAR {{ $documento->anexo->onum_anexo.'. '.$documento->anexo->oanexo }}" 
                    size="lg" 
                    theme="teal"
                    icon="fas fa-unlock-alt" 
                    v-centered static-backdrop >

        <center style="font-size:16px;">
                ¿DESEAS APERTURAR EL ANEXO 
                <br>
                <b>{{ $documento->onum_documento.'. '.$documento->odocumento }}</b>? 
                <br>           
            
                <form   name="FrmCartel" 
                        id="FrmCartel" 
                        method="post" 
                        action="{{ route('entregas-recepcion.update', $datosacta->id ) }}" >
                        @method('PATCH')
                        @csrf

                        <input  type="hidden" 
                                name="action" 
                                value="2">

                        <input  type="hidden" 
                                name="idacta" 
                                value="{{ $datosacta->id }}">

                        <input  type="hidden" 
                                name="idoc" 
                                value="{{ $documento->id }}">

                        <input  type="hidden" 
                                name="idane" 
                                value="{{ $documento->anexo->onum_anexo }}">
                        

                        <button type="submit" 
                                class="btn btn-outline-success btn-sm btn-block"
                                title="APERTURAR ANEXO {{ $documento->odocumento }}">
                            SI, APERTURAR ESTE ANEXO&nbsp;
                            <i class="fas fa-unlock-alt"></i>
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