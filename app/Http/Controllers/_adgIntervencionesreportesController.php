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

class _adgIntervencionesreportesController extends Controller
{



    public function edit(string $id)
    {
        
        if(Auth::user()->orol==2)
        {
            // Obtener las escuelas que están bajo la supervisión del usuario actual
            $escuelasPermitidas = Organitation::where('idct_direccion', Auth::user()->id_ct)
                ->orWhere('idct_subdireccion', Auth::user()->id_ct)
                ->orWhere('idct_departamento', Auth::user()->id_ct)
                ->orWhere('idct_sector', Auth::user()->id_ct)
                ->orWhere('idct_supervicion', Auth::user()->id_ct)
                ->whereNotNull('idct_escuela')
                ->where('idct_escuela', '>', 0)
                ->pluck('idct_escuela')
                ->unique()
                ->toArray();

            $intervencionesc= Intervencion::select('idct_departamento', 'oct_nivel', 'onivel_educativo', 'onotificado')
                                ->whereIn('idct_escuela', $escuelasPermitidas)->whereOfin(1)->whereNotIn('istatus',['B'])
                                ->GroupBy('idct_departamento', 'oct_nivel', 'onivel_educativo', 'onotificado')
                                ->count();

            $intervenciones = Intervencion::select('idct_departamento','oct_nivel','onivel_educativo','ofechafin','ourl','oarchivo','ofile','onotificado',
                                DB::raw('date_format(ofechafin, "%d/%m/%Y") as fechaentrega')) 
                                ->whereIn('idct_escuela', $escuelasPermitidas)->whereOfin(1)->whereNotIn('istatus',['B'])
                                ->GroupBy('idct_departamento', 'oct_nivel', 'onivel_educativo','ofechafin','ourl','oarchivo','ofile','onotificado')
                                ->OrderBy('ofechafin', 'DESC')
                                ->get();

        }else if(Auth::user()->orol==1){

            // Obtener información del titular de la Dirección para identificar el prefijo del oficio
            $getoficio = \App\Models\Ctitulares::whereIdCt(Auth::user()->id_ct)->first();
            
            if (!$getoficio) {
                $intervenciones = collect();
                $intervencionesc = 0;
            } else {
                $prefijoOficioDireccion = $getoficio->ooficio;
                
                // HISTORIAL DE REPORTES GENERADOS POR ROL 1 HACIA ROL 99 (COORDINACIÓN)
                // Solo mostrar reportes que tienen el oficio de Dirección asignado
                // Estos son los reportes que Rol 1 generó y envió a Coordinación
                $intervenciones = Intervencion::select([
                                    'idct_departamento',
                                    'oct_nivel',
                                    'onivel_educativo',
                                    'ofechafin',
                                    'ourl',
                                    'oarchivo',
                                    'ofile',
                                    'onotificado',
                                    'ooficio',
                                    DB::raw('date_format(ofechafin, "%d/%m/%Y") as fechaentrega')
                                ])
                                ->whereOnivel('ELEMENTAL')
                                ->whereOfin(1)
                                ->whereNotNull('ooficio')
                                ->where('ooficio', '!=', '')
                                ->where('ooficio', 'LIKE', $prefijoOficioDireccion.'/%') // Solo oficios de Dirección
                                ->whereNotIn('istatus', ['B'])
                                ->groupBy('idct_departamento', 'oct_nivel', 'onivel_educativo', 'ofechafin', 'ourl', 'oarchivo', 'ofile', 'onotificado', 'ooficio')
                                ->orderBy('ofechafin', 'DESC')
                                ->get();

                // Contar reportes generados por Dirección
                $intervencionesc = Intervencion::whereOnivel('ELEMENTAL')
                                    ->whereOfin(1)
                                    ->whereNotNull('ooficio')
                                    ->where('ooficio', '!=', '')
                                    ->where('ooficio', 'LIKE', $prefijoOficioDireccion.'/%') // Solo oficios de Dirección
                                    ->whereNotIn('istatus', ['B'])
                                    ->select('idct_departamento', 'oct_nivel', 'onivel_educativo', 'onotificado', 'ooficio')
                                    ->groupBy('idct_departamento', 'oct_nivel', 'onivel_educativo', 'onotificado', 'ooficio')
                                    ->count();
            }

        }else if(Auth::user()->orol==99){

            // Coordinación Académica y de Operación Educativa (rol 99)
            // Ve TODAS las intervenciones del nivel ELEMENTAL de TODOS los departamentos
            // Optimización: Consulta más eficiente con orden optimizado de condiciones WHERE
            $intervenciones = Intervencion::select([
                                'idct_departamento',
                                'oct_nivel',
                                'onivel_educativo',
                                'ofechafin',
                                'ourl',
                                'oarchivo',
                                'ofile',
                                'onotificado',
                                DB::raw('date_format(ofechafin, "%d/%m/%Y") as fechaentrega')
                            ])
                            ->whereOnivel('ELEMENTAL')  // Primero por índice
                            ->whereOfin(1)
                            ->whereNotIn('istatus', ['B'])
                            ->groupBy('idct_departamento', 'oct_nivel', 'onivel_educativo', 'ofechafin', 'ourl', 'oarchivo', 'ofile', 'onotificado')
                            ->orderBy('ofechafin', 'DESC')
                            ->get();

            // Optimización: Usar la misma consulta base para contar
            $intervencionesc = Intervencion::whereOnivel('ELEMENTAL')
                                ->whereOfin(1)
                                ->whereNotIn('istatus', ['B'])
                                ->select('idct_departamento', 'oct_nivel', 'onivel_educativo', 'onotificado')
                                ->groupBy('idct_departamento', 'oct_nivel', 'onivel_educativo', 'onotificado')
                                ->count();
        }



        return view('adg.intervenciones.reports.edit',
                compact('intervencionesc', 'intervenciones',)
                );
    }



