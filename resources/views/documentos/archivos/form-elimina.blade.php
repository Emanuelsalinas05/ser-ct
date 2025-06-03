<x-adminlte-modal   id="modaldelete{{ $inventario->id }}" 
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
                    name="acta" 
                    id="acta" 
                    value="{{ $datosacta->id }}">

            <input  type="hidden" 
                    name="actionarchivos" 
                    id="actionarchivos" 
                    value="1">

            <P style="font-size: 16px;">
                ¿DESEA ELIMINAR ESTE REGISTRO
                @if($documento->id==8||$documento->id==9) 
                    {{$inventario->onombre_expediente}}
                @elseif($documento->id==10) 
                    {{$inventario->onombre_documento}}
                @endif  
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