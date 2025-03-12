<x-adminlte-modal   id="modalCustomHist" 
                    title="INSTRUCCIONES PARA REGISTRO DE ARCHIVOS DE HISTÓRICO" 
                    size="lg" 
                    theme="teal"
                    icon="fa fa-copy" 
                    v-centered static-backdrop >
    
    <div>
        <a  href="formatos/13.2_Formato-Relacion-de-Archivos-de-concentracion-o-historico.doc"
            target="_blank"
            download 
            class="btn btn-outline-secondary btn-block"
            style="text-decoration:none; font-size: 12px;">
            <i class="far fa-hand-point-right"></i>&nbsp;&nbsp;
            DESCARGAR FORMATO PARA EL LLENADO DE RELACIÓN DE ARCHIVOS HISTÓRICO &nbsp;
            <i class="fa fa-file-alt"></i>&nbsp;&nbsp;
            <i class="far fa-hand-point-left"></i>
        </a>
        <br>
        <img src="img/13.2_Formato-Relacion-de-Archivos-de-concentracion-o-historico.png" class="img-fluid">

    </div>
    
    <x-slot name="footerSlot">
        <x-adminlte-button  theme="secondary" 
                            label=" CANCELAR ACCIÓN " 
                            data-dismiss="modal" 
                            icon="fa fa-times"
                            class="btn-sm"/>
    </x-slot>
</x-adminlte-modal>