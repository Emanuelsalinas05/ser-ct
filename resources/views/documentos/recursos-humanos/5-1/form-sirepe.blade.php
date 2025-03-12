<x-adminlte-callout>
    <p style="font-size:12px;">
        <i class="fa fa-info-circle"></i>&nbsp;
        <b class="text-info">INDICACIONES PARA EL REGISTRO:</b><br>
        {{ $documento->odescripcion }}.
        <br>AL TERMINAR CON EL REGISTRO DA CLIC EN "<B>FINALIZAR REGISTRO</B>" PARA CONCLUIR ESTE APARTADO.
    </p>
    
    <form   name="FrmCartel" id="FrmCartel" method="post" 
            action="{{ route('plantilla-personal.store') }}"
            enctype="multipart/form-data">
        @method('POST')
        @csrf

        <input  type="hidden" 
                name="actionpers" 
                id="actionpers" 
                value="9">

        <input  type="hidden" 
                name="idacta" 
                id="idacta"
                value="{{ $datosacta->id }}">

        <table class="table table-sm"
                style="font-size:12px;">
            <thead>
                <tr class="bg-lightblue disabled" align="center">
                    <th><b>INGRESA EL NOMBRE DEL DOCUMENTO DE PLANTILLA DEL SIREPE</b></th>
                    <th><b>ARCHIVO/DOCUMENTO A SUBIR DE PLANTILLA SIREPE</b></th>
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
                                class="form-control form-control-sm" 
                                accept="application/pdf">
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
