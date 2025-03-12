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

class _AdminSolicitudesController extends Controller
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

            return redirect(url('ver-solicitudes-noadeudos'))
                    ->with("success", "Se ha aprobado la solicitud para la gestión del certificado de no adeudo"); 
    }

 

 




}
