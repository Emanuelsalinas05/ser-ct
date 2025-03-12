
<x-adminlte-modal   id="modaldeditx{{ $i->ofechafin }}" 
                    title="CARGA DE ARCHIVO ESCANEADO" 
                    size="lg" 
                    theme="teal"
                    icon="fa fa-copy" 
                    v-centered static-backdrop >
    
    <div>

                <form   name="FrmCartel" id="FrmCartel" method="post" 
                        action="{{ route('reportes-intervencion.store', Auth::user()->id_ct ) }}" 
                        enctype="multipart/form-data">
                        @method('POST')
                        @csrf

                    <input  type="hidden" 
                            name="action" 
                            id="action" 
                            value="1">

                    <input  type="hidden" 
                            name="fecfin" 
                            id="fecfin" 
                            value="{{ $i->ofechafin }}">
                        <p style="font-size:14px; text-align: justify;">Una vez enviada la Solicitud de Intervención firmada y sellada, se notificará a la DEE, para informar a la CAOE y ésta a la vez al Órgano Interno de Control.</p>
                <table class="table table-sm"
                        style="font-size:12px;">
                    <thead>
                        <tr class="bg-lightblue disabled" align="center">
                            <th><b>INGRESA EL NOMBRE DEL DOCUMENTO</b></th>
                            <th><b>ARCHIVO/DOCUMENTO A SUBIR</b></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td width="50%">
                                <input  type="text" 
                                        name="onombre_documento" id="onombre_documento" required 
                                        class="form-control form-control-sm">
                                    @error('onombre_documento') <span style="color:red;">{{ $message }}</span> @enderror
                            </td>
                                    
                            <td width="35%">
                                <input  type="file" name="onombre_archivo" id="onombre_archivo"
                                        class="form-control form-control-sm" >
                                @error('onombre_archivo') <span style="color:red;">{{ $message }}</span> @enderror
                            </td> 
                        </tr>                 
                        <tr>
                            <td  colspan="2">
                                <button class="btn btn-outline-success btn-sm btn-block" 
                                        style="font-size:12px;">
                                    CARGAR ARCHIVO Y NOTIFICAR A LA DEE&nbsp;&nbsp;<i class="fas fa-file-upload"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    </table>
                </form>

    </div>
    
    <x-slot name="footerSlot">
        <x-adminlte-button  theme="secondary" 
                            label=" CANCELAR ACCIÓN " 
                            data-dismiss="modal" 
                            icon="fa fa-times"
                            class="btn-sm"/>
    </x-slot>
</x-adminlte-modal>