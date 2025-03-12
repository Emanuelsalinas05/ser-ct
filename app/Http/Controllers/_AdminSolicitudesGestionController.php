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

            $solicitudesc= Solicitudnoadeudo::whereIdTipocert(2) 
                            ->where('ogenerado',1) 
                            ->where('oentregado',1)
                            ->where('oadg', 1)
                            ->where('odee', 0)
                            ->where('ocaoe', 0)
                            ->whereOdir(Auth::user()->onivel)->count();

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

            if(Auth::user()->orol==1)
            {
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
                                    ->whereOdir(Auth::user()->onivel)
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

                    //require_once 'send-mails/notificaciones/index.php';
                    return redirect()->back()->with("success", "Se ha cargado el archivo $nombredoc correctamente");

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

                    //require_once 'send-mails/notificaciones/index.php';
                    return redirect()->back()->with("success", "Se ha cargado el archivo $nombredoc correctamente");

                }else{

                    return redirect()->back()->with("warning", "No se ha cargado ningún archivo");

                }

        }






    }

 

}
