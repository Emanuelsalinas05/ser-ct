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

class FinalizadasController extends Controller
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
                    $datosacta  =   DatosActa::select(DB::raw('distinct(g1acta.id) as idd'), 'g1acta.*')
                                    ->leftJoin('g1organigrama', 'g1organigrama.idct_sector',  'id_ct')  
                                    ->where('g1organigrama.idct_direccion', Auth::user()->id_ct)
                                    ->whereOconcluida(1) 
                                    ->get();

                    $datosacta2 =   DatosActa::select(DB::raw('distinct(g1acta.id) as idd'), 'g1acta.*')
                                    ->leftJoin('g1organigrama', 'g1organigrama.idct_supervicion',  'id_ct')  
                                    ->where('g1organigrama.idct_direccion', Auth::user()->id_ct)
                                    ->whereOconcluida(1) 
                                    ->get();


                    $datosacta3 =   DatosActa::select(DB::raw('g1acta.id as idd'), 'g1acta.*', 'g1organigrama.*')
                                    ->leftJoin('g1organigrama', 'g1organigrama.idct_escuela',  'id_ct')  
                                    ->where('g1organigrama.idct_direccion', Auth::user()->id_ct)
                                    ->whereOconcluida(1)
                                    ->get();
                    
            return view('admin.er.finalizadas.index',
                compact('datosacta','datosacta2','datosacta3','us')
                );


        }else if(Auth::user()->ocargo=='SUBDIRECCIÓN'){

                    $datosacta  =   DatosActa::select(DB::raw('distinct(g1acta.id) as idd'), 'g1acta.*')
                                    ->leftJoin('g1organigrama', 'g1organigrama.idct_sector',  'id_ct')  
                                    ->where('g1organigrama.idct_subdireccion', Auth::user()->id_ct)
                                    ->whereOconcluida(1)
                                    ->get();

                    $datosacta2  =   DatosActa::select(DB::raw('distinct(g1acta.id) as idd'), 'g1acta.*')
                                    ->leftJoin('g1organigrama', 'g1organigrama.idct_supervicion',  'id_ct')  
                                    ->where('g1organigrama.idct_subdireccion', Auth::user()->id_ct)
                                    ->whereOconcluida(1)
                                    ->get();


                    $datosacta3  =   DatosActa::select(DB::raw('distinct(g1acta.id) as idd'), 'g1acta.*')
                                    ->leftJoin('g1organigrama', 'g1organigrama.idct_escuela',  'id_ct')  
                                    ->where('g1organigrama.idct_subdireccion', Auth::user()->id_ct)
                                    ->whereOconcluida(1)
                                    ->get();

            return view('admin.er.finalizadas.index',
                compact('datosacta','datosacta2','datosacta3','us')
                );


        }else if(Auth::user()->ocargo=='DEPARTAMENTO'){
            
                    $datosacta  =   DatosActa::select(DB::raw('distinct(g1acta.id) as idd'), 'g1acta.*')
                                    ->leftJoin('g1organigrama', 'g1organigrama.idct_sector',  'id_ct')  
                                    ->where('g1organigrama.idct_departamento', Auth::user()->id_ct)
                                    ->whereOconcluida(1)
                                    ->get();

                    $datosacta2  =   DatosActa::select(DB::raw('distinct(g1acta.id) as idd'), 'g1acta.*')
                                    ->leftJoin('g1organigrama', 'g1organigrama.idct_supervicion',  'id_ct')  
                                    ->where('g1organigrama.idct_departamento', Auth::user()->id_ct)
                                    ->whereOconcluida(1)
                                    ->get();


                    $datosacta3  =   DatosActa::select(DB::raw('distinct(g1acta.id) as idd'), 'g1acta.*')
                                    ->leftJoin('g1organigrama', 'g1organigrama.idct_escuela',  'id_ct')  
                                    ->where('g1organigrama.idct_departamento', Auth::user()->id_ct)
                                    ->whereOconcluida(1)
                                    ->get();

            return view('admin.er.finalizadas.index',
                compact('datosacta','datosacta2','datosacta3','us')
                );

        }else if(Auth::user()->ocargo=='SECTOR'){

                    $datosacta2  =   DatosActa::select(DB::raw('distinct(g1acta.id) as idd'), 'g1acta.*')
                                    ->leftJoin('g1organigrama', 'g1organigrama.idct_supervicion',  'id_ct')  
                                    ->where('g1organigrama.idct_sector', Auth::user()->id_ct)
                                    ->whereOconcluida(1)
                                    ->get();


                    $datosacta3  =   DatosActa::select(DB::raw('distinct(g1acta.id) as idd'), 'g1acta.*')
                                    ->leftJoin('g1organigrama', 'g1organigrama.idct_escuela',  'id_ct')  
                                    ->where('g1organigrama.idct_sector', Auth::user()->id_ct)
                                    ->whereOconcluida(1)
                                    ->get();
            return view('admin.er.finalizadas.index2',
                compact('datosacta2','datosacta3','us') 
                );


        }else if(Auth::user()->ocargo=='SUPERVISIÓN'){
             
                    $datosacta3  =   DatosActa::select(DB::raw('distinct(g1acta.id) as idd'), 'g1acta.*')
                                    ->leftJoin('g1organigrama', 'g1organigrama.idct_escuela',  'id_ct')  
                                    ->where('g1organigrama.idct_supervicion', Auth::user()->id_ct)
                                    ->whereOconcluida(1)
                                    ->get();

            return view('admin.er.finalizadas.index3',
                compact('datosacta3','us')
                );


        }






    }








    public function show()
    {
            //$datosacta = DatosActa::get();
            $datosacta   = DatosActa::whereIdCtorigen(Auth::user()->id_ct)->paginate(10);

            return view('admin.er.finalizadas.show',
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
                                            g1acta.oconcluida=1 
                                        THEN 7

                                        END 
                                    WHEN g1acta.oopenanexo=1
                                    THEN 0
                                    END AS nivelavance')
                    )->leftJoin('g1acta', 'g1acta.id',  'id_acta')
                    ->whereIdActa($datosacta->id)->first();

            return view('admin.er.finalizadas.edit',
                    compact('anexos', 'documentos', 'datosacta', 'avanceanexos', 'avance', 'us')
                    );
    }



    

}
