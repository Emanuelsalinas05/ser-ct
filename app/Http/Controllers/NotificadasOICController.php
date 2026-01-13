<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use App\Models\DatosActa;

class NotificadasOICController extends Controller
{
    /**
     * Muestra las entregas finalizadas que han sido notificadas al OIC
     * Solo accesible para administradores (orol == 1)
     */
    public function index()
    {
        // Solo permitir acceso a administradores
        if (Auth::user()->orol != 1) {
            abort(403, 'No tienes permiso para acceder a esta sección.');
        }

        // Obtener actas finalizadas que han sido notificadas al OIC
        // Cargar relaciones necesarias para la vista
        // Calcular unidad administrativa usando organigrama
        // Ordenar por fecha de envío del correo (updated_at) para mostrar primero las más recientes
        $datosacta = DatosActa::select(
                    DB::raw('distinct(g1acta.id) as idd'), 
                    'g1acta.*',
                    'g1organigrama.idct_subdireccion',
                    'g1organigrama.idct_departamento',
                    DB::raw('CASE 
                                WHEN g1organigrama.idct_departamento=0 OR g1organigrama.idct_departamento IS NULL
                                THEN (SELECT CONCAT(oclave," - ",onombre_ct) FROM g1centros_trabajo WHERE kcvect=g1organigrama.idct_subdireccion LIMIT 1)
                                ELSE (SELECT CONCAT(oclave," - ",onombre_ct) FROM g1centros_trabajo WHERE kcvect=g1organigrama.idct_departamento LIMIT 1)
                            END AS unidad')
                )
                ->leftJoin('g1organigrama', 'g1organigrama.idct_escuela', 'g1acta.id_ct')
                ->where('oenviocorreooic', 1) // Notificadas a OIC
                ->where('oconcluida', 1)      // Finalizadas
                ->with(['tipoacta', 'elct'])  // Cargar relaciones necesarias
                ->orderBy('g1acta.updated_at', 'DESC') // Ordenar por fecha de envío del correo
                ->paginate(20);

        // Variables vacías para compatibilidad con la vista
        $datosacta2 = collect();
        $datosacta3 = collect();
        
        return view('admin.er.notificadas-oic.index', compact('datosacta', 'datosacta2', 'datosacta3'));
    }
}
