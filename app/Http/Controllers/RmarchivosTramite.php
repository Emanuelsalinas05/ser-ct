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

class RmarchivosTramite extends Controller
{
    public function index()
    {
        $anexo      = Anexos::whereOnumAnexo(13)->first();
        $documento  = Documentos::whereIdAnexo($anexo->id)->whereId(8)->first();
        $datosacta  = DatosActa::whereIdUser(Auth::user()->id)->whereOconcluida(0)->first();
        $avances    = Avanceanexos::whereIdActa($datosacta->id)->first();
        $iarchivos  = Archivostramite::whereIdActa($datosacta->id)->whereNotIn('status', ['B'])->get();
        $iarchivosc = Archivostramite::whereIdActa($datosacta->id)->whereNotIn('status', ['B'])->count();

        return view('documentos.archivos.13-1.index', 
                compact('anexo', 'documento', 'datosacta', 'avances', 'iarchivos', 'iarchivosc')
                );
    }

    public function store(Request $request)
    {
        $user           = User::whereId(Auth::user()->id)->first();
        $centrotrabajo  = CentrosTrabajo::whereKcvect($user->id_ct)->first();
        $elct           = $centrotrabajo->oclave;
        $iddoc          = $request->iddoc;
        $idacta         = $request->idacta;

        if($request->action=='1')
        {
            $nombredoc      = str_replace(' ', '',$request->onombre_documento);
            $file           = $request->file('onombre_archivo');

            if($request->hasFile('onombre_archivo'))
            {
                    $file->storeAs('archivos/13-1/'.$elct.'/'.$idacta, $nombredoc.'.'.$file->extension(), 'public');

                    Archivostramite::create([
                        'id_acta'           => $idacta,
                        'id_ct'             => Auth::user()->id_ct,
                        'onombre_documento' => $nombredoc,
                        'ourl'              => 'archivos/13-1/'.$elct.'/'.$idacta.'/',
                        'oarchivo_adjunto'  => $nombredoc.'.'.$file->extension(),
                        'oanio'             => date('Y-m-d'),   
                        'ofile'             => 1,   
                    ]);

                    return redirect()->back()->with("success", "Se ha cargado el archivo $nombredoc correctamente");

            }else{
                    return redirect()->back()->with("warning", "No se ha cargado ningún archivo");
            }

        }else if($request->action=='2'){

                Archivostramite::create([
                    'id_acta'           => $idacta,
                    'id_ct'             => Auth::user()->id_ct,
                    'oclave_expediente' => $request->oclave_expediente,
                    'onombre_expediente'=> $request->onombre_expediente,
                    'onum_legajos'      => $request->onum_legajos,
                    'onum_documentos'   => $request->onum_documentos,  
                    'ofecha_primero'    => $request->ofecha_primero,
                    'ofecha_ultimo'     => $request->ofecha_ultimo,
                    'oanio'             => date('Y-m-d'),    
                ]);

                return redirect()->back()->with("success", "Se ha finalizado la relación de archivos en trámite");

        }
  
    }


    public function update(Request $request, string $id)
    {
        
        if($request->actionarchivos==1)
        {
            $archivostramite = Archivostramite::whereId($id)->first();
            $update_archivostramite = Archivostramite::whereId($id);
            $update_archivostramite->update([ 'status' => 'B' ]);
            unlink(storage_path('app/public/'.$archivostramite->ourl.$archivostramite->oarchivo_adjunto));
            
            return redirect()->back()->with("success", "Se ha removido el archivo correctamente");
  
        }else if($request->actionarchivos==2){

            $avances_plantilla = Avanceanexos::whereIdActa($id);
            $avances_plantilla->update(['orelacion_archivos_a' => 1]);  
  
            return redirect()->route('documentos.archivos.index')
                    ->with("success", "Se ha finalizado la relación de archivos en trámite");

        }else if($request->actionarchivos==3){

                $update_archivostramite = Archivostramite::whereId($id);
                $update_archivostramite->update([   'oclave_expediente' => $request->oclave_expediente,
                                                    'onombre_expediente'=> $request->onombre_expediente,
                                                    'onum_legajos'      => $request->onum_legajos,
                                                    'onum_documentos'   => $request->onum_documentos,  
                                                    'ofecha_primero'    => $request->ofecha_primero,
                                                    'ofecha_ultimo'     => $request->ofecha_ultimo,
                                                ]);

                return redirect()->back()->with("success", "Se ha actualizado el expeciente: ".$request->onombre_expediente. " correctamente");  

        }else if($request->actionarchivos==9){

            $update_archivostramite = Archivostramite::whereId($id);
            $update_archivostramite->update([ 'status' => 'B' ]);
            
            return redirect()->back()->with("success", "Se ha removido el registro correctamente");
        }
       
    }


}
