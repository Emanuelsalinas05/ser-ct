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
use App\Models\Plantillacomisionados;

class PlantillaComisionadosController extends Controller
{   
    public function index()
    {
        $anexo         = Anexos::whereOnumAnexo(5)->first();
        // Excluir escuelas particulares: filtrar por omodalidad y rcvesostenimiento
        // No se puede comisionar personal a CCT particulares
        // Nota: ostatus es numérico (1 = ACTIVO), no string
        $centrotrabajo = CentrosTrabajo::where('ostatus', 1)
                                        // Excluir cualquier variación de "PARTICULAR" en omodalidad (case-insensitive)
                                        // Y excluir si rcvesostenimiento es 3 (Particular)
                                        ->where(function($query) {
                                            $query->whereRaw('UPPER(TRIM(COALESCE(omodalidad, ""))) NOT LIKE ?', ['%PARTICULAR%'])
                                                  ->where(function($q) {
                                                      $q->whereNull('rcvesostenimiento')
                                                        ->orWhere('rcvesostenimiento', '!=', '3')
                                                        ->orWhere('rcvesostenimiento', '!=', 3);
                                                  });
                                        })
                                        ->orderBy('onombre_ct', 'ASC')
                                        ->get();
        $documento     = Documentos::whereId(3)->first();
        $datosacta     = DatosActa::whereIdUser(Auth::user()->id)->whereOconcluida(0)->first();

        // Validar existencia de acta activa
        if (!$datosacta) {
            return redirect()->route('documentos.recursos-humanos.index')
                ->with('warning', 'No tienes un acta de entrega-recepción activa. Por favor, crea una nueva acta primero.');
        }

        $plantillac    = Plantillacomisionados::whereIdActa($datosacta->id)->whereNotIn('status', ['B'])->get();
        $plantillacc   = Plantillacomisionados::whereIdActa($datosacta->id)->whereNotIn('status', ['B'])->count();
        
        $avances    = Avanceanexos::whereIdActa($datosacta->id)->first();

        return view('documentos.recursos-humanos.5-3.index', 
                compact('anexo', 'documento', 'centrotrabajo', 'datosacta', 'plantillac', 'plantillacc', 'avances'),
                );
    }



    public function store(Request $request)
    {
        //$plantillac = Plantillacomisionados::whereIdActa($datosacta->id)->whereNotIn('status', ['B'])->get();

        if($request->action==1)
        {
            // Usar transacción para prevenir condición de carrera (race condition) en doble clic
            return DB::transaction(function () use ($request) {
                // Validar duplicidad con bloqueo de fila para prevenir inserción simultánea
                $duplicado = Plantillacomisionados::where('id_acta', $request->acta)
                                                ->where('onombre_servidor', mb_strtoupper(trim($request->onombre_servidor), 'UTF-8'))
                                                ->where('operiodoinicio', $request->operiodoinicio)
                                                ->where('ounidad_adscripcion', $request->ounidad_adscripcion)
                                                ->where('ocomisionado_act', $request->ocomisionado_act)
                                                ->where('status', 'A')
                                                ->lockForUpdate()  // Bloquear filas para prevenir inserción simultánea
                                                ->exists();
                
                if($duplicado) {
                    return redirect()->back()->with("error", "Ya existe un registro con los mismos datos. Verifique la información.");
                }

                // Verificar duplicado reciente (prevención adicional contra doble clic)
                // Verificar si se creó un registro idéntico en los últimos 3 segundos
                $duplicadoReciente = Plantillacomisionados::where('id_acta', $request->acta)
                                                        ->where('onombre_servidor', mb_strtoupper(trim($request->onombre_servidor), 'UTF-8'))
                                                        ->where('operiodoinicio', $request->operiodoinicio)
                                                        ->where('ounidad_adscripcion', $request->ounidad_adscripcion)
                                                        ->where('ocomisionado_act', $request->ocomisionado_act)
                                                        ->where('status', 'A')
                                                        ->whereRaw('TIMESTAMPDIFF(SECOND, created_at, NOW()) BETWEEN 0 AND 3')  // Últimos 3 segundos
                                                        ->lockForUpdate()
                                                        ->exists();
                
                if($duplicadoReciente) {
                    return redirect()->back()->with("error", "Por favor, espere un momento. El registro ya está siendo procesado.");
                }

                Plantillacomisionados::create([
                    'id_acta'             => $request->acta,
                    'id_ct'               => Auth::user()->id_ct,
                    'onombre_servidor'    => mb_strtoupper(trim($request->onombre_servidor), 'UTF-8'),
                    'ounidad_adscripcion' => $request->ounidad_adscripcion,
                    'ocomisionado_act'    => $request->ocomisionado_act,
                    'operiodoinicio'      => $request->operiodoinicio,
                    'operiodofinal'       => $request->operiodofinal,
                    'ooficio_autorizacion'=> $request->ooficio_autorizacion,
                    'oobservaciones'      => mb_strtoupper(trim($request->oobservaciones), 'UTF-8'),
                    'status'              => 'A',
                    'oactual'             => 1,
                    'oanio'               => date('Y-m-d'),
                    'option'              => 1,        
                ]);
                
                return redirect()->back()->with("success", "Se ha registrado correctamente el servidor comisionado");
            });
        }
        if($request->action==2)
        {
            Plantillacomisionados::create([
                'id_acta'             => $request->acta,
                'id_ct'               => Auth::user()->id_ct,
                'onombre_servidor'    => 'N/A',
                'ounidad_adscripcion' => 'N/A',
                'ocomisionado_act'    => 'N/A',
                'operiodoinicio'      => 'N/A',
                'operiodofinal'       => 'N/A',
                'ooficio_autorizacion'=> 'N/A',
                'oobservaciones'      => 'N/A',
                'status'              => 'A',
                'oactual'             => 1,
                'oanio'               => date('Y-m-d'),
                'ofinalizacion'       => 1,
                'option'              => 2,        
            ]);

            $avances_plantilla = Avanceanexos::whereIdActa($request->acta);
            $avances_plantilla->update([ 'oplantilla_comisionados_a' => 1 ]);
  
            return redirect()->back()->with("success", "Se ha registrado correctamente la información");
        }
    }



    public function update(Request $request, $id)
    {
        if($request->actioncomisionados==1)
        {
            $delete_plantilla = Plantillacomisionados::whereId($id)->whereIdActa($request->acta);
            $delete_plantilla->update([ 'status' => 'B', ]);
  
            return redirect()->back()->with("success", "Se ha eliminado correctamente el registro"); 
  
        }else if($request->actioncomisionados==2){

            $finalizacion_plantilla = Plantillacomisionados::whereIdActa($request->acta);
            $finalizacion_plantilla->update([ 'ofinalizacion' => 1 ]);

            $avances_plantilla = Avanceanexos::whereIdActa($request->acta);
            $avances_plantilla->update(['oplantilla_comisionados_a' => 1 , 
                                        ]);
  
            return redirect()->route('documentos.recursos-humanos.index')
                    ->with("success", "Se ha finalizado el registro de relación de servidores públicos comisionados");
        }   
    }

}
