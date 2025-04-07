<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use App\Models\CentrosTrabajo;
use App\Models\Organitation;
use App\Models\Plantilla;
use App\Models\Anexos;
use App\Models\Documentos;
use App\Models\Ordenamientojuridico;
use App\Models\Plantillapersonal;
use App\Models\Plantillacomisionados;

use App\Models\Tipoacta;
use App\Models\DatosActa;
use App\Models\Avanceanexos;
use App\Models\User;

class EntregasRecepcionController extends Controller
{


    public function index()
    {   
        
        if(Auth::user()->onivel=='ELEMENTAL'){
            $us=76;
        }else if(Auth::user()->onivel=='SECUNDARIA'){
            $us=89;
        }

        if(Auth::user()->ocargo=='DIRECCIÓN')
        {
            
                    $datosacta   = DatosActa::distinct()->select('g1acta.id', 'g1acta.id_user','g1acta.id_tipoacta','g1acta.id_ct',
                                                 'g1acta.onombre_entrega_a','g1acta.onombre_recibe_a','g1acta.onombre_recibe_ac',
                                DB::raw('CASE 
                                            WHEN 
                                                id_tipoacta=1 
                                            THEN 
                                                CASE WHEN   
                                                    onombre_entrega_a   IS NOT NULL AND
                                                    orfc_entrega_a      IS NOT NULL AND
                                                    ocargo_entrega_a    IS NOT NULL AND
                                                    onombre_recibe_a    IS NOT NULL AND
                                                    orfc_recibe_a       IS NOT NULL AND
                                                    ocargo_recibe_a     IS NOT NULL
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
                                                END AS estadoacta'))
                            ->leftJoin('g1organigrama', 'g1organigrama.idct_sector',  'id_ct')  
                            ->where('g1organigrama.idct_direccion', Auth::user()->id_ct)
                            ->whereOconcluida(0)
                            ->get();

                    $datosacta2   = DatosActa::distinct()->select('g1acta.id', 'g1acta.id_user','g1acta.id_tipoacta','g1acta.id_ct',
                                                 'g1acta.onombre_entrega_a','g1acta.onombre_recibe_a','g1acta.onombre_recibe_ac',
                                DB::raw('CASE 
                                            WHEN 
                                                id_tipoacta=1 
                                            THEN 
                                                CASE WHEN   
                                                    onombre_entrega_a   IS NOT NULL AND
                                                    orfc_entrega_a      IS NOT NULL AND
                                                    ocargo_entrega_a    IS NOT NULL AND
                                                    onombre_recibe_a    IS NOT NULL AND
                                                    orfc_recibe_a       IS NOT NULL AND
                                                    ocargo_recibe_a     IS NOT NULL
                                                THEN 1 ELSE 0 END 
                                            WHEN 
                                                id_tipoacta=2 
                                            THEN 
                                                CASE WHEN 
                                                    onombre_recibe_ac   IS NOT NULL AND
                                                    orfc_recibe_ac      IS NOT NULL
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
                                                END AS estadoacta'))
                            ->leftJoin('g1organigrama', 'g1organigrama.idct_supervicion',  'id_ct')  
                            ->where('g1organigrama.idct_direccion', Auth::user()->id_ct)
                            ->whereOconcluida(0)
                            ->get();

                    $datosacta3   = DatosActa::distinct()->select('g1acta.id', 'g1acta.id_user','g1acta.id_tipoacta','g1acta.id_ct',
                                                 'g1acta.onombre_entrega_a','g1acta.onombre_recibe_a','g1acta.onombre_recibe_ac', 
                                DB::raw('CASE 
                                            WHEN 
                                                id_tipoacta=1 
                                            THEN 
                                                CASE WHEN   
                                                    onombre_entrega_a   IS NOT NULL AND
                                                    orfc_entrega_a      IS NOT NULL AND
                                                    ocargo_entrega_a    IS NOT NULL AND
                                                    onombre_recibe_a    IS NOT NULL AND
                                                    orfc_recibe_a       IS NOT NULL AND
                                                    ocargo_recibe_a     IS NOT NULL
                                                THEN 1 ELSE 0 END 
                                            WHEN 
                                                id_tipoacta=2 
                                            THEN 
                                                CASE WHEN 
                                                    onombre_recibe_ac   IS NOT NULL AND
                                                    orfc_recibe_ac      IS NOT NULL
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
                                                END AS estadoacta'))
                            ->leftJoin('g1organigrama', 'g1organigrama.idct_escuela',  'id_ct')  
                            ->where('g1organigrama.idct_direccion', Auth::user()->id_ct)
                            ->whereOconcluida(0)
                            ->get();

            return view('admin.er.index',
                compact('datosacta','datosacta2','datosacta3','us')
                );


        }else if(Auth::user()->ocargo=='SUBDIRECCIÓN'){
            

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
                                                END AS estadoacta'))
                    ->leftJoin('g1organigrama', 'g1organigrama.idct_sector',  'id_ct')  
                    ->where('g1organigrama.idct_subdireccion', Auth::user()->id_ct)
                    ->whereOconcluida(0)
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
                                                END AS estadoacta'))
                    ->leftJoin('g1organigrama', 'g1organigrama.idct_supervicion',  'id_ct')  
                    ->where('g1organigrama.idct_subdireccion', Auth::user()->id_ct)
                    ->whereOconcluida(0)
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
                                                END AS estadoacta')) 
                    ->leftJoin('g1organigrama', 'g1organigrama.idct_escuela',  'id_ct')  
                    ->where('g1organigrama.idct_subdireccion', Auth::user()->id_ct)
                    ->whereOconcluida(0)
                    ->get();


            return view('admin.er.index',
                compact('datosacta','datosacta2','datosacta3','us')
                );


        }else if(Auth::user()->ocargo=='DEPARTAMENTO'){
            

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
                                                END AS estadoacta')) 
                    ->leftJoin('g1organigrama', 'g1organigrama.idct_sector',  'id_ct')  
                    ->where('g1organigrama.idct_departamento', Auth::user()->id_ct)
                    ->whereOconcluida(0)
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
                                                END AS estadoacta')) 
                    ->leftJoin('g1organigrama', 'g1organigrama.idct_supervicion',  'id_ct')  
                    ->where('g1organigrama.idct_departamento', Auth::user()->id_ct)
                    ->whereOconcluida(0)
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
                                                END AS estadoacta')) 
                    ->leftJoin('g1organigrama', 'g1organigrama.idct_escuela',  'id_ct')  
                    ->where('g1organigrama.idct_departamento', Auth::user()->id_ct)
                    ->whereOconcluida(0)
                    ->get();

            return view('admin.er.index',
                compact('datosacta','datosacta2','datosacta3','us')
                );

        }else if(Auth::user()->ocargo=='SECTOR'){
            

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
                                                END AS estadoacta')) 
                    ->leftJoin('g1organigrama', 'g1organigrama.idct_supervicion',  'id_ct')  
                    ->where('g1organigrama.idct_sector', Auth::user()->id_ct)
                    ->whereOconcluida(0)
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
                                                END AS estadoacta')) 
                    ->leftJoin('g1organigrama', 'g1organigrama.idct_escuela',  'id_ct')  
                    ->where('g1organigrama.idct_sector', Auth::user()->id_ct)
                    ->whereOconcluida(0)
                    ->get();

            return view('admin.er.02-ab',
                compact('datosacta2','datosacta3','us')
                );


        }else if(Auth::user()->ocargo=='SUPERVISIÓN'){
        
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
                                                END AS estadoacta')) 
                    ->leftJoin('g1organigrama', 'g1organigrama.idct_escuela',  'id_ct')  
                    ->where('g1organigrama.idct_supervicion', Auth::user()->id_ct)
                    ->whereOconcluida(0)
                    ->get();

            return view('admin.er.03-ab',
                compact('datosacta3','us')
                );

        }





    }





















    public function show()
    {
        //$datosacta = DatosActa::get();
        $datosacta   = DatosActa::select('*',
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
                                                    THEN "EN PROCESO DE CAPTURA DE ANEXOS "

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
                                                END AS estadoacta'))
                    ->whereIdCtorigen(Auth::user()->id_ct)->paginate(10);

        return view('admin.er.show',
                compact('datosacta')
                );
    }




















    public function edit(string $id)
    {
        if(Auth::user()->onivel=='ELEMENTAL'){
            $us=76;
        }else if(Auth::user()->onivel=='SECUNDARIA'){
            $us=89;
        }

        $documentos  = Documentos::get();
        $datosacta   = DatosActa::whereId($id)->first();
        $avanceanexos = Avanceanexos::whereIdActa($id)->get();

        if($datosacta->id_tipoacta==2)
        {
                $anexos = Anexos::whereNotIn('onum_anexo', [14,15])->OrderBy('onum_anexo', 'ASC')->get();
        }else if($datosacta->id_tipoacta==1){

               $anexos  = Anexos::OrderBy('onum_anexo', 'ASC')->get(); 
        }

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

        return view('admin.er.edit',
                compact('anexos', 'documentos', 'datosacta', 'avanceanexos', 'avance', 'us')
                );
    }














    public function update(Request $request, string $id)
    {
        if($request->action=='1')
        {
                $avances_acta = DatosActa::whereId($request->idacta);
                $avances_acta->update(['ocheckactaa'=> 1, 'owaitacta' => 1]);

                $avances_plantilla = Avanceanexos::whereIdActa($request->idacta);
                $avances_plantilla->update(['ocheckacta'=> 1,]);
            
                return redirect()->back()
                        ->with('success', 'Se aprobo al C.T para poder cargar el acta escaneada y firmadaa');

        }else if($request->action=='2'){

                $doc = Anexos::whereOnumAnexo($request->idane)->first();
                $openanex = $doc->oavance_anexo;

                $doc = Documentos::whereId($request->idoc)->first();
                $opendoc = $doc->oopendoc;

                if($request->idoc=='2')
                {
                    $opersonal = Plantillapersonal::whereIdActa($request->idacta);
                    $opersonal->update([ 'ofinalizacion' => 0 ]);
                }else if($request->idoc=='3'){
                    $ocomisionados = Plantillacomisionados::whereIdActa($request->idacta);
                    $ocomisionados->update([ 'ofinalizacion' => 0 ]);
                }

                $avances_plantilla = Avanceanexos::whereIdActa($request->idacta);
                $avances_plantilla->update([$opendoc => 0, 
                                            $openanex => 0, 
                                            'oopenanexo' => 1,]);

                $update_actt = DatosActa::whereId($request->idacta);
                $update_actt->update(['oopenanexo' => 1,]);  

                return redirect()->back()
                        ->with('success', 'Se aperturo el anexo: '.$doc->onum_documento.' - '.$doc->odocumento);
        
        }else if($request->action=='3'){

                $acta = DatosActa::whereId($request->idacta)->first();
                $ct = CentrosTrabajo::whereKcvect($acta->id_ct)->first();

                $update_acta = DatosActa::whereId($request->idacta);
                $update_acta->update(['oconcluida' => 1,]);  

                $update_avances = Avanceanexos::whereIdActa($request->idacta);
                $update_avances->update(['ofinalizacion' => 1,]);
            
                return redirect()->back()
                        ->with('success', 'Se finalizó esta entrega-recepción de: '.$ct->oclave.' - '.$ct->onombre_ct);

        }else if($request->action=='9'){

                $acta = DatosActa::whereId($request->idacta)->first();
                $ct = CentrosTrabajo::whereKcvect($acta->id_ct)->first();

                $avances_acta = DatosActa::whereId($request->idacta);
                $avances_acta->update([ 'ocheckactaa'=> 0, 
                                        'owaitacta'  => 0,
                                        'oestado'    => 0,
                                       ]);

                $avances_plantilla = Avanceanexos::whereIdActa($request->idacta);
                $avances_plantilla->update([
                                            'ocheckacta'=> 0,
                                            'oestado'   => 0,
                                           ]);

                return redirect()->back()
                        ->with('success', 'Se habilitó la modificación del acta para: '.$ct->oclave.' - '.$ct->onombre_ct);
        }

    }






}
