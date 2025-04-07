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

                <a  href="{{ url($anexo->ourl_anexo_history, $datosacta->id) }}" 
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
                            @include('entregas.acta-content.acta.06-buttons-view')
                        </td>
                    </tr>
                    @endif
                @endforeach
                </table>

        </td>
    </tr>
    @endforeach

    <tr class="shadow-sm">
        <td class="bg-light" colspan="2">
            <a  href="../../storage/{{ $datosacta->ourl_acta }}"
                target="_blank" 
                class="btn btn-outline-success btn-sm btn-block"
                title="{{ $datosacta->tipoacta->otipoacta }} FIRMADA Y ESCANEADA" 
                style="text-decoration: none; font-size:12px;">
                VER ACTA FIRMADA/ESCANEADA &nbsp;&nbsp;
                <i class="fa fa-file-alt" style="font-size:16px;"></i>
            </a>
        </td>
    </tr>

    <tr class="shadow-sm">
        <td class="bg-light" colspan="2">
            <a  href="../../storage/{{ $datosacta->ourlcarpeta.'/'.$datosacta->onombrecarpeta }}"
                target="_blank" 
                class="btn btn-outline-success btn-sm btn-block"
                title="DESCARGA DE CARPETA FINAL" 
                style="text-decoration: none; font-size:12px;">
                DESCARGAR CARPETA FINAL &nbsp;&nbsp;
                <i class="far fa-file-archive" style="font-size:16px;"></i>
            </a>
        </td>
    </tr>

</tbody>
</table>
   
