<x-adminlte-modal   id="modaldeletex{{ $inventario->id }}" 
                    title="ELIMINAR REGISTRO DE COMISIONADO REGISTRADO"
                    size="lg" 
                    theme="danger"
                    icon="fa fa-users" 
                    v-centered static-backdrop >
    <div>
        <form   name="FrmCartel" id="FrmCartel" method="post" 
                action="{{ route($documento->ourl_documentos.'.update', $inventario->id ) }}" >
                @method('PATCH')
                @csrf
            <input  type="hidden" 
                    name="idacta" 
                    id="idacta" 
                    value="{{ $datosacta->id }}">

            <input  type="hidden" 
                    name="actionarchivos" 
                    id="actionarchivos" 
                    value="9">

            <P style="font-size: 16px;">
                ¿DESEA ELIMINAR EL EXPEDIENTE &nbsp;&nbsp;<b>{{$inventario->onombre_expediente}}</b>
                CON CLAVE&nbsp;&nbsp;<b>{{$inventario->oclave_expediente}}</b>&nbsp;&nbsp;?
            </P>
            <center>
                <button class="btn btn-outline-success btn-sm btn-block">
                    SÍ, ELIMINAR EL REGISTRO
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