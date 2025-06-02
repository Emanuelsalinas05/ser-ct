<x-adminlte-modal   id="updatemj{{ $juridico->id }}" 
                    title="MODIFICAR ORDENAMIENTO JURÍDICO" 
                    size="lg" 
                    theme="success"
                    icon="fa fa-edit" 
                    v-centered static-backdrop >
    <div>
        <form   name="FrmCartel" id="FrmCartel" method="post" 
                action="{{ route('marco-juridico.update', $juridico->id ) }}" >
                @method('PATCH')
                @csrf

            <input  type="hidden" 
                    name="action" 
                    id="action" 
                    value="1">

                    
            <table  class="table table-striped table-hover table-sm"
                    id="example13"
                    style="font-size:12px;">
                <tr>
                    <td align="right" width="30%">DENOMINACIÓN DEL ORDENAMIENTO JURÍDICO-ADMINISTRATIVO</td>
                    <td width="70%">
                        <input  type="text" 
                                name="oordenamiento" id="oordenamiento"
                                style="font-size:12px;" 
                                class="form-control form-control-sm" value="{{ $juridico->odenominacion_juridica }}" />
                    </td>
                </tr>
                <tr>
                    <td align="right" width="30%">MEDIO OFICIAL DE PUBLICACIÓN</td>
                    <td width="70%">
                        <select class="form-control form-control-sm"
                                name="omediooficial" id="omediooficial" >
                            <option selected disabled>-- ELIJE UN MEDIO --</option>
                            <option value="DIARIO OFICIAL DE LA FEDERACIÓN" 
                                    {{ $juridico->omedio_oficial_publicacion=='DIARIO OFICIAL DE LA FEDERACIÓN' ? 'selected' : '' }}>
                                DIARIO OFICIAL DE LA FEDERACIÓN
                            </option>
                            <option value="GACETA DEL GOBIERNO" 
                                    {{ $juridico->omedio_oficial_publicacion=='GACETA DEL GOBIERNO' ? 'selected' : '' }}>
                                GACETA DEL GOBIERNO
                            </option>
                            <option value="AGENDA SEIEM" 
                                    {{ $juridico->omedio_oficial_publicacion=='AGENDA SEIEM' ? 'selected' : '' }}>
                                AGENDA SEIEM
                            </option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td align="right" width="30%">FECHA DE PUBLICACIÓN </td>
                    <td width="70%">
                        <input  type="date" 
                                name="ofechapublicacion" id="ofechapublicacion"
                                class="form-control form-control-sm" value="{{ $juridico->ofecha_publicacion }}" />
                    </td>
                </tr>
                <tr>
                    <td align="right" width="30%">URL ORDENAMIENTO</td>
                    <td  width="70%">
                        <input  type="text" 
                                name="olocalizador" id="olocalizador"
                                style="font-size:12px;" 
                                class="form-control form-control-sm" value="{{ $juridico->ourl_publicacion }}" />
                    </td>
                </tr>
            </table>


            <center>
                <button class="btn btn-outline-success btn-sm btn-block">
                    SÍ, ACTUALIZAR EL REGISTRO
                </button>
            </center>

        </form>
    </div>    
    <x-slot name="footerSlot">
        <x-adminlte-button  theme="secondary" 
                            label="CANCELAR ACCIÓN" 
                            data-dismiss="modal" 
                            class="btn-sm"/>
    </x-slot>
</x-adminlte-modal>