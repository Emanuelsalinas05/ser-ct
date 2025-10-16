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
use App\Models\Organitation;
use App\Models\Plantilla;
use App\Models\Anexos;
use App\Models\Documentos;
use App\Models\Ordenamientojuridico;

use App\Models\Intervencion;
use App\Models\Tipoacta;
use App\Models\DatosActa;
use App\Models\Avanceanexos;
use App\Models\User;
use App\Models\Rolesusers;
use App\Models\Solicitudnoadeudo;
use App\Models\Ctitulares;

class _adgIntervencionesController extends Controller
{


    public function index()
    {   
            $orga = Organitation::where('idct_direccion', Auth::user()->id_ct)
                    ->Orwhere('idct_subdireccion', Auth::user()->id_ct)
                    ->Orwhere('idct_departamento', Auth::user()->id_ct)
                    ->Orwhere('idct_sector', Auth::user()->id_ct)
                    ->Orwhere('idct_supervicion', Auth::user()->id_ct)->first();
            
            if($orga->idct_departamento==0){

                $elcct = $orga->idct_subdireccion;

            }else if($orga->idct_departamento>0){

                $elcct = $orga->idct_departamento;
            }


            $getoficix = Ctitulares::whereIdCt(Auth::user()->id_ct)->first();
            $getoficio = Ctitulares::whereIn('id_ct', [$orga->idct_direccion, $orga->idct_subdireccion, $orga->idct_departamento])->first();
            $getof = $getoficio ? $getoficio->ooficio : null;

            

            $sectores = Organitation::select('idct_sector', 'g1organigrama.cct_sector', 'g1centros_trabajo.onombre_ct')
                            ->leftJoin('g1centros_trabajo', 'g1centros_trabajo.oclave', 'g1organigrama.cct_sector')
                            ->where('idct_subdireccion', Auth::user()->id_ct)
                            ->Orwhere('idct_departamento', Auth::user()->id_ct)
                            ->whereOdireccionnivel('DIRECCION DE EDUCACION ELEMENTAL')
                            ->whereNotIn('g1organigrama.cct_sector', [1])
                            ->GroupBy('idct_sector', 'g1organigrama.cct_sector', 'g1centros_trabajo.onombre_ct')
                            ->OrderBy('g1organigrama.cct_sector', 'ASC')->get();

            $supervisiones = Organitation::select('idct_supervicion','g1organigrama.cct_supervision', 'g1centros_trabajo.onombre_ct')
                            ->leftJoin('g1centros_trabajo', 'g1centros_trabajo.oclave', 'g1organigrama.cct_supervision')
                            ->whereOdireccionnivel('DIRECCION DE EDUCACION ELEMENTAL')
                            ->where('idct_subdireccion', Auth::user()->id_ct)
                            ->Orwhere('idct_departamento', Auth::user()->id_ct)
                            ->Orwhere('idct_sector', Auth::user()->id_ct)
                            ->whereNotIn('g1organigrama.cct_supervision', [1])
                            ->GroupBy('idct_supervicion', 'cct_supervision', 'g1centros_trabajo.onombre_ct')
                            ->OrderBy('g1organigrama.cct_supervision', 'ASC')->get();
            
            $escuelas = Organitation::select('idct_escuela','cct_escuela', 'g1centros_trabajo.onombre_ct')
                            ->leftJoin('g1centros_trabajo', 'g1centros_trabajo.oclave', 'g1organigrama.cct_escuela')
                            ->whereOdireccionnivel('DIRECCION DE EDUCACION ELEMENTAL')
                            ->where('idct_subdireccion', Auth::user()->id_ct)
                            ->Orwhere('idct_departamento', Auth::user()->id_ct)
                            ->Orwhere('idct_sector', Auth::user()->id_ct)
                            ->Orwhere('idct_supervicion', Auth::user()->id_ct)
                            ->whereNotIn('cct_escuela', [1])
                            ->GroupBy('idct_escuela','cct_escuela', 'g1centros_trabajo.onombre_ct')
                            ->OrderBy('cct_escuela', 'ASC')->get();

            if(Auth::user()->orol==2)
            {

                    $intervenciones = Intervencion::select('*',
                                        DB::raw('date_format(ofecha_realizacion, "%d-%m-%Y") as fechacreacion'),
                                        DB::raw('date_format(ofecha_entrega, "%d-%m-%Y") as fechaentrega')) 
                                    ->whereNotIn('istatus',['B']) 
                                    ->whereIn('idct_departamento', [$orga->idct_direccion, $orga->idct_subdireccion, $orga->idct_departamento, $orga->idct_sector, $orga->idct_supervicion])
                                    ->whereOfin(0)->get();

                    $intervencionesc= Intervencion::whereOgenerada(1)
                                    ->whereIn('idct_departamento', [$orga->idct_direccion, $orga->idct_subdireccion, $orga->idct_departamento, $orga->idct_sector, $orga->idct_supervicion])
                                    ->whereOfin(0)->count();

            }else if(Auth::user()->orol==1){

                    $getct = Organitation::where('idct_direccion', Auth::user()->id_ct)->first();
                    $elctt = $getct->idct_direccion;

                    $intervenciones = Intervencion::select('*',
                                        DB::raw('date_format(ofecha_realizacion, "%d-%m-%Y") as fechacreacion'),
                                        DB::raw('date_format(ofecha_entrega, "%d-%m-%Y") as fechaentrega')) 
                                    ->whereNotIn('istatus',['B'])
                                    ->whereOgenerada(1)
                                    ->whereOnivel(Auth::user()->onivel)
                                    ->whereOfin(0)->get();

                    $intervencionesc= Intervencion::whereOgenerada(1)->whereOnivel(Auth::user()->onivel)->whereOfin(0)->count();
            }
            
            return view('adg.intervenciones.index',
                    compact('sectores','supervisiones','escuelas', 'intervenciones', 'intervencionesc', 'getof', 'getoficix')
                    );
    }





