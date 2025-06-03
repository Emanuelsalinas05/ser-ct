<p style="font-size:13px;">
    <i class="fa fa-info-circle"></i>&nbsp;
    <b class="text-info">INDICACIONES PARA EL REGISTRO:</b><br>
    {{ $documento->odescripcion }}.&nbsp;

    <x-adminlte-button  label="(CLIC PARA VER EL INSTRUCTIVO DE LLENADO DEL FORMATO)" 
                        data-toggle="modal" 
                        icon="fa fa-mouse-pointer"
                        data-target="#modalCustom" 
                        class="btn bg-secondary btn-sm"/>
    
    <a  href="formatos/13_1_Formato_Relacion_de_archivos_de_tramite.doc"
        target="_blank"
        download 
        class="btn btn-info btn-xs"
        style="text-decoration:none; font-size: 14px; color: white;">
        <i class="far fa-hand-point-right"></i>&nbsp;&nbsp;
        DESCARGAR AQUÍ EL FORMATO  PARA EL LLENADO DE LA RELACIÓN DE ARCHIVO DE CONCENTRACIÓN O HISTÓRICO &nbsp;
        <i class="fa fa-file-alt"></i>&nbsp;&nbsp;
        <i class="far fa-hand-point-left"></i>
    </a>
    &nbsp;AL TERMINAR CON EL REGISTRO DA CLIC EN "<B>FINALIZAR REGISTRO</B>" PARA CONCLUIR ESTE APARTADO.
    @include('documentos.archivos.13-1.modal-instructions')
</p>



<form   name="FrmCartel" id="FrmCartel" method="post" 
        action="{{ route($documento->ourl_documentos.'.store') }}" 
        enctype="multipart/form-data">
        @method('POST')
        @csrf

        <input  type="hidden" 
                name="iddoc" 
                id="iddoc"
                value="{{ $documento->id }}">
                
        <input  type="hidden" 
                name="idacta" 
                id="idacta"
                value="{{ $datosacta->id }}">

        <input  type="hidden" 
                name="action" 
                id="action"
                value="1">

    <table class="table table-sm"
            style="font-size:12px;">
    <thead>
        <tr class="bg-lightblue disabled" align="center">
            <th><b>INGRESA EL NOMBRE DEL DOCUMENTO</b></th>
            <th><b>ARCHIVO/DOCUMENTO A SUBIR</b></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td width="50%">
                <input  type="text" 
                        name="onombre_documento" id="onombre_documento" required 
                        class="form-control form-control-sm">
                    @error('onombre_documento') <span style="color:red;">{{ $message }}</span> @enderror
            </td>
                    
            <td width="35%">
                <input  type="file" name="onombre_archivo" id="onombre_archivo"
                        class="form-control form-control-sm" >
                @error('onombre_archivo') <span style="color:red;">{{ $message }}</span> @enderror
            </td>                  
            <td width="15%">
                <button class="btn btn-outline-success btn-sm btn-block" 
                        style="font-size:12px;">
                    AGREGAR ARCHIVO <i class="fas fa-file-upload"></i>
                </button>
            </td>
        </tr>
    </tbody>
    </table>
</form>
