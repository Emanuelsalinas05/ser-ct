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

class AdminSolicitudesController extends Controller
{

    public function index()
    {
        
        $solicitudes = Solicitudnoadeudo::select('g1solicitudes_noadeudos.*', 
                        DB::raw('date_format(g1solicitudes_noadeudos.ofecha, "%d-%m-%Y") as fecha'),
                        DB::raw('date_format(g1solicitudes_noadeudos.ofecha_acta, "%d-%m-%Y") as fechaacta'),)
                        ->OrderBY('ofecha', 'DESC')->get(); 

*/
        if(Auth::user()->ocargo=='DIRECCIÓN')
        {
                
                $solicitudesc= Solicitudnoadeudo::whereOfinalizado(1)->count();
                $solicitudes = Solicitudnoadeudo::select('g1solicitudes_noadeudos.*',  'g1acta.id_tipoacta',  
                                                    DB::raw('date_format(g1solicitudes_noadeudos.ofecha, "%d-%m-%Y") as fecha'), 
                                                    DB::raw('date_format(g1solicitudes_noadeudos.ofecha_acta, "%d-%m-%Y") as fechaacta'),)
                                ->leftJoin('g1acta', 'g1acta.id', 'g1solicitudes_noadeudos.id_acta')
                                ->leftJoin('g1organigrama', 'g1organigrama.idct_escuela', 'g1acta.id_ct')
                                ->where('g1solicitudes_noadeudos.oenviado',0)
                                ->where('g1solicitudes_noadeudos.ofinalizado',1)
                                ->where('g1organigrama.idct_direccion', Auth::user()->id_ct)
                                ->orWhere('g1organigrama.idct_subdireccion', Auth::user()->id_ct)
                                ->orWhere('g1organigrama.idct_sector', Auth::user()->id_ct)
                                ->orWhere('g1organigrama.idct_supervicion', Auth::user()->id_ct) 
                                ->OrderBY('ofecha', 'DESC')
                                ->get(); 

        }else if(Auth::user()->ocargo=='SUBDIRECCIÓN'){
                
                $solicitudesc= Solicitudnoadeudo::whereOfinalizado(1)->count();
                $solicitudes = Solicitudnoadeudo::select('g1solicitudes_noadeudos.*',  'g1acta.id_tipoacta',  
                                                    DB::raw('date_format(g1solicitudes_noadeudos.ofecha, "%d-%m-%Y") as fecha'), 
                                                    DB::raw('date_format(g1solicitudes_noadeudos.ofecha_acta, "%d-%m-%Y") as fechaacta'),)
                                ->leftJoin('g1acta', 'g1acta.id', 'g1solicitudes_noadeudos.id_acta')
                                ->leftJoin('g1organigrama', 'g1organigrama.idct_escuela', 'g1acta.id_ct')
                                ->where('g1solicitudes_noadeudos.ogenerado',1)
                                ->where('g1solicitudes_noadeudos.oenviado',0)
                                ->where('g1solicitudes_noadeudos.ofinalizado',1)
                                ->Where('g1organigrama.idct_subdireccion', Auth::user()->id_ct)
                                ->orWhere('g1organigrama.idct_sector', Auth::user()->id_ct)
                                ->orWhere('g1organigrama.idct_supervicion', Auth::user()->id_ct)
                                ->OrderBY('ofecha', 'DESC')
                                ->get(); 

        }else if( Auth::user()->ocargo=='DEPARTAMENTO'){
                $solicitudesc = 1;
                $solicitudes = Solicitudnoadeudo::select('g1solicitudes_noadeudos.*',  'g1acta.id_tipoacta',  
                                                    DB::raw('date_format(g1solicitudes_noadeudos.ofecha, "%d-%m-%Y") as fecha'), 
                                                    DB::raw('date_format(g1solicitudes_noadeudos.ofecha_acta, "%d-%m-%Y") as fechaacta'),)
                                ->leftJoin('g1acta', 'g1acta.id', 'g1solicitudes_noadeudos.id_acta')
                                ->leftJoin('g1organigrama', 'g1organigrama.idct_escuela', 'g1acta.id_ct')
                                ->where('g1solicitudes_noadeudos.ogenerado',1)
                                ->where('g1solicitudes_noadeudos.oenviado',0)
                                ->where('g1solicitudes_noadeudos.ofinalizado',0)
                                ->orWhere('g1organigrama.idct_subdireccion', Auth::user()->id_ct)
                                ->orWhere('g1organigrama.idct_sector', Auth::user()->id_ct)
                                ->orWhere('g1organigrama.idct_supervicion', Auth::user()->id_ct)
                                ->OrderBY('ofecha', 'DESC')
                                ->get(); 

        }else if(Auth::user()->ocargo=='SECTOR'){
                $solicitudesc = 1;
                $solicitudes = Solicitudnoadeudo::select('g1solicitudes_noadeudos.*',  'g1acta.id_tipoacta',  
                                                    DB::raw('date_format(g1solicitudes_noadeudos.ofecha, "%d-%m-%Y") as fecha'), 
                                                    DB::raw('date_format(g1solicitudes_noadeudos.ofecha_acta, "%d-%m-%Y") as fechaacta'),)
                                ->leftJoin('g1acta', 'g1acta.id', 'g1solicitudes_noadeudos.id_acta')
                                ->leftJoin('g1organigrama', 'g1organigrama.idct_escuela', 'g1acta.id_ct')
                                ->where('g1solicitudes_noadeudos.ogenerado',1)
                                ->where('g1solicitudes_noadeudos.oenviado',0)
                                ->where('g1solicitudes_noadeudos.ofinalizado',0)
                                ->orWhere('g1organigrama.idct_subdireccion', Auth::user()->id_ct)
                                ->orWhere('g1organigrama.idct_supervicion', Auth::user()->id_ct)
                                ->OrderBY('ofecha', 'DESC') 
                                ->get(); 

        }else if(Auth::user()->ocargo=='SUPERVISIÓN'){
                $solicitudesc = 1;
                $solicitudes = Solicitudnoadeudo::select('g1solicitudes_noadeudos.*',  'g1acta.id_tipoacta',  
                                                    DB::raw('date_format(g1solicitudes_noadeudos.ofecha, "%d-%m-%Y") as fecha'), 
                                                    DB::raw('date_format(g1solicitudes_noadeudos.ofecha_acta, "%d-%m-%Y") as fechaacta'),)
                                ->leftJoin('g1acta', 'g1acta.id', 'g1solicitudes_noadeudos.id_acta')
                                ->leftJoin('g1organigrama', 'g1organigrama.idct_escuela', 'g1acta.id_ct')
                                ->where('g1solicitudes_noadeudos.ogenerado',1)
                                ->where('g1solicitudes_noadeudos.oenviado',0)
                                ->where('g1solicitudes_noadeudos.ofinalizado',0)
                                ->Where('g1organigrama.idct_supervicion', Auth::user()->id_ct)
                                ->OrderBY('ofecha', 'DESC') 
                                ->get(); 
        }


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
                                        'ofinalizado'  => 1, 
                                        'oenviado'     => 1,
                                        ]);  

            return redirect(url('ver-solicitudes-noadeudos'))
                    ->with("success", "Se ha aprobado la solicitud para el certificado de no adeudo"); 
    }

 

 




}
