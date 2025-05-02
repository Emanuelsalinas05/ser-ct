<x-adminlte-callout>
    <p style="font-size:13px; text-align: justify;">
        <i class="fa fa-info-circle"></i>&nbsp;
        <b class="text-info">INDICACIONES PARA EL REGISTRO DE DOCUMENTOS:</b><br>
        {{ $documento->odescripcion }}.
        @if($documento->id==5) 
            <br>SI NO HAY DOCUMENTOS/ARCHIVOS PARA SUBIR EN ESTE APARTADO, DA CLIC EN OMITIR Y CONTINUAR.
        @endif
        <br>AL TERMINAR CON EL REGISTRO DA CLIC EN "<B>FINALIZAR REGISTRO</B>" PARA CONCLUIR ESTE APARTADO.
        (DESPUÉS DE HACER ESTA ACCIÓN YA NO SE PODRÁN SUBIR ARCHIVOS)
        
    </p>

    @if($documento->id==5 && $ialmacenc==0) 
        @include('documentos.situacion-recursos-materiales.form-omitir') 
    @endif

    
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
                    value="0">

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

</x-adminlte-callout>

