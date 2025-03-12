 

        <x-adminlte-modal   id="modalgenera" 
                    title="REGISTRO DE SOLICITUD DE INTERVENCIÓN PARA E-R" 
                    size="lg" 
                    theme="success"
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
                                value="7">

                    <table class="table table-sm table-striped">
                        <tr>
                            <td class="bg-lightblue disabled" 
                                colspan="4"
                                align="center">
                                <b>{{ Auth::user()->oct.' - '.Auth::user()->name }}</b>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-lightblue"
                                align="right"
                                width="30%">
                                <b>Ingresa el consecutivo del oficio</b>:
                            </td>
                            <td width="20%" 
                                align="right"> 
                                {{ $getoficix->ooficio }} /
                            </td>
                            <td width="10%" >
                                <input  type="text" 
                                        name="ooficio" required 
                                        class="form-control form-control-sm">
                            </td>
                            <td width="20%" >
                               / {{date('Y')}}
                            </td>
                        </tr>
                        <tr>
                            <td  colspan="4">
                                <b class="text-lightblue">Nombre del titular</b>: {{ $getoficix->otitular }}
                            </td>
                        </tr>
                        <tr>
                            <td align="right" colspan="4">
                                <button class="btn btn-outline-success btn-sm">
                            SOLICITAR INTERVENCIÓN
                        </button>
                            </td>
                        </tr>
                    </table>

 

                </form>
            </div>    
            <x-slot name="footerSlot">
                <x-adminlte-button  theme="secondary" 
                                    label="CANCELAR ACCIÓN" 
                                    data-dismiss="modal" 
                                    class="btn-sm"/>
            </x-slot>
        </x-adminlte-modal>

        