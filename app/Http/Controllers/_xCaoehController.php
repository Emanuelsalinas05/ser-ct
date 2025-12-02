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

use App\Models\Tipoacta;
use App\Models\DatosActa;
use App\Models\Avanceanexos;
use App\Models\User;
use App\Models\Rolesusers;
use App\Models\Solicitudnoadeudo;
use App\Models\Tiposnoadeudo;

class _xCaoehController extends Controller
{


    public function index()
    {
            $nivel  =   Auth::user()->onivel  ;
            $idctt  =   Auth::user()->id_ct;
            $org    =   Organitation::where('idct_direccion',Auth::user()->id_ct)
                        ->orWhere('idct_subdireccion',Auth::user()->id_ct)
                        ->orWhere('idct_departamento',Auth::user()->id_ct)
                        ->orWhere('idct_sector',Auth::user()->id_ct)
                        ->orWhere('idct_supervicion',Auth::user()->id_ct)
                        ->orWhere('idct_escuela',Auth::user()->id_ct)
                        ->first();

            // Validar existencia de $org para evitar errores fatales
            if (!$org && (Auth::user()->orol == 2)) {
                return redirect()->back()->withErrors("No se encontró información organizacional para este usuario.");
            }

            // Inicializar $res para evitar errores si $org es null
            $res = null;
            if ($org) {
                if($org->idct_direccion==Auth::user()->id_ct){
                    $res = 'id_dir';
                }else if($org->idct_subdireccion==Auth::user()->id_ct){
                    $res = 'id_sub';
                }else if($org->idct_departamento==Auth::user()->id_ct){
                    $res = 'id_dep';
                }else if($org->idct_sector==Auth::user()->id_ct){
                    $res = 'id_sec';
                }else if($org->idct_supervicion==Auth::user()->id_ct){
                    $res = 'id_sup';
                }
            }

            $solicitudesc= Solicitudnoadeudo::whereIdTipocert(2) 
                            ->where('ogenerado',1) 
                            ->where('oentregado',1)
                            ->where('oadg', 1)
                            ->where('odee', 1)
                            ->where('ocaoe', 0)
                            ->whereOdir(Auth::user()->onivel)->count();


        if(Auth::user()->orol==99 || Auth::user()->orol==1)
        {
                $solicitudes = Solicitudnoadeudo::select('*',  DB::raw('date_format(ofecha_adg, "%d-%m-%Y") as fechadg'))
                                ->whereIdTipocert(2)
                                ->where('ogenerado',1) 
                                ->where('oentregado',1)
                                ->where('oadg', 1)
                                ->where('odee', 1)
                                ->where('ocaoe', 0)
                                ->whereOdir('ELEMENTAL')
                                ->OrderBY('ofecha_adg', 'DESC')
                                ->OrderBY('id_sub', 'ASC')
                                ->OrderBY('id_dep', 'ASC')
                                ->get();

        }else if(Auth::user()->orol==2){
                // Si $res ya fue determinado arriba, usarlo
                if (!$res) {
                    if ($org) {
                        if($org->idct_direccion==Auth::user()->id_ct){
                            $res = 'id_dir';
                        }else if($org->idct_subdireccion==Auth::user()->id_ct){
                            $res = 'id_sub';
                        }else if($org->idct_departamento==Auth::user()->id_ct){
                            $res = 'id_dep';
                        }else if($org->idct_sector==Auth::user()->id_ct){
                            $res = 'id_sec';
                        }else if($org->idct_supervicion==Auth::user()->id_ct){
                            $res = 'id_sup';
                        }
                    }
                }

                if ($res) {
                    $solicitudes = Solicitudnoadeudo::select('*',  DB::raw('date_format(ofecha_adg, "%d-%m-%Y") as fechadg'))
                                    ->whereIdTipocert(2)
                                    ->where('ogenerado',1) 
                                    ->where('oentregado',1)
                                    ->where('oadg', 1)
                                    ->where('odee', 1)
                                    ->where('ocaoe', 0)
                                    ->whereOdir(Auth::user()->onivel)
                                    ->where($res, Auth::user()->id_ct)
                                    ->whereOdir('ELEMENTAL')
                                    ->OrderBY('ofecha_adg', 'DESC')
                                    ->OrderBY('id_sub', 'ASC')
                                    ->OrderBY('id_dep', 'ASC')
                                    ->get();
                } else {
                    $solicitudes = collect();
                }
        }

        return view('caoe.historico.index',
                compact('solicitudesc','solicitudes',)
                );
    }

    
    public function update(Request $request, string $id)
    {
            // Validar que la solicitud existe
            $solicitud = Solicitudnoadeudo::find($id);
            if (!$solicitud) {
                return redirect()->back()->withErrors("Solicitud no encontrada.");
            }

            $update_solicitudes = Solicitudnoadeudo::whereId($id);
            $update_solicitudes->update([ 
                                            'oficio'        => $request->oficio ,
                                            'olugar_fecha'  => date('Y-m-d') ,
                                            'orubrica'      => $request->orubrica ,
                                            'ocaoe'         => 1 , 
                                            'oliberado'     => 1 , 
                                        ]); 

            // Enviar correo cuando se libera el certificado
            $this->enviarCorreoCertificadoLiberado($id, $request);

            return redirect()->back()->with("success", "Se ha emitido el oficio de Certificado de No Adeudo");
    }

