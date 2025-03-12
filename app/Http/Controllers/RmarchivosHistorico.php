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

class RmarchivosHistorico extends Controller
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
        $user           = User::whereId(Auth::user()->id)->first();
        $centrotrabajo  = CentrosTrabajo::whereKcvect($user->id_ct)->first();
        $elct           = $centrotrabajo->oclave;
        $iddoc          = $request->iddoc;
        $idacta         = $request->idacta;
        $nombredoc      = str_replace(' ', '',$request->onombre_documento);
        $file           = $request->file('onombre_archivo');

        if($request->action==2)
        {
            if($request->hasFile('onombre_archivo') )
            {
                $file->storeAs('archivos/13-2/'.$elct.'/'.$idacta, $nombredoc.'.'.$file->extension(), 'public');
                Archivoshistorico::create([
                    'id_acta'           => $idacta,
                    'id_ct'             => Auth::user()->id_ct,
                    'onombre_documento' => $nombredoc,
                    'ourl'              => 'archivos/13-2/'.$elct.'/'.$idacta.'/',
                    'oarchivo_adjunto'  => $nombredoc.'.'.$file->extension(),
                    'ofile'             => 1, 
                    'oanio'             => date('Y-m-d'),     
                ]);
                return redirect()->back()->with("success", "Se ha cargado el archivo $nombredoc correctamente");
            }else{
                return redirect()->back()->with("warning", "No se ha cargado ningún archivo");
            }  

        }else if($request->action==1){

            if($request->ocomentarios){
                $rescom = $request->ocomentarios;
            }else{
                $rescom = '-----';
            }
            Archivoshistorico::create([
                'id_acta'               => $idacta,
                'id_ct'                 => Auth::user()->id_ct,
                'oclave_expediente'     => $request->oclave_expediente,
                'onombre_expediente'    => $request->onombre_expediente,
                'operiodo'              => $request->operiodo,
                'operiodo2'             => $request->operiodo2,
                'onum_legajos'          => $request->onum_legajos,
                'onum_documentos'       => $request->onum_documentos,
                'otiempo_conservacion'  => $request->anios,
                'add_otiempo_conservacion'=> " AÑOS ",
                'otiempo_conservacion2' => $request->meses,
                'ocomentarios'          => $rescom,
                'oanio'                 => date('Y-m-d'),     
            ]);

            return redirect()->back()->with("success", "Se ha registrado el archivo $nombredoc correctamente");

        }
    }


    public function update(Request $request, string $id)
    {
        if($request->actionarchivos==1)
        {
                $archivoshistorico = Archivoshistorico::whereId($id)->first();
                $update_archivoshistorico = Archivoshistorico::whereId($id);
                $update_archivoshistorico->update([ 'status' => 'B' ]);
                unlink(storage_path('app/public/'.$archivoshistorico->ourl.$archivoshistorico->oarchivo_adjunto));
                
                return redirect()->back()->with("success", "Se ha removido el archivo correctamente");
  
        }else if($request->actionarchivos==2){

                $avances_plantilla = Avanceanexos::whereIdActa($id);
                $avances_plantilla->update(['orelacion_archivos_historico_a' => 1]);  
      
                return redirect()->route('documentos.archivos.index')
                        ->with("success", "Se ha finalizado el inventario de existencias en almacenes");  
            
         }else if($request->actionarchivos==3){

                if($request->ocomentarios){
                    $rescom = $request->ocomentarios;
                }else{
                    $rescom = '-----';
                }

                $update_archivoshistorico = Archivoshistorico::whereId($id);
                $update_archivoshistorico->update([ 
                                                    'oclave_expediente'     => $request->oclave_expediente,
                                                    'onombre_expediente'    => $request->onombre_expediente,
                                                    'operiodo'              => $request->operiodo,
                                                    'operiodo2'             => $request->operiodo2,
                                                    'onum_legajos'          => $request->onum_legajos,
                                                    'onum_documentos'       => $request->onum_documentos,
                                                    'otiempo_conservacion'  => $request->anios,
                                                    'add_otiempo_conservacion'=> " AÑOS ",
                                                    'otiempo_conservacion2' => $request->meses,
                                                    'ocomentarios'          => $rescom,
                                                ]);
                return redirect()->back();

         }else if($request->actionarchivos==9){

                $update_archivoshistorico = Archivoshistorico::whereId($id);
                $update_archivoshistorico->update([ 'status' => 'B' ]);
                
                return redirect()->back()->with("success", "Se ha removido el archivo correctamente");
  
        }
        
    }



}
