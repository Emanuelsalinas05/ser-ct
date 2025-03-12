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

class EntregasRecepcionHistoricoController extends Controller
{
    public function index()
    {
        $actas     = DatosActa::whereIdCt(Auth::user()->id_ct)->whereOconcluida(1)->OrderBy('id', 'DESC')->first();
        $getHistor = DatosActa::whereIdCt(Auth::user()->id_ct)->whereOconcluida(1)->count();
        
        return view('entregas.index',
                compact('actas','getHistor')
                );
    }




    public function edit(string $id)
    {
        $documentos  = Documentos::get();

        $datosacta   = DatosActa::whereId($id)->first();

        $avanceanexos = Avanceanexos::whereIdActa($id)->get();
        
        if(Auth::user()->onivel=='ELEMENTAL'){
            $us=76;
        }else if(Auth::user()->onivel=='SECUNDARIA'){
            $us=89;
        }
        
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

        return view('entregas.edit',
                compact('anexos', 'documentos', 'datosacta', 'avanceanexos', 'avance', 'us',)
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
                    $opersonal->update([ 'ofinalizacion' => 1 ]);
                }else if($request->idoc=='3'){
                    $ocomisionados = Plantillacomisionados::whereIdActa($request->idacta);
                    $ocomisionados->update([ 'ofinalizacion' => 1 ]);
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
