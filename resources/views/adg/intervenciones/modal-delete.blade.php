 

        <x-adminlte-modal   id="modaldeditxxx{{ $i->id }}" 
                    title="QUITAR ESTE PERIÓDO Y VOLVER A REGISTROS" 
                    size="lg" 
                    theme="info"
                    icon="fa fa-file-alt" 
                    v-centered static-backdrop >
            <div>
                <form   name="FrmCartel" id="FrmCartel" method="post" 
                        action="{{ route('solicitud-intervencion.update', Auth::user()->id_ct ) }}" >
                        @method('PATCH')
                        @csrf

                    <input  type="hidden" 
                            name="action" 
                            id="action" 
                            value="99">

                    <input  type="hidden" 
                            name="idinter" 
                            id="idinter" 
                            value="{{ $i->id }}">
                    <p>
                        <h3>¿DESEAS QUITAR EL REGISTRO DE INTERVENCIÓN AL CT  <b>{{ $i->oclave.' - '.$i->onombrect }}</b>?</h3>
                    </p>
                    <br>

                    <button class="btn btn-outline-success btn-sm btn-block">
                        SI, ELIMINAR REGISTRO
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

        