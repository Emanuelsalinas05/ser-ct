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
        }

        return view('caoe.historico.index',
                compact('solicitudesc','solicitudes',)
                );
    }

    
    public function update(Request $request, string $id)
    {
            $update_solicitudes = Solicitudnoadeudo::whereId($id);
            $update_solicitudes->update([ 
                                            'oficio'        => $request->oficio ,
                                            'olugar_fecha'  => date('Y-m-d') ,
                                            'orubrica'      => $request->orubrica ,
                                            'ocaoe'         => 1 , 
                                            'oliberado'     => 1 , 
                                        ]); 

            return redirect()->back()->with("success", "Se ha emitido el oficio de Certificado de No Adeudo");
    }



}
