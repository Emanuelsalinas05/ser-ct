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
        $centrotrabajo = CentrosTrabajo::get();
        $documento     = Documentos::whereId(3)->first();
        $datosacta     = DatosActa::whereIdUser(Auth::user()->id)->whereOconcluida(0)->first();

        // Validar existencia de acta activa
        if (!$datosacta) {
            // Si no hay acta, redirigir a recursos humanos, pero NO a home
            // Esto NO debería pasar después de guardar, pero por si acaso
            return redirect()->route('documentos.recursos-humanos.index')
                ->with('warning', 'No tienes un acta de entrega-recepción activa. Por favor, crea una nueva acta primero.');
        }

        $plantillac    = Plantillacomisionados::whereIdActa($datosacta->id)->whereNotIn('status', ['B'])->get();
        $plantillacc   = Plantillacomisionados::whereIdActa($datosacta->id)->whereNotIn('status', ['B'])->count();
        
        // Verificar si hay un registro "N/A"
        $tieneNoAplica = Plantillacomisionados::whereIdActa($datosacta->id)
            ->where('onombre_servidor', 'N/A')
            ->where('status', 'A')
            ->exists();
        
        $avances    = Avanceanexos::whereIdActa($datosacta->id)->first();
        
        // Si no existe avances, crear uno por defecto
        if (!$avances) {
            $avances = Avanceanexos::create([
                'id_acta' => $datosacta->id,
                'oplantilla_comisionados_a' => 0
            ]);
        }

        return view('documentos.recursos-humanos.5-3.index', 
                compact('anexo', 'documento', 'centrotrabajo', 'datosacta', 'plantillac', 'plantillacc', 'avances', 'tieneNoAplica'),
                );
    }

    public function store(Request $request)
    {
        if($request->action==1)
        {
            // Validar que el acta existe antes de procesar
            $datosacta = DatosActa::whereId($request->acta)->whereIdUser(Auth::user()->id)->whereOconcluida(0)->first();
            
            if (!$datosacta) {
                return redirect()->to('/plantilla-comisionados')
                    ->with('error', 'No se encontró un acta activa válida.');
            }

            // Si se está agregando un registro real, eliminar cualquier registro "N/A" existente
            Plantillacomisionados::where('id_acta', $request->acta)
                ->where('onombre_servidor', 'N/A')
                ->where('status', 'A')
                ->update(['status' => 'B']);

            Plantillacomisionados::create([
                'id_acta'             => $request->acta,
                'id_ct'               => Auth::user()->id_ct,
                'onombre_servidor'    => mb_strtoupper($request->onombre_servidor, 'UTF-8'),
                'ounidad_adscripcion' => $request->ounidad_adscripcion,
                'ocomisionado_act'    => $request->ocomisionado_act,
                'operiodoinicio'      => $request->operiodoinicio,
                'operiodofinal'       => $request->operiodofinal,
                'ooficio_autorizacion'=> $request->ooficio_autorizacion,
                'oobservaciones'      => mb_strtoupper($request->oobservaciones ?? '', 'UTF-8'),
                'status'              => 'A',
                'oactual'             => 1,
                'oanio'               => date('Y-m-d'),
                'option'              => 1,        
            ]);

            // Si había un registro "N/A" y ahora se agregó uno real, desmarcar el apartado como finalizado
            $avances_plantilla = Avanceanexos::whereIdActa($request->acta)->first();
            if ($avances_plantilla && $avances_plantilla->oplantilla_comisionados_a == 1) {
                $avances_plantilla->update([ 'oplantilla_comisionados_a' => 0 ]);
            }

            // Redirigir usando URL directa para evitar problemas con rutas
            return redirect()->to('/plantilla-comisionados')
                    ->with("success", "Se ha registrado correctamente el servidor comisionado");
        }

        if($request->action==2)
        {
            // Validar que el acta existe antes de procesar
            $datosacta = DatosActa::whereId($request->acta)->whereIdUser(Auth::user()->id)->whereOconcluida(0)->first();
            
            if (!$datosacta) {
                return redirect()->to('/plantilla-comisionados')
                    ->with('error', 'No se encontró un acta activa válida.');
            }

            // Eliminar todos los registros reales (no "N/A") cuando se presiona "NO APLICA"
            Plantillacomisionados::where('id_acta', $request->acta)
                ->where('onombre_servidor', '!=', 'N/A')
                ->where('status', 'A')
                ->update(['status' => 'B']);

            // Verificar si ya existe un registro "N/A" activo
            $existeNoAplica = Plantillacomisionados::where('id_acta', $request->acta)
                ->where('onombre_servidor', 'N/A')
                ->where('status', 'A')
                ->first();
            
            if (!$existeNoAplica) {
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
            } else {
                // Si ya existe, asegurarse de que esté marcado como finalizado
                $existeNoAplica->update(['ofinalizacion' => 1]);
            }

            $avances_plantilla = Avanceanexos::whereIdActa($request->acta)->first();
            if ($avances_plantilla) {
                $avances_plantilla->update([ 'oplantilla_comisionados_a' => 1 ]);
            } else {
                Avanceanexos::create([
                    'id_acta' => $request->acta,
                    'oplantilla_comisionados_a' => 1
                ]);
            }

            // Redirigir usando URL directa para evitar problemas con rutas
            return redirect()->to('/plantilla-comisionados')
                    ->with("success", "Se ha registrado correctamente la información. Este apartado ha sido finalizado.");
        }
    }

    public function update(Request $request, $id)
    {
        if($request->actioncomisionados==1)
        {
            $delete_plantilla = Plantillacomisionados::whereId($id)->whereIdActa($request->acta)->first();
            if ($delete_plantilla) {
                $esNoAplica = ($delete_plantilla->onombre_servidor == 'N/A');
                $delete_plantilla->update([ 'status' => 'B' ]);
                
                // Si se eliminó un registro "N/A", desmarcar el apartado como finalizado
                if ($esNoAplica) {
                    $avances_plantilla = Avanceanexos::whereIdActa($request->acta)->first();
                    if ($avances_plantilla) {
                        $avances_plantilla->update([ 'oplantilla_comisionados_a' => 0 ]);
                    }
                }
            }

            return redirect()->back()->with("success", "Se ha eliminado correctamente el registro"); 

        }else if($request->actioncomisionados==2){

            $finalizacion_plantilla = Plantillacomisionados::whereIdActa($request->acta)->get();
            foreach ($finalizacion_plantilla as $plantilla) {
                $plantilla->update([ 'ofinalizacion' => 1 ]);
            }

            $avances_plantilla = Avanceanexos::whereIdActa($request->acta)->first();
            if ($avances_plantilla) {
                $avances_plantilla->update(['oplantilla_comisionados_a' => 1]);
            }

            return redirect()->route('documentos.recursos-humanos.index')
                    ->with("success", "Se ha finalizado el registro de servidores comisionados");
        }   
    }
}
