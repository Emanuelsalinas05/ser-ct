<?php 

use App\Models\Avanceanexos;

$avance  = Avanceanexos::select('*', 'g1acta.id',
        DB::raw('CASE 
                    WHEN g1acta.id_tipoacta=1
                    THEN 
                            CASE 
                                WHEN
                                    oplantilla_personal_a = 1 AND
                                    oplantilla_comisionados_a = 1 AND
                                    oinventario_bienes_a = 1 AND
                                    oinventario_almacen_a = 1 AND
                                    orelacion_bienes_custodia_a = 1 AND
                                    oinventario_equipo_a = 1 AND
                                    orelacion_archivos_a = 1 AND
                                    orelacion_archivos_historico_a = 1 AND
                                    orelacion_documentos_noconvencionles_a = 1 AND
                                    ocertificados_no_adeudo_a = 1 AND
                                    oinforme_gestion_a = 1 AND
                                    oinforme_compromisos_a = 1 AND
                                    ootros_hechos_a = 1 AND
                                    g1avance_anexos.oopenanexo=0 
                                THEN 1 ELSE 0 END 
                        WHEN g1acta.id_tipoacta=2       
                        THEN    
                            CASE 
                             WHEN
                                 oplantilla_personal_a = 1 AND
                                 oplantilla_comisionados_a = 1 AND
                                 oinventario_bienes_a = 1 AND
                                 oinventario_almacen_a = 1 AND
                                 orelacion_bienes_custodia_a = 1 AND
                                 oinventario_equipo_a = 1 AND
                                 orelacion_archivos_a = 1 AND
                                 orelacion_archivos_historico_a = 1 AND
                                 orelacion_documentos_noconvencionles_a = 1 AND
                                 ootros_hechos_a = 1 AND
                                 g1avance_anexos.oopenanexo=0   
                             THEN 1 ELSE 0 END          
                            END AS completado,
                    CASE
                    WHEN 
                      g1acta.oopenanexo=0 
                    THEN 
                        CASE 
                            WHEN 
                                g1acta.oactual=1       AND
                                g1acta.ocheck=0        AND
                                g1acta.ofinanexos=0    AND
                                g1acta.oestado=0       AND 
                                g1acta.owaitacta=0     AND
                                g1acta.ocheckactaa=0   AND 
                                g1acta.ocargaacta=0    AND
                                g1acta.ocargacomprimido=0 AND
                                g1acta.oconcluida=0 
                            THEN 1

                            WHEN 
                                g1acta.oactual=1       AND
                                g1acta.ocheck=1        AND
                                g1acta.ofinanexos=0    AND
                                g1acta.oestado=0       AND 
                                g1acta.owaitacta=0     AND
                                g1acta.ocheckactaa=0   AND 
                                g1acta.ocargaacta=0    AND
                                g1acta.ocargacomprimido=0 AND
                                g1acta.oconcluida=0 
                            THEN 2

                            WHEN 
                                g1acta.oactual=1       AND
                                g1acta.ocheck=1        AND
                                g1acta.ofinanexos=1    AND
                                g1acta.oestado=0       AND 
                                g1acta.owaitacta=0     AND
                                g1acta.ocheckactaa=0   AND 
                                g1acta.ocargaacta=0    AND
                                g1acta.ocargacomprimido=0 AND
                                g1acta.oconcluida=0 
                            THEN 3

                            WHEN 
                                g1acta.oactual=1       AND
                                g1acta.ocheck=1        AND
                                g1acta.ofinanexos=1    AND
                                g1acta.oestado=1       AND 
                                g1acta.owaitacta=2     AND
                                g1acta.ocheckactaa=0   AND 
                                g1acta.ocargaacta=0    AND
                                g1acta.ocargacomprimido=0 AND
                                g1acta.oconcluida=0 
                            THEN 4

                            WHEN 
                                g1acta.oactual=1       AND
                                g1acta.ocheck=1        AND
                                g1acta.ofinanexos=1    AND
                                g1acta.oestado=1       AND 
                                g1acta.owaitacta=1     AND
                                g1acta.ocheckactaa=1   AND 
                                g1acta.ocargaacta=0    AND
                                g1acta.ocargacomprimido=0 AND
                                g1acta.oconcluida=0 
                            THEN 5

                            WHEN 
                                g1acta.oactual=1       AND
                                g1acta.ocheck=1        AND
                                g1acta.ofinanexos=1    AND
                                g1acta.oestado=1       AND 
                                g1acta.owaitacta=1     AND
                                g1acta.ocheckactaa=1   AND 
                                g1acta.ocargaacta=1    AND
                                g1acta.ocargacomprimido=0 AND
                                g1acta.oconcluida=0 
                            THEN 6

                            WHEN 
                                g1acta.oactual=1       AND
                                g1acta.ocheck=1        AND
                                g1acta.ofinanexos=1    AND
                                g1acta.oestado=1       AND 
                                g1acta.owaitacta=1     AND
                                g1acta.ocheckactaa=1   AND 
                                g1acta.ocargaacta=1    AND
                                g1acta.ocargacomprimido=1 AND
                                g1acta.oconcluida=0 
                            THEN 7

                            WHEN 
                                g1acta.oactual=1       AND
                                g1acta.ocheck=1        AND
                                g1acta.ofinanexos=1    AND
                                g1acta.oestado=1       AND 
                                g1acta.owaitacta=1     AND
                                g1acta.ocheckactaa=1   AND 
                                g1acta.ocargaacta=1    AND
                                g1acta.ocargacomprimido=1 AND
                                g1acta.oconcluida=1 
                            THEN 8
                            END 
                        WHEN 
                            g1acta.oopenanexo=1
                        THEN 0
                        END AS nivelavance')
        )->leftJoin('g1acta', 'g1acta.id',  'id_acta')
        ->whereIdActa($datosacta->id)->first();

?>