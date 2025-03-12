<form   name="FrmCartel" id="FrmCartel" method="post" 
            action="{{ route($documento->ourl_documentos.'.store') }}" 
            enctype="multipart/form-data">
            @method('POST')
            @csrf

            <input  type="hidden" name="iddoc" id="iddoc"
                    value="{{ $documento->id }}">
            <input  type="hidden" name="idacta" id="idacta"
                    value="{{ $datosacta->id }}">
            <input  type="hidden" name="omitir" id="omitir"
                    value="1">

        <li class=" d-flex justify-content-between align-items-center"
            style="border:none;">
            <button class="btn btn-success btn-sm btn" 
                    style="font-size:12px;">
                OMITIR Y CONTINUAR &nbsp;<i class="fas fa-file-upload"></i>
            </button>
            &nbsp;
        </li>
        
</form>
<br>