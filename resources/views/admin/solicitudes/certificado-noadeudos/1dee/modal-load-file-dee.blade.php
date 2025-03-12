
<x-adminlte-modal   id="modaldee-file" 
                    title="CARGA DE ARCHIVO ESCANEADO" 
                    size="lg" 
                    theme="teal"
                    icon="fa fa-copy" 
                    v-centered static-backdrop >
    
    <div>

                <form   name="FrmCartel" id="FrmCartel" method="post" 
                        action="{{ route('gestion-noadeudos.update', Auth::user()->id_ct ) }}" 
                        enctype="multipart/form-data">
                        @method('PATCH')
                        @csrf

                    <input  type="hidden" 
                            name="action" 
                            id="action" 
                            value="50">

                    <input  type="hidden" 
                            name="oficiodee" 
                            id="oficiodee" 
                            value="{{ $solicitudesg->oficio_dee.$solicitudesg->oconsecutivo_dee.$solicitudesg->oanio }}">

                     <input  type="hidden" 
                            name="fecfin" 
                            id="fecfin" 
                            value="{{ $solicitudesg->ofecha_dee }}">

                    <p style="font-size:14px; text-align: justify;">
                        Una vez cargado el archivo escaneado, se notificará a la DEE para que realice las acciones correspondientes para la gestión de los Certificados de No Aduedos ante la CAOE.
                    </p>

                    <table class="table table-sm"
                        style="font-size:12px;">
                    <thead>
                        <tr class="bg-lightblue disabled" align="center">
                            <th colspan="3"><b>ARCHIVO/DOCUMENTO A SUBIR</b></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td width="30%">
                            </td>
                            <td width="60%">
                                <input  type="file" 
                                        name="onombre_archivo" 
                                        id="onombre_archivo"
                                        accept=".pdf, .PDF,"
                                        required 
                                        class="form-control form-control-sm" >
                                @error('onombre_archivo') <span style="color:red;">{{ $message }}</span> @enderror
                            </td>
                            <td width="30%"> 
                            </td>
                        </tr>                 
                        <tr>
                            <td  colspan="3">
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