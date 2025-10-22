<li class=" d-flex justify-content-between align-items-center bg-light"
    style="border:none;">
    
    <b class="text-orange">
        SI DESEAS CAMBIAR EL TIPO DE CERTIFICADO DE NO ADEUDO, DA CLIC EN EL BOTÓN <i>"CAMBIAR TIPO"</i>
    </b>

    <form   name="FrmCartel" 
            id="FrmCartel" 
            method="post" 
            action="{{ route('solicitud-certificado.update', $solicitud->id) }}" >
            @method('PATCH')
            @csrf

            <input  type="hidden" 
                    name="action" 
                    id="action"
                    value="99">

            <input  type="hidden" 
                    name="acta" 
                    id="acta"
                    value="{{ $datosacta->id }}">
            <i class="far fa-hand-point-right"></i>
            <i class="far fa-hand-point-right"></i>&nbsp;&nbsp;
            <button type="submit" class="btn btn-sm btn-warning">
                &nbsp; &nbsp; <B>CAMBIAR TIPO</B>&nbsp; &nbsp; 
            </button>

    </form>
    
</li>
<br>





<form   name="FrmCartel" 
        id="FrmCartel" 
        method="post" 
        action="{{ route('solicitud-certificado.update', $solicitud->id) }}" >
        @method('PATCH')
        @csrf

        <input  type="hidden" 
                name="acta" 
                id="acta"
                value="{{ $datosacta->id }}">
    <table class="table table-sm table-hover">
    <thead>
        <tr>
            <td colspan="4"></td>
        </tr>
    </thead>
    <tbody>
    @if($solicitud->id_tipocert==1)
                <input  type="hidden" 
                        name="action" 
                        id="action"
                        value="1">
                @include('solicitudes.certificado-noadeudos.1')
    @elseif($solicitud->id_tipocert==2)
                <input  type="hidden" 
                        name="action" 
                        id="action"
                        value="2">
                @include('solicitudes.certificado-noadeudos.2')
    @endif
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3"></td>
            <td align="right">
                <button class="btn btn-sm btn-success">
                    GENERAR CONSTANCIA DE SOLICITUD &nbsp;
                    <i class="fa fa-file-export"></i>
                </button>
            </td>
        </tr>
    </tfoot>
    </table>

</form>