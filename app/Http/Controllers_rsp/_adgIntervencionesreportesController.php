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

use App\Models\Intervencion;
use App\Models\Tipoacta;
use App\Models\DatosActa;
use App\Models\Avanceanexos;
use App\Models\User;
use App\Models\Rolesusers;
use App\Models\Solicitudnoadeudo;

class _adgIntervencionesreportesController extends Controller
{



    public function edit(string $id)
    {
        
        $intervencionesc= Intervencion::select('idct_departamento', 'oct_nivel', 'onivel_educativo', 'onotificado')
                            ->where('idct_departamento',$id)->whereOfin(1)->whereNotIn('istatus',['B'])
                            ->GroupBy('idct_departamento', 'oct_nivel', 'onivel_educativo', 'onotificado')
                            ->count();

        $intervenciones = Intervencion::select('idct_departamento','oct_nivel','onivel_educativo','ofechafin','ourl','oarchivo','ofile','onotificado',
                            DB::raw('date_format(ofechafin, "%d-%m-%Y") as fechaentrega')) 
                            ->where('idct_departamento',$id)->whereOfin(1)->whereNotIn('istatus',['B'])
                            ->GroupBy('idct_departamento', 'oct_nivel', 'onivel_educativo','ofechafin','ourl','oarchivo','ofile','onotificado')
                            ->OrderBy('ofechafin', 'DESC')
                            ->get();


        return view('adg.intervenciones.reports.edit',
                compact('intervencionesc', 'intervenciones',)
                );
    }



    public function update(Request $request, string $id)
    {
        
        if($request->action=='99')
        {
                    $ocomisionados = Intervencion::whereIdctDepartamento($id)->whereOfechafin($request->fecfin);
                    $ocomisionados->update([  'ofin' => 0 , ]);

                    return redirect(url('reportes-intervencion/'.$id.'/edit'))
                                ->with("success", "Se realizo la accion correctamente");

            }
    }



    public function store(Request $request)
    {
        $user   = User::whereIdCt(Auth::user()->id_ct)->first(); 
        $adg    = $user->oct;
        $fecha  = $request->fecfin; 

        if($request->action=='1')
        {
            $nombredoc = str_replace(' ', '',$request->onombre_documento);
            $file = $request->file('onombre_archivo');

            if($request->hasFile('onombre_archivo'))
            {
                    $file->storeAs('intervenciones/'.$adg.'/'.$fecha, $nombredoc.'.'.$file->extension(), 'public');

                    $ocomisionados = Intervencion::whereIdctDepartamento(Auth::user()->id_ct)->whereOfechafin($fecha);
                    $ocomisionados->update([
                                            'ourl'      => 'storage/intervenciones/'.$adg.'/'.$fecha.'/'.$nombredoc.'.'.$file->extension(),
                                            'oarchivo'  => $nombredoc,
                                            'ofile'     => 1,   
                                            ]);

                    $intervencionct = Intervencion::whereIdctDepartamento(Auth::user()->id_ct)->whereOfechafin($fecha)->first();
                    $intervenciones = Intervencion::whereIdctDepartamento(Auth::user()->id_ct)->whereOfechafin($fecha)->get();

                    require_once 'send-mails/notificaciones/index.php';

                    return redirect()->back()->with("success", "Se ha cargado el archivo $nombredoc correctamente");

            }else{
                    return redirect()->back()->with("warning", "No se ha cargado ningún archivo");
            }

        }
  
    }






}
