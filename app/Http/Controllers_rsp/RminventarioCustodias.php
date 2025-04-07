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

class RminventarioCustodias extends Controller
{
    public function index()
    {
        $anexo      = Anexos::whereOnumAnexo(8)->first();
        $documento  = Documentos::whereIdAnexo($anexo->id)->whereId(6)->first();
        $datosacta  = DatosActa::whereIdUser(Auth::user()->id)->whereOconcluida(0)->first();
        $avances    = Avanceanexos::whereIdActa($datosacta->id)->first();
        $ibienes    = Inventariobienes::whereIdActa($datosacta->id)->whereNotIn('status', ['B'])->get();
        $ibienesc   = Inventariobienes::whereIdActa($datosacta->id)->whereNotIn('status', ['B'])->count();

        return view('documentos.situacion-recursos-materiales.8-5.index', 
                compact('anexo', 'documento', 'datosacta', 'avances', 'ibienes', 'ibienesc')
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

        if($request->hasFile('onombre_archivo') )
        {
            $file->storeAs('recursos-materiales/8-5/'.$elct.'/'.$idacta, $nombredoc.'.'.$file->extension(), 'public');
            Relacioncustodias::create([
                'id_acta'           => $idacta,
                'id_ct'             => Auth::user()->id_ct,
                'onombre_documento' => $nombredoc,
                'ourl'              => 'recursos-materiales/8-5/'.$elct.'/'.$idacta.'/',
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
        $rcustodias = Relacioncustodias::whereId($id)->first();
        $update_custodias = Relacioncustodias::whereId($id);
        $update_custodias->update([ 'status' => 'B' ]);
        unlink(storage_path('app/public/'.$rcustodias->ourl.$rcustodias->oarchivo_adjunto));

        return redirect()->back()->with("success", "Se ha removido el archivo correctamente");
    }

}
