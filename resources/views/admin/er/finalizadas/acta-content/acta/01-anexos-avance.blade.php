<table class="table table-sm"
        style="font-size:14px;">
<thead >
    <tr class="bg-light" align="center">
        <th colspan="2">
             <b style="font-size:25px;" class="text-success">
                {{ $datosacta->tipoacta->otipoacta }} FINALIZADA
            </b>
        </th>
    </tr>
    <tr class="bg-lightblue disabled" >
        <th >
            <b>&nbsp;&nbsp;&nbsp;ANEXOS</b>
        </th>
        <th style="text-align:right;">
            <b>DOCUMENTOS</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </th>
    </tr>
</thead>
<tbody>
    @foreach($anexos as $anexo)
    <tr class="shadow-sm">
        <td width="100%" colspan="2">

                <a  href="{{ url($anexo->ourl_anexoadmin_ok, $datosacta->id) }}" 
                    style=" color:black; text-decoration:none;"
                    title="DA CLIC PARA IR A {{ $anexo->onum_anexo }}. {{ $anexo->oanexo }}">
                        <i class="fas fa-folder-open text-warning"></i>&nbsp;
                        <b class="text-info"> 
                            {{ $anexo->onum_anexo }}. {{ $anexo->oanexo }}
                        </b>&nbsp;&nbsp;
                        <i class="fas fa-mouse-pointer"></i>
                </a>

                <table  width="100%" 
                        class="table-sm table-hover" 
                        style="font-size: 13px; color: black;">

                @foreach($documentos as $documento)
                    @if($anexo->id==$documento->id_anexo)
                    <tr>
                        <td width="90%">
                            <i class="far fa-file-alt text-danger"></i>&nbsp;&nbsp;&nbsp;
                            {{$documento->onum_documento}}&nbsp;&nbsp; {{$documento->odocumento}}
                        </td>
                        <td width="10%">
                            @include('admin.er.finalizadas.acta-content.acta.06-buttons-view')
                        </td>
                    </tr>
                    @endif
                @endforeach
                </table>

        </td>
    </tr>
    @endforeach

    <tr class="shadow-sm">
        <td class="bg-light">
            <a  href="../../storage/{{ $datosacta->ourl_acta }}"
                target="_blank" 
                class="btn btn-outline-success btn-sm btn-block"
                title="{{ $datosacta->tipoacta->otipoacta }} FIRMADA Y ESCANEADA" 
                style="text-decoration: none; font-size:12px;">
                VER ACTA FIRMADA/ESCANEADA &nbsp;&nbsp;
                <i class="fa fa-file-alt" style="font-size:16px;"></i>
            </a>
        </td>
        <td class="bg-light">
            @if($datosacta->id_tipoacta==1)
                    <a  href="../../reportes/print-acta.php?i1d3={{$datosacta->id}}"
                        target="_blank" 
                        class="btn btn-outline-success btn-sm btn-block"
                        style="text-decoration: none; font-size:12px;">
                        ACTA&nbsp;&nbsp;
                        <i class="fa fa-file" style="font-size:16px;"></i>
                    </a>
            @elseif($datosacta->id_tipoacta==2)
                    <a  href="../../reportes/print-actac.php?i1d3={{$datosacta->id}}"
                        target="_blank" 
                        class="btn btn-outline-success btn-sm "
                        style="text-decoration: none; font-size:12px;">
                        ACTA GENERADA&nbsp;&nbsp;
                        <i class="fa fa-file" style="font-size:16px;"></i>
                    </a>
            @endif
        </td>
    </tr>

    @if($avance->ocargacomprimido==1)
    <tr class="shadow-sm">
        <td class="bg-light"   
            colspan="2">
                <b  class="text-info" 
                    style="font-size:16px;">
                    <i class="fa fa-folder-open text-warning"></i>&nbsp;
                   CARPETA DE ENTREGA-RECEPCIÓN
                </b>
                &nbsp;&nbsp;&nbsp;
                <a  href="../../storage/{{ $datosacta->ourlcarpeta.'/'.$datosacta->onombrecarpeta }}"
                    target="_blank"
                    download 
                    style="text-decoration:none; font-size: 12px;" 
                    class="btn btn-outline-info btn-sm">
                    DESCARGAR  &nbsp;&nbsp;<i class="fas fa-file-archive" style="font-size:18px;"></i> 
                </a>
        </td>
    </tr>
    @endif

</tbody>
</table>
   
