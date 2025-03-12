<?php 
use App\Models\DatosActa;


$datosacta   = DatosActa::distinct()->select('g1acta.id', 'g1acta.id_user','g1acta.id_tipoacta','g1acta.id_ct',
                             'g1acta.onombre_entrega_a','g1acta.onombre_recibe_a','g1acta.onombre_recibe_ac',
            DB::raw('CASE 
                        WHEN 
                            id_tipoacta=1 
                        THEN 
                            CASE WHEN   
                                onombre_entrega_a IS NOT NULL AND
                                orfc_entrega_a IS NOT NULL AND
                                ocargo_entrega_a IS NOT NULL AND
                                onombre_recibe_a IS NOT NULL AND
                                orfc_recibe_a IS NOT NULL AND
                                ocargo_recibe_a  IS NOT NULL
                            THEN 1 ELSE 0 END 
                        WHEN 
                            id_tipoacta=2 
                        THEN 
                            CASE WHEN 
                                onombre_recibe_ac IS NOT NULL AND
                                orfc_recibe_ac IS NOT NULL
                            THEN 1 ELSE 0 END  
                        END AS ock'),
            DB::raw('CASE
                                WHEN 
                                  g1acta.oopenanexo=0 
                                THEN 
                                    CASE 
                                        WHEN 
                                            g1acta.oactual=0       AND
                                            g1acta.ocheck=0        AND
                                            g1acta.ofinanexos=0    AND
                                            g1acta.oestado=0       AND 
                                            g1acta.owaitacta=0     AND
                                            g1acta.ocheckactaa=0   AND 
                                            g1acta.ocargaacta=0    AND
                                            g1acta.oconcluida=0    AND 
                                            g1acta.ocargacomprimido=0
                                        THEN "NO SE HA COMENZADO  "

                                        WHEN 
                                            g1acta.oactual=1       AND
                                            g1acta.ocheck=0        AND
                                            g1acta.ofinanexos=0    AND
                                            g1acta.oestado=0       AND 
                                            g1acta.owaitacta=0     AND
                                            g1acta.ocheckactaa=0   AND 
                                            g1acta.ocargaacta=0    AND
                                            g1acta.oconcluida=0    AND 
                                            g1acta.ocargacomprimido=0
                                        THEN "EN PROCESO DE CAPTURA DE QUIEN GENERA EL ACTA"

                                        WHEN 
                                            g1acta.oactual=1       AND
                                            g1acta.ocheck=1        AND
                                            g1acta.ofinanexos=0    AND
                                            g1acta.oestado=0       AND 
                                            g1acta.owaitacta=0     AND
                                            g1acta.ocheckactaa=0   AND 
                                            g1acta.ocargaacta=0    AND
                                            g1acta.oconcluida=0    AND
                                            g1acta.ocargacomprimido=0
                                        THEN "EN PROCESO DE CAPTURA DE ANEXOS "

                                        WHEN 
                                            g1acta.oactual=1       AND
                                            g1acta.ocheck=1        AND
                                            g1acta.ofinanexos=1    AND
                                            g1acta.oestado=0       AND 
                                            g1acta.owaitacta=0     AND
                                            g1acta.ocheckactaa=0   AND 
                                            g1acta.ocargaacta=0    AND
                                            g1acta.oconcluida=0    AND 
                                            g1acta.ocargacomprimido=0
                                        THEN "EN PROCESO DE CAPTURA DE DATOS PARA EL ACTA "

                                        WHEN 
                                            g1acta.oactual=1       AND
                                            g1acta.ocheck=1        AND
                                            g1acta.ofinanexos=1    AND
                                            g1acta.oestado=1       AND 
                                            g1acta.owaitacta=2     AND
                                            g1acta.ocheckactaa=0   AND 
                                            g1acta.ocargaacta=0    AND
                                            g1acta.oconcluida=0    AND 
                                            g1acta.ocargacomprimido=0
                                        THEN "ACTA GENERADA. (¡¡PENDIENTE LA APROBACIÓN PARA LA CARGA DEL ACTA ESCANEADA Y FIRMADA!!)."

                                        WHEN 
                                            g1acta.oactual=1       AND
                                            g1acta.ocheck=1        AND
                                            g1acta.ofinanexos=1    AND
                                            g1acta.oestado=1       AND 
                                            g1acta.owaitacta=1     AND
                                            g1acta.ocheckactaa=1   AND 
                                            g1acta.ocargaacta=0    AND
                                            g1acta.oconcluida=0    AND
                                            g1acta.ocargacomprimido=0
                                        THEN "¡¡SE ESPERA LA CARGA DEL ACTA ESCANEADA!!" 

                                        WHEN 
                                            g1acta.oactual=1       AND
                                            g1acta.ocheck=1        AND
                                            g1acta.ofinanexos=1    AND
                                            g1acta.oestado=1       AND 
                                            g1acta.owaitacta=1     AND
                                            g1acta.ocheckactaa=1   AND 
                                            g1acta.ocargaacta=1    AND
                                            g1acta.oconcluida=0    AND
                                            g1acta.ocargacomprimido=0
                                        THEN "EL ACTA SE SUBIÓ ESCANEADA Y FIRMADA. (FALTA SUBIR CARPETA FINAL DEL ACTA)" 

                                        WHEN 
                                            g1acta.oactual=1       AND
                                            g1acta.ocheck=1        AND
                                            g1acta.ofinanexos=1    AND
                                            g1acta.oestado=1       AND 
                                            g1acta.owaitacta=1     AND
                                            g1acta.ocheckactaa=1   AND 
                                            g1acta.ocargaacta=1    AND
                                            g1acta.oconcluida=0    AND
                                            g1acta.ocargacomprimido=1
                                        THEN "SE SUBÍO LA CARPETA DE ARCHIVOS. (¡¡SE ESPERA SU APROBACIÓN FINAL!!)" 

                                        WHEN 
                                            g1acta.oactual=1       AND
                                            g1acta.ocheck=1        AND
                                            g1acta.ofinanexos=1    AND
                                            g1acta.oestado=1       AND 
                                            g1acta.owaitacta=1     AND
                                            g1acta.ocheckactaa=1   AND 
                                            g1acta.ocargaacta=1    AND
                                            g1acta.oconcluida=1    AND
                                            g1acta.ocargacomprimido=1
                                        THEN "SE REVISO Y CONCLUYÓ EL PROCESO DE ENTREGA-RECEPCIÓN" 

                                        END 
                                    WHEN g1acta.oopenanexo=1
                                    THEN "¡¡ATENCIÓN!! ANEXO ABIERTO, DEBE FINALIZARSE ESTE ANEXO PARA CONTINUAR"
                                    END AS estadoacta'),DB::raw('CASE 
                                        WHEN idct_departamento=0 
                                        THEN (SELECT CONCAT(oclave," - ",onombre_ct) FROM g1centros_trabajo WHERE kcvect=idct_subdireccion) 
                                        ELSE (SELECT CONCAT(oclave," - ",onombre_ct) FROM g1centros_trabajo WHERE kcvect=idct_departamento) 
                                    END AS unidad')) 
        ->leftJoin('g1organigrama', 'g1organigrama.idct_sector',  'id_ct')  
        ->where('g1organigrama.idct_departamento', Auth::user()->id_ct)
        ->whereOconcluida(0)
        ->OrderBy('unidad', 'ASC')
        ->get();

$datosacta2   = DatosActa::distinct()->select('g1acta.id', 'g1acta.id_user','g1acta.id_tipoacta','g1acta.id_ct',
                             'g1acta.onombre_entrega_a','g1acta.onombre_recibe_a','g1acta.onombre_recibe_ac',
            DB::raw('CASE 
                        WHEN 
                            id_tipoacta=1 
                        THEN 
                            CASE WHEN   
                                onombre_entrega_a IS NOT NULL AND
                                orfc_entrega_a IS NOT NULL AND
                                ocargo_entrega_a IS NOT NULL AND
                                onombre_recibe_a IS NOT NULL AND
                                orfc_recibe_a IS NOT NULL AND
                                ocargo_recibe_a  IS NOT NULL
                            THEN 1 ELSE 0 END 
                        WHEN 
                            id_tipoacta=2 
                        THEN 
                            CASE WHEN 
                                onombre_recibe_ac IS NOT NULL AND
                                orfc_recibe_ac IS NOT NULL
                            THEN 1 ELSE 0 END  
                        END AS ock'),
            DB::raw('CASE
                                WHEN 
                                  g1acta.oopenanexo=0 
                                THEN 
                                    CASE 
                                        WHEN 
                                            g1acta.oactual=0       AND
                                            g1acta.ocheck=0        AND
                                            g1acta.ofinanexos=0    AND
                                            g1acta.oestado=0       AND 
                                            g1acta.owaitacta=0     AND
                                            g1acta.ocheckactaa=0   AND 
                                            g1acta.ocargaacta=0    AND
                                            g1acta.oconcluida=0    AND 
                                            g1acta.ocargacomprimido=0
                                        THEN "NO SE HA COMENZADO  "

                                        WHEN 
                                            g1acta.oactual=1       AND
                                            g1acta.ocheck=0        AND
                                            g1acta.ofinanexos=0    AND
                                            g1acta.oestado=0       AND 
                                            g1acta.owaitacta=0     AND
                                            g1acta.ocheckactaa=0   AND 
                                            g1acta.ocargaacta=0    AND
                                            g1acta.oconcluida=0    AND 
                                            g1acta.ocargacomprimido=0
                                        THEN "EN PROCESO DE CAPTURA DE QUIEN GENERA EL ACTA"

                                        WHEN 
                                            g1acta.oactual=1       AND
                                            g1acta.ocheck=1        AND
                                            g1acta.ofinanexos=0    AND
                                            g1acta.oestado=0       AND 
                                            g1acta.owaitacta=0     AND
                                            g1acta.ocheckactaa=0   AND 
                                            g1acta.ocargaacta=0    AND
                                            g1acta.oconcluida=0    AND
                                            g1acta.ocargacomprimido=0
                                        THEN "EN PROCESO DE CAPTURA DE ANEXOS "

                                        WHEN 
                                            g1acta.oactual=1       AND
                                            g1acta.ocheck=1        AND
                                            g1acta.ofinanexos=1    AND
                                            g1acta.oestado=0       AND 
                                            g1acta.owaitacta=0     AND
                                            g1acta.ocheckactaa=0   AND 
                                            g1acta.ocargaacta=0    AND
                                            g1acta.oconcluida=0    AND 
                                            g1acta.ocargacomprimido=0
                                        THEN "EN PROCESO DE CAPTURA DE DATOS PARA EL ACTA "

                                        WHEN 
                                            g1acta.oactual=1       AND
                                            g1acta.ocheck=1        AND
                                            g1acta.ofinanexos=1    AND
                                            g1acta.oestado=1       AND 
                                            g1acta.owaitacta=2     AND
                                            g1acta.ocheckactaa=0   AND 
                                            g1acta.ocargaacta=0    AND
                                            g1acta.oconcluida=0    AND 
                                            g1acta.ocargacomprimido=0
                                        THEN "ACTA GENERADA. (¡¡PENDIENTE LA APROBACIÓN PARA LA CARGA DEL ACTA ESCANEADA Y FIRMADA!!)."

                                        WHEN 
                                            g1acta.oactual=1       AND
                                            g1acta.ocheck=1        AND
                                            g1acta.ofinanexos=1    AND
                                            g1acta.oestado=1       AND 
                                            g1acta.owaitacta=1     AND
                                            g1acta.ocheckactaa=1   AND 
                                            g1acta.ocargaacta=0    AND
                                            g1acta.oconcluida=0    AND
                                            g1acta.ocargacomprimido=0
                                        THEN "¡¡SE ESPERA LA CARGA DEL ACTA ESCANEADA!!" 

                                        WHEN 
                                            g1acta.oactual=1       AND
                                            g1acta.ocheck=1        AND
                                            g1acta.ofinanexos=1    AND
                                            g1acta.oestado=1       AND 
                                            g1acta.owaitacta=1     AND
                                            g1acta.ocheckactaa=1   AND 
                                            g1acta.ocargaacta=1    AND
                                            g1acta.oconcluida=0    AND
                                            g1acta.ocargacomprimido=0
                                        THEN "EL ACTA SE SUBIÓ ESCANEADA Y FIRMADA. (FALTA SUBIR CARPETA FINAL DEL ACTA)" 

                                        WHEN 
                                            g1acta.oactual=1       AND
                                            g1acta.ocheck=1        AND
                                            g1acta.ofinanexos=1    AND
                                            g1acta.oestado=1       AND 
                                            g1acta.owaitacta=1     AND
                                            g1acta.ocheckactaa=1   AND 
                                            g1acta.ocargaacta=1    AND
                                            g1acta.oconcluida=0    AND
                                            g1acta.ocargacomprimido=1
                                        THEN "SE SUBÍO LA CARPETA DE ARCHIVOS. (¡¡SE ESPERA SU APROBACIÓN FINAL!!)" 

                                        WHEN 
                                            g1acta.oactual=1       AND
                                            g1acta.ocheck=1        AND
                                            g1acta.ofinanexos=1    AND
                                            g1acta.oestado=1       AND 
                                            g1acta.owaitacta=1     AND
                                            g1acta.ocheckactaa=1   AND 
                                            g1acta.ocargaacta=1    AND
                                            g1acta.oconcluida=1    AND
                                            g1acta.ocargacomprimido=1
                                        THEN "SE REVISO Y CONCLUYÓ EL PROCESO DE ENTREGA-RECEPCIÓN" 

                                        END 
                                    WHEN g1acta.oopenanexo=1
                                    THEN "¡¡ATENCIÓN!! ANEXO ABIERTO, DEBE FINALIZARSE ESTE ANEXO PARA CONTINUAR"
                                    END AS estadoacta'),DB::raw('CASE 
                                        WHEN idct_departamento=0 
                                        THEN (SELECT CONCAT(oclave," - ",onombre_ct) FROM g1centros_trabajo WHERE kcvect=idct_subdireccion) 
                                        ELSE (SELECT CONCAT(oclave," - ",onombre_ct) FROM g1centros_trabajo WHERE kcvect=idct_departamento) 
                                    END AS unidad')) 
        ->leftJoin('g1organigrama', 'g1organigrama.idct_supervicion',  'id_ct')  
        ->where('g1organigrama.idct_departamento', Auth::user()->id_ct)
        ->whereOconcluida(0)
        ->OrderBy('unidad', 'ASC')
        ->get();

$datosacta3   = DatosActa::distinct()->select('g1acta.id', 'g1acta.id_user','g1acta.id_tipoacta','g1acta.id_ct',
                             'g1acta.onombre_entrega_a','g1acta.onombre_recibe_a','g1acta.onombre_recibe_ac', 
            DB::raw('CASE 
                        WHEN 
                            id_tipoacta=1 
                        THEN 
                            CASE WHEN   
                                onombre_entrega_a IS NOT NULL AND
                                orfc_entrega_a IS NOT NULL AND
                                ocargo_entrega_a IS NOT NULL AND
                                onombre_recibe_a IS NOT NULL AND
                                orfc_recibe_a IS NOT NULL AND
                                ocargo_recibe_a  IS NOT NULL
                            THEN 1 ELSE 0 END 
                        WHEN 
                            id_tipoacta=2 
                        THEN 
                            CASE WHEN 
                                onombre_recibe_ac IS NOT NULL AND
                                orfc_recibe_ac IS NOT NULL
                            THEN 1 ELSE 0 END  
                        END AS ock'),
            DB::raw('CASE
                                WHEN 
                                  g1acta.oopenanexo=0 
                                THEN 
                                    CASE 
                                        WHEN 
                                            g1acta.oactual=0       AND
                                            g1acta.ocheck=0        AND
                                            g1acta.ofinanexos=0    AND
                                            g1acta.oestado=0       AND 
                                            g1acta.owaitacta=0     AND
                                            g1acta.ocheckactaa=0   AND 
                                            g1acta.ocargaacta=0    AND
                                            g1acta.oconcluida=0    AND 
                                            g1acta.ocargacomprimido=0
                                        THEN "NO SE HA COMENZADO  "

                                        WHEN 
                                            g1acta.oactual=1       AND
                                            g1acta.ocheck=0        AND
                                            g1acta.ofinanexos=0    AND
                                            g1acta.oestado=0       AND 
                                            g1acta.owaitacta=0     AND
                                            g1acta.ocheckactaa=0   AND 
                                            g1acta.ocargaacta=0    AND
                                            g1acta.oconcluida=0    AND 
                                            g1acta.ocargacomprimido=0
                                        THEN "EN PROCESO DE CAPTURA DE QUIEN GENERA EL ACTA"

                                        WHEN 
                                            g1acta.oactual=1       AND
                                            g1acta.ocheck=1        AND
                                            g1acta.ofinanexos=0    AND
                                            g1acta.oestado=0       AND 
                                            g1acta.owaitacta=0     AND
                                            g1acta.ocheckactaa=0   AND 
                                            g1acta.ocargaacta=0    AND
                                            g1acta.oconcluida=0    AND
                                            g1acta.ocargacomprimido=0
                                        THEN "EN PROCESO DE CAPTURA DE ANEXOS "

                                        WHEN 
                                            g1acta.oactual=1       AND
                                            g1acta.ocheck=1        AND
                                            g1acta.ofinanexos=1    AND
                                            g1acta.oestado=0       AND 
                                            g1acta.owaitacta=0     AND
                                            g1acta.ocheckactaa=0   AND 
                                            g1acta.ocargaacta=0    AND
                                            g1acta.oconcluida=0    AND 
                                            g1acta.ocargacomprimido=0
                                        THEN "EN PROCESO DE CAPTURA DE DATOS PARA EL ACTA "

                                        WHEN 
                                            g1acta.oactual=1       AND
                                            g1acta.ocheck=1        AND
                                            g1acta.ofinanexos=1    AND
                                            g1acta.oestado=1       AND 
                                            g1acta.owaitacta=2     AND
                                            g1acta.ocheckactaa=0   AND 
                                            g1acta.ocargaacta=0    AND
                                            g1acta.oconcluida=0    AND 
                                            g1acta.ocargacomprimido=0
                                        THEN "ACTA GENERADA. (¡¡PENDIENTE LA APROBACIÓN PARA LA CARGA DEL ACTA ESCANEADA Y FIRMADA!!)."

                                        WHEN 
                                            g1acta.oactual=1       AND
                                            g1acta.ocheck=1        AND
                                            g1acta.ofinanexos=1    AND
                                            g1acta.oestado=1       AND 
                                            g1acta.owaitacta=1     AND
                                            g1acta.ocheckactaa=1   AND 
                                            g1acta.ocargaacta=0    AND
                                            g1acta.oconcluida=0    AND
                                            g1acta.ocargacomprimido=0
                                        THEN "¡¡SE ESPERA LA CARGA DEL ACTA ESCANEADA!!" 

                                        WHEN 
                                            g1acta.oactual=1       AND
                                            g1acta.ocheck=1        AND
                                            g1acta.ofinanexos=1    AND
                                            g1acta.oestado=1       AND 
                                            g1acta.owaitacta=1     AND
                                            g1acta.ocheckactaa=1   AND 
                                            g1acta.ocargaacta=1    AND
                                            g1acta.oconcluida=0    AND
                                            g1acta.ocargacomprimido=0
                                        THEN "EL ACTA SE SUBIÓ ESCANEADA Y FIRMADA. (FALTA SUBIR CARPETA FINAL DEL ACTA)" 

                                        WHEN 
                                            g1acta.oactual=1       AND
                                            g1acta.ocheck=1        AND
                                            g1acta.ofinanexos=1    AND
                                            g1acta.oestado=1       AND 
                                            g1acta.owaitacta=1     AND
                                            g1acta.ocheckactaa=1   AND 
                                            g1acta.ocargaacta=1    AND
                                            g1acta.oconcluida=0    AND
                                            g1acta.ocargacomprimido=1
                                        THEN "SE SUBÍO LA CARPETA DE ARCHIVOS. (¡¡SE ESPERA SU APROBACIÓN FINAL!!)" 

                                        WHEN 
                                            g1acta.oactual=1       AND
                                            g1acta.ocheck=1        AND
                                            g1acta.ofinanexos=1    AND
                                            g1acta.oestado=1       AND 
                                            g1acta.owaitacta=1     AND
                                            g1acta.ocheckactaa=1   AND 
                                            g1acta.ocargaacta=1    AND
                                            g1acta.oconcluida=1    AND
                                            g1acta.ocargacomprimido=1
                                        THEN "SE REVISO Y CONCLUYÓ EL PROCESO DE ENTREGA-RECEPCIÓN" 

                                        END 
                                    WHEN g1acta.oopenanexo=1
                                    THEN "¡¡ATENCIÓN!! ANEXO ABIERTO, DEBE FINALIZARSE ESTE ANEXO PARA CONTINUAR"
                                    END AS estadoacta'),DB::raw('CASE 
                                        WHEN idct_departamento=0 
                                        THEN (SELECT CONCAT(oclave," - ",onombre_ct) FROM g1centros_trabajo WHERE kcvect=idct_subdireccion) 
                                        ELSE (SELECT CONCAT(oclave," - ",onombre_ct) FROM g1centros_trabajo WHERE kcvect=idct_departamento) 
                                    END AS unidad')) 
        ->leftJoin('g1organigrama', 'g1organigrama.idct_escuela',  'id_ct')  
        ->where('g1organigrama.idct_departamento', Auth::user()->id_ct)
        ->whereOconcluida(0)
        ->OrderBy('unidad', 'ASC')
        ->get();

 ?>