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

/**
 * Controlador para la gestión de actas de entrega-recepción
 * 
 * Maneja la creación, validación y finalización de actas.
 * Controla el flujo completo desde la solicitud hasta la conclusión del proceso.
 */
class ActaController extends Controller
{
    /**
     * Muestra el formulario inicial para crear una nueva acta
     * 
     * Para usuarios rol 3:
     * - Si hay acta en curso, siempre permite acceso (prioridad sobre intervención)
     * - Si NO hay acta en curso, requiere intervención activa para iniciar nueva acta
     * 
     * @return \Illuminate\View\View
     */
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
            // REGLA DE PRIORIDAD: Primero verificar si hay acta en curso
            $elacta = DatosActa::whereIdUser(Auth::user()->id)
                ->where('id_ct', Auth::user()->id_ct)
                ->where('oconcluida', 0)
                ->first();
            
            // Si hay acta en curso, SIEMPRE permitir acceso (sin importar estado de intervención)
            if ($elacta) {
                $intervencionPermitida = true;
            } else {
                // Si NO hay acta en curso, verificar intervención activa para iniciar nueva acta
                // Verificar si hay acta concluida completamente (ZIP + correo enviado)
                $actaConcluida = DatosActa::whereIdUser(Auth::user()->id)
                    ->where('id_ct', Auth::user()->id_ct)
                    ->where('oconcluida', 1)
                    ->where('oenviocorreooic', 1)
                    ->where('ocargacomprimido', 1)
                    ->exists();
                
                // Buscar intervención activa:
                // 1. Intervención no finalizada (ofin=0) - siempre permite crear acta
                // 2. Intervención finalizada (ofin=1) con oficio pero SIN acta concluida - permite crear acta
                $intervencionExistente = Intervencion::where('idct_escuela', Auth::user()->id_ct)
                    ->where('ogenerada', 1)
                    ->whereNotIn('istatus', ['B'])
                    ->where(function($query) use ($actaConcluida) {
                        // Intervención no finalizada
                        $query->where('ofin', 0)
                              // O intervención finalizada con oficio pero sin acta concluida
                              ->orWhere(function($q) use ($actaConcluida) {
                                  if (!$actaConcluida) {
                                      $q->where('ofin', 1)
                                        ->whereNotNull('ooficio')
                                        ->where('ooficio', '!=', '');
                                  }
                              });
                    })
                    ->orderBy('ofecha_realizacion', 'DESC')
                    ->first();
                
                // Si no hay intervención activa, bloquear creación de nueva acta
                if (!$intervencionExistente) {
                    $intervencionPermitida = false;
                }
            }
            
            // Limpieza: Si hay acta concluida, asegurar que la intervención asociada esté finalizada
            $actaConcluida = DatosActa::whereIdUser(Auth::user()->id)
                ->where('id_ct', Auth::user()->id_ct)
                ->where('oconcluida', 1)
                ->where('oenviocorreooic', 1)
                ->where('ocargacomprimido', 1)
                ->orderBy('ofechafin', 'DESC')
                ->first();
            
