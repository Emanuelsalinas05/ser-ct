

<table  width="100%" 
        class="table-sm table-hover" 
        style="font-size: 13px; color: black;">

@foreach($documentos as $documento)

    @include('admin.er.acta-content.acta.04-open-modal')

    @if($anexo->id==$documento->id_anexo)
    <tr>
        <td width="85%">
                <i class="far fa-file-alt text-danger"></i>&nbsp;&nbsp;&nbsp;
                {{$documento->onum_documento}}&nbsp;&nbsp; {{$documento->odocumento}}
        </td>

        <td width="5%">
                @if($datosacta->owaitacta!=1)
                @include('admin.er.acta-content.acta.05-open-btn-anexo')
                @endif
        </td>

        <td width="10%">
                @include('admin.er.acta-content.acta.06-buttons-view')
        </td>
    </tr>
    @endif
@endforeach
</table>