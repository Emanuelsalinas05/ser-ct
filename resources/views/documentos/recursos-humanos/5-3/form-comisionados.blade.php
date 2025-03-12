<x-adminlte-modal   id="modalCustom" 
                    title="Servidores públicos comisionados" 
                    size="xl" 
                    theme="teal"
                    icon="fa fa-users" 
                    v-centered static-backdrop >
    
    <div>

                <form   name="FrmCartel" id="FrmCartel" method="post" 
                        action="{{ route('plantilla-comisionados.store') }}" >
                    @method('POST')
                    @csrf
                    <input  type="hidden" 
                            name="action" 
                            id="action"
                            value="1">

                    <input  type="hidden" 
                            name="acta" 
                            id="acta"
                            value="{{ $datosacta->id }}">

                    <table class="table table-sm"
                            style="font-size:12px;">
                    <tbody>
                        <tr>
                            <td align="right" width="25%">Nombre del Servidor público</td>
                            <td colspan="2">
                                <input  type="text" 
                                        name="onombre_servidor"
                                        id="onombre_servidor"
                                        class="form-control form-control-sm" required>
                                @error('onombre_servidor') <span style="color:red;">{{ $message }}</span> @enderror
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td align="right">Unidad de adscripción</td>
                            <td>
                                <select id="ounidad_adscripcion" 
                                        name="ounidad_adscripcion"
                                        class="selectpicker form-control-sm" 
                                        data-live-search="true" style="cursor: pointer;"  
                                        data-width="100%" 
                                        title="Elije el CT de origen" required>
                                    <option value=""></option>
                                    @foreach($centrotrabajo as $ct)
                                    <option value="{{$ct->oclave.' - '.$ct->onombre_ct}}">{{$ct->oclave.' - '.$ct->onombre_ct}}</option>
                                    @endforeach
                                </select>
                                @error('ounidad_adscripcion') <span style="color:red;">{{ $message }}</span> @enderror
                            </td>

                            <td align="right">C.T. .Comisionado </td>
                            <td>
                                <select id="ocomisionado_act" 
                                        name="ocomisionado_act"
                                        class="selectpicker form-control-sm" 
                                        data-live-search="true" style="cursor: pointer;"  
                                        data-width="100%" 
                                        title="Elije el CT de comisión" required>
                                    <option value=""></option>
                                    @foreach($centrotrabajo as $ct)
                                    <option value="{{$ct->oclave.' - '.$ct->onombre_ct}}">{{$ct->oclave.' - '.$ct->onombre_ct}}</option>
                                    @endforeach
                                </select>
                                @error('ounidad_adscripcion') <span style="color:red;">{{ $message }}</span> @enderror
                            </td>
                        </tr>
                        <tr>
                            <td width="20%" align="right">Período inicio de comisión</td>
                            <td>
                                <input  type="date" 
                                        name="operiodoinicio"
                                        id="operiodoinicio"
                                        class="form-control form-control-sm"
                                        value="{{old('operiodoinicio')}}" required>
                                @error('operiodoinicio') <span style="color:red;">{{ $message }}</span> @enderror
                            </td>
                            <td width="20%" align="right">Período de término de comisión</td>
                            <td>
                                <input  type="date" 
                                        name="operiodofinal"
                                        id="operiodofinal"
                                        class="form-control input-sm"
                                        value="{{old('operiodofinal')}}" required>
                                @error('operiodofinal') <span style="color:red;">{{ $message }}</span> @enderror
                            </td>
                        </tr>
                        <tr>
                            <td width="20%" align="right">Oficio de comisión</td>
                            <td>
                                <input  type="text" 
                                        name="ooficio_autorizacion"
                                        id="ooficio_autorizacion"
                                        class="form-control form-control-sm" required>
                                @error('ooficio_autorizacion') <span style="color:red;">{{ $message }}</span> @enderror
                            </td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td align="right">Observaciones</td>
                            <td colspan="3">
                                <textarea   name="oobservaciones" 
                                            id="oobservaciones"
                                            class="form-control "
                                            style="resize: none;"></textarea>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" align="right">
                                <button class="btn btn-success btn-sm">
                                    AGREGAR SERVIDOR COMISIONADO
                                    <i class="fas fa-check"></i>
                                </button>
                            </td>
                        </tr>
                    </tfoot>
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