

<x-adminlte-modal   id="modalgenera" 
                    title="SOLICITUD PARA LA GESTIÓN DE CERTIFICADOS DE NO ADEUDOS" 
                    size="lg" 
                    theme="success"
                    icon="fa fa-file-alt" 
                    v-centered static-backdrop >
    
    <div>
    <form   name="FrmCartel" 
            id="FrmCartel" 
            method="post" 
            action="{{ route('solicitudes-noadeudos.update', Auth::user()->id_ct ) }}" >
            @method('PATCH')
            @csrf

                
        <input  type="hidden" 
                name="action" 
                id="action" 
                value="1">

        <table class="table table-sm table-hover">
            <tr>
                <td colspan="4">
                    RECUERDA QUE <b>TODOS</b> LOS REGISTROS VISUALIZADOS EN LA TABLA,
                    SERÁN AGRUPADOS EN EL OFICIO QUE ESTÁS APUNTO DE REALIZAR.
                </td>
            </tr>
            <tr>
                <td class="bg-lightblue disabled" 
                    colspan="4">
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
                    {{ $titular->ooficio }} /
                </td>
                <td width="20%" >
                    <input  type="text" 
                            name="oconsecutivo_adg" required 
                            onkeypress="if(event.keyCode<45 || event.keyCode>57) event.returnValue=false;"
                            class="form-control form-control-sm">
                    <input  type="hidden" 
                            name="oficio_adg"  
                            class="form-control form-control-sm"
                            value="{{ $titular->ooficio }}">
                </td>
                <td width="30%" >
                   / {{date('Y')}}
                </td>
            </tr>
            <tr>
                <td  colspan="4"
                     width="100%">
                    <b class="text-lightblue">Nombre del titular</b>: &nbsp;
                    {{ $titular->otitular }}
                </td>
            </tr>
            <tr>
                <td class="text-lightblue" 
                    width="30%"
                    align="right">
                    <b>Área/Oficina/etc solicitante</b>:
                </td>
                <td colspan="3">
                    <input  type="text" 
                            name="olugar_adg" required 
                            class="form-control form-control-sm">
                </td>
            </tr>
            <tr>
                <td class="text-lightblue" 
                    width="30%"
                    align="right">
                    <b>Rúbrica</b>:
                </td>
                <td>
                    <input  type="text" 
                            name="orubrica_adg" required 
                            class="form-control form-control-sm">
                </td>
                <td colspan="2">

                </td>
            </tr>
            <tr>
                <td align="right" colspan="4">
                    <button class="btn btn-success btn-sm">
                        GENERAR FORMATO PARA OFICIO 
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