            if ($actaConcluida) {
                $intervencionAsociada = Intervencion::where('idct_escuela', Auth::user()->id_ct)
                    ->where('ogenerada', 1)
                    ->whereNotIn('istatus', ['B'])
                    ->orderBy('ofecha_realizacion', 'DESC')
                    ->first();
                
                if ($intervencionAsociada && $intervencionAsociada->ofin == 0) {
                    Intervencion::where('id', $intervencionAsociada->id)
                        ->update(['ofin' => 1]);
                }
            }
        }

        if (Auth::user()->orol == 3) {
            $elacta     = DatosActa::whereIdUser(Auth::user()->id)->whereOconcluida(0)->first();
            $documentos = Documentos::get();

            // VALIDACIÓN: Solo bloquear si NO hay acta en curso Y NO hay intervención activa
            if (!$intervencionPermitida) {
                $ban = 0;
                return view('acta.index', compact('tipoacta','documentos','ban','us','ctts','intervencionPermitida'));
            }

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

    /**
     * Crea una nueva acta de entrega-recepción
     * 
     * Valida permisos y crea el registro inicial del acta según el tipo seleccionado.
     * Inicializa también el registro de avance de anexos.
     * 
     * Para usuarios rol 3:
     * - Si hay acta en curso, no permite crear nueva (debe continuar la existente)
     * - Si NO hay acta en curso, requiere intervención activa para crear nueva acta
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validación solo para usuarios rol 3
        if (Auth::user()->orol == 3) {
            // REGLA DE PRIORIDAD: Primero verificar si hay acta en curso
            $actaEnCurso = DatosActa::whereIdUser(Auth::user()->id)
                ->where('id_ct', Auth::user()->id_ct)
                ->where('oconcluida', 0)
                ->first();
            
            // Si hay acta en curso, no permitir crear una nueva
            if ($actaEnCurso) {
                return redirect()->route('entrega-recepcion.index')
                    ->with('error', 'Ya tienes un acta de entrega-recepción en curso. Debes continuar trabajando en ella o finalizarla antes de crear una nueva.');
            }
            
            // Si NO hay acta en curso, validar que exista intervención activa para crear nueva acta
            // Verificar si hay acta concluida completamente (ZIP + correo enviado)
            $actaConcluida = DatosActa::whereIdUser(Auth::user()->id)
                ->where('id_ct', Auth::user()->id_ct)
                ->where('oconcluida', 1)
                ->where('oenviocorreooic', 1)
                ->where('ocargacomprimido', 1)
                ->exists();
            
            // Buscar intervención activa:
            // 1. Intervención no finalizada (ofin=0) - siempre permite crear acta
            // 2. Intervención finalizada (ofin=1) con oficio pero SIN acta concluida - permite crear acta
            $intervencionExistente = Intervencion::where('idct_escuela', Auth::user()->id_ct)
                ->where('ogenerada', 1)
                ->whereNotIn('istatus', ['B'])
                ->where(function($query) use ($actaConcluida) {
                    // Intervención no finalizada
                    $query->where('ofin', 0)
                          // O intervención finalizada con oficio pero sin acta concluida
                          ->orWhere(function($q) use ($actaConcluida) {
                              if (!$actaConcluida) {
                                  $q->where('ofin', 1)
                                    ->whereNotNull('ooficio')
                                    ->where('ooficio', '!=', '');
                              }
                          });
                })
                ->orderBy('ofecha_realizacion', 'DESC')
                ->first();
            
            // Si no hay intervención activa, no permitir crear nueva acta
            if (!$intervencionExistente) {
                return redirect()->route('entrega-recepcion.index')
                    ->with('error', 'No puedes iniciar el acto de entrega-recepción. Debes tener una solicitud de intervención generada por tu autoridad inmediata superior.');
            }
            
            // Limpieza: Si hay acta concluida, asegurar que la intervención asociada esté finalizada
            $actaConcluida = DatosActa::whereIdUser(Auth::user()->id)
                ->where('id_ct', Auth::user()->id_ct)
                ->where('oconcluida', 1) // Actas finalizadas
                ->where('oenviocorreooic', 1) // Con correo enviado
                ->where('ocargacomprimido', 1) // Con ZIP cargado
                ->orderBy('ofechafin', 'DESC')
                ->first();
            
            if ($actaConcluida) {
                // Buscar la intervención asociada a esta acta concluida
                $intervencionAsociada = Intervencion::where('idct_escuela', Auth::user()->id_ct)
                    ->where('ogenerada', 1)
                    ->whereNotIn('istatus', ['B'])
                    ->orderBy('ofecha_realizacion', 'DESC')
                    ->first();
                
                // Si la intervención NO está finalizada, marcarla como finalizada
                if ($intervencionAsociada && $intervencionAsociada->ofin == 0) {
                    Intervencion::where('id', $intervencionAsociada->id)
                        ->update(['ofin' => 1]);
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

    /**
     * Actualiza datos del acta según la acción solicitada
     * 
     * Acciones disponibles:
     * - action=1: Actualiza datos básicos (nombres, RFCs) y genera código QR
     * - action=2: Carga archivo PDF del acta escaneada
     * - action=50: Carga carpeta comprimida (ZIP/RAR)
     * - action=60: Envía correo al OIC y finaliza el proceso
     * 
     * @param Request $request
     * @param int $id ID del acta
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        if ($request->action == '1') {
            $acta = DatosActa::findOrFail($request->idacta);

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
            $acta = \App\Models\DatosActa::findOrFail($request->idacta);
            if ($acta->ocargacomprimido != 1) {
                return back()->with('error', 'DEBES CARGAR PRIMERO EL ARCHIVO COMPRIMIDO (ZIP/RAR) ANTES DE ENVIAR EL CORREO.');
            }
            
            if ($request->filled('correocopia2') && $request->correocopia !== $request->correocopia2) {
                return back()->with('warning', 'Los correos no coinciden');
            }
            if (!filter_var($request->correocopia, FILTER_VALIDATE_EMAIL)) {
                return back()->with('warning', 'Correo inválido');
            }

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
                    // Preparar datos de actualización
                    // IMPORTANTE: Siempre marcar como finalizada (oconcluida = 1) y notificada (oenviocorreooic = 1)
                    // La fecha y hora se guardan usando la fecha/hora actual si no existen
                    $fechaFinalizacion = now()->format('Y-m-d');
                    $horaFinalizacion = now()->format('H:i');
                    
                    $updateData = [
                        'oenviocorreooic' => 1,
                        'oconcluida'      => 1,
                    ];
                    
                    // Guardar fecha y hora de finalización si no existen
                    // Para actas tipo 1 (ACTA DE ENTREGA Y RECEPCIÓN)
                    if ($actaActualizada->id_tipoacta == 1) {
                        if (empty($actaActualizada->ofecha_fin_a)) {
                            $updateData['ofecha_fin_a'] = $fechaFinalizacion;
                        }
                        if (empty($actaActualizada->ohora_fin_a)) {
                            $updateData['ohora_fin_a'] = $horaFinalizacion;
                        }
                    }
                    // Para actas tipo 2 (ACTA CIRCUNSTANCIADA)
                    elseif ($actaActualizada->id_tipoacta == 2) {
                        if (empty($actaActualizada->ofecha_fin_ac)) {
                            $updateData['ofecha_fin_ac'] = $fechaFinalizacion;
                        }
                        if (empty($actaActualizada->ohora_fin_ac)) {
                            $updateData['ohora_fin_ac'] = $horaFinalizacion;
                        }
                    }
                    
                    // Marcar acta como concluida y correo enviado (proceso completamente finalizado)
                    // Actualizar en una sola operación para asegurar integridad de datos
                    try {
                        \App\Models\DatosActa::whereId($acta->id)->update($updateData);
                        
                        // Verificar que se guardó correctamente
                        $actaVerificada = \App\Models\DatosActa::find($acta->id);
                        if (!$actaVerificada || $actaVerificada->oconcluida != 1 || $actaVerificada->oenviocorreooic != 1) {
                            throw new \Exception('Error al guardar el estado de finalización del acta');
                        }
                        
                        \Log::info('Acta finalizada y notificada correctamente desde ActaController', [
                            'acta_id' => $acta->id,
                            'id_ct' => $acta->id_ct,
                            'fecha_fin' => $fechaFinalizacion
                        ]);
                        
                        // Marcar avances como finalizados
                        \App\Models\Avanceanexos::whereIdActa($acta->id)->update(['ofinalizacion' => 1]);
                    
                        // Cerrar TODAS las intervenciones activas para este centro de trabajo
                        // Solo cuando el proceso está completamente finalizado (ZIP + correo enviado)
                        // IMPORTANTE: Solo marcar como finalizadas las intervenciones que aún NO están finalizadas (ofin=0)
                        // El registro vuelve al estado "Solicitud de intervención" (ofin=1)
                        // El CCT queda bloqueado hasta que se genere una nueva solicitud de intervención
                        \App\Models\Intervencion::where('idct_escuela', $acta->id_ct)
                            ->where('ogenerada', 1)
                            ->where('ofin', 0) // Solo intervenciones NO finalizadas
                            ->whereNotIn('istatus', ['B'])
                            ->update(['ofin' => 1]);
                        
                        return redirect('entrega-recepcion')->with('success', 'SE HA ENVIADO EL ACTA DE ENTREGA Y RECEPCIÓN Y SUS ANEXOS AL ÓRGANO INTERNO DE CONTROL. SE HA CONCLUIDO EXITOSAMENTE EL ACTA DE ENTREGA Y RECEPCIÓN.');
                    } catch (\Exception $e) {
                        \Log::error('Error al finalizar acta desde ActaController', [
                            'acta_id' => $acta->id,
                            'id_ct' => $acta->id_ct,
                            'error' => $e->getMessage(),
                            'trace' => $e->getTraceAsString()
                        ]);
                        return redirect('entrega-recepcion')->withErrors('Error al finalizar el acta. Por favor, contacte al administrador.');
                    }
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
        // Este método está disponible pero no se muestra en la UI para rol 3
        // La solicitud de intervención debe ser realizada por rol 2 desde el módulo "Solicitudes de intervención"
        // Se mantiene por compatibilidad pero no debería ser usado por rol 3
        
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
