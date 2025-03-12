 

        <x-adminlte-modal   id="modaldedit{{ $i->ofechafin }}" 
                    title="QUITAR ESTE PERIÓDO Y VOLVER A REGISTROS" 
                    size="lg" 
                    theme="info"
                    icon="fa fa-file-alt" 
                    v-centered static-backdrop >
            <div>
                <form   name="FrmCartel" id="FrmCartel" method="post" 
                        action="{{ route('reportes-intervencion.update', Auth::user()->id_ct ) }}" >
                        @method('PATCH')
                        @csrf

                    <input  type="hidden" 
                            name="action" 
                            id="action" 
                            value="99">

                    <input  type="hidden" 
                            name="fecfin" 
                            id="fecfin" 
                            value="{{ $i->ofechafin }}">
                    <p>
                        <h3>¿DESEAS QUITAR EL PERIODO CON FECHA <b>{{ $i->fechaentrega }}</b>?</h3>
                    </p>
                    <br>

                    <button class="btn btn-outline-success btn-sm">
                        SI, CANCELAR ESTA FECHA
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

        