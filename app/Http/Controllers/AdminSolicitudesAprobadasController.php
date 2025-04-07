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

class AdminSolicitudesAprobadasController extends Controller
{

    public function index()
    {

            $solicitudesc= Solicitudnoadeudo::whereOfinalizado(1)->whereOdir(Auth::user()->onivel)->count();

            $solicitudes = Solicitudnoadeudo::select('*',  DB::raw('date_format(ofecha, "%d-%m-%Y") as fecha'), 
                                                DB::raw('date_format(ofecha_acta, "%d-%m-%Y") as fechaacta'))
                            ->where('ofinalizado',1)
                            ->where('odir', Auth::user()->onivel)
                            ->where('id_dir', Auth::user()->id_ct)
                            ->orWhere('id_sub', Auth::user()->id_ct)
                            ->orWhere('id_dep', Auth::user()->id_ct)
                            ->orWhere('id_sec', Auth::user()->id_ct) 
                            ->orWhere('id_sup', Auth::user()->id_ct) 
                            ->OrderBY('ofecha', 'DESC')
                            ->get();       


            return view('admin.solicitudes.certificado-noadeudos.aprobadas.index',
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
                                        'ofinalizado'  => 1, 
                                        'oenviado'     => 1,
                                        ]);  

            return redirect(url('ver-solicitudes-noadeudos'))
                    ->with("success", "Se ha aprobado la solicitud para el certificado de no adeudo"); 
    }

 

 




}
