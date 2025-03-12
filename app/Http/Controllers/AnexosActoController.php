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

class AnexosActoController extends Controller
{

    public function index(){}

    public function juridico()
    {
        $juridicos = Ordenamientojuridico::OrderBy('onprogresivo', 'ASC')->get();
        return view('documentos.marco-juridico.index', compact('juridicos'));
    }

    public function recursoshumanos()
    {
        $anexo        = Anexos::whereOnumAnexo(5)->first();
        $documentos   = Documentos::whereIdAnexo($anexo->id)->get();
        $datosacta    = DatosActa::whereIdUser(Auth::user()->id)->whereOconcluida(0)->first();
        $avanceanexos = Avanceanexos::whereIdActa($datosacta->id)->get();

        return view('documentos.recursos-humanos.index', 
                compact('anexo', 'documentos', 'datosacta', 'avanceanexos')
                );
    }

    public function recursosmateriales()
    {
        $anexo        = Anexos::whereOnumAnexo(8)->first();
        $documentos   = Documentos::whereIdAnexo($anexo->id)->get();
        $datosacta    = DatosActa::whereIdUser(Auth::user()->id)->whereOconcluida(0)->first();
        $avanceanexos = Avanceanexos::whereIdActa($datosacta->id)->get();

        return view('documentos.situacion-recursos-materiales.index', 
                compact('anexo', 'documentos', 'datosacta', 'avanceanexos')
                );
    }

    public function situaciontics()
    {
        $anexo        = Anexos::whereOnumAnexo(9)->first();
        $documentos   = Documentos::whereIdAnexo($anexo->id)->get();
        $datosacta    = DatosActa::whereIdUser(Auth::user()->id)->whereOconcluida(0)->first();
        $avanceanexos = Avanceanexos::whereIdActa($datosacta->id)->get();

        return view('documentos.situacion-tics.index', 
                compact('anexo', 'documentos', 'datosacta', 'avanceanexos')
                );
    }

    public function archivos()
    {
        $anexo        = Anexos::whereOnumAnexo(13)->first();
        $documentos   = Documentos::whereIdAnexo($anexo->id)->get();
        $datosacta    = DatosActa::whereIdUser(Auth::user()->id)->whereOconcluida(0)->first();
        $avanceanexos = Avanceanexos::whereIdActa($datosacta->id)->get();

        return view('documentos.archivos.index', 
                compact('anexo', 'documentos', 'datosacta', 'avanceanexos')
                );
    }

    public function noadeudos()
    {
        $anexo        = Anexos::whereOnumAnexo(14)->first();
        $documentos   = Documentos::whereIdAnexo($anexo->id)->get();
        $datosacta    = DatosActa::whereIdUser(Auth::user()->id)->whereOconcluida(0)->first();
        $avanceanexos = Avanceanexos::whereIdActa($datosacta->id)->get();

        return view('documentos.certificados-no-adeudos.index', 
                compact('anexo', 'documentos', 'datosacta', 'avanceanexos')
                );
    }

    public function informegestion()
    {
        $anexo        = Anexos::whereOnumAnexo(15)->first();
        $documentos   = Documentos::whereIdAnexo($anexo->id)->get();
        $datosacta    = DatosActa::whereIdUser(Auth::user()->id)->whereOconcluida(0)->first();
        $avanceanexos = Avanceanexos::whereIdActa($datosacta->id)->get();

        return view('documentos.informe-gestion.index', 
                compact('anexo', 'documentos', 'datosacta', 'avanceanexos')
                );
    }

    public function otroshechos()
    {
        $anexo        = Anexos::whereOnumAnexo(18)->first();
        $documentos   = Documentos::whereIdAnexo($anexo->id)->get();
        $datosacta    = DatosActa::whereIdUser(Auth::user()->id)->whereOconcluida(0)->first();
        $avanceanexos = Avanceanexos::whereIdActa($datosacta->id)->get();

        return view('documentos.otros-hechos.index', 
                compact('anexo', 'documentos', 'datosacta', 'avanceanexos')
                );
    }

