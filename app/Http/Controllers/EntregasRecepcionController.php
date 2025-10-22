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
use App\Models\Intervencion;


class EntregasRecepcionController extends Controller
{


    public function index()
    {
        $user = Auth::user();

        //  si es entregador (orol == 1), necesita intervención generada y activa
        if ($user->orol == 1) {
            $intervencionActiva = Intervencion::where('idct_escuela', $user->id_ct)
                ->where('ogenerada', 1)
                ->where('ofin', 0)
                ->where('istatus', '!=', 'B')
                ->exists();

            if (!$intervencionActiva) {
                return redirect()->route('home')->with('error', 'Para acceder a Entrega-Recepción, primero debe solicitarse y aprobarse una intervención por el revisor.');
            }
        }


        $us = ($user->onivel == 'ELEMENTAL') ? 76 : 89;


        // Manejar usuarios con orol == 1 (entregadores)
        if ($user->orol == 1) {
            // Para usuarios con role_id 1, mostrar todas las entregas-recepción
            $datosacta = DatosActa::distinct()->select('g1acta.id', 'g1acta.id_user','g1acta.id_tipoacta','g1acta.id_ct',
                'g1acta.oconcluida','g1acta.ocargacomprimido','g1acta.ocheckactaa','g1acta.owaitacta','g1acta.oestado',
                'g1acta.oopenanexo','g1acta.oenviocorreooic','g1acta.ourlcarpeta','g1acta.onombrecarpeta',
                'g1acta.created_at','g1acta.updated_at',
                'g1ct.oclave','g1ct.onombre_ct','g1ct.odomicilio','g1ct.otelefono','g1ct.ocorreo',
                'g1tipoacta.otipoacta','g1tipoacta.odescripcion',
                'g1user.name','g1user.email',
                DB::raw('CASE 
                    WHEN g1acta.oconcluida=1 AND g1acta.ocargacomprimido=1
                    THEN "SE REVISO Y CONCLUYÓ EL PROCESO DE ENTREGA-RECEPCIÓN"
                    WHEN g1acta.oopenanexo=1
                    THEN "¡¡ATENCIÓN!! ANEXO ABIERTO, DEBE FINALIZARSE ESTE ANEXO PARA CONTINUAR"
                    END AS estadoacta'))
            ->join('g1ct', 'g1acta.id_ct', '=', 'g1ct.kcvect')
            ->join('g1tipoacta', 'g1acta.id_tipoacta', '=', 'g1tipoacta.id')
            ->join('g1user', 'g1acta.id_user', '=', 'g1user.id')
            ->orderBy('g1acta.created_at', 'DESC')
            ->paginate(10);

            return view('admin.er.index', compact('datosacta', 'us'));
        }

        switch ($user->ocargo) {
            case 'DIRECCIÓN':
                require_once 'controllers/entregas/iniciadas/01direccion.php';
                return view('admin.er.index', compact('datosacta', 'datosacta2', 'datosacta3', 'us'));

            case 'SUBDIRECCIÓN':
                require_once 'controllers/entregas/iniciadas/02subdireccion.php';
                return view('admin.er.index', compact('datosacta', 'datosacta2', 'datosacta3', 'us'));

            case 'DEPARTAMENTO':
                require_once 'controllers/entregas/iniciadas/03departamento.php';
                return view('admin.er.index', compact('datosacta', 'datosacta2', 'datosacta3', 'us'));

            case 'SECTOR':
                require_once 'controllers/entregas/iniciadas/04sector.php';
                return view('admin.er.02-ab', compact('datosacta2', 'datosacta3', 'us'));

            case 'SUPERVISIÓN':
                require_once 'controllers/entregas/iniciadas/05supervision.php';
                return view('admin.er.03-ab', compact('datosacta3', 'us'));

            default:
                return redirect()->route('home')->with('error', 'No tiene permisos para acceder a esta sección.');
        }
    }
       public function solicitarIntervencion(Request $request)
{
    $usuario = auth()->user();
    $actaId  = $request->input('acta_id');

    $path = base_path('send-mails/correos.php');
    if (!file_exists($path)) {
        return back()->with('error', 'No se encontró el módulo legacy de correos (send-mails/correos.php).');
    }

    require_once $path;

    // TODO: ajusta al nombre real de la función dentro de correos.php
    if (!function_exists('enviar_intervencion_elemental')) {
        return back()->with('error', 'La función enviar_intervencion_elemental no existe en correos.php.');
    }

    // Pasa los datos que tu script espere
    $ok = enviar_intervencion_elemental([
        'ct'      => $usuario->id_ct,
        'usuario' => ['nombre' => $usuario->name, 'email' => $usuario->email],
        'acta_id' => $actaId,
    ]);

    return back()->with($ok ? 'success' : 'error', $ok ? 'Solicitud enviada.' : 'No se pudo enviar el correo.');
}
    public function edit(string $id)
    {
        if(Auth::user()->onivel=='ELEMENTAL'){
            $us=76;
        }else if(Auth::user()->onivel=='SECUNDARIA'){
            $us=89;
        }

        $documentos     = Documentos::get();
        $datosacta      = DatosActa::whereId($id)->first();
        $avanceanexos   = Avanceanexos::whereIdActa($id)->get();

        if($datosacta->id_tipoacta==2){
            $anexos = Anexos::whereNotIn('onum_anexo', [14,15])->OrderBy('onum_anexo', 'ASC')->get();
        }else if($datosacta->id_tipoacta==1){
            $anexos  = Anexos::OrderBy('onum_anexo', 'ASC')->get();
        }

        require_once 'controllers/entregas/iniciadas/edit/index.php';

        return view('admin.er.edit',
            compact('anexos', 'documentos', 'datosacta', 'avanceanexos', 'avance', 'us')
        );
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
                                                        THEN "SE SUBÝO LA CARPETA DE ARCHIVOS. (¡¡SE ESPERA SU APROBACIÓN FINAL!!)"

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


    public function update(Request $request, string $id)
    {
        if($request->action=='1')
        {
            $avances_acta = DatosActa::whereId($request->idacta);
            $avances_acta->update(['ocheckactaa'=> 1, 'owaitacta' => 1]);

            $avances_plantilla = Avanceanexos::whereIdActa($request->idacta);
            $avances_plantilla->update(['ocheckacta'=> 1,]);

            return redirect()->back()
                ->with('success', 'Se aprobó al C.T para poder cargar el acta escaneada y firmadaa');

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
                ->with('success', 'Se aperturó el anexo: '.$doc->onum_documento.' - '.$doc->odocumento);

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
