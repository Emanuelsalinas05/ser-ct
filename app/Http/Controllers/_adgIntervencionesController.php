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
            // Validar que solo roles administrativos (1, 2, 99) pueden acceder
            // Rol 3 (Entregador/Escuela) NO debe acceder a este proceso
            if (Auth::user()->orol == 3) {
                return redirect()->route('home')
                    ->with('error', 'No tiene permisos para acceder a esta sección.');
            }

            $orga = Organitation::where('idct_direccion', Auth::user()->id_ct)
                    ->Orwhere('idct_subdireccion', Auth::user()->id_ct)
                    ->Orwhere('idct_departamento', Auth::user()->id_ct)
                    ->Orwhere('idct_sector', Auth::user()->id_ct)
                    ->Orwhere('idct_supervicion', Auth::user()->id_ct)->first();
            
            // Validar que $orga existe
            if (!$orga) {
                return redirect()->route('home')
                    ->with('error', 'No se encontró la organización del usuario.');
            }
            
            if($orga->idct_departamento==0){

                $elcct = $orga->idct_subdireccion;

            }else if($orga->idct_departamento>0){

                $elcct = $orga->idct_departamento;
            }


            $getoficix = Ctitulares::whereIdCt(Auth::user()->id_ct)->first();
            $getoficio = Ctitulares::whereIn('id_ct', [$orga->idct_direccion, $orga->idct_subdireccion, $orga->idct_departamento])->first();
            $getof = $getoficio ? $getoficio->ooficio : null;

            

            // Optimización: Consulta más eficiente de sectores
            $sectores = Organitation::select('idct_sector', 'g1organigrama.cct_sector', 'g1centros_trabajo.onombre_ct')
                            ->leftJoin('g1centros_trabajo', 'g1centros_trabajo.oclave', 'g1organigrama.cct_sector')
                            ->whereOdireccionnivel('DIRECCION DE EDUCACION ELEMENTAL')  // Primero el filtro más restrictivo
                            ->where(function($query) {
                                $query->where('idct_subdireccion', Auth::user()->id_ct)
                                      ->orWhere('idct_departamento', Auth::user()->id_ct);
                            })
                            ->whereNotIn('g1organigrama.cct_sector', [1])
                            ->groupBy('idct_sector', 'g1organigrama.cct_sector', 'g1centros_trabajo.onombre_ct')
                            ->orderBy('g1organigrama.cct_sector', 'ASC')
                            ->get();

            // Optimización: Consulta más eficiente de supervisiones
            $supervisiones = Organitation::select('idct_supervicion','g1organigrama.cct_supervision', 'g1centros_trabajo.onombre_ct')
                            ->leftJoin('g1centros_trabajo', 'g1centros_trabajo.oclave', 'g1organigrama.cct_supervision')
                            ->whereOdireccionnivel('DIRECCION DE EDUCACION ELEMENTAL')  // Primero el filtro más restrictivo
                            ->where(function($query) {
                                $query->where('idct_subdireccion', Auth::user()->id_ct)
                                      ->orWhere('idct_departamento', Auth::user()->id_ct)
                                      ->orWhere('idct_sector', Auth::user()->id_ct);
                            })
                            ->whereNotIn('g1organigrama.cct_supervision', [1])
                            ->groupBy('idct_supervicion', 'cct_supervision', 'g1centros_trabajo.onombre_ct')
                            ->orderBy('g1organigrama.cct_supervision', 'ASC')
                            ->get();
            
            // Optimización: Consulta más eficiente de escuelas
            $escuelas = Organitation::select('idct_escuela','cct_escuela', 'g1centros_trabajo.onombre_ct')
                            ->leftJoin('g1centros_trabajo', 'g1centros_trabajo.oclave', 'g1organigrama.cct_escuela')
                            ->whereOdireccionnivel('DIRECCION DE EDUCACION ELEMENTAL')  // Primero el filtro más restrictivo
                            ->where(function($query) {
                                $query->where('idct_subdireccion', Auth::user()->id_ct)
                                      ->orWhere('idct_departamento', Auth::user()->id_ct)
                                      ->orWhere('idct_sector', Auth::user()->id_ct)
                                      ->orWhere('idct_supervicion', Auth::user()->id_ct);
                            })
                            ->whereNotIn('cct_escuela', [1])
                            ->groupBy('idct_escuela','cct_escuela', 'g1centros_trabajo.onombre_ct')
                            ->orderBy('cct_escuela', 'ASC')
                            ->get();

            if(Auth::user()->orol==2)
            {
                    // Optimización: Obtener las escuelas que están bajo la supervisión del usuario actual
                    $escuelasPermitidas = Organitation::where(function($query) {
                                $query->where('idct_direccion', Auth::user()->id_ct)
                                      ->orWhere('idct_subdireccion', Auth::user()->id_ct)
                                      ->orWhere('idct_departamento', Auth::user()->id_ct)
                                      ->orWhere('idct_sector', Auth::user()->id_ct)
                                      ->orWhere('idct_supervicion', Auth::user()->id_ct);
                            })
                            ->whereNotNull('idct_escuela')
                            ->where('idct_escuela', '>', 0)
                            ->pluck('idct_escuela')
                            ->unique()
                            ->toArray();

                    // Optimización: Consulta más eficiente con campos específicos y orden optimizado
                    // Usar índices: idct_escuela, ogenerada, ofin, istatus
                    $intervenciones = Intervencion::select([
                                        'id',
                                        'idct_departamento',
                                        'oct_nivel',
                                        'onivel_educativo',
                                        'otitular_nivel',
                                        'idct_escuela',
                                        'oclave',
                                        'onombrect',
                                        'odomicilio',
                                        'oentrega',
                                        'orecibe',
                                        'omotivo',
                                        'ofecha_realizacion',
                                        'ofecha_entrega',
                                        'ohora_entrega',
                                        'ooficio',
                                        'ogenerada',
                                        'oanio',
                                        'onivel',
                                        DB::raw('date_format(ofecha_realizacion, "%d/%m/%Y") as fechacreacion'),
                                        DB::raw('date_format(ofecha_entrega, "%d/%m/%Y") as fechaentrega')
                                    ])
                                    ->whereIn('idct_escuela', $escuelasPermitidas)  // Primero por índice
                                    ->whereOgenerada(1)
                                    ->whereOfin(0)
                                    ->whereNotIn('istatus', ['B'])
                                    ->orderBy('ofecha_realizacion', 'DESC')
                                    ->get();

                    // Optimización: Usar la misma consulta base para contar
                    $intervencionesc = Intervencion::whereIn('idct_escuela', $escuelasPermitidas)
                                    ->whereOgenerada(1)
                                    ->whereOfin(0)
                                    ->whereNotIn('istatus', ['B'])
                                    ->count();

            }else if(Auth::user()->orol==1){

                    $getct = Organitation::where('idct_direccion', Auth::user()->id_ct)->first();
                    // Validar que $getct existe
                    if (!$getct) {
                        return redirect()->route('home')
                            ->with('error', 'No se encontró la organización del usuario.');
                    }
                    $elctt = $getct->idct_direccion;

                    // Optimización: Consulta más eficiente con campos específicos y orden optimizado
                    // Usar índices: onivel, ogenerada, ofin, istatus
                    $intervenciones = Intervencion::select([
                                        'id',
                                        'idct_departamento',
                                        'oct_nivel',
                                        'onivel_educativo',
                                        'otitular_nivel',
                                        'idct_escuela',
                                        'oclave',
                                        'onombrect',
                                        'odomicilio',
                                        'oentrega',
                                        'orecibe',
                                        'omotivo',
                                        'ofecha_realizacion',
                                        'ofecha_entrega',
                                        'ohora_entrega',
                                        'ooficio',
                                        'ogenerada',
                                        'oanio',
                                        'onivel',
                                        DB::raw('date_format(ofecha_realizacion, "%d/%m/%Y") as fechacreacion'),
                                        DB::raw('date_format(ofecha_entrega, "%d/%m/%Y") as fechaentrega')
                                    ])
                                    ->whereOnivel(Auth::user()->onivel)  // Primero por índice
                                    ->whereOgenerada(1)
                                    ->whereOfin(0)
                                    ->whereNotIn('istatus', ['B'])
                                    ->orderBy('ofecha_realizacion', 'DESC')
                                    ->get();

                    // Optimización: Usar la misma consulta base para contar
                    $intervencionesc = Intervencion::whereOnivel(Auth::user()->onivel)
                                    ->whereOgenerada(1)
                                    ->whereOfin(0)
                                    ->whereNotIn('istatus', ['B'])
                                    ->count();

            }else if(Auth::user()->orol==99){

                    // Coordinación Académica y de Operación Educativa (rol 99)
                    // Ve TODAS las intervenciones del nivel ELEMENTAL de TODOS los departamentos
                    // Optimización: Consulta más eficiente con campos específicos
                    $intervenciones = Intervencion::select([
                                        'id',
                                        'idct_departamento',
                                        'oct_nivel',
                                        'onivel_educativo',
                                        'otitular_nivel',
                                        'idct_escuela',
                                        'oclave',
                                        'onombrect',
                                        'odomicilio',
                                        'oentrega',
                                        'orecibe',
                                        'omotivo',
                                        'ofecha_realizacion',
                                        'ofecha_entrega',
                                        'ohora_entrega',
                                        'ooficio',
                                        'ogenerada',
                                        'oanio',
                                        'onivel',
                                        DB::raw('date_format(ofecha_realizacion, "%d/%m/%Y") as fechacreacion'),
                                        DB::raw('date_format(ofecha_entrega, "%d/%m/%Y") as fechaentrega')
                                    ])
                                    ->whereOnivel('ELEMENTAL')  // Primero por índice
                                    ->whereOgenerada(1)
                                    ->whereOfin(0)
                                    ->whereNotIn('istatus', ['B'])
                                    ->orderBy('ofecha_realizacion', 'DESC')
                                    ->get();

                    // Optimización: Usar la misma consulta base para contar
                    $intervencionesc = Intervencion::whereOnivel('ELEMENTAL')
                                    ->whereOgenerada(1)
                                    ->whereOfin(0)
                                    ->whereNotIn('istatus', ['B'])
                                    ->count();
            }
            
            return view('adg.intervenciones.index',
                    compact('sectores','supervisiones','escuelas', 'intervenciones', 'intervencionesc', 'getof', 'getoficix')
                    );
    }





    public function update(Request $request, string $id)
    {   
            // Validar que el action existe y es válido
            $validActions = ['9', '7', '19', '99'];
            if (!$request->has('action') || !in_array($request->action, $validActions)) {
                return redirect(url('solicitud-intervencion'))
                    ->with('error', 'Acción no válida.');
            }

            // Validar permisos del usuario
            if (Auth::user()->orol != 2 && $request->action != '7') {
                return redirect(url('solicitud-intervencion'))
                    ->with('error', 'No tiene permisos para realizar esta acción.');
            }

            $orga = Organitation::where('idct_subdireccion', $id)
                                ->Orwhere('idct_departamento', $id)
                                ->Orwhere('idct_sector', $id)
                                ->Orwhere('idct_supervicion', $id)->first();

            // Validar que $orga existe
            if (!$orga) {
                return redirect(url('solicitud-intervencion'))
                    ->with('error', 'No se encontró la organización del usuario.');
            }

            if($orga->idct_subdireccion==0 && $orga->idct_departamento>0){
                $elctx = $orga->idct_departamento;
            }else if($orga->idct_subdireccion>1 && $orga->idct_departamento==0){
                 $elctx = $orga->idct_subdireccion;
            }else if($orga->idct_subdireccion>0 && $orga->idct_departamento>0){
                $elctx = $orga->idct_departamento;
            }

            $getoficio = Ctitulares::where('id_ct', $elctx)->first();

            // Validar que $getoficio existe
            if (!$getoficio) {
                return redirect(url('solicitud-intervencion'))
                    ->with('error', 'No se encontró el titular del nivel.');
            }

            $elct  = CentrosTrabajo::whereKcvect($id)->first();
            
            if($request->action=='9')
            {
                    // Validación de datos para crear intervención
                    $validated = $request->validate([
                        'idct_escuela' => 'required|integer|exists:g1centros_trabajo,kcvect',
                        'oentrega' => 'required|string|max:255',
                        'orecibe' => 'required|string|max:255',
                        'omotivo' => 'required|string|max:500',
                        'ofecha_entrega' => 'required|date',
                        'ohora_entrega' => 'required|date_format:H:i',
                    ]);

                    $getct = CentrosTrabajo::whereKcvect($request->idct_escuela)->first();

                    // Validar que $getct existe
                    if (!$getct) {
                        return redirect(url('solicitud-intervencion'))
                            ->with('error', 'No se encontró el centro de trabajo seleccionado.');
                    }

                    $check = Intervencion::whereIdctEscuela($request->idct_escuela)->whereOfin(0)
                            ->whereOgenerada(1)->whereNotIn('istatus', ['B'])->first();

                    if($check)
                    {
                        return redirect(url('solicitud-intervencion'))
                                ->with("warning", "Ya existe un registro  de esta intervención");
                    }else{
                            // Mejorar concatenación de domicilio
                            $domicilioParts = array_filter([
                                $getct->odomicilio,
                                $getct->nombre_loc,
                                $getct->ovalle
                            ]);
                            $domicilio = trim(implode(', ', $domicilioParts));

                            Intervencion::create([
                                    'idct_departamento' => $getoficio->id_ct,
                                    'oct_nivel'         => $getoficio->oclave,
                                    'onivel_educativo'  => $getoficio->onombre_ct,
                                   'otitular_nivel' => $getoficio->otitular,
                                    'ofecha_realizacion'=> date('Y-m-d'),
                                    'idct_escuela'      => $validated['idct_escuela'],
                                    'oclave'            => $getct->oclave,
                                    'onombrect'         => $getct->onombre_ct,
                                    'odomicilio'        => $domicilio,
                                    'oentrega'          => $validated['oentrega'],  
                                    'orecibe'           => $validated['orecibe'],  
                                    'omotivo'           => $validated['omotivo'],
                                    'ofecha_entrega'    => $validated['ofecha_entrega'],
                                    'ohora_entrega'     => $validated['ohora_entrega'],
                                    'ogenerada'         => 1,
                                    'oanio'             => date('Y'),
                                    'onivel'            => Auth::user()->onivel,
                            ]);
                        
                            
                        require_once public_path('send-mails/intervencion-elemental/index.php');

                        return redirect(url('solicitud-intervencion'))
                                ->with("success", "Se ha registrado la intervención");  
                    }

            }else if($request->action=='7'){

                    // Validación de datos para generar reporte
                    $validated = $request->validate([
                        'ooficio' => 'required|string|max:255',
                    ]);

                    // Validar que $getoficio existe
                    if (!$getoficio) {
                        return redirect(url('solicitud-intervencion'))
                            ->with('error', 'No se encontró el titular del nivel.');
                    }

                    $ocomisionados = Intervencion::whereIdctDepartamento($id)->whereOfin(0);
                    $ocomisionados->update([ 
                                                'ooficio'   => $getoficio->ooficio.'/'.$validated['ooficio'].'/'.date('Y'),  
                                                'ofin'      => 1 ,
                                                'ofechafin' => date('Y-m-d') , 
                                            ]);

                    return redirect(url('solicitud-intervencion'))
                                ->with("success", "Se ha generado el reporte, ve al reportes de intervención para su descarga");

            }else if($request->action=='19'){

                    // Validación de datos para editar intervención
                    $validated = $request->validate([
                        'idinter' => 'required|integer|exists:b3adg_intervenciones,id',
                        'otitular_nivel' => 'required|string|max:255',
                        'ooficio' => 'nullable|string|max:255',
                        'oentrega' => 'required|string|max:255',
                        'orecibe' => 'required|string|max:255',
                        'omotivo' => 'required|string|max:500',
                        'ofecha_entrega' => 'required|date',
                        'ohora_entrega' => 'required|date_format:H:i',
                    ]);

                    $ocomisionados = Intervencion::whereId($validated['idinter']);
                    
                    // Verificar que la intervención existe
                    if (!$ocomisionados->exists()) {
                        return redirect(url('solicitud-intervencion'))
                            ->with('error', 'La intervención no existe.');
                    }

                    $ocomisionados->update([ 
                                            'otitular_nivel'    => $validated['otitular_nivel'],
                                            'ofecha_realizacion'=> date('Y-m-d'),
                                            'ooficio'           => $validated['ooficio'] ?? null,  
                                            'oentrega'          => $validated['oentrega'],  
                                            'orecibe'           => $validated['orecibe'],  
                                            'omotivo'           => $validated['omotivo'],
                                            'ofecha_entrega'    => $validated['ofecha_entrega'],
                                            'ohora_entrega'     => $validated['ohora_entrega'], 
                                            ]);

                    return redirect(url('solicitud-intervencion'))
                                ->with("success", "Se actualizó el registro correctamente");

             }else if($request->action=='99'){

                    // Validación de datos para eliminar intervención
                    $validated = $request->validate([
                        'idinter' => 'required|integer|exists:b3adg_intervenciones,id',
                    ]);

                    $ocomisionados = Intervencion::whereId($validated['idinter']);
                    
                    // Verificar que la intervención existe
                    if (!$ocomisionados->exists()) {
                        return redirect(url('solicitud-intervencion'))
                            ->with('error', 'La intervención no existe.');
                    }

                    $ocomisionados->update([  'istatus' => 'B' ]);

                    return redirect(url('solicitud-intervencion'))
                                ->with("success", "Se ha eliminado el registro de intervención correctamente");

            }


    }




}
