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
use App\Models\Archivostramite;
use App\Models\Archivoshistorico;
use App\Models\Documentoshemerograficos;
use App\Models\Certificadosnoadeudo;
use App\Models\Informegestion;
use App\Models\Compromisos90dias;
use App\Models\Otroshechos;

class RmotrosHechos extends Controller
{
    public function index()
    {
        $anexo      = Anexos::whereOnumAnexo(18)->first();
        $documento  = Documentos::whereIdAnexo($anexo->id)->whereId(14)->first();
        $datosacta  = DatosActa::whereIdUser(Auth::user()->id)->whereOconcluida(0)->first();
        $avances    = Avanceanexos::whereIdActa($datosacta->id)->first();
        $iotroshechos  = Otroshechos::whereIdActa($datosacta->id)->whereNotIn('status', ['B'])->get();
        $iotroshechosc = Otroshechos::whereIdActa($datosacta->id)->whereNotIn('status', ['B'])->count();

        return view('documentos.otros-hechos.18-1.index', 
                compact('anexo', 'documento', 'datosacta', 'avances', 'iotroshechos', 'iotroshechosc')
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

        if($request->hasFile('onombre_archivo')   )
        {
            $file->storeAs('otros-hechos/18-1/'.$elct.'/'.$idacta, $nombredoc.'.'.$file->extension(), 'public');
            
            Otroshechos::create([
                'id_acta'           => $idacta,
                'id_ct'             => Auth::user()->id_ct,
                'onombre_documento' => $nombredoc,
                'ourl'              => 'otros-hechos/18-1/'.$elct.'/'.$idacta.'/',
                'oarchivo_adjunto'  => $nombredoc.'.'.$file->extension(),
                'oanio'             => date('Y-m-d'),     
            ]);
            return redirect()->back()->with("success", "Se ha cargado el archivo $nombredoc correctamente"); 
        }else{
            return redirect()->back()->with("warning", "No se ha cargado ningún archivo");
        }
    }

    public function update(Request $request, string $id)
    {
        if($request->actionplantilla==1)
        {
            $bienes = Otroshechos::whereId($id)->first();
            $update_hechos = Otroshechos::whereId($id);
            $update_hechos->update([ 'status' => 'B' ]);
            unlink(storage_path('app/public/'.$bienes->ourl.$bienes->oarchivo_adjunto));
            
            return redirect()->back()->with("success", "Se ha removido el archivo correctamente");
  
        }else if($request->actionplantilla==2){

            $avances_plantilla = Avanceanexos::whereIdActa($request->acta);
            $avances_plantilla->update(['ootros_hechos_a'  => 1 ]);  

            return redirect()->route('documentos.otros-hechos.index')
                    ->with("success", "Se ha finalizado el registro de otros hechos"); 
        } 
    }

}
