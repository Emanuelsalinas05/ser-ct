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


class _AdminSolicitudesAprobadasController extends Controller
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
                        ->where('oadg', 0)
                        ->where('odee', 0)
                        ->where('ocaoe', 0)
                        ->where($res, Auth::user()->id_ct)
                        ->whereOdir(Auth::user()->onivel)->count();

        $solicitudes = Solicitudnoadeudo::select('*', 
                        DB::raw('date_format(ofecha, "%d-%m-%Y") as fecha'), 
                        DB::raw('date_format(ofecha_acta, "%d-%m-%Y") as fechaacta'))
                        ->whereIdTipocert(2)
                        ->where('ogenerado',1) 
                        ->where('oentregado',1)
                        ->where('oadg', 0)
                        ->where('odee', 0)
                        ->where('ocaoe', 0)
                        ->whereOdir(Auth::user()->onivel)
                        ->where($res, Auth::user()->id_ct)
                        ->OrderBY('ofecha', 'DESC')
                        ->get();  

        return view('admin.solicitudes.certificado-noadeudos.0adg.index',
                compact('titular','solicitudesc','solicitudes','check')
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
        
            if($request->action=='1')
            { 
                    switch (Auth::user()->id_ct) 
                    {
                        case 49: case 51: case 92: case 61: case 60: case 59: case 50:
                                $avances_plantilla = Solicitudnoadeudo::whereIdSub(Auth::user()->id_ct)
                                                ->whereIdTipocert(2)
                                                    ->where('ogenerado',1) 
                                                    ->where('oentregado',1)
                                                    ->where('oadg', 0)
                                                    ->where('odee', 0)
                                                    ->where('ocaoe', 0);
                        break;

                        case 52: case 54: case 55: case 94: case 56: case 53: case 58:
                                $avances_plantilla = Solicitudnoadeudo::whereIdDep(Auth::user()->id_ct)
                                                    ->whereIdTipocert(2)
                                                    ->where('ogenerado',1) 
                                                    ->where('oentregado',1)
                                                    ->where('oadg', 0)
                                                    ->where('odee', 0)
                                                    ->where('ocaoe', 0);
                        break;
                    }
        
                    $avances_plantilla->update([
                                                'oadg'              => 1,
                                                'ofecha_adg'        => date('Y-m-d'),
                                                'oconsecutivo_adg'  => $request->oconsecutivo_adg,
                                                'oficio_adg'        => $titular->ooficio,
                                                'olugar_adg'        => $request->olugar_adg,
                                                'orubrica_adg'      => $request->orubrica_adg,
                                                ]);  

                return redirect(url('solicitudes-noadeudos'))->with("success", "Se ha generado el formato de oficio correctamente"); 
            }


    }

 

 




}
