@if($anexo->oavance_anexo=='omarco_juridico_d')
        @if($avance->omarco_juridico_d==1)
            <i  class="far fa-thumbs-up" 
                style="font-size:20px; color:green;"></i>
        @else
            <i class="far fa-thumbs-down" 
                style="font-size:20px; color:red;"></i>
        @endif
@elseif($anexo->oavance_anexo=='orecursos_humanos_d')
        @if($avance->orecursos_humanos_d==1)
            <i  class="far fa-thumbs-up" 
                style="font-size:20px; color:green;"></i>
        @else
            <i  class="far fa-thumbs-down" 
                style="font-size:20px; color:red;"></i>
        @endif
@elseif($anexo->oavance_anexo=='osituacion_recursos_materiales_d')
        @if($avance->osituacion_recursos_materiales_d==1)
            <i  class="far fa-thumbs-up" 
                style="font-size:20px; color:green;"></i>
        @else
            <i class="far fa-thumbs-down" 
                style="font-size:20px; color:red;"></i>
        @endif
@elseif($anexo->oavance_anexo=='osituacion_tics_d')
        @if($avance->osituacion_tics_d==1)
            <i  class="far fa-thumbs-up" 
                style="font-size:20px; color:green;"></i>
        @else
            <i  class="far fa-thumbs-down" 
                style="font-size:20px; color:red;"></i>
        @endif
@elseif($anexo->oavance_anexo=='oarchivos_d')
        @if($avance->oarchivos_d==1)
            <i  class="far fa-thumbs-up" 
                style="font-size:20px; color:green;"></i>
        @else
            <i class="far fa-thumbs-down" 
                style="font-size:20px; color:red;"></i>
        @endif
@elseif($anexo->oavance_anexo=='ocertificados_no_adeudos_d')
        @if($avance->ocertificados_no_adeudos_d==1)
            <i  class="far fa-thumbs-up" 
                style="font-size:20px; color:green;"></i>
        @else
            <i class="far fa-thumbs-down" 
                style="font-size:20px; color:red;"></i>
        @endif
@elseif($anexo->oavance_anexo=='oinforme_gestion_d')
        @if($avance->oinforme_gestion_d==1)
            <i  class="far fa-thumbs-up" 
                style="font-size:20px; color:green;"></i>
        @else
            <i  class="far fa-thumbs-down" 
                style="font-size:20px; color:red;"></i>
        @endif
@elseif($anexo->oavance_anexo=='ootros_hechos_d')
        @if($avance->ootros_hechos_d==1)
            <i  class="far fa-thumbs-up" 
                style="font-size:20px; color:green;"></i>
        @else
            <i class="far fa-thumbs-down" 
                style="font-size:20px; color:red;"></i>
        @endif
@endif
