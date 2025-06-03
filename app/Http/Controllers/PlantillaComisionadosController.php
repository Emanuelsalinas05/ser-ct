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
use App\Models\Plantilla;
use App\Models\Anexos;
use App\Models\Documentos;
use App\Models\Ordenamientojuridico;

use App\Models\Tipoacta;
use App\Models\DatosActa;
use App\Models\Avanceanexos;
use App\Models\User;
use App\Models\Plantillacomisionados;

class PlantillaComisionadosController extends Controller
{   
    public function index()
    {
        $anexo         = Anexos::whereOnumAnexo(5)->first();
        $centrotrabajo = CentrosTrabajo::get();
        $documento     = Documentos::whereId(3)->first();
        $datosacta     = DatosActa::whereIdUser(Auth::user()->id)->whereOconcluida(0)->first();

        $plantillac    = Plantillacomisionados::whereIdActa($datosacta->id)->whereNotIn('status', ['B'])->get();
        $plantillacc   = Plantillacomisionados::whereIdActa($datosacta->id)->whereNotIn('status', ['B'])->count();
        
        $avances    = Avanceanexos::whereIdActa($datosacta->id)->first();

        return view('documentos.recursos-humanos.5-3.index', 
                compact('anexo', 'documento', 'centrotrabajo', 'datosacta', 'plantillac', 'plantillacc', 'avances'),
                );
    }



    public function store(Request $request)
    {
        //$plantillac = Plantillacomisionados::whereIdActa($datosacta->id)->whereNotIn('status', ['B'])->get();

        if($request->action==1)
        {
            Plantillacomisionados::create([
                'id_acta'             => $request->acta,
                'id_ct'               => Auth::user()->id_ct,
                'onombre_servidor'    => strtoupper($request->onombre_servidor),
                'ounidad_adscripcion' => $request->ounidad_adscripcion,
                'ocomisionado_act'    => $request->ocomisionado_act,
                'operiodoinicio'      => $request->operiodoinicio,
                'operiodofinal'       => $request->operiodofinal,
                'ooficio_autorizacion'=> $request->ooficio_autorizacion,
                'oobservaciones'      => strtoupper($request->oobservaciones),
                'status'              => 'A',
                'oactual'             => 1,
                'oanio'               => date('Y-m-d'),
                'option'              => 1,        
            ]);
            return redirect()->back()->with("success", "Se ha registrado correctamente el servidor comisionado");
        }
        if($request->action==2)
        {
            Plantillacomisionados::create([
                'id_acta'             => $request->acta,
                'id_ct'               => Auth::user()->id_ct,
                'onombre_servidor'    => 'N/A',
                'ounidad_adscripcion' => 'N/A',
                'ocomisionado_act'    => 'N/A',
                'operiodoinicio'      => 'N/A',
                'operiodofinal'       => 'N/A',
                'ooficio_autorizacion'=> 'N/A',
                'oobservaciones'      => 'N/A',
                'status'              => 'A',
                'oactual'             => 1,
                'oanio'               => date('Y-m-d'),
                'ofinalizacion'       => 1,
                'option'              => 2,        
            ]);

            $avances_plantilla = Avanceanexos::whereIdActa($request->acta);
            $avances_plantilla->update([ 'oplantilla_comisionados_a' => 1 ]);
  
            return redirect()->back()->with("success", "Se ha registrado correctamente la información");
        }
    }



    public function update(Request $request, $id)
    {
        if($request->actioncomisionados==1)
        {
            $delete_plantilla = Plantillacomisionados::whereId($id)->whereIdActa($request->acta);
            $delete_plantilla->update([ 'status' => 'B', ]);
  
            return redirect()->back()->with("success", "Se ha eliminado correctamente el registro"); 
  
        }else if($request->actioncomisionados==2){

            $finalizacion_plantilla = Plantillacomisionados::whereIdActa($request->acta);
            $finalizacion_plantilla->update([ 'ofinalizacion' => 1 ]);

            $avances_plantilla = Avanceanexos::whereIdActa($request->acta);
            $avances_plantilla->update(['oplantilla_comisionados_a' => 1 , 
                                        ]);
  
            return redirect()->route('documentos.recursos-humanos.index')
                    ->with("success", "Se ha finalizado el registro de relación de servidores públicos comisionados");
        }   
    }

}
