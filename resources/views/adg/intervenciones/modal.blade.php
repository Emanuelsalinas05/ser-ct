 

        <x-adminlte-modal   id="modaldeletefile" 
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
                            value="9">


                    <table class="table table-sm table-striped">
                        <tr>
                            <td class="bg-lightblue disabled" 
                                colspan="4"
                                align="center">
                                <b>{{ Auth::user()->oct.' - '.Auth::user()->name }}</b>
                            </td>
                        </tr>
                    <!--
                        <tr>
                            <td class="text-lightblue"
                                align="right"
                                width="35%">
                                <b>Ingresa el consecutivo del oficio</b>:
                            </td>
                            <td width="20%" 
                                align="right">
                                <input  type="hidden" 
                                        name="oeconomico" value="{{ $getof }}" 
                                        class="form-control form-control-sm">
                                {{ $getof }} /
                            </td>
                            <td width="10%" >
                                <input  type="text" 
                                        name="ooficio" required 
                                        class="form-control form-control-sm">
                            </td>
                            <td width="20%" >
                               / {{date('Y')}}
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
                                colspan="4">
                                <input  type="text" 
                                        name="otitular_nivel" required 
                                        class="form-control form-control-sm">
                            </td>
                        </tr>
                    -->
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
                                colspan="4">

                                <select name="idct_escuela" required 
                                        class="selectpicker" 
                                        data-live-search="true" style="cursor: pointer;"  
                                        data-width="100%"  
                                        title="C.T. a entregar...">
                                    @foreach($sectores as $key => $sector)
                                    <option value="{{ $sector->idct_sector }}"
                                            data-tokens="{{ $sector->cct_sector }}">
                                        {{ $sector->cct_sector.' - '.$sector->onombre_ct }}
                                    </option>
                                    @endforeach

                                    @foreach($supervisiones as $key => $supervision)
                                    <option value="{{ $supervision->idct_supervicion }}"
                                            data-tokens="{{ $supervision->cct_supervision }}">
                                        {{ $supervision->cct_supervision.' - '.$supervision->onombre_ct }}
                                    </option>
                                    @endforeach

                                    @foreach($escuelas as $key => $ct)
                                    <option value="{{ $ct->idct_escuela }}"
                                            data-tokens="{{ $ct->cct_escuela }}">
                                        {{ $ct->cct_escuela.' - '.$ct->onombre_ct }}
                                    </option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-lightblue"
                                align="right"
                                width="35%">
                                <b>Nombre de quien entrega</b>:
                            </td>
                            <td width="65%"
                                colspan="4">
                                <input  type="text" 
                                        name="oentrega" required 
                                        class="form-control form-control-sm">
                            </td>
                        </tr>
                        <tr>
                            <td class="text-lightblue"
                                align="right"
                                width="35%">
                                <b>Nombre de quien recibe</b>:
                            </td>
                            <td width="65%"
                                colspan="4">
                                <input  type="text" 
                                        name="orecibe" required 
                                        class="form-control form-control-sm">
                            </td>
                        </tr>
                        <tr>
                            <td class="text-lightblue"
                                align="right"
                                width="35%">
                                <b>Motivo</b>:
                            </td>
                            <td width="65%"
                                colspan="4">
                                <input  type="text" 
                                        name="omotivo" required 
                                        class="form-control form-control-sm">
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
                                        class="form-control form-control-sm">
                            </td>
                            <td class="text-lightblue"
                                align="right"
                                width="20%">
                                <b>Hora</b>:
                            </td>
                            <td width="15%">
                                <input  type="time" 
                                        name="ohora_entrega" required 
                                        class="form-control form-control-sm">
                            </td>
                        </tr>
                        <tr>
                            <td align="right" colspan="4">
                                <button class="btn btn-outline-success btn-sm">
                            REGISTRAR INTERVENCIÓN
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

        