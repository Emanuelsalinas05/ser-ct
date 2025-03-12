
<table width="100%" class="table-sm table-hover" style="font-size: 13px; color: black;">
@foreach($documentos as $documento)
    @if($anexo->id==$documento->id_anexo)
    <tr>
        <td width="90%">
            <i class="far fa-file-alt text-danger"></i>&nbsp;&nbsp;&nbsp;
            {{$documento->onum_documento}}&nbsp;&nbsp; {{$documento->odocumento}}
        </td>
        <td width="10%">
                @if($anexo->oavance_anexo=='omarco_juridico_d')
                    @if($avance->omarco_juridico_d==1)
                        <a  href="reportes/print-report.php?i1d3={{$datosacta->id}}&idr3p0rt={{$documento->id}}&us={{$us}}" target="_blank"
                            class="btn btn-xs btn-outline-dark" style="text-decoration:none;">
                            VER &nbsp;<i class="far fa-file-pdf text-danger" style="font-size: 14px;"></i>
                        </a>
                    @endif
                @elseif($anexo->oavance_anexo=='orecursos_humanos_d')
                    @if($avance->orecursos_humanos_d==1 && $avance->oplantilla_personal_a==1 && $avance->oplantilla_comisionados_a==1)
                        <a  href="reportes/print-report.php?i1d3={{$datosacta->id}}&idr3p0rt={{$documento->id}}&us={{$us}}" target="_blank"
                            class="btn btn-xs btn-outline-dark" style="text-decoration:none;">
                            VER &nbsp;<i class="far fa-file-pdf text-danger" style="font-size: 14px;"></i>
                        </a>
                    @endif
                @elseif($anexo->oavance_anexo=='osituacion_recursos_materiales_d')
                    @if($avance->osituacion_recursos_materiales_d==1 && $avance->oinventario_bienes_a==1 && $avance->oinventario_almacen_a==1 && $avance->orelacion_bienes_custodia_a==1)
                        <a  href="reportes/print-report.php?i1d3={{$datosacta->id}}&idr3p0rt={{$documento->id}}&us={{$us}}" target="_blank"
                            class="btn btn-xs btn-outline-dark" style="text-decoration:none;">
                            VER &nbsp;<i class="far fa-file-pdf text-danger" style="font-size: 14px;"></i>
                        </a>
                    @endif
                @elseif($anexo->oavance_anexo=='osituacion_tics_d')
                    @if($avance->osituacion_tics_d==1 && $avance->oinventario_equipo_a==1)
                        <a  href="reportes/print-report.php?i1d3={{$datosacta->id}}&idr3p0rt={{$documento->id}}&us={{$us}}" target="_blank"
                            class="btn btn-xs btn-outline-dark" style="text-decoration:none;">
                            VER &nbsp;<i class="far fa-file-pdf text-danger" style="font-size: 14px;"></i>
                        </a>
                    @endif
                @elseif($anexo->oavance_anexo=='oarchivos_d')
                    @if($avance->oarchivos_d==1 && $avance->orelacion_archivos_a==1 && $avance->orelacion_archivos_historico_a==1 && $avance->orelacion_documentos_noconvencionles_a==1)
                        <a  href="reportes/print-report.php?i1d3={{$datosacta->id}}&idr3p0rt={{$documento->id}}&us={{$us}}" target="_blank"
                            class="btn btn-xs btn-outline-dark" style="text-decoration:none;">
                            VER &nbsp;<i class="far fa-file-pdf text-danger" style="font-size: 14px;"></i>
                        </a>
                    @endif
                @elseif($anexo->oavance_anexo=='ocertificados_no_adeudos_d')
                    @if($avance->ocertificados_no_adeudos_d==1 && $avance->ocertificados_no_adeudo_a==1)
                        <a  href="reportes/print-report.php?i1d3={{$datosacta->id}}&idr3p0rt={{$documento->id}}&us={{$us}}" target="_blank"
                            class="btn btn-xs btn-outline-dark" style="text-decoration:none;">
                            VER &nbsp;<i class="far fa-file-pdf text-danger" style="font-size: 14px;"></i>
                        </a>
                    @endif
                @elseif($anexo->oavance_anexo=='oinforme_gestion_d')
                    @if($avance->oinforme_gestion_d==1 && $avance->oinforme_gestion_a==1 && $avance->oinforme_compromisos_a==1)
                        <a  href="reportes/print-report.php?i1d3={{$datosacta->id}}&idr3p0rt={{$documento->id}}&us={{$us}}" target="_blank"
                            class="btn btn-xs btn-outline-dark" style="text-decoration:none;">
                            VER &nbsp;<i class="far fa-file-pdf text-danger" style="font-size: 14px;"></i>
                        </a>
                    @endif
                @elseif($anexo->oavance_anexo=='ootros_hechos_d')
                    @if($avance->ootros_hechos_d==1 && $avance->ootros_hechos_a==1)
                        <a  href="reportes/print-report.php?i1d3={{$datosacta->id}}&idr3p0rt={{$documento->id}}&us={{$us}}" target="_blank"
                            class="btn btn-xs btn-outline-dark" style="text-decoration:none;">
                            VER &nbsp;<i class="far fa-file-pdf text-danger" style="font-size: 14px;"></i>
                        </a>
                    @endif
                @endif
        </td>
    </tr>
    @endif
@endforeach
</table>