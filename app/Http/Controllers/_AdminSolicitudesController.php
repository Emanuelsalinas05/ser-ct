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

class _AdminSolicitudesController extends Controller
{

    public function index()
    {
    
            // Manejar rol 99 (Coordinación Académica) - Ve todas las solicitudes ELEMENTAL
            if (Auth::user()->orol == 99) {
                $solicitudesc = Solicitudnoadeudo::whereIdTipocert(2)
                                ->where('ogenerado',1) 
                                ->where('oentregado',0)
                                ->where('oadg', 0)
                                ->where('odee', 0)
                                ->where('ocaoe', 0)
                                ->whereOdir('ELEMENTAL')
                                ->count();

                $solicitudes = Solicitudnoadeudo::select('*',  DB::raw('date_format(ofecha, "%d-%m-%Y") as fecha'), 
                                                    DB::raw('date_format(ofecha_acta, "%d-%m-%Y") as fechaacta'))
                                ->whereIdTipocert(2)
                                ->where('ogenerado',1) 
                                ->where('oentregado',0)
                                ->where('oadg', 0)
                                ->where('odee', 0)
                                ->where('ocaoe', 0)
                                ->whereOdir('ELEMENTAL')
                                ->OrderBY('ofecha', 'DESC')
                                ->get();       

                return view('admin.solicitudes.certificado-noadeudos.index',
                        compact('solicitudesc','solicitudes',)
                        );
            }

            $org  = Organitation::where('idct_direccion',Auth::user()->id_ct)
                    ->orWhere('idct_subdireccion',Auth::user()->id_ct)
                    ->orWhere('idct_departamento',Auth::user()->id_ct)
                    ->orWhere('idct_sector',Auth::user()->id_ct)
                    ->orWhere('idct_supervicion',Auth::user()->id_ct)
                    ->orWhere('idct_escuela',Auth::user()->id_ct)
                    ->first();

            if (!$org) {
                return redirect()->back()->withErrors("No se encontró información organizacional para este usuario.");
            }

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

            $solicitudesc= Solicitudnoadeudo::whereIdTipocert(2)
                            ->where('ogenerado',1) 
                            ->where('oentregado',0)
                            ->where('oadg', 0)
                            ->where('odee', 0)
                            ->where('ocaoe', 0)
                            ->whereOdir(Auth::user()->onivel)
                            ->where($res, Auth::user()->id_ct)
                            ->count();

            $solicitudes = Solicitudnoadeudo::select('*',  DB::raw('date_format(ofecha, "%d-%m-%Y") as fecha'), 
                                                DB::raw('date_format(ofecha_acta, "%d-%m-%Y") as fechaacta'))
                            ->whereIdTipocert(2)
                            ->where('ogenerado',1) 
                            ->where('oentregado',0)
                            ->where('oadg', 0)
                            ->where('odee', 0)
                            ->where('ocaoe', 0)
                            ->whereOdir(Auth::user()->onivel)
                            ->where($res, Auth::user()->id_ct)
                            ->OrderBY('ofecha', 'DESC')
                            ->get();       

            return view('admin.solicitudes.certificado-noadeudos.index',
                    compact('solicitudesc','solicitudes',)
                    );
    }


 




    public function edit($id)
    {
        $user = User::whereIdCt($id)->first();
        $org  = Organitation::where('idct_escuela',$user->id_ct)
                ->orWhere('idct_supervicion',$user->id_ct)
                ->orWhere('idct_sector',$user->id_ct)->first();

        return view('admin.users.edit',
                compact('user','org',)
                );
    }




    public function update(Request $request, string $id)
    {
            $avances_plantilla = Solicitudnoadeudo::whereId($id);
            $avances_plantilla->update([
                                        'oentregado'  => 1, 
                                        ]);  

            // Enviar correo cuando se aprueba la solicitud
            $this->enviarCorreoCertificado($id, $request);

            return redirect(url('ver-solicitudes-noadeudos'))
                    ->with("success", "Se ha aprobado la solicitud para la gestión del certificado de no adeudo"); 
    }

    /**
     * Envía correo de notificación para certificados de no adeudo cuando se aprueba
     */
    private function enviarCorreoCertificado($solicitudId, $request)
    {
        try {
            \Log::info('Iniciando envío de correo certificado aprobado', ['solicitud_id' => $solicitudId]);
            
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
            $tipoCert = \App\Models\Tiposnoadeudo::find($solicitud->id_tipocert);

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
            $request->solicitud_id = $solicitudId;
            $request->id_ct = $solicitud->id_ct;

            // Incluir el archivo de envío de correos
            $path = base_path('public/send-mails/certificado-noadeudo/index.php');
            \Log::info('Ruta del archivo de correo', ['path' => $path, 'exists' => file_exists($path)]);
            
            if (file_exists($path)) {
                ob_start();
                include $path;
                $result = ob_get_clean();
                
                \Log::info('Resultado del envío de correo', [
                    'MAIL_OK' => isset($MAIL_OK) ? $MAIL_OK : 'no definido',
                    'result' => $result
                ]);
                
                // Verificar si el correo se envió correctamente
                return isset($MAIL_OK) && $MAIL_OK;
            }

            \Log::error('Archivo de correo no encontrado', ['path' => $path]);
            return false;
        } catch (\Exception $e) {
            \Log::error('Error enviando correo certificado: ' . $e->getMessage());
            return false;
        }
    }

}
