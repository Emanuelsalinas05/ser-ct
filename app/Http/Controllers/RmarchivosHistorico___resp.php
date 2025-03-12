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

class RmarchivosHistoricoxxx extends Controller
{
    public function index()
    {
        $anexo      = Anexos::whereOnumAnexo(13)->first();
        $documento  = Documentos::whereIdAnexo($anexo->id)->whereId(9)->first();
        $datosacta  = DatosActa::whereIdUser(Auth::user()->id)->whereOconcluida(0)->first();
        $avances    = Avanceanexos::whereIdActa($datosacta->id)->first();
        $iarchivosh = Archivoshistorico::whereIdActa($datosacta->id)->whereNotIn('status', ['B'])->get();
        $iarchivoshc= Archivoshistorico::whereIdActa($datosacta->id)->whereNotIn('status', ['B'])->count();

        return view('documentos.archivos.13-2.index', 
                compact('anexo', 'documento', 'datosacta', 'avances', 'iarchivosh', 'iarchivoshc')
                );
    }

    public function store(Request $request)
    {
        $tiempocons = $request->anios.' años con '.$request->meses.' meses';
        Archivoshistorico::create([
            'id_acta'             => $request->acta,
            'id_ct'               => Auth::user()->id_ct,
            'oclave_expediente'   => $request->oclave_expediente,
            'onombre_expediente'  => $request->onombre_expediente,
            'operiodo'            => $request->operiodo,
            'operiodo2'           => $request->operiodo2,
            'onum_legajos'        => $request->onum_legajos,
            'onum_documentos'     => $request->onum_documentos,
            'otiempo_conservacion'=> $tiempocons,
            'ocomentarios'        => $request->ocomentarios,
            'oanio'               => date('Y-m-d'),     
        ]);    
        return redirect()->back()->with("success", "Se ha registrado el archivo correctamente"); 
    }

    public function update(Request $request, string $id)
    {
        if($request->actionarchivos==1)
        {
            $update_almacen = Archivoshistorico::whereId($id);
            $update_almacen->update([ 'status' => 'B' ]);

            return redirect()->back()->with("danger", "Se ha eliminado el registro correctamente");
  
        }else if($request->actionarchivos==2){

            $avances_plantilla = Avanceanexos::whereIdActa($id);
            $avances_plantilla->update(['orelacion_archivos_historico_a' => 1 , ]);  
  
            return redirect()->route('documentos.archivos.index')
                    ->with("success", "Se ha finalizado el inventario de existencias en almacenes"); 
        }         
    }



}
