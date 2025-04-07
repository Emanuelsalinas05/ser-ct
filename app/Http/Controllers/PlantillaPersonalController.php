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
use App\Models\Plantillapersonal;

class PlantillaPersonalController extends Controller
{
    public function index()
    {
        $anexo      = Anexos::whereOnumAnexo(5)->first();
        $documento  = Documentos::whereId(2)->first();
        $plantilla  = Plantilla::whereOcm(0)->get();

        $datosacta  = DatosActa::whereIdUser(Auth::user()->id)->whereOconcluida(0)->first();

        if(Auth::user()->onivel=='ELEMENTAL'){
                $ofilee=0;
        }else if(Auth::user()->onivel=='SECUNDARIA'){
                $ofilee=1;
        }

        $plantillap = Plantillapersonal::whereIdActa($datosacta->id)->whereNotIn('status', ['B'])
                        ->whereOfile($ofilee)->get();

        $plantillacp= Plantillapersonal::whereIdActa($datosacta->id)->whereNotIn('status', ['B'])
                        ->whereOfile($ofilee)->count();
        
        $avances    = Avanceanexos::whereIdActa($datosacta->id)->first();

        return view('documentos.recursos-humanos.5-1.index', 
                compact('anexo', 'documento', 'plantilla', 'datosacta', 'plantillap', 'plantillacp', 'avances')
                );
    }

    public function store(Request $request)
    {
        if($request->actionpers==1)
        {
            $plantillap = Plantillapersonal::whereIdActa($request->idacta)->whereNotIn('status', ['B'])->get();

            $validatedData = $request->validate([
                'ocategoria'     => 'required',
                'ototalplazas'   => 'required',
                'ototalocupadas' => 'required',
            ],$message=[
                'ocategoria.required'    => 'Selecciona la categoría/plaza',
                'ototalplazas.required'  => 'Elije el total de plazas (ocupadas y vacantes)',
                'ototalocupadas.required'=> 'Elije el total de plazas ocupadas',
            ]);

            $selectplantilla    = Plantilla::whereId($request->ocategoria)->whereOcm(0)->first();
            
            $validatorplantilla = Plantillapersonal::whereIdActa($request->idacta)
                                    ->whereOclavePuesto($selectplantilla->oclave)
                                    ->whereNotIn('status', ['B'])->first();

            if($validatorplantilla)
            {
                    return redirect()->back()->with("warning", "Ya se registro esta información");
            }else{

                Plantillapersonal::create([
                    'id_acta'       => $request->idacta,
                    'id_ct'         => Auth::user()->id_ct,
                    'oclave_puesto' => $selectplantilla->oclave,
                    'onombre_puesto'=> $selectplantilla->oclave_descripcion,
                    'onivelrango'   => $selectplantilla->oclave_sueldo,
                    'ototalplazas'  => $request->ototalplazas,
                    'ototalocupadas'=> $request->ototalocupadas,
                    'ototalvacantes'=> $request->ototalvacantes,
                    'osueldo_ind'   => $selectplantilla->omonto_mensual,
                    'osueldo_total' => ($request->ototalplazas*$selectplantilla->omonto_mensual),
                    'oactual'       => 1,
                    'oanio'         => date('Y-m-d'),
                ]);
                return redirect()->back()->with("success", "Se ha registrado correctamente la información");    
            }

        }else if($request->actionpers==9){

            $user           = User::whereId(Auth::user()->id)->first();
            $centrotrabajo  = CentrosTrabajo::whereKcvect($user->id_ct)->first();
            $elct           = $centrotrabajo->oclave;
            $idacta         = $request->idacta;
            $nombredoc      = str_replace(' ', '',$request->onombre_documento);
            $file           = $request->file('onombre_archivo');

            if($request->hasFile('onombre_archivo') )
            {
                $file->storeAs('archivos-personal/5-1/'.$elct.'/'.$idacta, $nombredoc.'.'.$file->extension(), 'public');

                Plantillapersonal::create([
                    'id_acta'           => $idacta,
                    'id_ct'             => Auth::user()->id_ct,
                    'onombre_documento' => $nombredoc,
                    'ourl'              => 'archivos-personal/5-1/'.$elct.'/'.$idacta.'/',
                    'oarchivo_adjunto'  => $nombredoc.'.'.$file->extension(),
                    'oactual'           => 1,
                    'oanio'             => date('Y-m-d'),
                    'ofile'             => 1, 
                ]);
                return redirect()->back()->with("success", "Se ha cargado el archivo $nombredoc correctamente");

            }else{
                return redirect()->back()->with("warning", "No se ha cargado ningún archivo");
            }  
                
        }

  
    }

    public function update(Request $request, $id)
    {
        if($request->actionplantilla==1)
        {
            $delete_plantilla = Plantillapersonal::whereId($id)->whereIdActa($request->acta);
            $delete_plantilla->update([ 'status' => 'B', ]);
  
            return redirect()->back()->with("success", "Se ha eliminado correctamente el registro"); 
  
        }else if($request->actionplantilla==2){

            $finalizacion_plantilla = Plantillapersonal::whereIdActa($request->acta);
            $finalizacion_plantilla->update([ 'ofinalizacion' => 1 ]);

            $avances_plantilla = Avanceanexos::whereIdActa($request->acta);
            $avances_plantilla->update(['oplantilla_personal_a' => 1, 
                                        ]);
  
            return redirect()->route('documentos.recursos-humanos.index')
                    ->with("success", "Se ha finalizado el registro de plantilla de personal"); 
        }else if($request->actionplantilla==9){

            $plantillapersonal = Plantillapersonal::whereId($id)->first();
            $update_plantillapersonal = Plantillapersonal::whereId($id);
            $update_plantillapersonal->update([ 'status' => 'B' ]);
            unlink(storage_path('app/public/'.$plantillapersonal->ourl.$plantillapersonal->oarchivo_adjunto));
            
            return redirect()->back()->with("success", "Se ha removido el archivo correctamente");
        }  
            

    }


}