    /**
     * Envía correo de notificación cuando se libera el certificado de no adeudo
     */
    private function enviarCorreoCertificadoLiberado($solicitudId, $request)
    {
        try {
            \Log::info('Iniciando envío de correo certificado liberado', ['solicitud_id' => $solicitudId]);
            
            // Obtener datos de la solicitud
            $solicitud = Solicitudnoadeudo::find($solicitudId);
            if (!$solicitud) {
                \Log::error('Solicitud no encontrada', ['solicitud_id' => $solicitudId]);
                return false;
            }

            // Obtener datos del centro de trabajo
            $ct = CentrosTrabajo::whereKcvect($solicitud->id_ct)->first();
            if (!$ct) {
                \Log::error('Centro de trabajo no encontrado', ['id_ct' => $solicitud->id_ct]);
                return false;
            }

            // Obtener datos del usuario que hizo la solicitud
            $usuario = User::where('id_ct', $solicitud->id_ct)->first();
            if (!$usuario) {
                \Log::error('Usuario no encontrado', ['id_ct' => $solicitud->id_ct]);
                return false;
            }

            // Obtener datos organizacionales
            $org = Organitation::where('idct_escuela', $solicitud->id_ct)
                ->orWhere('idct_supervicion', $solicitud->id_ct)
                ->orWhere('idct_sector', $solicitud->id_ct)
                ->first();

            if (!$org) {
                \Log::error('Organización no encontrada', ['id_ct' => $solicitud->id_ct]);
                return false;
            }

            // Obtener tipo de certificado
            // NOTA: id_tipocert se relaciona con oorden, no con id
            $tipoCert = Tiposnoadeudo::where('oorden', $solicitud->id_tipocert)->first();

            // Preparar datos para el correo
            $getct = $ct;
            $getoficio = (object) [
                'ocorreo' => $org->ocorreo ?? 'modernizacion.administrativa@dee.edu.mx'
            ];

            // Variables para el correo
            $request->onombre_solicitante = $usuario->name ?? 'Usuario';
            $request->tipo_certificado = $tipoCert->onombre ?? 'Certificado de No Adeudo';
            $request->ofecha = $solicitud->ofecha ?? date('Y-m-d');
            $request->onumero_oficio = $solicitud->onumero_oficio ?? '';
            $request->oficio_liberado = $solicitud->oficio ?? '';
            $request->solicitud_id = $solicitudId;
            $request->id_ct = $solicitud->id_ct;
            $request->estado = 'LIBERADO'; // Indicar que el certificado está liberado

            // Incluir el archivo de envío de correos
            $path = base_path('public/send-mails/certificado-noadeudo/index.php');
            \Log::info('Ruta del archivo de correo liberado', ['path' => $path, 'exists' => file_exists($path)]);
            
            if (file_exists($path)) {
                ob_start();
                include $path;
                $result = ob_get_clean();
                
                \Log::info('Resultado del envío de correo certificado liberado', [
                    'MAIL_OK' => isset($MAIL_OK) ? $MAIL_OK : 'no definido',
                    'result' => $result
                ]);
                
                // Verificar si el correo se envió correctamente
                return isset($MAIL_OK) && $MAIL_OK;
            }

            \Log::error('Archivo de correo no encontrado', ['path' => $path]);
            return false;
        } catch (\Exception $e) {
            \Log::error('Error enviando correo certificado liberado: ' . $e->getMessage());
            return false;
        }
    }



}
