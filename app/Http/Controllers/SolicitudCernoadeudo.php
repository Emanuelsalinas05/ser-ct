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

class SolicitudCernoadeudo extends Controller
{

   public function index()
{
    $tipocert   = Tiposnoadeudo::orderBy('oorden', 'DESC')->get();
    $datosacta  = DatosActa::whereIdUser(Auth::id())->whereOconcluida(0)->first();

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

    $check = $solicitudc > 0 ? 1 : 0;

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

        if(Auth::user()->id_ct==$decide->idct_escuela)
        {
            $id_super   = $decide->idct_supervicion;
            $id_sector  = $decide->idct_sector;

        }else if(Auth::user()->id_ct==$decide->idct_supervicion){

            $id_super   = $decide->idct_supervicion;
            $id_sector  = $decide->idct_sector;
            
        }else if(Auth::user()->id_ct==$decide->idct_sector){

            $id_super   = $decide->idct_supervicion;
            $id_sector  = $decide->idct_sector;
        }


        if($solicitud)
        {   
                $update_solicitud = Solicitudnoadeudo::whereId($solicitud->id);
                $update_solicitud->update([  'id_tipocert' => $tipocert, 'oselecttipo' => 1, ]);

        }else{
                Solicitudnoadeudo::create([
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
        }
        
        return redirect()->back()->with("success", "Registra los datos para obtener tu oficio de solicitud de certificado de no adeudo");

    }




    public function update(Request $request, string $id)
    {

        if($request->action==1)
        {
                    $validatedData = $request->validate([
                        'omunicipio'    => 'required',
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
                        $nnnn= ucfirst($request->olocalidad);
                    }else{
                        $nnnn= NULL;
                    }

                    $update_solicitud = Solicitudnoadeudo::whereId($id);
                    $update_solicitud->update([ 
                                        'onumero_oficio'=> $request->onumero_oficio,
                                        'olocalidad'    => $nnnn, 
                                        'omunicipio'    => ucfirst($request->omunicipio),
                                        'ofecha'        => $request->ofechax,
                                        'ofecha_acta'   => $request->ofecha,
                                        'ohora_acta'    => $request->ohora,
                                        'ogenerado'     => 1,  
                                    ]);

                    return redirect()->back()
                            ->with("success", "Descarga tu oficio de solicitud, firma y entrega a tu autoridad inmedata superior; en el apartado 14.1. deberás adjuntar el acuse.");

        }else if($request->action==2){

                     $validatedData = $request->validate([
                        'omunicipio'                => 'required',
                        'ofecha'                    => 'required',
                        'ofechax'                   => 'required',
                        'ohora'                     => 'required',
                        'onombre_autoridadinmediata'=> 'required',
                        'ocargo_autoridadinmediata' => 'required',
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
                        $nnnn= ucfirst($request->olocalidad);
                    }else{
                        $nnnn= NULL;
                    }
                    
                    $update_solicitud = Solicitudnoadeudo::whereId($id);
                    $update_solicitud->update([ 
                                        'olocalidad'                => $nnnn, 
                                        'omunicipio'                => ucfirst($request->omunicipio),
                                        'onumero_oficio'            => $request->onumero_oficio,
                                        'ofecha'                    => $request->ofechax,
                                        'onombre_autoridadinmediata'=> ($request->onombre_autoridadinmediata),
                                        'ocargo_autoridadinmediata' => ($request->ocargo_autoridadinmediata),
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

 



}
