    @if($anexo->oavance_anexo=='omarco_juridico_d')
        @if($avance->omarco_juridico_d==1)
            <a  href="reportes/marco-juridico.php?TOKEN-SEIEM=kajaKAJEU8982kKA99201MaoowlllQQQ09?i1d3={{Auth::user()->id}}"
                class="btn bg-teal btn-sm" 
                target="_blank" 
                style="font-size: 12px; text-decoration: none;">
                DECARGAR <i class="far fa-file-pdf"></i>
            </a>
        @endif
    @elseif($anexo->oavance_anexo=='orecursos_humanos_d')
        @if($avance->orecursos_humanos_d==1)
            <a  href=""
                class="btn btn-outline-info btn-sm" 
                style="font-size: 12px; text-decoration: none;">
                DECARGAR <i class="far fa-file-pdf"></i>
            </a>
        @endif
    @elseif($anexo->oavance_anexo=='osituacion_recursos_materiales_d')
        @if($avance->osituacion_recursos_materiales_d==1)
            <a  href=""
                class="btn btn-outline-info btn-sm" 
                style="font-size: 12px; text-decoration: none;">
                DECARGAR <i class="far fa-file-pdf"></i>
            </a>
        @endif
    @elseif($anexo->oavance_anexo=='osituacion_tics_d')
        @if($avance->osituacion_tics_d==1)
            <a  href=""
                class="btn btn-outline-info btn-sm" 
                style="font-size: 12px; text-decoration: none;">
                DECARGAR <i class="far fa-file-pdf"></i>
            </a>
        @endif
    @elseif($anexo->oavance_anexo=='oarchivos_d')
        @if($avance->oarchivos_d==1)
            <a  href=""
                class="btn btn-outline-info btn-sm" 
                style="font-size: 12px; text-decoration: none;">
                DECARGAR <i class="far fa-file-pdf"></i>
            </a>
        @endif
    @elseif($anexo->oavance_anexo=='ocertificados_no_adeudos_d')
        @if($avance->ocertificados_no_adeudos_d==1)
            <a  href=""
                class="btn btn-outline-info btn-sm" 
                style="font-size: 12px; text-decoration: none;">
                DECARGAR <i class="far fa-file-pdf"></i>
            </a>
        @endif
    @elseif($anexo->oavance_anexo=='oinforme_gestion_d')
        @if($avance->oinforme_gestion_d==1)
            <a  href=""
                class="btn btn-outline-info btn-sm" 
                style="font-size: 12px; text-decoration: none;">
                DECARGAR <i class="far fa-file-pdf"></i>
            </a>
        @endif
    @elseif($anexo->oavance_anexo=='ootros_hechos_d')
        @if($avance->ootros_hechos_d==1)
            <a  href=""
                class="btn btn-outline-info btn-sm" 
                style="font-size: 12px; text-decoration: none;">
                DECARGAR <i class="far fa-file-pdf"></i>
            </a>
        @endif
    @endif
