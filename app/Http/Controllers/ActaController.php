<?php

namespace App\Http\Controllers;

use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

use App\Models\Intervencion;
use App\Models\CentrosTrabajo;
use App\Models\Plantilla;
use App\Models\Anexos;
use App\Models\Documentos;
use App\Models\Ordenamientojuridico;
use App\Models\Organitation;
use App\Models\Tipoacta;
use App\Models\DatosActa;
use App\Models\Avanceanexos;
use App\Models\User;
use App\Rules\SoloMayusculas;

class ActaController extends Controller
{
    public function index()
    {
        $us = Auth::user()->onivel === 'ELEMENTAL' ? 76 : 89;

        $tipoacta  = Tipoacta::get();
        $anexos    = Anexos::orderBy('onum_anexo', 'ASC')->get();
        $datosacta = DatosActa::whereIdUser(Auth::user()->id)->first();
        $ctts      = Organitation::where('cct_escuela', Auth::user()->emaill)
            ->orWhere('cct_sector', Auth::user()->email)
            ->orWhere('cct_supervision', Auth::user()->email)
            ->first();

        $intervencionPermitida = true;
        if (Auth::user()->orol == 3) {
            // Verificar si hay una intervención registrada por el superior inmediato
            // La intervención puede estar concluida (ofin=1) pero el proceso no finalizado
            // Cada solicitud y entrega es independiente, así que verificamos por intervención específica
            $intervencionExistente = Intervencion::where('idct_escuela', Auth::user()->id_ct)
                ->where('ogenerada', 1)
                ->whereNotIn('istatus', ['B'])
                ->orderBy('ofecha_realizacion', 'DESC') // Obtener la más reciente
                ->first();
            
            // Si no hay intervención, restringir acceso
            if (!$intervencionExistente) {
                $intervencionPermitida = false;
            } else {
                // Verificar si tiene un acta NO concluida (en curso) asociada a esta intervención
                // Solo las actas NO concluidas indican un proceso en curso
                $actaEnCurso = DatosActa::whereIdUser(Auth::user()->id)
                    ->where('id_ct', Auth::user()->id_ct)
                    ->where('oconcluida', 0) // Solo actas en curso
                    ->first();
                
                // Si hay acta en curso, verificar si el proceso está completamente finalizado
                // El proceso está finalizado cuando: ZIP cargado (ocargacomprimido=1) Y correo enviado (oenviocorreooic=1)
                if ($actaEnCurso) {
                    $procesoFinalizado = ($actaEnCurso->ocargacomprimido == 1 && 
                                         $actaEnCurso->oenviocorreooic == 1);
                    
                    // Restringir acceso solo si el proceso está completamente finalizado
                    // En ese caso, el registro vuelve a "Solicitud de intervención" y se necesita una nueva intervención
                    if ($procesoFinalizado) {
                        $intervencionPermitida = false;
                    }
                    // Si hay acta en curso y el proceso NO está finalizado, permitir acceso (continuar trabajo)
                }
                // Si NO hay acta en curso, permitir acceso (iniciar nueva entrega-recepción)
            }
        }

        if (Auth::user()->orol == 3) {
            $elacta     = DatosActa::whereIdUser(Auth::user()->id)->whereOconcluida(0)->first();
            $documentos = Documentos::get();


            if ($elacta) {
                $datosacta = DatosActa::select(
                    '*',
                    DB::raw("CASE
                        WHEN id_tipoacta=1 THEN
                            CASE WHEN onombre_entrega_a IS NOT NULL AND orfc_entrega_a IS NOT NULL AND ocargo_entrega_a IS NOT NULL
                                   AND onombre_recibe_a IS NOT NULL AND orfc_recibe_a IS NOT NULL AND ocargo_recibe_a IS NOT NULL
                                 THEN 1 ELSE 0 END
                        WHEN id_tipoacta=2 THEN
                            CASE WHEN onombre_recibe_ac IS NOT NULL AND orfc_recibe_ac IS NOT NULL
                                 THEN 1 ELSE 0 END
                    END AS ock"),
                    DB::raw("CASE
                        WHEN owaitacta=2 AND ocargaacta=0 AND ocargacomprimido=0 THEN 0
                        WHEN owaitacta=1 AND ocargaacta=1 AND ocargacomprimido=0 THEN 1
                        WHEN owaitacta=1 AND ocargaacta=1 AND ocargacomprimido=1 THEN 2
                    END AS avancez"),
                    DB::raw("CASE
                        WHEN ocargacomprimido=0 AND onombrecarpeta IS NULL AND ocorreocc IS NULL THEN 0
                        WHEN ocargacomprimido=1 AND onombrecarpeta IS NOT NULL AND ocorreocc IS NULL THEN 1
                        WHEN ocargacomprimido=1 AND onombrecarpeta IS NOT NULL AND ocorreocc IS NOT NULL THEN 2
                    END AS carpetacorreo")
                )->whereIdUser(Auth::user()->id)->whereOconcluida(0)->first();

                $avanceanexos = Avanceanexos::select(
                    '*',
                    DB::raw("CASE
                        WHEN omarco_juridico_d=1 AND orecursos_humanos_d=1 AND osituacion_recursos_materiales_d=1
                             AND osituacion_tics_d AND ocertificados_no_adeudos_d=1 AND oinforme_gestion_d=1
                             AND ootros_hechos_d=1
                        THEN 1 ELSE 0 END AS completado")
                )->whereIdActa($datosacta->id)->get();

                if ($datosacta->id_tipoacta == 2) {
                    $anexos = Anexos::whereNotIn('onum_anexo', [14, 15])->orderBy('onum_anexo', 'ASC')->get();
                    $avance = Avanceanexos::select(
                        '*',
                        DB::raw("CASE
                            WHEN omarco_juridico_d=1 AND orecursos_humanos_d=1 AND osituacion_recursos_materiales_d=1
                                 AND osituacion_tics_d AND oarchivos_d=1 AND ootros_hechos_d=1
                            THEN 1 ELSE 0 END AS completado")
                    )->whereIdActa($datosacta->id)->first();
                } else {
                    $anexos = Anexos::orderBy('onum_anexo', 'ASC')->get();
                    $avance = Avanceanexos::select(
                        '*',
                        DB::raw("CASE
                            WHEN omarco_juridico_d=1 AND orecursos_humanos_d=1 AND osituacion_recursos_materiales_d=1
                                 AND osituacion_tics_d AND oarchivos_d=1 AND ocertificados_no_adeudos_d=1
                                 AND oinforme_gestion_d=1 AND ootros_hechos_d=1
                            THEN 1 ELSE 0 END AS completado")
                    )->whereIdActa($datosacta->id)->first();
                }

                $ban = 1;
                return view('acta.index', compact(
                    'tipoacta','anexos','documentos','datosacta','avanceanexos','avance','ban','us','ctts','intervencionPermitida'
                ));
            }

            $ban = 0;
            return view('acta.index', compact('tipoacta','documentos','ban','us','ctts','intervencionPermitida'));
        }

        if (Auth::user()->orol <= 2) return redirect(url('entregas-recepcion'));
        return redirect(url('certificados-emitidos'));
    }

    public function store(Request $request)
    {
        // Validar que el usuario tenga una intervención generada (solo para rol 3)
        if (Auth::user()->orol == 3) {
            $intervencionExistente = Intervencion::where('idct_escuela', Auth::user()->id_ct)
                ->where('ogenerada', 1)
                ->whereNotIn('istatus', ['B'])
                ->orderBy('ofecha_realizacion', 'DESC')
                ->first();
            
            // Si no hay intervención, no permitir crear acta
            if (!$intervencionExistente) {
                return redirect()->route('entrega-recepcion.index')
                    ->with('error', 'No puedes iniciar el acto de entrega-recepción. Debes tener una solicitud de intervención generada por tu autoridad inmediata superior.');
            }
            
            // Verificar si tiene un acta NO concluida (en curso) asociada a esta intervención
            $actaEnCurso = DatosActa::whereIdUser(Auth::user()->id)
                ->where('id_ct', Auth::user()->id_ct)
                ->where('oconcluida', 0)
                ->first();
            
            // Si hay acta en curso, verificar si el proceso está completamente finalizado
            if ($actaEnCurso) {
                $procesoFinalizado = ($actaEnCurso->ocargacomprimido == 1 && 
                                     $actaEnCurso->oenviocorreooic == 1);
                
                // Si el proceso está completamente finalizado, no permitir crear nueva acta
                // Se necesita una nueva intervención
                if ($procesoFinalizado) {
                    return redirect()->route('entrega-recepcion.index')
                        ->with('error', 'El proceso de entrega-recepción anterior ha sido finalizado. Se requiere una nueva solicitud de intervención para iniciar un nuevo proceso.');
                }
            }
        }

        $datosacta = DatosActa::whereIdUser(Auth::user()->id)->whereOconcluida(0)->first();
        $datosCT   = CentrosTrabajo::whereKcvect(Auth::user()->id_ct)->first();

        $decide = Organitation::select('idct_direccion','idct_subdireccion','idct_departamento','idct_sector','idct_supervicion')
            ->where('idct_escuela', Auth::user()->id_ct)
            ->orWhere('idct_supervicion', Auth::user()->id_ct)
            ->orWhere('idct_sector', Auth::user()->id_ct)
            ->first();

        if (!$decide) {
            return back()->with('warning', 'No se encontró información organizacional para este centro de trabajo.');
        }

        if (!$datosacta) {
            DatosActa::create([
                'id_user'      => Auth::user()->id,
                'id_tipoacta'  => $request->tipoacta,
                'id_dir'       => $decide->idct_direccion,
                'id_sub'       => $decide->idct_subdireccion,
                'id_dep'       => $decide->idct_departamento,
                'id_sec'       => $decide->idct_sector,
                'id_sup'       => $decide->idct_supervicion,
                'id_ct'        => Auth::user()->id_ct,
                'oactual'      => 1,
                'ofecha'       => date('Y-m-d'),
                'oestado'      => 0,
                'oconcluida'   => 0,
                'oct_a'        => $datosCT->oclave,
                'oct_ac'       => $datosCT->oclave,
                'odomicilio_ct_a'  => $datosCT->odomicilio,
                'olugar_a'         => $datosCT->nombre_loc,
                'onombre_ct_a'     => $datosCT->onombre_ct,
                'onombre_ct_ac'    => $datosCT->onombre_ct,
                'odomicilio_ct_ac' => $datosCT->odomicilio,
                'olugar_ac'        => $datosCT->nombre_loc,
                'id_ctorigen'  => Auth::user()->id_ctorigen,
                'octorigen'    => Auth::user()->octorigen,
            ]);

            $nuevo = DatosActa::whereIdUser(Auth::user()->id)->whereOconcluida(0)->first();
            Avanceanexos::create([
                'id_acta' => $nuevo->id,
                'id_ct'   => $nuevo->id_ct,
                'oanio'   => date('Y-m-d'),
            ]);
        }

        return redirect(url('entrega-recepcion'))->with('success', 'SE HA ELEGIDO EL TIPO DE ACTA CORRECTAMENTE');
    }

    public function cambiarTipo()
    {
        // Eliminar el acta actual para permitir nueva selección
        $actaActual = DatosActa::whereIdUser(Auth::user()->id)->whereOconcluida(0)->first();
        
        if ($actaActual) {
            // Eliminar avances relacionados
            Avanceanexos::whereIdActa($actaActual->id)->delete();
            
            // Eliminar el acta
            $actaActual->delete();
        }

        return redirect(url('entrega-recepcion'))->with('success', 'PUEDES SELECCIONAR UN NUEVO TIPO DE ACTA.');
    }

    public function update(Request $request, $id)
    {
        if ($request->action == '1') {
            $acta = DatosActa::findOrFail($request->idacta);

            // Validar campos de texto con mayúsculas
            $request->validate([
                'onombre_entrega_a' => ['nullable', new SoloMayusculas],
                'ocargo_entrega_a' => ['nullable', new SoloMayusculas],
                'onombre_recibe_a' => ['nullable', new SoloMayusculas],
                'ocargo_recibe_a' => ['nullable', new SoloMayusculas],
                'onombre_recibe_ac' => ['nullable', new SoloMayusculas],
            ]);

            if ($acta->id_tipoacta == 1) {
                $acta->onombre_entrega_a = mb_strtoupper($request->onombre_entrega_a, 'UTF-8');
                $acta->orfc_entrega_a    = $request->orfc_entrega_a;
                $acta->ocargo_entrega_a  = mb_strtoupper($request->ocargo_entrega_a, 'UTF-8');
                $acta->onombre_recibe_a  = mb_strtoupper($request->onombre_recibe_a, 'UTF-8');
                $acta->orfc_recibe_a     = $request->orfc_recibe_a;
                $acta->ocargo_recibe_a   = mb_strtoupper($request->ocargo_recibe_a, 'UTF-8');
            } elseif ($acta->id_tipoacta == 2) {
                $acta->onombre_recibe_ac = mb_strtoupper($request->onombre_recibe_ac, 'UTF-8');
                $acta->orfc_recibe_ac    = $request->orfc_recibe_ac;
            }

            $acta->oactual = 1;
            $acta->ocheck  = 1;
            $acta->ocodigo_verificacion = base64_encode(url('validation-qr/'.$request->idacta.'/edit'));
            $acta->save();

            return redirect(url('entrega-recepcion'))->with('success', 'SE REGISTRÓ LA INFORMACIÓN DEL ACTA.');
        }

        if ($request->action == '2') {
            $user          = User::find(Auth::user()->id);
            $centrotrabajo = CentrosTrabajo::whereKcvect($user->id_ct)->first();
            $elct          = $centrotrabajo->oclave;
            $idacta        = $request->idacta;
            $tipoacta      = $request->tipoacta;

            $request->validate([
                'onombre_archivo' => ['required','file','mimes:pdf','max:51200'], // 50 MB
            ], ['onombre_archivo.required' => 'Debes seleccionar un archivo PDF.']);

            if ($request->hasFile('onombre_archivo')) {
                $file = $request->file('onombre_archivo');
                $file->storeAs("actas-entregadas/$elct/$tipoacta/$idacta", 'SCAN-ACTA.pdf', 'public');

                $acta = DatosActa::findOrFail($idacta);
                $acta->ourl_acta  = "actas-entregadas/$elct/$tipoacta/$idacta/SCAN-ACTA.pdf";
                $acta->ocargaacta = 1;
                $acta->owaitacta  = 1;
                $acta->save();

                Avanceanexos::whereIdActa($idacta)->update(['ocargaacta' => 1]);

                return back()->with('success', 'ARCHIVO DEL ACTA CARGADO.');
            }

            return back()->with('warning', 'No se cargó ningún archivo.');
        }

        if ($request->action == '50') {
            $acta = DatosActa::findOrFail($request->idacta);
            $ctt  = $acta->id_tipoacta == 1 ? $acta->oct_a : $acta->oct_ac;

            $request->validate([
                'onombre_archivo' => [
                    'required','file','max:512000', // 500 MB
                    'mimetypes:application/zip,application/x-zip,application/x-zip-compressed,application/x-rar,application/vnd.rar'
                ],
            ]);

            if ($request->hasFile('onombre_archivo')) {
                $file   = $request->file('onombre_archivo');
                $nombre = $acta->id.'.'.$file->extension();

                $file->storeAs("carpeta-entrega-recepcion/$ctt", $nombre, 'public');

                DatosActa::whereId($acta->id)->update([
                    'ocargacomprimido' => 1,
                    'ourlcarpeta'      => "carpeta-entrega-recepcion/$ctt/",
                    'onombrecarpeta'   => $nombre,
                ]);
                Avanceanexos::whereIdActa($acta->id)->update(['ocargacomprimido' => 1]);

                return back()->with('success', 'CARPETA CARGADA. AHORA ENVÍA EL CORREO AL OIC.');
            }

            return back()->with('warning', 'No se cargó ningún archivo.');
        }

        if ($request->action == '60') {
            // 1) Validaciones mínimas del correo copia
            if ($request->filled('correocopia2') && $request->correocopia !== $request->correocopia2) {
                return back()->with('warning', 'Los correos no coinciden');
            }
            if (!filter_var($request->correocopia, FILTER_VALIDATE_EMAIL)) {
                return back()->with('warning', 'Correo inválido');
            }

            // 2) Guardado de datos finales
            $acta = \App\Models\DatosActa::findOrFail($request->idacta);
            \App\Models\DatosActa::whereId($acta->id)->update([
                'ocorreocc' => $request->correocopia,
                'ofechafin' => date('Y-m-d'),
            ]);
            \App\Models\Avanceanexos::whereIdActa($acta->id)->update(['ofinalizacion' => 1]);

            $datosacta = \App\Models\DatosActa::find($acta->id);
            $oky = 0;
            try {
                ob_start();
                include resource_path('views/send-mails/index.php'); 
                ob_end_clean();
            } catch (\Throwable $e) {
                $oky = 0;
            }

            // 4) Resultado y flags
            if ((int)$oky === 1) {
                // Verificar que el ZIP esté cargado antes de marcar como finalizado
                // El proceso solo se considera finalizado cuando: ZIP cargado (ocargacomprimido=1) Y correo enviado (oenviocorreooic=1)
                $actaActualizada = \App\Models\DatosActa::find($acta->id);
                
                if ($actaActualizada && $actaActualizada->ocargacomprimido == 1) {
                    // Marcar acta como concluida y correo enviado (proceso completamente finalizado)
                    \App\Models\DatosActa::whereId($acta->id)->update([
                        'oenviocorreooic' => 1,
                        'oconcluida'      => 1,
                    ]);
                    
                    // Marcar avances como finalizados
                    \App\Models\Avanceanexos::whereIdActa($acta->id)->update(['ofinalizacion' => 1]);
                    
                    // Cerrar intervención para este centro de trabajo
                    // Solo cuando el proceso está completamente finalizado (ZIP + correo enviado)
                    // El registro vuelve al estado "Solicitud de intervención" (ofin=1)
                    // para permitir iniciar un nuevo ciclo si se requiere
                    \App\Models\Intervencion::where('idct_escuela', $acta->id_ct)
                        ->where('ogenerada', 1)
                        ->whereNotIn('istatus', ['B'])
                        ->update(['ofin' => 1]);
                    
                    return redirect('entrega-recepcion')->with('success', 'SE HA ENVIADO EL ACTA DE ENTREGA Y RECEPCIÓN Y SUS ANEXOS AL ÓRGANO INTERNO DE CONTROL. SE HA CONCLUIDO EXITOSAMENTE EL ACTA DE ENTREGA Y RECEPCIÓN.');
                } else {
                    // El ZIP no está cargado, no se puede finalizar el proceso
                    return redirect('entrega-recepcion')->with('error', 'Debes cargar primero el archivo ZIP antes de enviar el correo.');
                }
            } else {
                return redirect('entrega-recepcion')->with('error', 'No se pudo enviar el correo al OIC.');
            }
        }
    }

    public function solicitarIntervencion(Request $request)
    {
        $request->validate(['acta_id' => ['nullable','integer']]);

        $user   = Auth::user();
        $actaId = $request->input('acta_id');

        $to = config('mail.autoridad_intervencion');
        if (empty($to)) return back()->with('error', 'Falta configurar AUTORIDAD_INTERVENCION.');

        $ct  = CentrosTrabajo::whereKcvect($user->id_ct)->first();
        $cte = $ct ? ($ct->oclave.' - '.$ct->onombre_ct) : 'CT no identificado';

        $subject = "Solicitud de intervención – {$cte}";
        $body = view('emails.plain_intervencion', [
            'usuario' => $user,
            'actaId'  => $actaId,
            'cte'     => $cte,
            'url'     => url('/solicitud-intervencion'),
        ])->render();

        try {
            Mail::send([], [], function ($message) use ($to, $subject, $body) {
                $message->to($to)->subject($subject)->setBody($body, 'text/html');
            });
        } catch (\Throwable $e) {
            return back()->with('error', 'No se pudo enviar el correo: '.$e->getMessage());
        }

        return back()->with('success', 'SOLICITUD DE INTERVENCIÓN ENVIADA.');
    }
}
