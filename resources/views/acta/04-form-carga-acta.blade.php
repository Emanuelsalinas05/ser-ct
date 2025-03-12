<form   name="FrmCartel" id="FrmCartel" method="post" 
        action="{{ route('entrega-recepcion.update', $datosacta->id) }}" 
        enctype="multipart/form-data" 
        accept="application/pdf" >
        @method('PATCH')
        @csrf

        <input  type="hidden" name="idacta" id="idacta"
                value="{{ $datosacta->id }}">
        <input  type="hidden" name="tipoacta" id="tipoacta"
                value="{{ $datosacta->id_tipoacta }}">
        <input  type="hidden" name="action" id="action"
                value="2">

    <table class="table table-sm col-sm-10"
            style="font-size:14px;">
    <tbody>
        <tr>
            <td align="right" width="20%" class="text-warning">
                @if(Auth::user()->onivel=='SECUNDARIA')
                    <b>2) </b> 
                @else
                @endif
                <b class="text-warning">SUBIR ACTA ESCANEADA Y FIRMADA</b>
            </td>
            <td width="30%">
                <input  type="file" name="onombre_archivo" id="onombre_archivo"
                        class="form-control form-control-sm"accept="application/pdf" >
                @error('onombre_archivo') <span style="color:red;">{{ $message }}</span> @enderror
            </td>                  

            <td width="20%">
                <button class="btn btn-outline-success btn-sm btn-block" 
                        style="font-size:12px;">
                    SUBIR ACTA ESCANEADA/FIRMADA <i class="fas fa-file-upload"></i>
                </button>
            </td>
        </tr>
    </tbody>
    </table>
</form>
