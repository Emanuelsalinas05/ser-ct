 

        <x-adminlte-modal   id="modaldedit{{ $i->id }}" 
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
                            value="19">

                    <input  type="hidden" 
                            name="idinter" 
                            id="idinter" 
                            value="{{ $i->id }}">

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
                                width="35%">
                                <b>Oficio</b>:
                            </td>
                            <td width="50%" colspan="2" >
                                <input  type="text" 
                                        name="ooficio" required 
                                        class="form-control form-control-sm"
                                        value="{{ $i->ooficio }}">
                            </td>
                            <td width="15%"></td>
                        </tr>
                        <tr>
                            <td class="text-lightblue"
                                align="right"
                                width="35%">
                                <b>Nombre del titular</b>:
                            </td>
                            <td width="65%"
                                colspan="3">
                                <input  type="text" 
                                        name="otitular_nivel" required 
                                        class="form-control form-control-sm"
                                        value="{{ $i->otitular_nivel }}">
                            </td>
                        </tr>
                        <tr>
                            <td class="bg-lightblue disabled" 
                                colspan="4"
                                align="center">
                                <b>Datos del CT a entrega</b>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-lightblue"
                                align="right"
                                width="35%">
                                <b>C.T.</b>:
                            </td>
                            <td width="65%"
                                colspan="3">
                                 {{ $i->oclave.' - '.$i->onombrect }}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-lightblue"
                                align="right"
                                width="35%">
                                <b>Nombre de quien entrega</b>:
                            </td>
                            <td width="65%"
                                colspan="3">
                                <input  type="text" 
                                        name="oentrega" required 
                                        class="form-control form-control-sm"
                                        value="{{ $i->oentrega }}">
                            </td>
                        </tr>
                        <tr>
                            <td class="text-lightblue"
                                align="right"
                                width="35%">
                                <b>Nombre de quien recibe</b>:
                            </td>
                            <td width="65%"
                                colspan="3">
                                <input  type="text" 
                                        name="orecibe" required 
                                        class="form-control form-control-sm"
                                        value="{{ $i->oentrega }}">
                            </td>
                        </tr>
                        <tr>
                            <td class="text-lightblue"
                                align="right"
                                width="35%">
                                <b>Motivo</b>:
                            </td>
                            <td width="65%"
                                colspan="3">
                                <input  type="text" 
                                        name="omotivo" required 
                                        class="form-control form-control-sm"
                                        value="{{ $i->omotivo }}">
                            </td>
                        </tr>
                        <tr>
                            <td class="text-lightblue"
                                align="right"
                                width="35%">
                                <b>Fecha</b>:
                            </td>
                            <td width="30%">
                                <input  type="date" 
                                        name="ofecha_entrega" required 
                                        class="form-control form-control-sm"
                                        value="{{ $i->ofecha_entrega }}">
                            </td>
                            <td class="text-lightblue"
                                align="right"
                                width="20%">
                                <b>Hora</b>:
                            </td>
                            <td width="15%">
                                <input  type="time" 
                                        name="ohora_entrega" required 
                                        class="form-control form-control-sm"
                                        value="{{ $i->ohora_entrega }}">
                            </td>
                        </tr>
                        <tr>
                            <td align="right" colspan="4">
                                <button class="btn btn-outline-success btn-sm">
                                    ACTUALIZAR INTERVENCIÓN
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

        