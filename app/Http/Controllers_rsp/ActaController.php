<?php

namespace App\Http\Controllers;
use File;
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
use App\Models\Organitation;
use App\Models\Tipoacta;
use App\Models\DatosActa;
use App\Models\Avanceanexos;
use App\Models\User;


class ActaController extends Controller
{

    public function index()
    {
        $tipoacta   = Tipoacta::get();
        $anexos     = Anexos::OrderBy('onum_anexo', 'ASC')->get();
        $datosacta  = DatosActa::whereIdUser(Auth::user()->id)->first();
        $ctts       = Organitation::where('cct_escuela', Auth::user()->emaill)
                    ->orWhere('cct_sector', Auth::user()->email)
                    ->orWhere('cct_supervision', Auth::user()->email)->first();

        if(Auth::user()->onivel=='ELEMENTAL')
        {
            $us=76;
        }else if(Auth::user()->onivel=='SECUNDARIA'){
            $us=89;
        }


        if ( Auth::user()->orol==3 )
        {
                $elacta      = DatosActa::whereIdUser(Auth::user()->id)->whereOconcluida(0)->first();
                $documentos  = Documentos::get();

                if($elacta)
                {
                            $datosacta   = DatosActa::select('*', 
                                            DB::raw('CASE 
                                                        WHEN 
                                                            id_tipoacta=1 
                                                        THEN 
                                                            CASE 
                                                                WHEN   
                                                                    onombre_entrega_a IS NOT NULL AND
                                                                    orfc_entrega_a    IS NOT NULL AND
                                                                    ocargo_entrega_a  IS NOT NULL AND
                                                                    onombre_recibe_a  IS NOT NULL AND
                                                                    orfc_recibe_a     IS NOT NULL AND
                                                                    ocargo_recibe_a   IS NOT NULL
                                                                THEN 1 
                                                                ELSE 0 
                                                                END 
                                                                
                                                                WHEN 
                                                                    id_tipoacta=2 
                                                                THEN 
                                                                    CASE 
                                                                        WHEN 
                                                                            onombre_recibe_ac IS NOT NULL AND
                                                                            orfc_recibe_ac    IS NOT NULL
                                                                        THEN 1 
                                                                        ELSE 0 
                                                                END  
                                                        END AS ock'),
                                                DB::raw('CASE 
                                                            WHEN 
                                                                owaitacta=2 AND 
                                                                ocargaacta=0 AND
                                                                ocargacomprimido=0  
                                                            THEN 0 
                                                            WHEN  
                                                                owaitacta=1 AND 
                                                                ocargaacta=1 AND
                                                                ocargacomprimido=0 
                                                            THEN 1
                                                            WHEN 
                                                                owaitacta=1 AND 
                                                                ocargaacta=1 AND
                                                                ocargacomprimido=1
                                                            THEN 2
                                                        END AS avancez'),


                                                DB::raw('CASE 
                                                            WHEN 
                                                                ocargacomprimido=0 AND 
                                                                onombrecarpeta IS NULL AND 
                                                                ocorreocc IS NULL 
                                                            THEN 0 
                                                            WHEN 
                                                                ocargacomprimido=1 AND 
                                                                onombrecarpeta IS NOT NULL AND 
                                                                ocorreocc IS NULL 
                                                            THEN 1
                                                            WHEN 
                                                                ocargacomprimido=1 AND 
                                                                onombrecarpeta IS NOT NULL AND 
                                                                ocorreocc IS NOT NULL 
                                                            THEN 2
                                                        END AS carpetacorreo'))
                                    ->whereIdUser(Auth::user()->id)->whereOconcluida(0)->first();

                            $avanceanexos = Avanceanexos::select('*',
                                                        DB::raw('CASE 
                                                                    WHEN
                                                                        omarco_juridico_d=1 AND 
                                                                        orecursos_humanos_d=1 AND 
                                                                        osituacion_recursos_materiales_d=1 AND 
                                                                        osituacion_tics_d AND 
                                                                        ocertificados_no_adeudos_d=1 AND 
                                                                        oinforme_gestion_d=1 AND 
                                                                        oinforme_gestion_d=1 AND 
                                                                        ootros_hechos_d=1  
                                                                    THEN 1 
                                                                    ELSE 0 
                                                                END AS completado'))->whereIdActa($datosacta->id)->get();
            

                        if($datosacta->id_tipoacta==2)
                        {
                                $anexos = Anexos::whereNotIn('onum_anexo', [14,15])->OrderBy('onum_anexo', 'ASC')->get();
                                $avance = Avanceanexos::select('*', 
                                                        DB::raw('CASE 
                                                                    WHEN
                                                                        omarco_juridico_d=1 AND 
                                                                        orecursos_humanos_d=1 AND 
                                                                        osituacion_recursos_materiales_d=1 AND 
                                                                        osituacion_tics_d AND
                                                                        oarchivos_d=1 AND 
                                                                        ootros_hechos_d=1   
                                                                    THEN 1 
                                                                    ELSE 0 
                                                                END AS completado'))->whereIdActa($datosacta->id)->first();

                        }else if($datosacta->id_tipoacta==1){

                               $anexos  = Anexos::OrderBy('onum_anexo', 'ASC')->get(); 
                               $avance  = Avanceanexos::select('*', 
                                                            DB::raw('CASE 
                                                                        WHEN
                                                                            omarco_juridico_d=1 AND 
                                                                            orecursos_humanos_d=1 AND 
                                                                            osituacion_recursos_materiales_d=1 AND 
                                                                            osituacion_tics_d AND
                                                                            oarchivos_d=1 AND 
                                                                            ocertificados_no_adeudos_d=1 AND 
                                                                            oinforme_gestion_d=1 AND 
                                                                            ootros_hechos_d=1  
                                                                        THEN 1 
                                                                        ELSE 0 
                                                                    END AS completado'))->whereIdActa($datosacta->id)->first();
                        }

                        $ban = 1;
                        return view('acta.index', 
                                compact('tipoacta', 'anexos', 'documentos', 'datosacta', 'avanceanexos', 'avance', 'ban', 'us', 'ctts'));

                }else{

                        $ban = 0;
                        return view('acta.index', 
                                compact('tipoacta', 'documentos', 'ban', 'us', 'ctts'));

                }
                            

        }else if(Auth::user()->orol<=2){
                
                $datosacta = DatosActa::get();
                 return redirect(url('entregas-recepcion'));
                 
        }else if ( Auth::user()->orol>3 ){

                return redirect(url('gestion-certificados'));

            }
        

    }




    public function store(Request $request)
    {
            $datosacta = DatosActa::whereIdUser(Auth::user()->id)->whereOconcluida(0)->first();
            $datosCT   = CentrosTrabajo::whereKcvect(Auth::user()->id_ct)->first();

            if(!$datosacta)
            {
                    DatosActa::create([
                        'id_user'       => Auth::user()->id,
                        'id_tipoacta'   => $request->tipoacta,
                        'id_ct'         => Auth::user()->id_ct,
                        'oactual'       => 1,
                        'ofecha'        => date('Y-m-d'),
                        'oestado'       => 0,
                        'oconcluida'    => 0,
                        'oct_a'         => $datosCT->oclave,   
                        'oct_ac'        => $datosCT->oclave,    
                        'odomicilio_ct_a'=> $datosCT->odomicilio,
                        'olugar_a'      => $datosCT->nombre_loc,
                        'onombre_ct_a'  => $datosCT->onombre_ct,
                        'onombre_ct_ac' => $datosCT->onombre_ct,
                        'odomicilio_ct_ac'=> $datosCT->odomicilio,
                        'olugar_ac'     => $datosCT->nombre_loc,
                        'id_ctorigen'   => Auth::user()->id_ctorigen,
                        'octorigen'     => Auth::user()->octorigen,
                    ]);

                    $datosacta_ = DatosActa::whereIdUser(Auth::user()->id)->whereOconcluida(0)->first();

                    Avanceanexos::create([
                        'id_acta'   => $datosacta_->id,
                        'id_ct'     => $datosacta_->id_ct,
                        'oanio'     => date('Y-m-d'),
                    ]);
                    /*
                    Archivostramite;
                    Archivoshistorico;
                    Documentoshemerograficos;
                    */
            }
            
            return redirect(url('entrega-recepcion'))
                        ->with('success', 'Se ha elegido el tipo de Acta correctamente');
    }

    




    public function update(Request $request, $id)
    {   


            if($request->action=='1')
            {
                    $update_acta = DatosActa::find($request->idacta);   
                    if($id==1)
                    {
                    $update_acta->onombre_entrega_a = strtoupper($request->onombre_entrega_a);
                    $update_acta->orfc_entrega_a    = $request->orfc_entrega_a;
                    $update_acta->ocargo_entrega_a  = strtoupper($request->ocargo_entrega_a);
                    $update_acta->onombre_recibe_a  = strtoupper($request->onombre_recibe_a);
                    $update_acta->orfc_recibe_a     = $request->orfc_recibe_a;
                    $update_acta->ocargo_recibe_a   = strtoupper($request->ocargo_recibe_a);
                    }
                    if($id==2)
                    {
                    $update_acta->onombre_recibe_ac = strtoupper($request->onombre_recibe_ac);
                    $update_acta->orfc_recibe_ac    = $request->orfc_recibe_ac;
                    }
                    $update_acta->oactual = 1 ;
                    $update_acta->ocheck = 1 ;
                    $update_acta->ocodigo_verificacion  = base64_encode('https://entregasrecepcion.seiem.gob.mx/validation-qr/'.$request->idacta.'/edit');
                    $update_acta->save();
            
                    return redirect(url('entrega-recepcion'))
                            ->with('success', 'Se registro la información para el acta correctamente');

            }else if($request->action=='2'){

                        $user           = User::whereId(Auth::user()->id)->first();
                        $centrotrabajo  = CentrosTrabajo::whereKcvect($user->id_ct)->first();
                        $elct           = $centrotrabajo->oclave;
                        $idacta         = $request->idacta;
                        $tipoacta       = $request->tipoacta;
                        $file           = $request->file('onombre_archivo');

                        $validatedData = $request->validate([ 'onombre_archivo'=>'required', ],
                                        $message=[ 'onombre_archivo.required'  =>'Debes de seleccionar un archivo',]);

                    if($request->hasFile('onombre_archivo'))
                    {
                            $file->storeAs('actas-entregadas/'.$elct.'/'.$tipoacta.'/'.$idacta, 'SCAN-ACTA.pdf', 'public');
                            
                            $update_act = DatosActa::find($request->idacta);
                            $update_act->ourl_acta  = 'actas-entregadas/'.$elct.'/'.$tipoacta.'/'.$idacta.'/SCAN-ACTA.pdf';
                            $update_act->ocargaacta = 1 ;
                            $update_act->owaitacta  = 1 ;
                            $update_act->save();

                            $avances_plantilla = Avanceanexos::whereIdActa($request->idacta);
                            $avances_plantilla->update(['ocargaacta' => 1, ]);

                            return redirect()->back()
                                    ->with("success", "Se ha cargado el archivo del acta correctamente"); 
                    }else{
                            return redirect()->back()
                                    ->with("warning", "No se ha cargado ningún archivo");
                    }

            }else if($request->action=='50'){

                    $datosacta  = DatosActa::whereId($request->idacta)->first();

                    if($datosacta->id_tipoacta==1){
                        $ctt  = $datosacta->oct_a;
                        $elct = $datosacta->oct_a.' - '.$datosacta->onombre_ct_a;
                    }else if($datosacta->id_tipoacta==2){
                        $ctt  = $datosacta->oct_ac;
                        $elct = $datosacta->oct_ac.' - '.$datosacta->onombre_ct_ac;
                    }
                    

                    if($request->hasFile('onombre_archivo'))
                    {

                                $nombredoc      = str_replace(' ', '',$request->onombre_documento);
                                $file           = $request->file('onombre_archivo');

                                $file->storeAs('carpeta-entrega-recepcion/'.$ctt, $datosacta->id.'.'.$file->extension(), 'public');

                                $up_actacarpeta = DatosActa::whereId($request->idacta);
                                $up_actacarpeta->update([ 
                                                            'ocargacomprimido'  => 1 ,
                                                            'ourlcarpeta'       => 'carpeta-entrega-recepcion/'.$ctt.'/',
                                                            'onombrecarpeta'    => $datosacta->id.'.'.$file->extension(),
                                                        ]);

                                $avances_plantilla = Avanceanexos::whereIdActa($request->idacta);
                                $avances_plantilla->update(['ocargacomprimido' => 1, ]);


                                $up_actacarpeta = DatosActa::whereId($request->idacta);
                                $up_actacarpeta->update([ 
                                                            'ocargacomprimido'  => 1 ,
                                                            'ourlcarpeta'       => 'carpeta-entrega-recepcion/'.$ctt.'/',
                                                            'onombrecarpeta'    => $datosacta->id.'.'.$file->extension(),
                                                        ]);

                                $avances_plantilla = Avanceanexos::whereIdActa($request->idacta);
                                $avances_plantilla->update(['ocargacomprimido' => 1, ]);



                                return redirect()->back()
                                        ->with("success", "Se ha cargado la carpeta de información correctamente"); 
                    }else{
                                return redirect()->back()
                                        ->with("warning", "No se ha cargado ningún archivo");
                    }

            }else if($request->action=='60'){

                        $avances_plantilla = DatosActa::whereId($request->idacta);
                        $avances_plantilla->update([
                                                        'ocorreocc' => $request->correocopia,  
                                                     ]);
                         $avances_plantilla = Avanceanexos::whereIdActa($request->idacta);
                                $avances_plantilla->update(['ofinalizacion'=>1   ]);

                            return redirect(url('entrega-recepcion'))
                                    ->with("success", "Se ha enviado correo con la información de tu carpeta final de entrega-recepción "); 

            }

    }




}
