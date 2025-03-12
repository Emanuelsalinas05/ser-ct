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
use App\Models\Inventariobienes;
use App\Models\Inventarioalmacen;
use App\Models\Relacioncustodias;

class RminventarioAlmacen extends Controller
{
    public function index()
    {
        $anexo      = Anexos::whereOnumAnexo(8)->first();
        $documento  = Documentos::whereIdAnexo($anexo->id)->whereId(5)->first();
        $datosacta  = DatosActa::whereIdUser(Auth::user()->id)->whereOconcluida(0)->first();
        $avances    = Avanceanexos::whereIdActa($datosacta->id)->first();
        $ialmacen    = Inventarioalmacen::whereIdActa($datosacta->id)->whereNotIn('status', ['B'])->get();
        $ialmacenc   = Inventarioalmacen::whereIdActa($datosacta->id)->whereNotIn('status', ['B'])->count();

        return view('documentos.situacion-recursos-materiales.8-3.index', 
                compact('anexo', 'documento', 'datosacta', 'avances', 'ialmacen', 'ialmacenc')
                );
    }

    public function store(Request $request)
    {
        $user           = User::whereId(Auth::user()->id)->first();
        $centrotrabajo  = CentrosTrabajo::whereKcvect($user->id_ct)->first();
        $elct           = $centrotrabajo->oclave;
        $iddoc          = $request->iddoc;
        $idacta         = $request->idacta;
        $nombredoc      = str_replace(' ', '',$request->onombre_documento);
        $file           = $request->file('onombre_archivo');

        if($request->omitir=='1')
        {
                Inventarioalmacen::create([
                    'id_acta'           => $idacta,
                    'id_ct'             => Auth::user()->id_ct,
                    'onombre_documento' => 'N/A',
                    'ourl'              => 'N/A',
                    'oarchivo_adjunto'  => 'N/A',
                    'oanio'             => date('Y-m-d'),     
                ]);

                $avances_plantilla = Avanceanexos::whereIdActa($idacta);
                $avances_plantilla->update([ 
                    'oinventario_almacen_a' => 1 , 
                ]);      
                
                return redirect()->route('documentos.situacion-recursos-materiales.index')
                    ->with("success", "Se ha finalizado el inventario de existencias en almacenes");

        }else{
            if($request->hasFile('onombre_archivo'))
            {
                $file->storeAs('recursos-materiales/8-3/'.$elct.'/'.$idacta, $nombredoc.'.'.$file->extension(), 'public');
                Inventarioalmacen::create([
                    'id_acta'           => $idacta,
                    'id_ct'             => Auth::user()->id_ct,
                    'onombre_documento' => $nombredoc,
                    'ourl'              => 'recursos-materiales/8-3/'.$elct.'/'.$idacta.'/',
                    'oarchivo_adjunto'  => $nombredoc.'.'.$file->extension(),
                    'oanio'             => date('Y-m-d'),     
                ]);
                return redirect()->back()->with("success", "Se ha cargado el archivo $nombredoc correctamente"); 
            }else{
                return redirect()->back()->with("warning", "No se ha cargado ningún archivo");
            } 
        }
    }

    public function update(Request $request, string $id)
    {
        if($request->actionplantilla==1)
        {
            $almacen = Inventarioalmacen::whereId($id)->first();
            $update_almacen = Inventarioalmacen::whereId($id);
            $update_almacen->update([ 'status' => 'B' ]);
            unlink(storage_path('app/public/'.$almacen->ourl.$almacen->oarchivo_adjunto));

            return redirect()->back()->with("success", "Se ha removido el archivo correctamente");
  
        }else if($request->actionplantilla==2){

            $avances_plantilla = Avanceanexos::whereIdActa($request->acta);
            $avances_plantilla->update(['oinventario_almacen_a' => 1]);  
  
            return redirect()->route('documentos.situacion-recursos-materiales.index')
                    ->with("success", "Se ha finalizado el inventario de existencias en almacenes"); 
        }          
    }



}
