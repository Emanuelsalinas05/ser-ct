<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use App\Models\Organitation;
use App\Models\CentrosTrabajo;
use App\Models\Tiposnoadeudo;
use App\Models\Solicitudnoadeudo;
use App\Models\DatosActa;
use App\Models\Avanceanexos;
use App\Models\User;
use App\Rules\SoloMayusculas;

class SolicitudCernoadeudo extends Controller
{

   public function index()
{
    $tipocert   = Tiposnoadeudo::orderBy('oorden', 'DESC')->get();
    $datosacta  = DatosActa::whereIdUser(Auth::user()->id)->whereOconcluida(0)->first();

    if (!$datosacta) {
        return redirect()->back()->withErrors("No se encontró un acta activa (no concluida) para este usuario.");
    }

    $solicitudc = Solicitudnoadeudo::whereIdActa($datosacta->id)->count();
    $solicitud  = Solicitudnoadeudo::whereIdActa($datosacta->id)->first();

    // Determinar valor de $us por nivel
    $nivel = Auth::user()->onivel;
    $us    = null;

    if ($nivel === 'ELEMENTAL') {
        $us = 76;
        $datasct = CentrosTrabajo::whereKcvect($datosacta->id_ct)->first();
    } elseif ($nivel === 'SECUNDARIA') {
        $us = 89;
    }

    // Verificar si existe solicitud Y si ya se seleccionó el tipo
    $check = ($solicitudc > 0 && $solicitud && $solicitud->oselecttipo == 1) ? 1 : 0;

    return view('solicitudes.certificado-noadeudos.index', compact(
        'tipocert', 'datosacta', 'solicitudc', 'solicitud', 'check', 'us'
    ));
}



    public function store(Request $request)
    {
        $idacta     = $request->acta;
        $tipocert   = $request->tipocert;

        $solicitud  = Solicitudnoadeudo::whereIdActa($idacta)->first();

        $decide = Organitation::where('idct_escuela', Auth::user()->id_ct)
                    ->orWhere('idct_supervicion', Auth::user()->id_ct)
                    ->orWhere('idct_sector', Auth::user()->id_ct)->first();

        if (!$decide) {
            return redirect()->back()->withErrors("No se encontró información organizacional para este centro de trabajo.");
        }

        // Asignar valores de supervisión y sector
        $id_super   = $decide->idct_supervicion;
        $id_sector  = $decide->idct_sector;


        if($solicitud)
        {   
                $update_solicitud = Solicitudnoadeudo::whereId($solicitud->id);
                $update_solicitud->update([  'id_tipocert' => $tipocert, 'oselecttipo' => 1, ]);
                $solicitudId = $solicitud->id;
        }else{
                $nuevaSolicitud = Solicitudnoadeudo::create([
                    'odir'          => Auth::user()->onivel,
                    'id_dir'        => Auth::user()->id_ctorigen,
                    'id_sub'        => $decide->idct_subdireccion,
                    'id_dep'        => $decide->idct_departamento,
                    'id_sec'        => $id_sector,
                    'id_sup'        => $id_super,
                    'id_ct'         => Auth::user()->id_ct, 
                    'id_tipocert'   => $tipocert,
                    'oselecttipo'   => 1, 
                    'id_acta'       => $idacta,
                    'oanio'         => date('Y'),     
                ]);
                $solicitudId = $nuevaSolicitud->id;
        }

        return redirect()->back()->with("success", "REGISTRA LOS DATOS PARA OBTENER TU OFICIO DE SOLICITUD DE CERTIFICADO DE NO ADEUDO");

    }




