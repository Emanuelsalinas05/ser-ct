@if($anexo->oavance_anexo=='omarco_juridico_d')
    @if($avance->omarco_juridico_a==1)
        <x-adminlte-button  icon="fas fa-unlock-alt" 
                            data-toggle="modal" 
                            data-target="#modalOpenanexo{{ $documento->id }}" 
                            class="btn btn-outline-warning btn-xs"/>
    @endif
@elseif($anexo->oavance_anexo=='orecursos_humanos_d')
    @if($avance->oplantilla_personal_a==1 && $avance->oplantilla_comisionados_a==1)
        <x-adminlte-button  icon="fas fa-unlock-alt" 
                            data-toggle="modal" 
                            data-target="#modalOpenanexo{{ $documento->id }}" 
                            class="btn btn-outline-warning btn-xs"/>
    @endif
@elseif($anexo->oavance_anexo=='osituacion_recursos_materiales_d')
    @if($avance->oinventario_bienes_a==1 && $avance->oinventario_almacen_a==1 && $avance->orelacion_bienes_custodia_a==1)
        <x-adminlte-button  icon="fas fa-unlock-alt" 
                            data-toggle="modal" 
                            data-target="#modalOpenanexo{{ $documento->id }}" 
                            class="btn btn-outline-warning btn-xs"/>
    @endif
@elseif($anexo->oavance_anexo=='osituacion_tics_d')
    @if($avance->oinventario_equipo_a==1)
        <x-adminlte-button  icon="fas fa-unlock-alt" 
                            data-toggle="modal" 
                            data-target="#modalOpenanexo{{ $documento->id }}" 
                            class="btn btn-outline-warning btn-xs"/>
    @endif
@elseif($anexo->oavance_anexo=='oarchivos_d')
    @if($avance->orelacion_archivos_a==1 && $avance->orelacion_archivos_historico_a==1 && $avance->orelacion_documentos_noconvencionles_a==1)
        <x-adminlte-button  icon="fas fa-unlock-alt" 
                            data-toggle="modal" 
                            data-target="#modalOpenanexo{{ $documento->id }}" 
                            class="btn btn-outline-warning btn-xs"/>
    @endif
@elseif($anexo->oavance_anexo=='ocertificados_no_adeudos_d')
    @if($avance->ocertificados_no_adeudo_a==1)
        <x-adminlte-button  icon="fas fa-unlock-alt" 
                            data-toggle="modal" 
                            data-target="#modalOpenanexo{{ $documento->id }}" 
                            class="btn btn-outline-warning btn-xs"/>
    @endif
@elseif($anexo->oavance_anexo=='oinforme_gestion_d')
    @if($avance->oinforme_gestion_a==1 && $avance->oinforme_compromisos_a==1)
        <x-adminlte-button  icon="fas fa-unlock-alt" 
                            data-toggle="modal" 
                            data-target="#modalOpenanexo{{ $documento->id }}" 
                            class="btn btn-outline-warning btn-xs"/>
    @endif
@elseif($anexo->oavance_anexo=='ootros_hechos_d')
    @if($avance->ootros_hechos_a==1)
        <x-adminlte-button  icon="fas fa-unlock-alt" 
                            data-toggle="modal" 
                            data-target="#modalOpenanexo{{ $documento->id }}" 
                            class="btn btn-outline-warning btn-xs"/>
    @endif
@endif