    public function edit($id)
    {
        $documento = Documentos::whereId($id)->first();
        $anexo     = Anexos::whereId($documento->id_anexo)->first();    
        return view('documentos.edit', compact('documento'));
    }

    public function update(Request $request, $idanexo)
    {   
        $anexo  =   Anexos::whereOnumAnexo($request->num_anexo)->first(); 
        $ccacta =   DatosActa::whereId($request->acta)->first(); 
        /*
        $cavance=   Avanceanexos::select('*', 'g1acta.id_tipoacta', 'g1acta.id',
                                    DB::raw('CASE 
                                                WHEN 
                                                    g1acta.id_tipoacta=1 
                                                THEN 
                                                    CASE WHEN   
                                                        omarco_juridico_d = 1 AND
                                                        orecursos_humanos_d = 1 AND
                                                        osituacion_recursos_materiales_d = 1 AND
                                                        osituacion_tics_d = 1 AND
                                                        oarchivos_d = 1 AND
                                                        ocertificados_no_adeudos_d = 1 AND
                                                        oinforme_gestion_d = 1 AND
                                                        ootros_hechos_d = 1
                                                    THEN 1 
                                                    ELSE 0 END 
                                                WHEN 
                                                    g1acta.id_tipoacta=2 
                                                THEN 
                                                    CASE WHEN 
                                                        omarco_juridico_d = 1 AND
                                                        orecursos_humanos_d = 1 AND
                                                        osituacion_recursos_materiales_d = 1 AND
                                                        osituacion_tics_d = 1 AND
                                                        oarchivos_d = 1 AND
                                                        ootros_hechos_d = 1
                                                    THEN 1 
                                                    ELSE 0 END  
                                                END AS verificacion'))
                    ->leftJoin('g1acta', 'g1acta.id',  'id_acta')  
                    ->where('g1acta.id', $request->acta)->first();

            if($cavance->verificacion==1){
                $num = 0; 
            }else if($cavance->verificacion==0){
                $num = 1; 
            }
            */


                $update_avance = Avanceanexos::find($idanexo);
            if($request->num_anexo==1){
                $update_avance->omarco_juridico_d =  1;
                $update_avance->ofecha_orecursos_humanos =  date('Y-m-d');
            
            }else if($request->num_anexo==5){
                $update_avance->orecursos_humanos_d =  1;
                $update_avance->ofecha_orecursos_humanos =  date('Y-m-d');
            
            }else if($request->num_anexo==8){
                $update_avance->osituacion_recursos_materiales_d =  1;
                $update_avance->ofecha_osituacion_recursos_materiales =  date('Y-m-d');
            
            }else if($request->num_anexo==9){
                $update_avance->osituacion_tics_d =  1;
                $update_avance->ofecha_osituacion_tics =  date('Y-m-d');
            
            }else if($request->num_anexo==13){
                $update_avance->oarchivos_d =  1;
                $update_avance->ofecha_oarchivos =  date('Y-m-d');
            
            }else if($request->num_anexo==14){
                $update_avance->ocertificados_no_adeudos_d =  1;
                $update_avance->ofecha_ocertificados_no_adeudos =  date('Y-m-d');
            
            }else if($request->num_anexo==15){
                $update_avance->oinforme_gestion_d =  1;
                $update_avance->ofecha_oinforme_gestion =  date('Y-m-d');
            
            }else if($request->num_anexo==18){
                $update_avance->ootros_hechos_d =  1;
                $update_avance->ofecha_ootros_hechos =  date('Y-m-d');
            }
                $update_avance->oopenanexo = 0;
                $update_avance->oanio =  date('Y-m-d');
                $update_avance->ofinanexos =  1;
                $update_avance->save();
            
           $update_acta = DatosActa::find($request->acta);
                        $update_acta->oopenanexo =  0;
                        $update_acta->ofinanexos =  1;
                        $update_acta->save();

           
            

        return redirect(url('entrega-recepcion'))
                ->with("success", "Se ha completado el anexo:  ".$anexo->onum_anexo.'. '.$anexo->oanexo ); 
    }


}