    public function update(Request $request, string $id)
    {
        // Validar que action existe
        if (!$request->has('action')) {
            return redirect()->back()->withErrors("Acción no especificada.");
        }

        if($request->action==1)
        {
                    $validatedData = $request->validate([
                        'omunicipio'    => ['required', new SoloMayusculas],
                        'ofecha'        => 'required',
                        'ofechax'       => 'required',
                        'ohora'         => 'required',
                        'onumero_oficio'=>'required',
                    ],$message=[
                        'omunicipio.required'    => 'INGRESA EL MUNICIPIO',
                        'ofecha.required'        => 'INGRESA LA FECHA DEL ACTA',
                        'ofechax.required'       => 'INGRESA LA FECHA DEL OFICIO',
                        'ohora.required'         => 'INGRESA LA HORA',
                        'onumero_oficio.required'=>'INGRESA EL NÚMERO DE TÚ OFICIO', 
                    ]);

                    if($request->olocalidad)
                    {
                        $nnnn= strtoupper($request->olocalidad);
                    }else{
                        $nnnn= NULL;
                    }

                    $update_solicitud = Solicitudnoadeudo::whereId($id);
                    $update_solicitud->update([ 
                                        'onumero_oficio'=> $request->onumero_oficio,
                                        'olocalidad'    => $nnnn, 
                                        'omunicipio'    => strtoupper($request->omunicipio),
                                        'ofecha'        => $request->ofechax,
                                        'ofecha_acta'   => $request->ofecha,
                                        'ohora_acta'    => $request->ohora,
                                        'ogenerado'     => 1,  
                                    ]);

                    return redirect()->back()
                            ->with("success", "DESCARGA TU OFICIO DE SOLICITUD, FIRMA Y ENTREGA A TU AUTORIDAD INMEDIATA SUPERIOR; EN EL APARTADO 14.1. DEBERÁS ADJUNTAR EL ACUSE.");

        }else if($request->action==2){

                     $validatedData = $request->validate([
                        'omunicipio'                => ['required', new SoloMayusculas],
                        'ofecha'                    => 'required',
                        'ofechax'                   => 'required',
                        'ohora'                     => 'required',
                        'onombre_autoridadinmediata'=> ['required', new SoloMayusculas],
                        'ocargo_autoridadinmediata' => ['required', new SoloMayusculas],
                        'onumero_oficio'            =>'required',
                    ],$message=[
                        'omunicipio.required'                => 'INGRESA EL MUNICIPIO',
                        'ofecha.required'                    => 'INGRESA LA FECHA DEL ACTA',
                        'ofechax.required'                   => 'INGRESA LA FECHA DEL OFICIO',
                        'ohora.required'                     => 'INGRESA LA HORA',
                        'onombre_autoridadinmediata.required'=> 'INGRESA EL NOMBRE DE LA AUTORIDAD',
                        'ocargo_autoridadinmediata.required' => 'INGRESA EL CARGO DE LA AUTORIDAD',
                        'onumero_oficio.required'            =>'INGRESA EL NÚMERO DE TÚ OFICIO',
                    ]);
                    
                    if($request->olocalidad)
                    {
                        $nnnn= strtoupper($request->olocalidad);
                    }else{
                        $nnnn= NULL;
                    }
                    
                    $update_solicitud = Solicitudnoadeudo::whereId($id);
                    $update_solicitud->update([ 
                                        'olocalidad'                => $nnnn, 
                                        'omunicipio'                => strtoupper($request->omunicipio),
                                        'onumero_oficio'            => $request->onumero_oficio,
                                        'ofecha'                    => $request->ofechax,
                                        'onombre_autoridadinmediata'=> strtoupper($request->onombre_autoridadinmediata),
                                        'ocargo_autoridadinmediata' => strtoupper($request->ocargo_autoridadinmediata),
                                        'ofecha_acta'               => $request->ofecha,
                                        'ohora_acta'                => $request->ohora,
                                        'ogenerado'                 => 1, 
                                    ]);
                    return redirect()->back()
                            ->with("success", "Imprime, firma y entrega personalmente ante la
Coordinación de Administración y Finanzas de SEIEM (adjunta copias de tu INE y
último comprobante de pago); en el apartado 14.1, deberá adjuntar el acuse.");
        
        }else if($request->action==99){

                   $update_solicitud = Solicitudnoadeudo::whereId($id);
                    $update_solicitud->update([ 'oselecttipo' => 0 ]);

                    return redirect()->back()
                            ->with("success", "VUELVE A ELEGIR EL TIPO DE CERTIFICADO QUE DESEAR SOLICITAR");
        }




    }

    /**
     * Envía correo de notificación para certificados de no adeudo
     */
    private function enviarCorreoCertificado($solicitudId, $request)
    {
        try {
            \Log::info('Iniciando envío de correo certificado', ['solicitud_id' => $solicitudId]);
            
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

            // Obtener datos del usuario
            $usuario = Auth::user();

            // Obtener datos organizacionales
            $org = Organitation::where('idct_escuela', $solicitud->id_ct)
                ->orWhere('idct_supervicion', $solicitud->id_ct)
                ->orWhere('idct_sector', $solicitud->id_ct)
                ->first();

            if (!$org) {
                return false;
            }

            // Obtener tipo de certificado
            $tipoCert = Tiposnoadeudo::find($solicitud->id_tipocert);

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
