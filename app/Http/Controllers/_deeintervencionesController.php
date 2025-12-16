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

class _deeintervencionesController extends Controller
{
 
    public function index()
    {
            $intervenciones = Intervencion::select('idct_departamento','oct_nivel','onivel_educativo','ourl','oarchivo', 
                            DB::raw('date_format(ofechafin, "%d-%m-%Y") as fechafin'),'ofile', 'onotificado', 'ofechafin', 
                            DB::raw('count(idct_escuela) as totalct'))
                            ->whereOfile(1)
                            ->GroupBy('idct_departamento','oct_nivel','onivel_educativo','ourl','oarchivo','ofechafin','ofile', 'onotificado')
                            ->OrderBy('ofechafin', 'DESC')
                            ->get();

             $getmensual = Intervencion::select(DB::raw('date_format(ofechafin, "%Y-%m") as fecha'), 
                                                DB::raw('date_format(ofechafin, "%m-%Y") as fechax'))
                            ->whereOnotificado(1)
                            ->GroupBy(DB::raw('date_format(ofechafin, "%Y-%m")'), 
                                      DB::raw('date_format(ofechafin, "%m-%Y")'))
                            ->OrderBy(DB::raw('date_format(ofechafin, "%Y-%m")'),'ASC')->get();


            $intervencionesc = Intervencion::whereOnotificado(1)->count();

            // Obtener información del titular para Rol 1 (Dirección)
            $getoficix = null;
            if (Auth::user()->orol == 1) {
                $getoficix = Ctitulares::whereIdCt(Auth::user()->id_ct)->first();
            }

            return view('admin.intervenciones.index',
                        compact('intervenciones', 'intervencionesc','getmensual', 'getoficix')
                        );
    }

 
    public function create()
    {
        //
    }

 
    public function store(Request $request)
    {
        //
    }

 
    public function show(string $id)
    {
        //
    }

 
    public function edit(string $id)
    {
        //
    }

 
    public function update(Request $request, string $id)
    {
        // Validar que el action existe y es válido
        if (!$request->has('action') || $request->action != '7') {
            return redirect(url('intervenciones-niveles'))
                ->with('error', 'Acción no válida.');
        }

        // Validar que solo Rol 1 (Dirección) puede generar reportes desde esta ruta
        if (Auth::user()->orol != 1) {
            return redirect(url('intervenciones-niveles'))
                ->with('error', 'Solo Dirección puede generar reportes desde esta sección.');
        }

        // Validación de datos para generar reporte
        $validated = $request->validate([
            'ooficio' => 'required|string|max:255',
        ]);

        // Obtener información del titular de la Dirección
        $getoficio = Ctitulares::whereIdCt(Auth::user()->id_ct)->first();

        // Validar que $getoficio existe
        if (!$getoficio) {
            return redirect(url('intervenciones-niveles'))
                ->with('error', 'No se encontró el titular de la Dirección.');
        }

        // Obtener todas las intervenciones del nivel ELEMENTAL que:
        // 1. Ya fueron reportadas por Rol 2 (Subdirección/Departamento): tienen ofin=1 y ofechafin
        // 2. Ya tienen un oficio de departamento asignado (no nulo, no vacío)
        // 3. Aún NO tienen el oficio de Dirección asignado
        // 
        // IMPORTANTE: El oficio de Dirección tiene el formato: {ooficio_direccion}/{consecutivo}/{año}
        // donde {ooficio_direccion} viene de Ctitulares de la Dirección (diferente al de departamento)
        // 
        // Para distinguir si ya tiene oficio de Dirección, verificamos que el oficio NO empiece con
        // el prefijo de oficio de la Dirección actual
        $prefijoOficioDireccion = $getoficio->ooficio;
        
        $intervencionesPendientes = Intervencion::whereOnivel('ELEMENTAL')
            ->whereOfin(1) // Ya finalizadas por Rol 2
            ->whereNotNull('ofechafin') // Ya tienen fecha de finalización del reporte de Rol 2
            ->whereNotNull('ooficio') // Ya tienen oficio de departamento asignado por Rol 2
            ->where('ooficio', '!=', '') // El oficio no está vacío
            ->whereNotIn('istatus', ['B'])
            // Verificar que el oficio NO empiece con el prefijo de la Dirección
            // Esto significa que aún tiene el oficio de departamento, no el de Dirección
            ->where('ooficio', 'NOT LIKE', $prefijoOficioDireccion.'/%')
            ->get();

        $totalIntervenciones = $intervencionesPendientes->count();

        // Si no hay intervenciones pendientes, no se puede generar el reporte
        if ($totalIntervenciones == 0) {
            return redirect(url('intervenciones-niveles'))
                ->with('warning', 'No hay intervenciones pendientes para generar el reporte. Todas las intervenciones ya tienen oficio asignado.');
        }

        // Generar número de oficio completo
        $numeroOficioCompleto = $getoficio->ooficio.'/'.$validated['ooficio'].'/'.date('Y');
        
        // Obtener los IDs de los departamentos únicos para actualizar
        $departamentosIds = $intervencionesPendientes->pluck('idct_departamento')->unique()->toArray();
        
        // Actualizar todas las intervenciones pendientes con el nuevo oficio de Dirección
        // IMPORTANTE: Esto REEMPLAZA el oficio de departamento con el oficio de Dirección
        // El oficio de Dirección agrupa todas las intervenciones de todos los departamentos
        // en un solo reporte consolidado para Coordinación (Rol 99)
        Intervencion::whereOnivel('ELEMENTAL')
            ->whereOfin(1) // Ya finalizadas por Rol 2
            ->whereNotNull('ofechafin') // Ya tienen fecha de finalización del reporte de Rol 2
            ->whereNotNull('ooficio') // Ya tienen oficio de departamento
            ->where('ooficio', '!=', '') // El oficio no está vacío
            ->whereNotIn('istatus', ['B'])
            // Solo actualizar las que aún NO tienen el oficio de Dirección
            ->where('ooficio', 'NOT LIKE', $prefijoOficioDireccion.'/%')
            ->update([ 
                'ooficio'   => $numeroOficioCompleto, // Nuevo oficio de Dirección (reemplaza el de departamento)
                'ofin'      => 1, // Ya están finalizadas, se mantiene
                'ofechafin' => date('Y-m-d'), // Actualizar fecha de finalización del reporte de Dirección
            ]);

        // Enviar correo de notificación a Coordinación (Rol 1 → Rol 99)
        // Solo si se actualizaron intervenciones
        if ($totalIntervenciones > 0) {
            try {
                // Preparar variables para el correo
                $getoficio_temp = $getoficio; // Para compatibilidad con el script de correo
                $numero_oficio = $numeroOficioCompleto;
                $fecha_oficio = date('Y-m-d');
                $total_intervenciones = $totalIntervenciones;
                $nivel_educativo = $getoficio->onombre_ct ?? 'DIRECCIÓN DE EDUCACIÓN ELEMENTAL';
                $destino_dee = true; // Indicar que el correo va a Coordinación
                
                // Incluir y ejecutar el script de correo
                require_once public_path('send-mails/intervencion-coordinacion/index.php');
            } catch (\Throwable $e) {
                // Error silencioso en el envío de correo, no bloquea el proceso
                // El oficio ya se generó correctamente
                \Log::error('Error al enviar correo a Coordinación desde Dirección', [
                    'error' => $e->getMessage(),
                    'direccion_id' => $id,
                    'oficio' => $numeroOficioCompleto
                ]);
            }
        }

        return redirect(url('intervenciones-niveles'))
                    ->with("success", "Se ha generado el reporte DEE → Coordinación. Se ha notificado a Coordinación Académica.");
    }

 
    public function destroy(string $id)
    {
        //
    }
}
