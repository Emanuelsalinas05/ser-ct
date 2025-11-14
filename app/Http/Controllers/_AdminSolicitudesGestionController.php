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
use App\Models\Ctitulares;


class _AdminSolicitudesGestionController extends Controller
{


    public function index()
    {   
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

            switch (Auth::user()->ocargo) 
            {
                case 'DIRECCIÓN':
                case 'SUBDIRECCIÓN':
                case 'DEPARTAMENTO':
                    $check = 1;
                break;

                default:
                    $check = 0;
                break;
            }


            $titular = Ctitulares::whereIdCt(Auth::user()->id_ct)->first();

            // Para rol 99, contar todas las solicitudes ELEMENTAL
            if (Auth::user()->orol == 99) {
                $solicitudesc = Solicitudnoadeudo::whereIdTipocert(2) 
                                ->where('ogenerado',1) 
                                ->where('oentregado',1)
                                ->where('oadg', 1)
                                ->where('odee', 0)
                                ->where('ocaoe', 0)
                                ->whereOdir('ELEMENTAL')->count();
            } else {
                $solicitudesc = Solicitudnoadeudo::whereIdTipocert(2) 
                                ->where('ogenerado',1) 
                                ->where('oentregado',1)
                                ->where('oadg', 1)
                                ->where('odee', 0)
                                ->where('ocaoe', 0)
                                ->whereOdir(Auth::user()->onivel)->count();
            }

            $solicitudesg = Solicitudnoadeudo::select('odir', 'id_dir', 'oadg', 'ofile_adg', 'odee','ofecha_dee', 'oficio_dee', 
                            'oconsecutivo_dee', 'orubrica_dee', 'ofile_dee', 'oruta_dee')
                            ->whereIdTipocert(2)
                            ->where('ogenerado',1) 
                            ->where('oentregado',1)
                            ->where('oadg', 1)
                            ->where('odee', 0)
                            ->where('ocaoe', 0)
                            ->whereOdir(Auth::user()->onivel)
                            ->GroupBy('odir', 'id_dir', 'oadg', 'ofile_adg', 'odee','ofecha_dee', 'oficio_dee', 
                            'oconsecutivo_dee', 'orubrica_dee', 'ofile_dee', 'oruta_dee')
                            ->first(); 

        // Inicializar $solicitudes como array vacío
        $solicitudes = collect();

        if(Auth::user()->orol==1 || Auth::user()->orol==99)
        {
                // Rol 1 (DEE) o Rol 99 (Coordinación Académica) - Ve todas las solicitudes ELEMENTAL
                $solicitudes = Solicitudnoadeudo::select('odir', 'id_dir', 'id_sub', 'id_dep', 'ogenerado', 'oenviado', 'oadg', 'ofecha_adg', 
                                        DB::raw('date_format(ofecha_adg, "%d-%m-%Y") as fechadg'),
                                        DB::raw('count(id_ct) as totalct') , 'oficio_adg', 'oconsecutivo_adg', 'orubrica_adg', 'olugar_adg', 'oanio', 
                                        'oruta_adg', 'ofile_adg', 'odee')
                                    ->whereIdTipocert(2)
                                    ->where('ogenerado',1) 
                                    ->where('oentregado',1)
                                    ->where('oadg', 1)
                                    ->where('odee', 0)
                                    ->where('ocaoe', 0)
                                    ->whereOdir('ELEMENTAL')
                                    ->GroupBy('odir', 'id_dir', 'id_sub', 'id_dep', 'ogenerado', 'oenviado', 'oadg', 'ofecha_adg','oficio_adg', 
                                              'oconsecutivo_adg', 'orubrica_adg', 'olugar_adg', 'oanio', 'oruta_adg', 'ofile_adg', 'odee')
                                    ->OrderBY('ofecha_adg', 'DESC')
                                    ->get(); 

        }else if(Auth::user()->orol==2){
                $solicitudes = Solicitudnoadeudo::select('odir', 'id_dir', 'id_sub', 'id_dep', 'ogenerado', 'oenviado', 'oadg', 'ofecha_adg',
                                        DB::raw('date_format(ofecha_adg, "%d-%m-%Y") as fechadg'),
                                        DB::raw('count(id_ct) as totalct'), 'oficio_adg', 'oconsecutivo_adg', 'orubrica_adg', 'olugar_adg', 'oanio', 
                                        'oruta_adg', 'ofile_adg', 'odee')
                                    ->whereIdTipocert(2)
                                    ->where('ogenerado',1) 
                                    ->where('oentregado',1)
                                    ->where('oadg', 1)
                                    ->where('odee', 0)
                                    ->where('ocaoe', 0)
                                    ->whereOdir(Auth::user()->onivel)
                                    ->where($res, Auth::user()->id_ct)
                                    ->GroupBy('odir', 'id_dir', 'id_sub', 'id_dep', 'ogenerado', 'oenviado', 'oadg', 'ofecha_adg','oficio_adg', 
                                              'oconsecutivo_adg', 'orubrica_adg', 'olugar_adg', 'oanio', 'oruta_adg', 'ofile_adg', 'odee')
                                    ->OrderBY('ofecha_adg', 'DESC')
                                    ->get(); 
        }
                 
        return view('admin.solicitudes.certificado-noadeudos.1dee.index',
            compact('titular','solicitudesc','solicitudes', 'solicitudesg', 'check')
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

        $titular = Ctitulares::whereIdCt(Auth::user()->id_ct)->first();

        switch (Auth::user()->id_ct) 
        {
            case 49:
                $update_cna = Solicitudnoadeudo::whereIdDir(Auth::user()->id_ct)
                            ->whereIdTipocert(2)
                            ->where('ogenerado',1) 
                            ->where('oentregado',1)
                            ->where('oadg', 1)
                            ->where('odee', 0)
                            ->where('ocaoe', 0);
            break;

            case 50:
            case 51:            
            case 59:
            case 60:
            case 61:
            case 92:
                $update_cna = Solicitudnoadeudo::whereIdSub(Auth::user()->id_ct)
                            ->whereIdTipocert(2)
                            ->where('ogenerado',1) 
                            ->where('oentregado',1)
                            ->where('oadg', 1)
                            ->where('odee', 0)
                            ->where('ocaoe', 0);
            break;

            case 52:
            case 53:
            case 54:
            case 55:
            case 56:
            case 58:
            case 94:
                $update_cna = Solicitudnoadeudo::whereIdDep(Auth::user()->id_ct)
                            ->whereIdTipocert(2)
                            ->where('ogenerado',1) 
                            ->where('oentregado',1)
                            ->where('oadg', 1)
                            ->where('odee', 0)
                            ->where('ocaoe', 0);
            break;
        }


        if($request->action=='1')
        {
                $update_cna->update([
                                    'oadg'              => 1,
                                    'ofecha_adg'        => date('Y-m-d'),
                                    'oconsecutivo_adg'  => $titular->ooficio,
                                    'oficio_adg'        => $request->oficio_adg,
                                    'olugar_adg'        => $request->olugar_adg,
                                    'orubrica_adg'      => $request->orubrica_adg,
                                    ]);  

                return redirect(url('solicitudes-noadeudos'))->with("success", "Se ha generado el formato de oficio correctamente"); 



        }else if($request->action=='10'){


                $nombredoc = str_replace(' ', '',$request->onombre_documento);
                $file = $request->file('onombre_archivo');

                if($request->hasFile('onombre_archivo'))
                {
                    $ruta     = 'solicitudes-cna/nivel/'.Auth::user()->id_ct.'/'.$request->fecfin;
                    $filename = $request->oficioadg.'.'.$file->extension();

                    $file->storeAs($ruta, $filename, 'public');

                    $update_cna->update([
                                        'oruta_adg' => $ruta.'/'.$filename,
                                        'ofile_adg' => 1,    
                                        ]);

                    // Enviar correo de notificación cuando se carga archivo
                    $this->enviarCorreoArchivoCargado($request, $ruta.'/'.$filename, 'ADG');

                    return redirect()->back()->with("success", "Se ha cargado el archivo $nombredoc correctamente y se ha notificado a la DEE");

                }else{

                    return redirect()->back()->with("warning", "No se ha cargado ningún archivo");

                }

        }else if($request->action=='100'){


                $update_cna->update([
                                    'ofecha_dee'        => date('Y-m-d'),
                                    'oficio_dee'        => $titular->ooficio,
                                    'oconsecutivo_dee'  => $request->oconsecutivo_dee,
                                    'orubrica_dee'      => $request->orubrica_dee,
                                    ]);  

                return redirect()->back()->with("success", "Se ha generado el formato de oficio correctamente");

        }else if($request->action=='50'){


                $nombredoc = str_replace(' ', '',$request->onombre_documento);
                $file = $request->file('onombre_archivo');

                if($request->hasFile('onombre_archivo'))
                {
                    $ruta     = 'solicitudes-cna/dee/'.Auth::user()->id_ct.'/'.$request->fecfin;
                    $filename = $request->oficioadg.'.'.$file->extension();

                    $file->storeAs($ruta, $filename, 'public');

                    $update_cna->update([
                                        'oruta_dee' => $ruta.'/'.$filename,
                                        'ofile_dee' => 1,    
                                        'odee'      => 1,   
                                        ]);

                    // Enviar correo de notificación cuando se carga archivo DEE
                    $this->enviarCorreoArchivoCargado($request, $ruta.'/'.$filename, 'DEE');

                    return redirect()->back()->with("success", "Se ha cargado el archivo $nombredoc correctamente y se ha notificado a la DEE");

                }else{

                    return redirect()->back()->with("warning", "No se ha cargado ningún archivo");

                }

        }






    }

    /**
     * Envía correo de notificación cuando se carga un archivo escaneado
     */
    private function enviarCorreoArchivoCargado($request, $rutaArchivo, $tipoProceso)
    {
        try {
            \Log::info('Iniciando envío de correo archivo cargado', [
                'ruta_archivo' => $rutaArchivo,
                'tipo_proceso' => $tipoProceso
            ]);

            // Obtener datos del usuario actual
            $usuario = Auth::user();
            
            // Obtener datos del centro de trabajo
            $ct = CentrosTrabajo::whereKcvect($usuario->id_ct)->first();
            if (!$ct) {
                \Log::error('Centro de trabajo no encontrado', ['id_ct' => $usuario->id_ct]);
                return false;
            }

            // Obtener datos organizacionales
            $org = Organitation::where('idct_escuela', $usuario->id_ct)
                ->orWhere('idct_supervicion', $usuario->id_ct)
                ->orWhere('idct_sector', $usuario->id_ct)
                ->first();

            if (!$org) {
                \Log::error('Organización no encontrada', ['id_ct' => $usuario->id_ct]);
                return false;
            }

            // Preparar datos para el correo
            $getct = $ct;
            $getoficio = (object) [
                'ocorreo' => $org->ocorreo ?? 'modernizacion.administrativa@dee.edu.mx'
            ];

            // Variables para el correo
            $request->onombre_solicitante = $usuario->name ?? 'Usuario';
            $request->tipo_proceso = $tipoProceso;
            $request->ruta_archivo = $rutaArchivo;
            // Generar URL absoluta completa para el correo electrónico
            $request->url_archivo = 'https://entregasrecepcion.seiem.gob.mx/storage/' . $rutaArchivo;
            $request->fecha_carga = date('Y-m-d H:i:s');
            $request->id_ct = $usuario->id_ct;

            // Incluir el archivo de envío de correos
            $path = base_path('public/send-mails/notificaciones/index.php');
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
            \Log::error('Error enviando correo archivo cargado: ' . $e->getMessage());
            return false;
        }
    }

}
