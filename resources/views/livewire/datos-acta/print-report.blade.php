
<table width="100%" class="table-sm table-hover" style="font-size: 13px; color: black;">
@foreach($documentos as $documento)
    @if($anexo->id==$documento->id_anexo)
    <tr>
        <td width="90%">
            <i class="far fa-file-alt"></i>&nbsp;&nbsp;&nbsp;
            {{$documento->onum_documento}}&nbsp;&nbsp; {{$documento->odocumento}}
        </td>
        <td width="10%">
                @if($anexo->oavance_anexo=='omarco_juridico_d')
                    @if($avance->omarco_juridico_d==1)
                        <a  href="reportes/print-report.php?i1d3={{$datosacta->id}}&idr3p0rt={{$documento->id}}" target="_blank"
                            class="btn btn-xs btn-outline-info" style="text-decoration:none;">
                            VER &nbsp;<i class="fas fa-file-import" style="font-size: 14px;"></i>
                        </a>
                    @endif
                @elseif($anexo->oavance_anexo=='orecursos_humanos_d')
                    @if($avance->orecursos_humanos_d==1)
                        <a  href="reportes/print-report.php?i1d3={{$datosacta->id}}&idr3p0rt={{$documento->id}}" target="_blank"
                            class="btn btn-xs btn-outline-info" style="text-decoration:none;">
                            VER &nbsp;<i class="fas fa-file-import" style="font-size: 14px;"></i>
                        </a>
                    @endif
                @elseif($anexo->oavance_anexo=='osituacion_recursos_materiales_d')
                    @if($avance->osituacion_recursos_materiales_d==1)
                        <a  href="reportes/print-report.php?i1d3={{$datosacta->id}}&idr3p0rt={{$documento->id}}" target="_blank"
                            class="btn btn-xs btn-outline-info" style="text-decoration:none;">
                            VER &nbsp;<i class="fas fa-file-import" style="font-size: 14px;"></i>
                        </a>
                    @endif
                @elseif($anexo->oavance_anexo=='osituacion_tics_d')
                    @if($avance->osituacion_tics_d==1)
                        <a  href="reportes/print-report.php?i1d3={{$datosacta->id}}&idr3p0rt={{$documento->id}}" target="_blank"
                            class="btn btn-xs btn-outline-info" style="text-decoration:none;">
                            VER &nbsp;<i class="fas fa-file-import" style="font-size: 14px;"></i>
                        </a>
                    @endif
                @elseif($anexo->oavance_anexo=='oarchivos_d')
                    @if($avance->oarchivos_d==1)
                        <a  href="reportes/print-report.php?i1d3={{$datosacta->id}}&idr3p0rt={{$documento->id}}" target="_blank"
                            class="btn btn-xs btn-outline-info" style="text-decoration:none;">
                            VER &nbsp;<i class="fas fa-file-import" style="font-size: 14px;"></i>
                        </a>
                    @endif
                @elseif($anexo->oavance_anexo=='ocertificados_no_adeudos_d')
                    @if($avance->ocertificados_no_adeudos_d==1)
                        <a  href="reportes/print-report.php?i1d3={{$datosacta->id}}&idr3p0rt={{$documento->id}}" target="_blank"
                            class="btn btn-xs btn-outline-info" style="text-decoration:none;">
                            VER &nbsp;<i class="fas fa-file-import" style="font-size: 14px;"></i>
                        </a>
                    @endif
                @elseif($anexo->oavance_anexo=='oinforme_gestion_d')
                    @if($avance->oinforme_gestion_d==1)
                        <a  href="reportes/print-report.php?i1d3={{$datosacta->id}}&idr3p0rt={{$documento->id}}" target="_blank"
                            class="btn btn-xs btn-outline-info" style="text-decoration:none;">
                            VER &nbsp;<i class="fas fa-file-import" style="font-size: 14px;"></i>
                        </a>
                    @endif
                @elseif($anexo->oavance_anexo=='ootros_hechos_d')
                    @if($avance->ootros_hechos_d==1)
                        <a  href="reportes/print-report.php?i1d3={{$datosacta->id}}&idr3p0rt={{$documento->id}}" target="_blank"
                            class="btn btn-xs btn-outline-info" style="text-decoration:none;">
                            VER &nbsp;<i class="fas fa-file-import" style="font-size: 14px;"></i>
                        </a>
                    @endif
                @endif
        </td>
    </tr>
    @endif
@endforeach
</table>