    public function update(Request $request, string $id)
    {
        
        if($request->action=='99')
        {
                    // Comentado: No se debe revertir el estado de la intervención
                    // La intervención debe mantenerse finalizada hasta que se solicite una nueva
                    /*
                    $ocomisionados = Intervencion::whereIdctDepartamento($id)->whereOfechafin($request->fecfin);
                    $ocomisionados->update([  
                                                'ofin'      => 0 , 
                                                'ofechafin' => null
                                            ]);
                    */

                    return redirect(url('reportes-intervencion/'.$id.'/edit'))
                                ->with("info", "La intervención se mantiene finalizada. Para iniciar un nuevo proceso, se debe solicitar una nueva intervención.");

            }
    }



    public function store(Request $request)
    {
        $user   = User::whereIdCt(Auth::user()->id_ct)->first(); 
        $adg    = $user->oct;
        $fecha  = $request->fecfin; 

        if($request->action=='1')
        {
            $nombredoc = str_replace(' ', '',$request->onombre_documento);
            $file = $request->file('onombre_archivo');

            if($request->hasFile('onombre_archivo'))
            {
                    $file->storeAs('intervenciones/'.$adg.'/'.$fecha, $nombredoc.'.'.$file->extension(), 'public');

                    $ocomisionados = Intervencion::whereIdctDepartamento(Auth::user()->id_ct)->whereOfechafin($fecha);
                    $ocomisionados->update([
                                            'ourl'      => 'storage/intervenciones/'.$adg.'/'.$fecha.'/'.$nombredoc.'.'.$file->extension(),
                                            'oarchivo'  => $nombredoc,
                                            'ofile'     => 1,   
                                            ]);

                    $intervencionct = Intervencion::whereIdctDepartamento(Auth::user()->id_ct)->whereOfechafin($fecha)->first();
                    $intervenciones = Intervencion::whereIdctDepartamento(Auth::user()->id_ct)->whereOfechafin($fecha)->get();

                    require_once public_path('send-mails/notificaciones/index.php');

                    return redirect()->back()->with("success", "Se ha cargado el archivo $nombredoc correctamente");

            }else{
                    return redirect()->back()->with("warning", "No se ha cargado ningún archivo");
            }

        }
  
    }






}