    public function update(Request $request, string $id)
    {   

            $orga = Organitation::where('idct_subdireccion', $id)
                                ->Orwhere('idct_departamento', $id)
                                ->Orwhere('idct_sector', $id)
                                ->Orwhere('idct_supervicion', $id)->first();

            if($orga->idct_subdireccion==0 && $orga->idct_departamento>0){
                $elctx = $orga->idct_departamento;
            }else if($orga->idct_subdireccion>1 && $orga->idct_departamento==0){
                 $elctx = $orga->idct_subdireccion;
            }else if($orga->idct_subdireccion>0 && $orga->idct_departamento>0){
                $elctx = $orga->idct_departamento;
            }

            $getoficio = Ctitulares::where('id_ct', $elctx)->first();


            $elct  = CentrosTrabajo::whereKcvect($id)->first();
            $getct = CentrosTrabajo::whereKcvect($request->idct_escuela)->first();

            $check = Intervencion::whereIdctEscuela($request->idct_escuela)->whereOfin(0)
                    ->whereOgenerada(1)->whereNotIn('istatus', ['B'])->first();


            if($request->action=='9')
            {

                    if($check)
                    {
                        return redirect(url('solicitud-intervencion'))
                                ->with("warning", "Ya existe un registro  de esta intervención");
                    }else{    
                            Intervencion::create([
                                    'idct_departamento' => $getoficio->id_ct,
                                    'oct_nivel'         => $getoficio->oclave,
                                    'onivel_educativo'  => $getoficio->onombre_ct,
                                   'otitular_nivel' => $getoficio->otitular,
                                    'ofecha_realizacion'=> date('Y-m-d'),
                                    'idct_escuela'      => $request->idct_escuela,
                                    'oclave'            => $getct->oclave,
                                    'onombrect'         => $getct->onombre_ct,
                                    'odomicilio'        => $getct->odomicilio.', '.$getct->nombre_loc.'. '.$getct->ovalle,
                                    'oentrega'          => $request->oentrega,  
                                    'orecibe'           => $request->orecibe,  
                                    'omotivo'           => $request->omotivo,
                                    'ofecha_entrega'    => $request->ofecha_entrega,
                                    'ohora_entrega'     => $request->ohora_entrega,
                                    'ogenerada'         => 1,
                                    'oanio'             => date('Y'),
                                    'onivel'            => Auth::user()->onivel,
                            ]);
                        
                            
                        require_once 'send-mails/intervencion-elemental/index.php';

                        return redirect(url('solicitud-intervencion'))
                                ->with("success", "Se ha registrado la intervención");  
                    }

            }else if($request->action=='7'){

                    $ocomisionados = Intervencion::whereIdctDepartamento($id)->whereOfin(0);
                    $ocomisionados->update([ 
                                                'ooficio'   => $getoficio->ooficio.'/'.$request->ooficio.'/'.date('Y'),  
                                                'ofin'      => 1 ,
                                                'ofechafin' => date('Y-m-d') , 
                                            ]);

                    return redirect(url('solicitud-intervencion'))
                                ->with("success", "Se ha generado el reporte, ve al reportes de intervención para su descarga");

            }else if($request->action=='19'){

                    $ocomisionados = Intervencion::whereId($request->idinter);
                    $ocomisionados->update([ 
                                            'otitular_nivel'    => $request->otitular_nivel,
                                            'ofecha_realizacion'=> date('Y-m-d'),
                                            'ooficio'           => $request->ooficio,  
                                            'oentrega'          => $request->oentrega,  
                                            'orecibe'           => $request->orecibe,  
                                            'omotivo'           => $request->omotivo,
                                            'ofecha_entrega'    => $request->ofecha_entrega,
                                            'ohora_entrega'     => $request->ohora_entrega, 
                                            ]);

                    return redirect(url('solicitud-intervencion'))
                                ->with("success", "Se actualizo el registro correctamente");

             }else if($request->action=='99'){

                    $ocomisionados = Intervencion::whereId($request->idinter);
                    $ocomisionados->update([  'istatus' => 'B' ]);

                    return redirect(url('solicitud-intervencion'))
                                ->with("INFO", "Se ha generado el reporte, ve al reportes de intervención para su descarga");

            }


    }




}
